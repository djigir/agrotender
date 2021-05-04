<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    include "../inc/utils-inc.php";
    //include "../inc/catutils-inc.php";
	include "../inc/torgutils-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }
	
	include "../inc/errors-hints.php";

function checkDtFormat($dt)
{
	if( !(
		is_numeric(substr($dt, 0, 1)) &&
		is_numeric(substr($dt, 1, 1)) &&
		is_numeric(substr($dt, 3, 1)) &&
		is_numeric(substr($dt, 4, 1)) &&
		is_numeric(substr($dt, 6, 1)) &&
		is_numeric(substr($dt, 7, 1)) &&
		is_numeric(substr($dt, 8, 1)) &&
		is_numeric(substr($dt, 9, 1))
		) )
		return false;

	$starr = @split("[.]", $dt);
	if( (count($starr) == 3) &&
		is_numeric($starr[1]) && is_numeric($starr[0]) && is_numeric($starr[2]) &&
	 	!checkdate( $starr[1], $starr[0], $starr[2] ) )
	{
		return false;
	}

	return true;
}

	$strings['tipedit']['en'] = "Edit This Comment";
   	$strings['tipdel']['en'] = "Delete This Comment";
   	$strings['hdrlist']['en'] = "Comment List";
   	$strings['hdradd']['en'] = "Add Comment";
   	$strings['hdredit']['en'] = "Edit Comment";
   	$strings['rowdate']['en'] = "Comment date";
   	$strings['rowtitle']['en'] = "Name";
   	$strings['rowfirst']['en'] = "Preview Page";
   	$strings['rowtext']['en'] = "Comment Text";
   	$strings['rowbrand']['en'] = "Company Source";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No comments in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";
	$strings['product']['en'] ="Product";

    $strings['tipedit']['ru'] = "Редактировать этот отзыв";
   	$strings['tipdel']['ru'] = "Удалить этот отзыв";
   	$strings['hdrlist']['ru'] = "Список отзывов";
   	$strings['hdradd']['ru'] = "Добавить отзыв";
   	$strings['hdredit']['ru'] = "Редакировать объявление";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Отображать в анонсе";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет отзывов";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";
	$strings['product']['ru']="Продукт";
	$strings['article']['ru']="Статья";

	$PAGE_HEADER['ru'] = "Редактировать Публикации";
	$PAGE_HEADER['en'] = "Comment Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$ADVTYPE = Array("Все", "Куплю", "Продам", "Услуги");
	
	$ADVRULES = $ADVRULES_MODER_MSG;
	/*
	$ADVRULES = Array(
		0 => "",
		1 => Array("title" => "Похожий заголовок", "text" => "Вы указали заголовок, очень похожий на одно из ваших объявлений."),
		2 => Array("title" => "Цена не верна", "text" => "Указанная Вами цена не отвечает действительной цене товара/услуги."),
		3 => Array("title" => "Не цензурная брань", "text" => "В тексте или заголовке объявления указаны недопустимые слова."),
		4 => Array("title" => "Капслок", "text" => "Заголовок или текст объявления набран в верхнем регистре.")
	);
	*/	

	$compmode = GetParameter("compmode", "");

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$typeid = GetParameter("typeid", 0);
	$topicid = GetParameter("topicid", "0:0");
	$topicid0 = GetParameter("topicid0", 0);
	$oblid = GetParameter("oblid", 0);
	$compid = GetParameter("compid", 0);
	$authorid = GetParameter("authorid", 0);
	$sesmode = GetParameter("sesmode", 0);

	$fltmail = trim(strip_tags(GetParameter("fltmail", ""), ""));
	$flttel = trim(strip_tags(GetParameter("flttel", ""), ""));
	$fltname = trim(strip_tags(GetParameter("fltname", ""), ""));
	$fltip = trim(strip_tags(GetParameter("fltip", ""), ""));
	$fltid = trim(strip_tags(GetParameter("fltid", 0), ""));
	$fltses = trim(strip_tags(GetParameter("fltses", ""), ""));
	$fltuid = trim(strip_tags(GetParameter("fltuid", 0), ""));
	
	if( $fltuid != 0 )
	{
		$authorid = $fltuid;
	}
	
	$flttxt = trim(GetParameter("flttxt", ""));

	$sortby = GetParameter("sortby", "");
	
	$period = GetParameter("period", 0);
	$arctype = GetParameter("arctype", 0);
	$modertype = GetParameter("modertype", -1);
	$moderwordtype = GetParameter("moderwordtype", -1);
	
	$upgrdtype = GetParameter("upgrdtype", 0);

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 100);

	$datest = GetParameter("datest", date("d.m.Y", time()));

	$topicsel = explode(":", $topicid);
	$topicparent = ($topicsel[0] == 0);
	$topicsid = ( isset($topicsel[1]) ? $topicsel[1] : 0 );
	
	$txt_res = Resources_Get($LangId);
	
	$pmodercont = GetParameter("pmodercont", $txt_res['postmodermsg']['text']);


				$item_id = GetParameter("item_id", "0");
			$newsauthor = GetParameter("newsauthor", "");
			$newstitle = GetParameter("newstitle", "");
			$newscont = GetParameter("newscont", "", false);
			$newsfirst = GetParameter("newsfirst", 0);

			$newsemail = GetParameter("newsemail", "");
			$newsphone = GetParameter("newsphone", "");
			$newscity = GetParameter("newscity", "");
			$newsamount = GetParameter("newsamount", "");
			$newsizm = GetParameter("newsizm", "");
			$newscost = GetParameter("newscost", "");
			$newscostc = GetParameter("newscostc", "");

			$newsobl = GetParameter("newsobl", 0);
			$newstopic = GetParameter("newstopic", "0:0");
			
			$newsact = GetParameter("newsact", 0);
			$newsmoder = GetParameter("newsmoder", 0);
			$newsarc = GetParameter("newsarc", 0);
			
			$newscolor = GetParameter("newscolor", 0);
			$newstop = GetParameter("newstop", 0);

	////////////////////////////////////////////////////////////////////////////
	switch( $action )
	{
		case "updatemoder":
			$item_id = GetParameter("item_id", "0");
						
			$pmoderr = GetParameter("pmoderr", null);
			
			//$modermsg = $txt_res['postmodermsg']['text'];
			$modermsg = $pmodercont;
			
			$modermsg_in = "";
			for( $i=0; $i<count($pmoderr); $i++ )
			{
				$modermsg_in .= $ADVRULES[$pmoderr[$i]]['text']."<br>";
			}
			
			$modermsg = str_replace("{TPL_RULES}", $modermsg_in, $modermsg);
			
			// Сообщение
			$query = "INSERT INTO $TABLE_ADV_POST_MODER_MSG (post_id, add_date, msg) VALUES ('$item_id', NOW(), '".addslashes($modermsg)."')";
			if(!mysqli_query($upd_link_db,$query))
			{
				debugMysql();
			}
			
			$query = "UPDATE $TABLE_ADV_POST SET fixdone=0, active=0 WHERE id='$item_id'";
			if(!mysqli_query($upd_link_db,$query))
			{
				debugMysql();
			}
			
			///////////////////////// 						
			$author_id = 0;
			
			$postinf = Board_PostInfo($LangId, $item_id);
			if( isset($postinf['id']) && ($postinf['id'] != 0) )
			{
				$author_id = $postinf['author_id'];
			}
			/*
			$query = "SELECT * FROM $TABLE_ADV_POST WHERE id='$item_id'";
			if( $res = mysqli_query($upd_link_db,$query) )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					$author_id = $row->author_id;
				}
				mysqli_free_result($res);
			}
			*/
			
			if( $author_id != 0 )
			{
				$buyerinf = Torg_BuyerInfo($LangId, $author_id);				
				
				///////////////////////////////////////////////////////////////////
				// Send mail through unisender
				include "../uhlibs/unisend/inc/unisender-init.php";
				
				$body_data = array(
					"{FULL_NAME}" => $buyerinf['name'],
					"{URL_AD_EDIT}" => $WWWHOST."board/edit".$item_id.".html",
					"{AD_NAME}" => $postinf['title'],
				);
		
				Send_UniSenderMail($buyerinf['login'], $buyerinf['name'], "Ваше объявление не прошло модерацию", MAIL_TPL_MODER_NOT_APPROVE, $body_data);
				////////////////////////////////////////////////////////////////////
			}
			
			break;
			
			
		case "delete":
			$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
				_post_Delete($com_id[$i]);
//    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_ADV_POST WHERE id=".$com_id[$i]." "))
//				{
//        			echo "<b>".mysqli_error($upd_link_db)."</b>";
//    			}
//				if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_COMPANY_POST2ADVTOPICS WHERE post_id=".$com_id[$i]." "))
//				{
//					echo "<b>".mysqli_error($upd_link_db)."</b>";
//				}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
			_post_Delete($item_id);
//            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_ADV_POST WHERE id=".$item_id." "))
//			{
//        		echo "<b>".mysqli_error($upd_link_db)."</b>";
//    		}
//			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_COMPANY_POST2ADVTOPICS WHERE post_id=".$item_id." "))
//			{
//				echo "<b>".mysqli_error($upd_link_db)."</b>";
//			}
    		break;


		case "update":
			$item_id = GetParameter("item_id", "0");
			$newstsel = explode(":", $newstopic);
			$newstparent = ($newstsel[0] == "0" ? 0 : 1);
			$newstid = $newstsel[1];
			
			
			// Get current adv status
			$author_id = 0;
			$send_moder_done = false;
			
			$postinf = Board_PostInfo($LangId, $item_id);
			if( isset($postinf['id']) && ($postinf['id'] != 0) )
			{
				$author_id = $postinf['author_id'];
				if( ($postinf['moder'] == 0) && ($newsmoder == 1) )
				{
					$send_moder_done = true;
				}
			}
			
			
			$upadvbtn = GetParameter("upadvbtn", "");
			if( $upadvbtn != "" )
			{
				// Make UP! without saving changes
				//$mode = "edit";
				
				$query = "UPDATE $TABLE_ADV_POST SET upnotif_dt=NOW(), ups=ups+1, up_dt=NOW() WHERE id='".intval($item_id)."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
					//debugMysql();					
				}
				
				break;
			}
			

			//echo $newstid." - ".$newstparent." - ".$newstsel[0]."<br />";

			$topicsql = "";
			if( ($newstid != 0) && $newstparent )
			{
				$topicsql = ", topic_id='".$newstid."' ";
			}

    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");
			$a=getdate();
			$time=$a['hours'].":".$a['minutes'].":".$a['seconds'];
    		$db_datest = substr($datest, 6, 4)."-".substr($datest, 3, 2)."-".substr($datest, 0, 2)." ".$time;			
			

			//$query = "UPDATE $TABLE_ADV_POST SET add_date='$db_datest', author='".addslashes($newsauthor)."', title='".addslashes($newstitle)."' WHERE id='".$item_id."'";
			$query = "UPDATE $TABLE_ADV_POST SET obl_id='$newsobl' $topicsql, active='$newsact', moderated='$newsmoder', archive='$newsarc', 
				author='".addslashes($newsauthor)."', city='".addslashes($newscity)."',
				email='".addslashes($newsemail)."', phone='".addslashes($newsphone)."', amount='".addslashes($newsamount)."', colored='".$newscolor."', targeting='".$newstop."', 
				izm='".addslashes($newsizm)."', cost='".addslashes($newscost)."', cost_izm='".addslashes($newscostc)."',
				title='".addslashes($newstitle)."', content='".addslashes($newscont)."' WHERE id='".$item_id."'";
			//echo $query."<br />";
				//date_default_timezone_set('UTC');
