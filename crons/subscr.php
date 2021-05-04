<?php

////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	include "../inc/torgutils-inc.php";

	$NUM_NOTIFIES = 1;
	$MIN_AVAILAMOUNT_NOTIFY = 3;

	////////////////////////////////////////////////////////////////////////////
	// Update Product Avail Notify Table
	$query = "SELECT DISTINCT b1.id, b1.login FROM $TABLE_TORG_BUYERS b1
		INNER JOIN $TABLE_SUBSCRIPTION s1 ON b1.id=s1.user_id
		WHERE b1.login<>'' AND b1.isactive=1 AND b1.isactive_web=1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			// Для каждого пользователя нужно составить письмо с перечнем объявлений или тендеров по его подписке
			$mail_text = '';

			$its = Array();

			// Извлечь перечень подписок на Объявления
			$query1 = "SELECT s1.*, t1.title, t1.parent_id, tp1.title as ptitle
				FROM $TABLE_SUBSCRIPTION s1
				INNER JOIN $TABLE_ADV_TOPIC t1 ON s1.board_topic_id=t1.id
				INNER JOIN $TABLE_ADV_TOPIC tp1 ON t1.parent_id=tp1.id
				WHERE s1.user_id='".$row->id."' AND s1.board_topic_id<>0
				ORDER BY ptitle, t1.title";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$sit = Array();
					$sit['id'] = $row1->id;
					$sit['dt'] = $row1->add_date;
					$sit['topic_id'] = $row1->board_topic_id;
					$sit['ptopic_id'] = $row1->parent_id;
					$sit['topic'] = stripslashes($row1->title);
					$sit['ptopic'] = stripslashes($row1->ptitle);
					$sit['torg']= $row1->board_torg_type;
					$sit['obl_id'] = $row1->board_obl_id;

					$its[] = $sit;
				}
				mysqli_free_result( $res1 );
			}


			for( $i=0; $i<count($its); $i++ )
			{
				$first = false;
				$query1 = "SELECT * FROM $TABLE_ADV_POST WHERE topic_id='".$its[$i]['topic_id']."' AND add_date>DATE_SUB(NOW(), INTERVAL 1 DAY)
					".($its[$i]['obl_id'] != 0 ? ' AND obl_id='.$its[$i]['obl_id'].' ' : '').($its[$i]['torg'] != 0 ? ' AND type_id='.$its[$i]['torg'].' ' : '')."
					LIMIT 0,10";
				$oind = 0;
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$oind++;

						if( !$first )
						{
							$BOARDURL = Board_BuildUrl($LangId, "list", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['torg'], $its[$i]['topic_id']);

							$mail_text .= '<br />Объявления из раздела: <a href="'.$BOARDURL.'">'.$its[$i]['ptopic'].' > '.$its[$i]['topic'].'</a><br />';
							$first = true;
						}

						$mail_text .= ' '.($oind).'. '.stripslashes($row1->title).', г. '.stripslashes($row1->city).'<br />';
					}
					mysqli_free_result( $res1 );
				}
				else
					echo mysqli_error($upd_link_db);
			}

			// Tenders

			$its = Array();

			$query1 = "SELECT s1.*, t1.icon_filename, t1.url as culturl, t2.type_name as culture
				FROM $TABLE_SUBSCRIPTION s1
				LEFT JOIN $TABLE_TORG_PROFILE t1 ON s1.tender_cult_id=t1.id
				LEFT JOIN $TABLE_TORG_PROFILE_LANGS t2 ON t1.id=t2.profile_id AND t2.lang_id='$LangId'
				WHERE s1.user_id='".$row->id."' AND s1.board_topic_id=0
				ORDER BY s1.tender_obl_id, culture";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$sit = Array();
					$sit['id'] = $row1->id;
					$sit['dt'] = $row1->add_date;
					$sit['cult_id'] = $row1->tender_cult_id;
					$sit['cultname'] = ( $row1->tender_cult_id != 0 ? stripslashes($row1->culture) : '' );
					$sit['cultico'] = ( $row1->tender_cult_id != 0 ? $FILE_DIR.stripslashes($row1->icon_filename) : '' );
					$sit['cult_url'] = ( $row1->tender_cult_id != 0 ? stripslashes($row1->culturl) : '' );
					$sit['torg']= $row1->tender_torg_type;
					$sit['obl_id'] = $row1->tender_obl_id;

					$its[] = $sit;
				}
				mysqli_free_result( $res1 );
			}


			$tendernames = Array("Все тендеры", "Закупки", "Продажи");
			for( $i=0; $i<count($its); $i++ )
			{
				$lots = Torg_LotList( $LangId, $its[$i]['obl_id'], null, $its[$i]['torg'], $its[$i]['cult_id'], null, "lastday", "lotid", "up", 0, 10 );
				if( count($lots) > 0 )
				{
					//$BOARDURL = Board_BuildUrl($LangId, "list", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['torg'], $its[$i]['topic_id']);
					$mail_text .= '<br />Тендеры в группе: '.$REGIONS[$its[$i]['obl_id']].($its[$i]['cult_id'] != 0 ? " - ".$its[$i]['cultname'] : '').', '.$tendernames[$its[$i]['torg']].'<br />';
					for( $j=0; $j<count($lots); $j++ )
					{
						$ITURL = TorgItem_BuildUrl( $LangId, $lots[$j]['id'], $lots[$j]['id'], $REGIONS_URL[$lots[$j]['obl_id']] );

						$mail_text .= ' '.($i+1).'. '.$lots[$j]['cultname'].', '.$TORG_TYPES[$lots[$j]['torg_type']].' - '.$lots[$j]['amount'].' т ( смотреть лот №<a href="'.$ITURL.'">'.Torg_LotIdStr($lots[$j]['id']).'</a>)<br />';
					}
				}
			}


			if( $mail_text != '' )
			{
				$mailbody = MakeMailBody($mail_text);
				SendUniSenderMail( stripslashes($row->login), "Agrtotender - Novoe", $mailbody );
			}

			echo "<br /><b>".stripslashes($row->login)."</b><br />";
			echo $mail_text."<br />";
		}
		mysqli_free_result( $res );
	}




