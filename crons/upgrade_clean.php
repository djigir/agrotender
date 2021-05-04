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
	
	////////////////////////////////////////////////////////////////////////////
	// Delete all colored upgrades 
	$clearids = Array();
	$query = "SELECT p1.id, o1.id as orderid 
		FROM $TABLE_ADV_POST p1 
		LEFT JOIN $TABLE_PAYED_PACK_ORDERS o1 ON p1.id=o1.post_id AND o1.pack_type='$BILLING_PACK_POSTCOLOR' AND stdt<=NOW() AND endt>=NOW() 
		WHERE p1.colored=1";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			if( $row->orderid != null )
			{
				// ok
			}
			else
			{
				$clearids[] = $row->id;
			}
		}
		mysqli_free_result($res);
	}
	
	if( count($clearids) > 0 )
	{
		$query = "UPDATE $TABLE_ADV_POST SET colored=0 WHERE id IN (".implode(",", $clearids).")";
		if( !mysqli_query($upd_link_db,$query) )
		{
			echo mysqli_error($upd_link_db)."<br>";
		}
	}
	
	echo "Clear Colored!!<br>";
	
	////////////////////////////////////////////////////////////////////////////
	// Delete all TOP upgrades 
	$clearids = Array();	
	
	$query = "SELECT p1.id, o1.id as orderid, b1.login as uemail, b1.name as uname  
		FROM $TABLE_ADV_POST p1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.real_author_id=b1.id 
		LEFT JOIN $TABLE_PAYED_PACK_ORDERS o1 ON p1.id=o1.post_id AND o1.pack_type='$BILLING_PACK_POSTTOP' AND stdt<=NOW() AND endt>=NOW() 
		WHERE p1.targeting=1";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			if( $row->orderid != null )
			{
				// ok
			}
			else
			{
				$clearids[] = $row->id;				
			}
		}
		mysqli_free_result($res);
	}
	if( count($clearids) > 0 )
	{
		$query = "UPDATE $TABLE_ADV_POST SET targeting=0 WHERE id IN (".implode(",", $clearids).")";
		if( !mysqli_query($upd_link_db,$query) )
		{
			echo mysqli_error($upd_link_db)."<br>";
		}
		
		echo "Cleared<br>";
		
		$items = Array();
		$byuser = [];
		
		$query = "SELECT p1.*, b1.login as uemail, b1.name as uname 
			FROM $TABLE_ADV_POST p1 
			INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.real_author_id=b1.id 
			WHERE p1.id IN (".implode(",", $clearids).")";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			$i = 0;
			while( $row = mysqli_fetch_object($res) )
			{

				
					$byuser[$i] = [
						'id' => $row->real_author_id,
						'email' => stripslashes($row->uemail),
						'name' => stripslashes($row->uname),
						'posts' => Array(),
					];					
					
					$byuser[$i]['posts'][] = [
					  'id' => $row->id,
                      'title' => stripslashes($row->title),
                      'views' => $row->viewnum,
                      'views_cont' => $row->viewnum,
                      'reklurl' => $WWWHOST.'u/posts/upgrade?adv='.$row->id
					];
				
				$i++;
			}
			mysqli_free_result($res);
		}
		
		
		include_once "../uhlibs/unisend/inc/unisender-init.php";
		
		foreach($byuser as $bid => $inf)
		{
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
			
			$body_data = array(
				"{FULL_NAME}" => $inf['name'],
				"{SERVICE_NAME}" => "Топ-объявление",
				"{ARR_TPL_ADS}" => array(),
			);
			
			for( $i=0; $i<count($inf['posts']); $i++ )
			{
				$body_data["{ARR_TPL_ADS}"][] = Array(
						"{AD_NAME}" => $inf['posts'][$i]['title'],	
						"{VIEWS}" => $inf['posts'][$i]['views'],
						"{CONTACTS_VIEWS}" => $inf['posts'][$i]['views_cont'],
						"{URL_ADVERTISE}" => $inf['posts'][$i]['reklurl'],
					);
			}
		
			Send_UniSenderMail($inf['email'], $inf['name'], "Окончилась услуга - Поднять в ТОП", MAIL_TPL_ADV_SERV_EXPIRE, $body_data);
			////////////////////////////////////////////////////////////////////
		}
	}
	
	echo "Done All!!<br>";
	

	////////////////////////////////////////////////////////////////////////////
	include "../inc/close-inc.php";

?>