//print_r(date());
//die();
			 	$startDate = date("Y-m-d H:i:s", time());
        		$endDate  = date('Y-m-d H:i:s', strtotime($startDate . "+1 month"));

				//Register order in agt_buyer_packs_orders
        		if($newstop == 1){
				$query2 = "INSERT INTO $TABLE_PAYED_PACK_ORDERS (post_id, pack_type, pack_id, add_date, comments, stdt, endt, adv_avail) VALUES ('".$item_id."',1,6,'".$startDate."','Добавлена админом','".$startDate."','".$endDate."',0)";

				if(!mysqli_query($upd_link_db,$query2)){
					debugMysql();	
				}
			} elseif ($newstop == 0) {
				$query2 = "DELETE FROM $TABLE_PAYED_PACK_ORDERS WHERE post_id = '$item_id'";
				if(!mysqli_query($upd_link_db,$query2)){
					debugMysql();	
				}
			}

			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			else
			{
				        // dates
       

				if( $author_id != 0 )
				{
					$buyerinf = Torg_BuyerInfo($LangId, $author_id);				
					
					///////////////////////////////////////////////////////////////////
					// Send mail through unisender
					include "../uhlibs/unisend/inc/unisender-init.php";
					
					$body_data = array(
						"{FULL_NAME}" => $buyerinf['name'],
						"{URL_AD}" => $WWWHOST."board/post-".$item_id.".html",
						"{AD_NAME}" => $postinf['title'],
					);
			
					Send_UniSenderMail($buyerinf['login'], $buyerinf['name'], "Ваше объявление активировано", MAIL_TPL_MODER_APPROVE, $body_data);
					////////////////////////////////////////////////////////////////////
				}
			}			
			break;
			
		case "delitempic":
			$item_id = GetParameter("item_id", "0");
			$picid = GetParameter("picid", "0");
			
			$query = "DELETE FROM $TABLE_ADV_POST_PICS WHERE item_id='$item_id' AND file_id='$picid'";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			
			$mode = "edit";
			
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newsauthor_id = 0;
		$newsauthor = "";
		$newstitle = "";
		$newscont = "";
		$newsfirst = 0;

		$newsemail = "";
		$newsphone = "";
		$newscity = "";
		$newsamount = "";
		$newsizm = "";
		$newscost = "";
		$newscostc = "";

		$newsobl = 0;
		$newstid = 0;
		
		$newsmoder = 0;
		$newsarc = 0;
		$newsact = 0;

		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, DAYOFMONTH(m1.add_date) as dd, MONTH(m1.add_date) as dm, YEAR(m1.add_date) as dy
			FROM $TABLE_ADV_POST m1 WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newsauthor_id = $row->author_id;
				$newsauthor= stripslashes($row->author);
				$newstitle= stripslashes($row->title);
				$newscont = stripslashes($row->content);
				//$newsfirst = $row->show_first;
				//$newsbrand = $row->brand_id;
				$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$newsemail = stripslashes($row->email);
				$newsphone = stripslashes($row->phone);
				$newscity = stripslashes($row->city);
				$newsamount = stripslashes($row->amount);
				$newsizm = stripslashes($row->izm);
				$newscost = stripslashes($row->cost);
				$newscostc = '';
				  if ($row->cost_cur == 1) {
				  	$newscostc = 'грн.';
				  } elseif ($row->cost_cur == 2) {
				  	$newscostc = '$';
				  } elseif ($row->cost_cur == 3) {
				  	$newscostc = '€';
				  } else {
                    $newscostc = 'грн.';
				  }
				$newsobl = $row->obl_id;
				$newstid = $row->topic_id;
				
				$newsact = $row->active;
				$newsmoder = $row->moderated;
				$newsarc = $row->archive;
				
				$newscolor = $row->colored;
				$newstop = $row->targeting;

			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
		
		$apics = Board_PostPhotos($LangId, $item_id);