function MakeMailBody($prod_list)
{
	$mailbody = "Здравствуйте,
<br />
Вы подписались на новые объявления и тендеры на сайте <a href=\"http://agrotender.com.ua\">agrotender.com.ua</a>
<br />
".$prod_list."
<br />
Надеемся, что эта информация была вам полезна.<br />
";

	return $mailbody;
}



/*
// Ваш ключ доступа к API (из Личного Кабинета)
$api_key = "51bj7y958yh9z8ne3aftopqzqtwxt1xw9qdi67fy";

// Создаём POST-запрос
$POST = array (
  'api_key' => $api_key,
);

// Устанавливаем соединение
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_URL, 'http://api.unisender.com/ru/api/getLists?format=json');
$result = curl_exec($ch);

if ($result) {
  // Раскодируем ответ API-сервера
  $jsonObj = json_decode($result);

  if(null===$jsonObj) {
    // Ошибка в полученном ответе
    echo "Invalid JSON";

  }
  elseif(!empty($jsonObj->error)) {
    // Ошибка получения перечня список
    echo "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

  } else {
    // Выводим коды и названия всех имеющихся списков
    echo "Here's a list of your mailing lists:<br>";
    foreach ($jsonObj->result as $one) {
      echo "List #" . $one->id . " (" . $one->title . ")". "<br>";
    }

  }
} else {
  // Ошибка соединения с API-сервером
  echo "API access error";
}
*/


function SendUniSenderMail($to, $subject, $mailbody)
{
	// Ваш ключ доступа к API (из Личного Кабинета)
	$api_key = "51bj7y958yh9z8ne3aftopqzqtwxt1xw9qdi67fy";

	// Параметры сообщения
	// Если скрипт в кодировке UTF-8, не используйте iconv
	$email_from_name = "Agrotender.com.ua";
	$email_from_email = "info@agrotender.com.ua";
	$email_to = $to; //"alex@uh.ua";
	//$email_body = urlencode(iconv('cp1251', 'utf-8', $mailbody));
	$email_body = $mailbody;
	$email_subject = $subject; //'test email';
	$list_id = "2222924";

	// Создаём POST-запрос
	$POST = array (
	  'api_key' => $api_key,
	  'email' => $email_to,
	  'sender_name' => $email_from_name,
	  'sender_email' => $email_from_email,
	  'subject' => $email_subject,
	  'body' => $email_body,
	  'list_id' => $list_id
	);

	// Устанавливаем соединение
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_URL,
	            'http://api.unisender.com/ru/api/sendEmail?format=json');
	$result = curl_exec($ch);

	if ($result) {
		// Раскодируем ответ API-сервера
		$jsonObj = json_decode($result);

		if(null===$jsonObj) {
		  // Ошибка в полученном ответе
		  echo "Invalid JSON";

		}
		elseif(!empty($jsonObj->error)) {
		  // Ошибка отправки сообщения
		  echo "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

		} else {
		  // Сообщение успешно отправлено
		  echo "Email message is sent. Message id " . $jsonObj->result->email_id;

		}
	} else {
		// Ошибка соединения с API-сервером
		echo "API access error";
	}
}

	include "../inc/close-inc.php";

?>