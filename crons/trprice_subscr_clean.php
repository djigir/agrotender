<?php

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	//include "../inc/torgutils-inc.php";
	
	include "../inc5/trader-utils-inc.php";

	$continfo = Contacts_Get($LangId);
	$txt_res = Resources_Get($LangId);

	//$BOARD_PERONCE = 50;
	//$BOARD_MONTHOLD = 5;
	//$BOARD_NOTIFYDAYS = 7;
	
	$period_mode = GetParameter("period", 24);
	//if( $period_mode != 24 )
	//	$period_mode = 1;
	
	//$BOARD_DEACT_DAY_PERIOD = intval($PREFS['BOARD_DEACTPERIOD']);
	
	
	echo "Go<br>";
	
	////////////////////////////////////////////////////////////////////////////
	
	////////////////////////////////////////////////////////////////////////////
	$recvlist = Array();
	
	echo "!";
	
	$query = "SELECT sub1.id as subid, c1.id as cult_id, c1.url as cult_url, c2.name as cult_name, b1.name as uname, b1.email as uemail, b1.guid_deact  
		FROM $TABLE_BUYER_SUBSCR_TRPR sub1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON sub1.buyer_id=b1.id 
		INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON sub1.cult_id=c1.id 
		INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
		WHERE sub1.is_active=1 AND sub1.until_date<NOW()
		ORDER BY b1.id, c1.id";
	
	echo $query."<br>";
		
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$semail = stripslashes($row->uemail);

			if( $semail == "" )	continue;
			
			//if( $row->subscr_adv_deact == 0 )
			//	continue;

			if( empty($recvlist[$semail]) )
			{
				$recvlist[$semail] = Array("isregged" => true, "email" => $semail, "author" => stripslashes($row->uname), "guid_deact" => stripslashes($row->guid_deact), "cults" => Array());
			}
			
			if( empty($recvlist[$semail]['cults'][$row->cult_id]) )
				$recvlist[$semail]['cults'][$row->cult_id] = Array("cult_id" => $row->cult_id, "url" => stripslashes($row->cult_url), "name" => stripslashes($row->cult_name), "subid" => $row->subid);
					
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);	
	
	
	include "../uhlibs/unisend/inc/unisender-init.php";

	
	echo "<br>Start Send<br>";

	// Make sending
	foreach($recvlist as $se => $binf)
	{
		$cults = $binf['cults'];

		echo "send to ".$binf['email']." - ".count($cults)." культур<br />";
		
		///////////////////////////////////////////////////////////////////
		// Send mail through unisender
			
		$body_data = array(
			"{FULL_NAME}" => $binf['author'],
			//"{URL_UNSUBSCRIBE}" => $WWWHOST."activate.html?action=actsubcrdeact&guid=".$binf['guid_deact'],	// !!!!!!!!!!!!!!!!!! //"http://example.com",
			"{ARR_TPL_CULTS}" => Array(),			
		);
		
		//for( $i=0; $i<count($cults); $i++ )
		foreach( $cults as $cultid => $cultitem )
		{
			echo $cultitem['name']." == ".$cultitem['url']."<br />";			
			
			$URL = $WWWHOST.'u/notify';
			
			$body_data["{ARR_TPL_CULTS}"][] = array(
				"{CULT_NAME}" 		=> $cultitem['name'],
				"{URL_ACTIVATE}"	=> $URL,
			);			
		}
		
		//echo "<br>";
		//var_dump($body_data);
		//echo "<br><br>";

		Send_UniSenderMail($binf['email'], $binf['author'], "Подписка на цены трейдеров истекла", MAIL_TPL_TRADER_EXPIRE, $body_data);
		////////////////////////////////////////////////////////////////////
	
	}
	
	
	/////////////////////////////////////////////////////////////////////////////////
	
	$query = "UPDATE $TABLE_BUYER_SUBSCR_TRPR SET is_active=0 WHERE is_active=1 AND until_date<NOW()";
	if( !mysqli_query($upd_link_db,$query) )
	{
		echo mysqli_error($upd_link_db);
	}
	
	echo "Done All<br>";
	

	////////////////////////////////////////////////////////////////////////////
	include "../inc/close-inc.php";

?>