?>

	<h3>Фото в объявлении</h3>
	
	<div class="pic-list">
<?php
	for( $i=0; $i<count($apics); $i++ )
	{
		echo '<div class="pic-it">
			<div class="pic-img"><img src="'.$apics[$i]['ico'].'" alt=""></div>
			<div class="ta_center"><a href="'.$PHP_SELF.'?action=delitempic&item_id='.$item_id.'&picid='.$apics[$i]['id'].'&compmode='.$compmode.'&typeid='.$typeid.'&topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&compid='.$compid.'&sortby='.$sortby.'&authorid='.$authorid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&fltses='.$fltses.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'#rowlnk'.($i).'" onclick="return window.confirm(\'Вы действительно хотите удалить эту картинку?\')"><img src="img/delete.gif" width="20" height="20" border="0" alt="'.$strings['tipdel'][$lang].'" /></a></div>
		</div>';
	}
?>
	</div>
	

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="compmode" value="<?=$compmode;?>" />
	<input type="hidden" name="typeid" value="<?=$typeid;?>" />
	<input type="hidden" name="topicid" value="<?=$topicid;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
	<input type="hidden" name="compid" value="<?=$compid;?>" />
	<input type="hidden" name="pi" value="<?=$pi;?>" />
	<input type="hidden" name="pn" value="<?=$pn;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltip" value="<?=$fltip;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<input type="hidden" name="fltuid" value="<?=$fltuid;?>" />	
	<input type="hidden" name="flttxt" value="<?=$flttxt;?>" />
    <input type="hidden" name="sortby" value="<?=$sortby;?>" />
	<input type="hidden" name="period" value="<?=$period;?>" />
	<tr><td class="ff"><?=$strings['rowdate'][$lang];?>:</td><td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"datest\" name=\"datest\" size=\"10\" maxlength=\"10\" value=\"".$datest."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.advfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
