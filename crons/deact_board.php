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

	//include "../inc/torgutils-inc.php";

	$continfo = Contacts_Get($LangId);
	$txt_res = Resources_Get($LangId);

	//$BOARD_PERONCE = 50;
	//$BOARD_MONTHOLD = 5;
	//$BOARD_NOTIFYDAYS = 7;
	
	$BOARD_DEACT_DAY_PERIOD = intval($PREFS['BOARD_DEACTPERIOD']);
	
	////////////////////////////////////////////////////////////////////////////
	// Delete all colored upgrades 
	$clearids = Array();
	$recvlist = Array();
	
	echo "Run clear : ".$BOARD_DEACT_DAY_PERIOD." Days<br>";
	mysqli_query($upd_link_db, "set time_zone='".date('P')."';");
	$query = "SELECT p1.*, b1.name as uname, b1.login as uemail, b1.guid_deact, b1.subscr_adv_deact   
		FROM $TABLE_ADV_POST p1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id
		WHERE p1.archive=0 AND p1.up_dt<DATE_SUB(NOW(),INTERVAL $BOARD_DEACT_DAY_PERIOD DAY)";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$semail = stripslashes($row->uemail);

			if( $semail == "" )	continue;
			
			if( $row->subscr_adv_deact == 0 )
				continue;

			if( empty($recvlist[$semail]) )
			{
				$recvlist[$semail] = Array("isregged" => true, "email" => $semail, "author" => stripslashes($row->uname), "guid_deact" => stripslashes($row->guid_deact), "posts" => Array());
			}

			$guid = makeUuid();

			//$UPLINK = $WWWHOST."upboard.php?action=up&postid=".$row->id."&guid=".$guid;
			//$UPLINK = $WWWHOST."bcab_posts.php?viewarc=0&viewtype=0";
			$UPLINK = $WWWHOST."u/posts?archive=1";
			$UNUPLINK = "";
			if( stripslashes($row->deact_ups_guid) != "" )
			{
				//$UNUPLINK = $WWWHOST."upboard.php?action=del&postid=".$row->id."&guid=".stripslashes($row->deact_ups_guid);
			}

			echo $row->id." ".$semail." - ".$UPLINK."<br />";

			$recvlist[$semail]['posts'][] = Array("title" => stripslashes($row->title), "ups" => $row->ups, "upurl" => $UPLINK, "unsubscrurl" => $UNUPLINK);			
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	echo "<br>";
	
	$query = "UPDATE $TABLE_ADV_POST SET archive=1 WHERE up_dt<DATE_SUB(NOW(),INTERVAL $BOARD_DEACT_DAY_PERIOD DAY)";
	echo $query."<br>";
	if( !mysqli_query($upd_link_db, $query) )
	{
		echo mysqli_error($upd_link_db)."<br>";
	}	
	
	echo "Done<br>";
	
	
	include "../uhlibs/unisend/inc/unisender-init.php";

	
	echo "Start Send<br>";

	// Make sending
	foreach($recvlist as $se => $binf)
	{
		$mailsubj = "Ваше объявление деактивировано";

		$posts = $binf['posts'];

		echo "send to ".$binf['email']." - ".count($posts)." постов<br />";
		
		///////////////////////////////////////////////////////////////////
		// Send mail through unisender
		$body_data = array(
			"{FULL_NAME}" => $binf['author'],
			"{PERIOD}" => $BOARD_DEACT_DAY_PERIOD." дней",
			"{URL_UNSUBSCRIBE}" => $WWWHOST."u/posts?archive=1",	// !!!!!!!!!!!!!!!!!! //"http://example.com",
			"{ARR_TPL_ADS}" => array(),
			/*
			"{ARR_TPL_ADS}" => array(
				array(
					"{AD_NAME}" => "Куплю зернорубочный комбайн бу с Германии",
					"{URL_ACTIVATE}" => "http://example.com",
				),
				array(
					"{AD_NAME}" => "Продать пшеницу 6 класса на элеваторе",
					"{URL_ACTIVATE}" => "http://example.com",
				),
			),
			*/
		);
		
		for( $i=0; $i<count($posts); $i++ )
		{
			echo $posts[$i]['title']." == ".$posts[$i]['upurl']."<br />";

			$body_data["{ARR_TPL_ADS}"][] = array(
					"{AD_NAME}" => $posts[$i]['title'], 
					"{URL_ACTIVATE}" => $posts[$i]['upurl'],
			);
		}

		Send_UniSenderMail($binf['email'], $binf['author'], "Ваше объявление деактивировано", MAIL_TPL_ADV_DEACT, $body_data);
		////////////////////////////////////////////////////////////////////
	
	}
	
	echo "Done All<br>";
	

	////////////////////////////////////////////////////////////////////////////
	include "../inc/close-inc.php";

?>