<?php

chdir(__DIR__);

	////////////////////////////////////////////////////////////////////////////
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";
	include "../inc/utils-inc.php";

	include "../inc/torgutils-inc.php";

	$continfo = Contacts_Get($LangId);
	$txt_res = Resources_Get($LangId);

	//$BOARD_PERONCE = 50;
	//$BOARD_MONTHOLD = 5;
	//$BOARD_NOTIFYDAYS = 7;
	
	echo "Start !<br>";
	
	////////////////////////////////////////////////////////////////////////////
	// Find all closing in 3 days POSTS LIMIT upgrades 
	$items = Array();
	
	$query = "SELECT o1.*, DATE_FORMAT(o1.endt, '%d.%m.%Y') as end_serv_dt, p1.title, p1.cost packcost, p1.adv_num as totadvpost, b1.login as uemail, b1.name as uname 
		FROM $TABLE_PAYED_PACK_ORDERS o1 
		INNER JOIN $TABLE_BUYER_PACKS p1 ON o1.pack_id=p1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON o1.user_id=b1.id 
		WHERE o1.pack_type='$BILLING_PACK_POSTNUM' AND o1.stdt<=NOW() AND o1.endt>=NOW() AND NOW()>=DATE_SUB(o1.endt, INTERVAL 3 DAY) AND o1.notified0=0 
	";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			echo "order id: ".$row->id." - ".$row->title." - ".$row->uemail.".<br>";
			
			$it = Array();
			$it['id'] = $row->id;
			$it['email'] = stripslashes($row->uemail);
			$it['name'] = stripslashes($row->uname);
			$it['end'] = stripslashes($row->end_serv_dt);
			$it['title'] = stripslashes($row->title);
			$it['cost'] = $row->packcost;
			//$it['numpost'] = $row->adv_num;
			
			$UserCfg = Buyer_LoadLimits($row->user_id);
			
			$it['maxpost'] = $UserCfg['max_post'];
			$it['maxpost0'] = ( $it['maxpost'] - $row->totadvpost );
			
			$it['curposts'] = Board_PostsNumByAuthor( $row->user_id, "", -1, 1 );
			
			$it['numpost'] = ( $it['curposts']>$it['maxpost0'] ? ($it['curposts'] - $it['maxpost0']) : "0" );
			
			$items[] = $it;
		}
		mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db)."<br>";
	
	if( count($items) > 0 )
	{
		echo "Send start<br>";
		
		include_once "../uhlibs/unisend/inc/unisender-init.php";
		
		$endordersids0 = Array();
		
		for( $i=0; $i<count($items); $i++ )
		{
			$inf = $items[$i];
			
			$endordersids0[] = $inf['id'];
			
			///////////////////////////////////////////////////////////////////
			// Send mail through unisender
			$body_data = array(
				"{FULL_NAME}" => $inf['name'],
				"{URL_ADS_LIMIT}" => $WWWHOST."u/posts/limits",
				"{DATE_EXPIRATION}" => $inf['end'],
				"{SERVICE_NAME}" => $inf['title'],
				"{DEACTIVATED_COUNT}" => $inf['numpost'],
				"{TOTAL_COUNT}" => $inf['curposts'],
			);
		
			Send_UniSenderMail($inf['email'], $inf['name'], "Заканчивается срок действия пакета - ".$inf['title'], MAIL_TPL_LIMIT_PACK_EXPIRE_WARN, $body_data);
			////////////////////////////////////////////////////////////////////
		}
		
		$query = "UPDATE $TABLE_PAYED_PACK_ORDERS SET notified0=1, notify0_dt=NOW() WHERE id IN (".implode(",",$endordersids0).")";
		if( !mysqli_query($upd_link_db,$query) )
		{
			echo mysqli_error($upd_link_db)."<br>";
		}
		
		echo "Send done<br>";
	}
	
	
	///////////////////////////////////////////////////////////////////////////////
	
	echo "<br>Start end limits<br>";
	
	////////////////////////////////////////////////////////////////////////////
	// Find all closed yesterday POSTS LIMIT upgrades 
	$items = Array();
	
	$query = "SELECT o1.*, DATE_FORMAT(o1.endt, '%d.%m.%Y') as end_serv_dt, p1.title, p1.cost packcost, p1.adv_num as totadvpost, b1.login as uemail, b1.name as uname 
		FROM $TABLE_PAYED_PACK_ORDERS o1 
		INNER JOIN $TABLE_BUYER_PACKS p1 ON o1.pack_id=p1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON o1.user_id=b1.id 
		WHERE o1.pack_type='$BILLING_PACK_POSTNUM' AND o1.stdt<=NOW() AND o1.endt<NOW() AND o1.notified=0 
	";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['email'] = stripslashes($row->uemail);
			$it['name'] = stripslashes($row->uname);
			$it['end'] = stripslashes($row->end_serv_dt);
			$it['title'] = stripslashes($row->title);
			$it['cost'] = $row->packcost;
			//$it['numpost'] = $row->adv_num;			
			$UserCfg = Buyer_LoadLimits($row->user_id);
			
			$it['maxpost'] = $UserCfg['max_post'];
			$it['maxpost0'] = ( $it['maxpost'] + $row->totadvpost );
			
			$it['curposts'] = Board_PostsNumByAuthor( $row->user_id, "", -1, 1 );
			
			$it['numpost'] = ( $it['curposts']>$it['maxpost'] ? ($it['curposts'] - $it['maxpost']) : "0" );
			
			$items[] = $it;
		}
		mysqli_free_result($res);
	}
	
	if( count($items) > 0 )
	{
		echo "Start sends<br>";
		
		include_once "../uhlibs/unisend/inc/unisender-init.php";
		
		$endordersids = Array();
		
		for( $i=0; $i<count($items); $i++ )
		{
			$inf = $items[$i];
			
			$endordersids[] = $inf['id'];
			
			///////////////////////////////////////////////////////////////////
			// Send mail through unisender
			$body_data = array(
				"{FULL_NAME}" => $inf['name'],
				"{URL_LIMIT_INCREASE}" => $WWWHOST."u/posts/limits",
				//"{DATE_EXPIRATION}" => $inf['end'],
				"{PACK_NAME}" => $inf['title'],
				"{DEACTIVATED_COUNT}" => $inf['numpost'],
				"{TOTAL_COUNT}" => $inf['curposts'],
			);			
		
			Send_UniSenderMail($inf['email'], $inf['name'], "Пакет‚ ".$inf['title']." закончился", MAIL_TPL_LIMIT_PACK_EXPIRE, $body_data);
			////////////////////////////////////////////////////////////////////
		}
		
		$query = "UPDATE $TABLE_PAYED_PACK_ORDERS SET notified=1, notify_dt=NOW() WHERE id IN (".implode(",",$endordersids).")";
		if( !mysqli_query($upd_link_db,$query) )
		{
			echo mysqli_error($upd_link_db)."<br>";
		}
		
		echo "Sends done<br>";
	}
	
	echo "<br>End<br>";
	

	////////////////////////////////////////////////////////////////////////////
	include "../inc/close-inc.php";

?>