</td></tr>
	<tr><td class="ff">Автор:</td><td class="fr"><input type="text" size="70" name="newsauthor" value="<?=$newsauthor;?>" /></td></tr>
	<tr><td class="ff">E-mail:</td><td class="fr"><input type="text" size="70" name="newsemail" value="<?=$newsemail;?>" /></td></tr>
	<tr><td class="ff">Телефон:</td><td class="fr"><input type="text" size="70" name="newsphone" value="<?=$newsphone;?>" /></td></tr>
	<tr><td class="ff">Раздел:</td><td class="fr"><select name="newstopic">
		<option value="0:0">--- Все секции ---</option>
<?php
		$topics = Board_TopicLevel($LangId, 0, "bygroups");

		$grcurname = "";

		for( $i=0; $i<count($topics); $i++ )
		{
			if( $grcurname != $topics[$i]['group'] )
			{
				echo '<option style = "text-transform : uppercase; font-weight : bold" value="0:0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
				$grcurname = $topics[$i]['group'];
			}
			echo '<option style = "font-weight : bold; font-style : italic" value="0:'.$topics[$i]['id'].'"'.($newstid == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';

			$subtopics = Board_TopicLevel($LangId, $topics[$i]['id']);
			for( $j=0; $j<count($subtopics); $j++ )
			{
				echo '<option value="1:'.$subtopics[$j]['id'].'"'.($newstid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
			}
		}
?>
	</select></td></tr>
	<tr><td class="ff">Заглавие:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
<!--        class="ckeditor" добавить ниже что бы получить расширенный редактор-->
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	<tr><td class="ff">Область:</td><td class="fr"><select name="newsobl">
	<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($newsobl == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}
	?>
	</select></td></tr>
	<tr><td class="ff">Город:</td><td class="fr"><input type="text" size="70" name="newscity" value="<?=$newscity;?>" /></td></tr>
	<tr><td class="ff">Объем:</td><td class="fr"><input type="text" name="newsamount" value="<?=$newsamount;?>" /> <input type="text" size="7" name="newsizm" size="6" value="<?=$newsizm;?>" /></td></tr>
	<tr><td class="ff">Цена:</td><td class="fr"><input type="text" name="newscost" value="<?=$newscost;?>" /> <input type="text" size="5" name="newscostc" value="<?=$newscostc;?>" /></td></tr>
	
	<tr>
		<td class="ff">Выделение цветом:</td>
		<td class="fr"><select name="newscolor">
			<option value="0"<?=( $newscolor == 0 ? " selected ": "" );?>>Обычное</option>
			<option value="1"<?=( $newscolor == 1 ? " selected ": "" );?>>Выделено цветом</option>
		</select></td>
	</tr>
	
	<tr>
		<td class="ff">Поднято в ТОП:</td>
		<td class="fr"><select name="newstop">
			<option value="0"<?=( $newstop == 0 ? " selected ": "" );?>>Обычное</option>
			<option value="1"<?=( $newstop == 1 ? " selected ": "" );?>>Выделено в топе</option>
		</select></td>
	</tr>
	
	<tr>
		<td class="ff">Выполнить UP:</td>
		<td class="fr"><input type="submit" name="upadvbtn" value="Апнуть объявление"></td>
	</tr>
	
	<tr>
		<td class="ff">Статус модерации:</td>
		<td class="fr"><select name="newsact">
			<option value="0"<?=( $newsact == 0 ? " selected ": "" );?>>Не прошло модерацию</option>
			<option value="1"<?=( $newsact == 1 ? " selected ": "" );?>>Прошло модерацию (допущено к показу)</option>
		</select></td>
	</tr>
	
	<tr>
		<td class="ff">Бан по словам:</td>
		<td class="fr"><select name="newsmoder">
			<option value="0"<?=( $newsmoder == 0 ? " selected ": "" );?>>Скрыто по правилам бана</option>
			<option value="1"<?=( $newsmoder == 1 ? " selected ": "" );?>>Все ОК, Допущено к показу</option>
		</select></td>
	</tr>
	
	<tr>
		<td class="ff">Активное/Архив:</td>
		<td class="fr"><select name="newsarc">
			<option value="0"<?=( $newsarc == 0 ? " selected ": "" );?>>Активное</option>
			<option value="1"<?=( $newsarc == 1 ? " selected ": "" );?>>В архиве</option>
		</select></td>
	</tr>
	
    <tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnrefresh'][$lang];?> "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
	
	<br><br>
	
	<?php
		$msgs = Array();
		$query = "SELECT * FROM $TABLE_ADV_POST_MODER_MSG WHERE post_id='$item_id' ORDER BY add_date";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while( $row = mysqli_fetch_object($res) )
			{
				$mi = Array();
				$mi['id'] = $row->id;
				$mi['fixed'] = $row->fixed;
				$mi['msg'] = stripslashes($row->msg);
				$mi['add_dt'] = $row->add_date;
				$mi['fix_dt'] = $row->fix_date;
				
				$msgs[] = $mi;
			}
			mysqli_free_result($res);
		}
		
		if( count($msgs)>0 )
		{
			echo '<br><br>
			<table align="center" width="96%" cellspacing="0" cellpadding="0" id="brdlistfrm">
			<tr>
				<th>ID</th>
				<th>Дата</th>				
				<th>Текст</th>
				<th>Исправлено</th>
				<th>Дата испр.</th>
			</tr>';
			for( $i=0; $i<count($msgs); $i++ )
			{
				echo '<tr>
					<td>'.$msgs[$i]['id'].'</td>
					<td>'.$msgs[$i]['add_dt'].'</td>
					<td>'.$msgs[$i]['msg'].'</td>
					<td>'.($msgs[$i]['fixed'] == 1 ? '<span style="color: red; font-weight: bold;">ДА</span>' : ' - ' ).'</td>
					<td>'.$msgs[$i]['fix_dt'].'</td>
				</tr>
				<tr><td colspan="5" bgcolor="#EEEEEE"><img src="spacer.gif" width="1" height="1" alt="" /></td></tr>';
			}
			echo '</table><br><br>';
		}
	?>
	
	<h3>Сообщение о модерации</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="updatemoder" />
	<input type="hidden" name="compmode" value="<?=$compmode;?>" />
	<input type="hidden" name="typeid" value="<?=$typeid;?>" />
	<input type="hidden" name="topicid" value="<?=$topicid;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
	<input type="hidden" name="compid" value="<?=$compid;?>" />
	<input type="hidden" name="pi" value="<?=$pi;?>" />
	<input type="hidden" name="pn" value="<?=$pn;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltip" value="<?=$fltip;?>" />
	<input type="hidden" name="fltuid" value="<?=$fltuid;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<input type="hidden" name="flttxt" value="<?=$flttxt;?>" />
    <input type="hidden" name="sortby" value="<?=$sortby;?>" />
	<input type="hidden" name="period" value="<?=$period;?>" />	
	<tr>
		<td class="ff">Нарушенные правила:</td>
		<td class="fr">
	<?php
		for( $i=1; $i<count($ADVRULES); $i++ )
		{
			echo '<span><input type="checkbox" name="pmoderr[]" id="pmoder'.$i.'" value="'.$i.'"><label for="pmoder'.$i.'">'.$ADVRULES[$i]['title'].'</label></span>';
		}
	?>
		</td>
	</tr>	
	<tr>
		<td class="ff">Текст сообщения:</td>
		<td class="fr"><textarea rows="14" cols="80" name="pmodercont"><?=$pmodercont;?></textarea></td>
	</tr>		
    <tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Отклонить объявление "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
	
	
<?php
		if( $newsauthor_id != 0 )
		{
			echo '<div style="padding: 15px 0px 20px 0px; text-align: center;"><a href="torg_buyer_ban.php?action=editprofile&uid='.$newsauthor_id.'">Перейти к управлению баном для пользователя</a></div>';
		}

	}
	else
	{
?>
    <h3><?=$strings['hdrlist'][$lang];?></h3>

	<form action="<?=$PHP_SELF;?>" name="bselfrm" method="GET">
	<input type="hidden" name="sortby" value="<?=$sortby;?>" />
	<input type="hidden" name="compmode" value="<?=$compmode;?>" />
    <div class="select_form" style="line-height: 24px;">
        <label>Область: &nbsp;
    	<select name="oblid" onchange="document.forms['bselfrm'].submit();">
    		<option value="0">--- Все области ---</option>
<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($oblid == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}
?>
        </select></label>&nbsp;
        <label>Тип объявления:
		<select name="typeid" onchange="document.forms['bselfrm'].submit();">
<?php
		for( $i=0; $i<count($ADVTYPE); $i++ )
		{
			echo '<option value="'.$i.'"'.($typeid == $i ? ' selected' : '').'>'.$ADVTYPE[$i].'</option>';
		}
?>
		</select></label>&nbsp;
        <label>Раздел:
		<select name="topicid0" id="topicgroup" onchange="reloadSects(this, 'topicid')">
			<option value="0">--- Все разделы ---</option>
<?php
		$topics = Board_TopicLevel($LangId, 0, "bygroups");
		
		$grcurname = "";
		
		for( $i=0; $i<count($topics); $i++ )
		{
			if( $grcurname != $topics[$i]['group'] )
			{
				//echo '<option value="0:0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
				echo '<option value="0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
				$grcurname = $topics[$i]['group'];
			}
			//echo '<option value="0:'.$topics[$i]['id'].'"'.($topicsid == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
			echo '<option value="'.$topics[$i]['id'].'"'.($topicid0 == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';
			/*
			$subtopics = Board_TopicLevel($LangId, $topics[$i]['id']);
			for( $j=0; $j<count($subtopics); $j++ )
			{
				echo '<option value="1:'.$subtopics[$j]['id'].'"'.($topicsid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
			}
			*/
		}
?>
		</select></label>&nbsp;&nbsp;
        <label>Секция:
		<select name="topicid" id="topicid" onchange="document.forms['bselfrm'].submit();">
			<option value="0:0">--- Все секции ---</option>
		</select></label>
		<label>Показать по:
		<select name="pn" onchange="document.forms['bselfrm'].submit();">
			<option value="25"<?=($pn == 25 ? ' selected' : '');?>>25</option>
			<option value="50"<?=($pn == 50 ? ' selected' : '');?>>50</option>
			<option value="100"<?=($pn == 100 ? ' selected' : '');?>>100</option>
			<option value="250"<?=($pn == 250 ? ' selected' : '');?>>250</option>
			<option value="500"<?=($pn == 500 ? ' selected' : '');?>>500</option>
        </select></label>
		<label>За:
		<select name="period" onchange="document.forms['bselfrm'].submit();">
			<option value="0"<?=($period == 0 ? ' selected' : '');?>>- не указан -</option>
			<option value="1"<?=($period == 1 ? ' selected' : '');?>>Сегодня</option>
			<option value="7"<?=($period == 7 ? ' selected' : '');?>>7 дней</option>
        </select></label>
		<br>
		<label>Сесии:
		<select name="sesmode"  onchange="document.forms['bselfrm'].submit();">
			<option value="0" <?=($sesmode == 0 ? 'selected' : '') ?>>Нет</option>
			<option value="1" <?=($sesmode == 1 ? 'selected' : '') ?>>Да</option>
        </select></label>
        <label>Актив:
            <select name="arctype" onchange="document.forms['bselfrm'].submit();">
                <option value="0"<?=($arctype == 0 ? ' selected' : '');?>>Активные не арх.</option>
                <option value="1"<?=($arctype == 1 ? ' selected' : '');?>>Активные арх.</option>
                <option value="-10"<?=($arctype == -10 ? ' selected' : '');?>>Все</option>
            </select></label>
		<label>Улучшения:
            <select name="upgrdtype" onchange="document.forms['bselfrm'].submit();">
                <option value="0"<?=($upgrdtype == 0 ? ' selected' : '');?>>Любые объявления</option>
                <option value="1"<?=($upgrdtype == 1 ? ' selected' : '');?>>Объявления в топе</option>
                <option value="2"<?=($upgrdtype == 2 ? ' selected' : '');?>>Выделенные цветом</option>
            </select></label>
        <label>Модерация:
            <select name="modertype" onchange="document.forms['bselfrm'].submit();">
                <option value="-1"<?=($modertype == -1 ? ' selected' : '');?>>Все</option>
                <option value="0"<?=($modertype == 0 ? ' selected' : '');?>>На модерации</option>
                <option value="1"<?=($modertype == 1 ? ' selected' : '');?>>Допущенные</option>
            </select>
            <!--<span style="color: red; font-size: 14px"> 5</span>-->
        </label>
		 <label>Бан по словам:
            <select name="moderwordtype" onchange="document.forms['bselfrm'].submit();">
                <option value="-1"<?=($moderwordtype == -1 ? ' selected' : '');?>>Все</option>
                <option value="0"<?=($moderwordtype == 0 ? ' selected' : '');?>>Заблокированные</option>
                <option value="1"<?=($moderwordtype == 1 ? ' selected' : '');?>>Допущенные</option>
            </select>
            <!--<span style="color: red; font-size: 14px"> 5</span>-->
        </label>
    </div>
    <div class="search_form" style="line-height: 24px;">
        <label>E-mail: <input type="text" name="fltmail" value="<?=$fltmail;?>" /></label>
        <label>Тел. <input type="text" name="flttel" value="<?=$flttel;?>" /></label>
        <label>SES <input type="text" name="fltses" value="<?=$fltses;?>" /></label>
        <label>Имя <input type="text" name="fltname" value="<?=$fltname;?>" /></label>
        <label>IP <input type="text" name="fltip" value="<?=$fltip;?>" /></label>
        <label>ID <input type="text" name="fltid" value="<?=$fltid;?>" size="5" /></label>
        <label>Текст: <input type="text" name="flttxt" value="<?=$flttxt;?>" /></label>
		<label>UserID: <input type="text" name="authorid" value="<?=$authorid;?>" size="5" /></label>
        <input type="submit" value="Применить" />
	</div>

    </form>
<script type="text/javascript">
$(document).ready( function() {
	$("#selchkall").click( function() {
		$("#brdlistfrm input:checkbox").attr('checked', true);
		return false;
	});

	$("#unselchkall").click( function() {
		$("#brdlistfrm input:checkbox").attr('checked', false);
		return false;
	});
		
	reloadSects( document.getElementById('topicgroup'), 'topicid');
});

function reloadSects(selobj, comboid)
{
	var tid = selobj.options[selobj.selectedIndex].value;
	
	if( tid == 0 )
		return;
	
	$.ajax({
        type: "GET",
        url: "/admin/ajx/ajx_jq.php",
        data: 'cmd=uh_com_topics&tid='+tid,
        dataType: "text",
        success: function(data){
			//alert(data);
			var res = $.parseJSON(data);
			//eval('var rays = '+data+';');
			
			//alert( res.tlist.length );

			var cobj = document.getElementById(comboid);
			cobj.options.length = 0; //new Array();
			cobj.options[0] = new Option("--- Все секции ---", 0);

			for(i=0;i<res.tlist.length;i++)
			{
				cobj.options[i+1] = new Option(res.tlist[i].tn, tid+":"+res.tlist[i].tid);
			}
        },
		error: function(){
			alert("error");
		}
	});
}
</script>
    <table align="center" width="96%" cellspacing="0" cellpadding="0" id="brdlistfrm">
    <form action="<?=$PHP_SELF;?>" method="GET">
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="compmode" value="<?=$compmode;?>" />
    <input type="hidden" name="topicid" value="<?=$topicid;?>" />
    <input type="hidden" name="typeid" value="<?=$typeid;?>" />
    <input type="hidden" name="oblid" value="<?=$oblid;?>" />
	<input type="hidden" name="authorid" value="<?=$authorid;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltip" value="<?=$fltip;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<input type="hidden" name="fltuid" value="<?=$fltuid;?>" />
	<input type="hidden" name="flttxt" value="<?=$flttxt;?>" />
		<input type="hidden" name="fltses" value="<?=$fltses;?>" />
    <input type="hidden" name="sortby" value="<?=$sortby;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
	<input type="hidden" name="period" value="<?=$period;?>" />
    <tr><td colspan="9"><a href="#" id="selchkall">Отметить все</a> | <a href="#" id="unselchkall">Снять выделение</a></td></tr>
    <tr>
    	<th>&nbsp;<a name="rowlnk0"></a></th>
    	<th>№</th>
		<?php $sortbyConst = $PHP_SELF.'?compmode='.$compmode.'&typeid='.$typeid.'&topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&compid='.$compid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltip='.$fltip.'&fltid='.$fltid.'&flttxt='.$flttxt.'&fltuid='.$fltuid.'&period='.$period.'&arctype='.$arctype.'&modertype='.$modertype.'&moderwordtype='.$moderwordtype ?>
		<th><?=( $sortby == "sect" ? "Раздел" : '<a href="'.$sortbyConst.'&sortby=sect&authorid='.$authorid.'">Раздел</a>' );?></th>
		<th style="padding: 1px 10px 1px 20px" width="25%">
			<?=( $sortby == "name" ? "Автор" : '<a href="'.$sortbyConst.'&sortby=name&authorid='.$authorid.'">Автор</a>' );?> /
			<?=( $sortby == "tel" ? "Тел." : '<a href="'.$sortbyConst.'&sortby=tel&authorid='.$authorid.'">Тел.</a>' );?> /
			<?=( $sortby == "mail" ? "E-mail" : '<a href="'.$sortbyConst.'&sortby=mail&authorid='.$authorid.'">E-mail</a>' );?> /
			<?=( $sortby == "ip" ? "IP" : '<a href="'.$sortbyConst.'&sortby=ip&authorid='.$authorid.'">IP</a>' );?>
		</th>
		<th>Объявление</th>
		<th><?=( $sortby == "obl" ? "Область" : '<a href="'.$sortbyConst.'&sortby=obl&authorid='.$authorid.'">Область</a>' );?>
		</th>
		<th>
			<?=( $sortby == "dateadd" ? "Дата" : '<a href="'.$sortbyConst.'&sortby=dateadd&authorid='.$authorid.'">Дата созд.</a>' );?> /
			<?=( $sortby == "date" ? "Дата" : '<a href="'.$sortbyConst.'&sortby=date&authorid='.$authorid.'">Дата обн.</a>' );?>
		</th>
    	<!--<th>Показ</th>-->
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php

		//$SHOW_DEBUG_INFUNC = true;

		//$its	= Board_Posts( $LangId, $typeid, $topicsid, $topicparent, $oblid, $pi, $pn, 0, $authorid, 0, ( $compid != 0 ? $compid : ( $compmode == "onlycomp" ? "onlycomp" : "onlyadv" ) ), $fltmail, $flttel, $fltname, $flttxt, $fltip, $fltid, $sortby, "up", $arctype, 0, false, $flttxt, ( $flttxt != "" ? true : false), false, $period, $fltses, $modertype);
		$its	= Board_Posts( $LangId, $typeid, $topicsid, $topicparent, $oblid, $pi, $pn, 0, $authorid, 0, ( $compid != 0 ? $compid : ( $compmode == "onlycomp" ? "onlycomp" : 0 ) ), $fltmail, $flttel, $fltname, $flttxt, $fltip, $fltid, $sortby, "up", $arctype, 0, false, $flttxt, ( $flttxt != "" ? true : false), false, $period, $fltses, $modertype, $moderwordtype);

		
		for( $i=0; $i<count($its); $i++ )
		{
			if($sesmode == 1) {
				$sid = array();
				$query = 'SELECT * FROM `agt_torg_buyer_auth_arch` WHERE user_login = "' . $its[$i]['bemail'] . '";';
				$res = mysqli_query($upd_link_db,$query);
				$x = 0;
				while ($row = mysqli_fetch_object($res)) {

					$sid[$i][$x] = $row->ses_id;
					$x++;
				}
			}
			$advtype = $BOART_PTYPE_STR[$its[$i]['type_id']];
			$sz_txt='';
			if ($its[$i]['cost']!=''){
				if( $its[$i]['cdog'] != 0 )
				{
					$sz_txt = 'Цена: договорная';
				}
				else if( $its[$i]['cost'] != "" )
				{
					$currency = '';
				  if ($its[$i]['cost_cur'] == 1) {
				  	$currency = 'грн.';
				  } elseif ($its[$i]['cost_cur'] == 2) {
				  	$currency = '$';
				  } elseif ($its[$i]['cost_cur'] == 3) {
				  	$currency = '€';
				  } else {
                    $currency = 'грн.';
				  }
					$sz_txt = 'Цена: ' .$its[$i]['cost'].' '.$currency;
				}
			}
			if( !empty($its[$i]['amount'])) {
                $am_txt = "Объем: " . $its[$i]['amount'] . ' ' . $its[$i]['izm'];
            }
            else{
			    $am_txt = "";
            }
			echo "<tr>
				<td><a name=\"rowlnk".($i+1)."\"></a><input  type=\"checkbox\" name='com_id[]' value=\"".$its[$i]['id']."\" /></td>
				<td>".'<a href="'.$WWWHOST.'board/post-'.$its[$i]['id'].'.html" target="_blank">'.$its[$i]['id']."</a></td>
				<td align=\"center\">
					<b>".$advtype."<br>".$its[$i]['topic']."</b><br /><span style=\"font-size: 7pt;\">".$its[$i]['ptopic']."</span>
				</td>
				<td style=\"padding: 2px 10px 2px 10px;\">
					<b>".$its[$i]['bname']."</b><br />"
						.$its[$i]['bphone']."<br />
						<a style='padding: 2px 0 2px 0; display: inline-block' href=\"$PHP_SELF?compmode=".$compmode."&typeid=".$typeid./*"&topicid=".($topicparent ? "0" : "1").':'.$topicsid.*/"&oblid=".$oblid."&sesmode=".$sesmode."&compid=".$compid."&sortby=".$sortby."&authorid=".$its[$i]['author_id']."&fltmail=".$its[$i]['bemail']."&flttel=".$flttel."&fltname=".$fltname.'&pn='.$pn."\">".$its[$i]['bemail']."</a><br />
						<a href=\"$PHP_SELF?compmode=".$compmode."&typeid=".$typeid./*"&topicid=".($topicparent ? "0" : "1").':'.$topicsid.*/"&oblid=".$oblid."&sesmode=".$sesmode."&compid=".$compid."&sortby=".$sortby."&flttel=".$flttel."&fltname=".$fltname."&fltip=".$its[$i]['remote_ip'].'&pn='.$pn."\">".$its[$i]['remote_ip']."</a><br />
						";
				if( isset($sid[$i]) )
				{
					for ($x = 0; $x < count($sid[$i]); $x++)
					{
						if (isset ($sid[$i][$x]))
						    echo "<a href=\"$PHP_SELF?compmode=".$compmode."&typeid=".$typeid./*"&topicid=".($topicparent ? "0" : "1").':'.$topicsid.*/"&oblid=".$oblid."&sesmode=".$sesmode."&compid=".$compid."&sortby=".$sortby."&flttel=".$flttel."&fltname=".$fltname."&fltip=".$fltip."&fltses=".$sid[$i][$x].'&pn='.$pn."\">".$sid[$i][$x]."</a><br />";
					}
				}
				echo "					
				</td>
				<td style=\"width:300px;\"><b>".$its[$i]['title']."</b></br>
				<span>".$sz_txt."   ".$am_txt."</span>
				".($its[$i]['color'] == 1 ? '<br><span style="font-weight: bold; color: #f0841b;">Выделено цветом</span>' : '').($its[$i]['target'] == 1 ? '<br><span style="font-weight: bold; color: #1968e0;">Объявление в ТОП</span>' : '')."
				</td>
				<td align=\"center\">".$REGIONS[$its[$i]['obl_id']]."
				</td>
				<td align=\"center\"><b>".$its[$i]['dt']."</b><br>".$its[$i]['adddt'].(
					$its[$i]['act'] == 0 ? 
						'<br><b style="color: red;">на модерации</b>'.($its[$i]['fixdone'] == 1 ? '<br><b style="color: green;">Исправлено автором</b>' : '') : 
						''
				).(
					$its[$i]['moderated'] == 0 ? 
						'<br><b style="color: red;">попало в бан по словам</b>' : 
						''
				)."</td>
				".( false ? "<td align=\"center\" >".(true ? " <span style=\"font-weight: bold; color: red;\">Да</span> " : " Нет ")."</td>" : "" )."
				<td align=\"center\">
					<a href=\"$PHP_SELF?action=deleteitem&compmode=".$compmode."&typeid=".$typeid."&topicid=".($topicparent ? "0" : "1").':'.$topicsid."&oblid=".$oblid."&compid=".$compid."&sortby=".$sortby."&authorid=".$authorid."&pi=".$pi."&pn=".$pn."&item_id=".$its[$i]['id']."&fltmail=".$fltmail."&fltses=".$fltses."&flttel=".$flttel."&fltname=".$fltname."&fltid=".$fltid."#rowlnk".($i)."\" onclick=\"return window.confirm('Вы действительно хотите удалить это объявление?')\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
					<a href=\"$PHP_SELF?mode=edit&compmode=".$compmode."&typeid=".$typeid."&topicid=".($topicparent ? "0" : "1").':'.$topicsid."&oblid=".$oblid."&compid=".$compid."&sortby=".$sortby."&authorid=".$authorid."&pi=".$pi."&pn=".$pn."&item_id=".$its[$i]['id']."&fltmail=".$fltmail."&flttel=".$flttel."&fltname=".$fltname."&fltid=".$fltid."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;&nbsp;
				</td>
			</tr>
			<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
		}

		if( $fltid != 0 )	$its_num = 1;
		//else				$its_num = Board_PostsNum( $LangId, $typeid, $topicsid, $topicparent, $oblid, ( $compid != 0 ? $compid : ( $compmode == "onlycomp" ? "onlycomp" : "onlyadv" ) ), $fltmail, $flttel, $fltname, $flttxt, $fltip, $arctype, 0, false, $period, $fltses, $modertype);
		else				$its_num = Board_PostsNum( $LangId, $typeid, $topicsid, $topicparent, $oblid, ( $compid != 0 ? $compid : ( $compmode == "onlycomp" ? "onlycomp" : 0 ) ), $fltmail, $flttel, $fltname, $flttxt, $fltip, $arctype, 0, false, $period, $fltses, $modertype, $moderwordtype);

		if( count($its) == 0 )
		{
			echo "<tr><td colspan=\"8\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"8\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>
    <?php
    	if( $its_num > $pn )
    	{
    		$PAGES_NUM = ceil( $its_num/$pn );
    		echo '<div style="padding: 20px 20px 20px 20px; text-align: center;">Страницы: ';

    		for( $i=1; $i<=$PAGES_NUM && ($fltses =='') ; $i++ )
    		{
    			if( $i == $pi )
    				echo ' <b>'.($i).'</b> ';
    			else
    			    echo ' <a href="'.$PHP_SELF.'?compmode='.$compmode.'&typeid='.$typeid.'&topicid0='.$topicid0.'&topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid."&sesmode=".$sesmode.'&compid='.$compid.'&sortby='.$sortby.'&pi='.$i.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'&flttxt='.$flttxt.'&fltuid='.$fltuid.'&period='.$period.'&arctype='.$arctype.'&modertype='.$modertype.'&moderwordtype='.$moderwordtype.'&fltses='.$fltses.'">'.$i.'</a> ';
    		}

    		echo '</div>';
    	}
    ?>

    <br /><br />

    <table align="center" cellspacing="0" cellpadding="0" border="0" class="tableborder">
    <tr><td>   	</td></tr>
    </table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
