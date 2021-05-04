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

	$continfo = Contacts_Get($LangId);
	$txt_res = Resources_Get($LangId);

	$BOARD_PERONCE = 50;
	$BOARD_MONTHOLD = 5;
	$BOARD_NOTIFYDAYS = 7;



    ////////////////////////////////////////////////////////////////////////////
    //
	// Send notify
	echo "Start Notify<br>";

	// Structure, to group by revievers
	$recvlist = Array();

	//$BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['upsfpd'];
	//$BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['maxups'];

	$BOARD_NOTIFYDAYS = $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['upsfpd'];
	$BOARD_MAX_UPS = $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['maxups'];
	
	//$BOARD_UP_PERIOD;	//$PREFS['BOARD_UPPERIOD'];
	//$PREFS['BOARD_DEACTPERIOD'];
	
	// Version UniSender
	$ind = 0;
	/*
	$query = "SELECT p1.*, b1.name as uname, b1.login as uemail, b1.guid_deact, b1.subscr_adv_up   
		FROM $TABLE_ADV_POST p1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id AND p1.email<>'' 
		WHERE p1.ups_do_notif=1 AND p1.ups>=0 AND p1.ups<$BOARD_MAX_UPS AND 
		( ((p1.upnotif_dt IS NULL) AND (p1.add_date>DATE_SUB(NOW(), INTERVAL $BOARD_UP_PERIOD DAY))) OR (p1.upnotif_dt>DATE_ADD(p1.add_date, INTERVAL $BOARD_UP_PERIOD DAY)) ) 
		AND p1.archive=0 
		LIMIT 0,$BOARD_PERONCE";
	*/
	echo "<br>";
	/*
	$query = "SELECT p1.*, b1.name as uname, b1.login as uemail, b1.guid_deact, b1.subscr_adv_up   
		FROM $TABLE_ADV_POST p1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id AND p1.email<>'' 
		WHERE p1.ups_do_notif=1 AND p1.ups>=0 AND p1.ups<$BOARD_MAX_UPS AND 
		( ((p1.upnotif_dt IS NULL) AND (p1.add_date<DATE_SUB(NOW(), INTERVAL $BOARD_UP_PERIOD DAY))) OR ((p1.up_dt<DATE_SUB(NOW(), INTERVAL $BOARD_UP_PERIOD DAY)) AND (p1.upnotif_dt<DATE_SUB(NOW(), INTERVAL 1 DAY))) ) 
		AND p1.archive=0 
		LIMIT 0,$BOARD_PERONCE";
	*/
	echo "<pre>";
	mysqli_query($upd_link_db, "set time_zone='".date('P')."';");
	$query = "SELECT p1.*, b1.name as uname, b1.login as uemail, b1.subscr_adv_up   
		FROM agt_adv_torg_post p1 
		INNER JOIN agt_torg_buyer b1 ON p1.author_id=b1.id
		WHERE (p1.up_dt < '".date('Y-m-d H:i:s')."' AND (p1.upnotif_dt IS NULL)) AND p1.archive=0 and b1.subscr_adv_up != 0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			echo $row->id." - ".$row->title."<br />";
			//$ind++;
			//$semail = stripslashes($row->email);
			$semail = stripslashes($row->uemail);

			
			if( $row->subscr_adv_up == 0 )
				continue;

			if( empty($recvlist[$semail]) )
			{
				$recvlist[$row->uemail] = ["email" => $semail, "author" => stripslashes($row->uname), "posts" => []];
			}

			$UPLINK = $WWWHOST.'u/posts';
			$UNUPLINK = "";

			echo $row->id." ".$semail." - ".$UPLINK."<br />";

			$recvlist[$semail]['posts'][] = Array("title" => stripslashes($row->title), "ups" => $row->ups, "upurl" => $UPLINK);

			$query1 = "UPDATE $TABLE_ADV_POST SET upnotif_dt=NOW() WHERE id=".$row->id;
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}

		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	
	echo "Data collected<br>";
	
	include "../uhlibs/unisend/inc/unisender-init.php";


	// Make sending
	foreach($recvlist as $se => $binf)
	{
		$mailto = $binf['email'];
		//$mailsubj = $WWWNAMERU." - поднять объявление в рейтинге";
		$mailsubj = "Вам доступно бесплатное поднятие объявлений";

		$mailbody = str_replace( "{AUTHOR}", $binf['author'], $txt_res['upmhdr']['text'] );
//		$mailbody = "Здравствуйе ".$binf['author'].",
//
//Вы опубликовали следующие объявления на нашем сайте ".$WWWHOST.":
//";
		$posts = $binf['posts'];

		echo "send to $mailto - ".count($posts)." постов<br />";

		/*
		for( $i=0; $i<count($posts); $i++ )
		{
			echo $posts[$i]['upurl']."<br />";

			$mailbody .= "\"".$posts[$i]['title']."\"
".( false ? "Вы можете поднять объявление в рейтинге нажав на эту ссылку:" : $txt_res['upmitup']['text'] )."
".$posts[$i]['upurl']."
";
			if( $posts[$i]['unsubscrurl'] != "" )
			{
				//$mailbody .= "Если вы не хотите больше получать сообщения с предложением поднять это объявление, то пройдите по этой ссылке:
				$mailbody .= $txt_res['upmitunsub']['text']."
".$posts[$i]['unsubscrurl']."
";
			}

			$board_max_ups_tmp = ( $binf['isregged'] ? $BOARD_LIMITS[$BOARD_UTYPE_USER]['maxups'] : $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['maxups'] );

			if( $posts[$i]['ups'] >= ($board_max_ups_tmp-1) )
			{
				$mailbody .= $txt_res['upmitlast']['text'];
				//$mailbody .= "Это последнее письмо с возможностью поднятия объявления в рейтинге. Дальнейшее поднятие объявления можно осуществлять в личном кабинете.
//";
			}

			$mailbody .= "
";
		}
		*/

		$mailbody .= $txt_res['upmfoot']['text'];
//		$mailbody .= "Данные ссылки могут сработать только один раз, и повторно нажимать на них не имеет никакого смысла.
//С уважением, администрация сайта ".$WWWNAMERU."
//";

		//if( send1251mail($mailto, $mailsubj, $mailbody) )
		//send1251mail($mailto, $mailsubj, $mailbody);		
					
		///////////////////////////////////////////////////////////////////
		// Send mail through unisender
		$body_data = array(
			"{FULL_NAME}" => $binf['author'],
			"{PERIOD}" => $BOARD_UP_PERIOD." дней",
			"{URL_UNSUBSCRIBE}" => $WWWHOST."u/notify",
			"{ARR_TPL_ADS}" => array(),
			/*
			"{ARR_TPL_ADS}" => array(
				array(
					"{AD_NAME}" => "Куплю зернорубочный комбайн бу с Германии",
					"{URL_UP}" => "http://example.com",
				),
				array(
					"{AD_NAME}" => "Продать пшеницу 6 класса на элеваторе",
					"{URL_UP}" => "http://example.com",
				),
			),
			*/
		);
		
		for( $i=0; $i<count($posts); $i++ )
		{
			echo $posts[$i]['title']." == ".$posts[$i]['upurl']."<br />";

			$body_data["{ARR_TPL_ADS}"][] = array(
					"{AD_NAME}" => $posts[$i]['title'], 
					"{URL_UP}" => $posts[$i]['upurl'],
			);
		}

		Send_UniSenderMail($binf['email'], $binf['author'], "Вам доступно бесплатное поднятие объявлений", MAIL_TPL_ADV_UP, $body_data);
		////////////////////////////////////////////////////////////////////
	
	}
	
	echo "Sending done<br>";

	include "../inc/close-inc.php";

?>