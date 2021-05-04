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
	// check the max number of adv posts by each user, which buy amount upgrade
	//$query = "SELECT DISTINCT o1.user_id FROM $TABLE_PAYED_PACK_ORDERS o1 WHERE o1.pack_type='$BILLING_PACK_POSTNUM' AND o1.endt>=DATE_SUB(NOW(), INTERVAL 2 MONTH)";
	$query = "SELECT b1.id, count(p1.id) as totpostnum  
		FROM $TABLE_TORG_BUYERS b1
		LEFT JOIN $TABLE_ADV_POST p1 ON b1.id=p1.author_id AND p1.archive=0 
		GROUP BY b1.id
		HAVING totpostnum>5 
		ORDER BY b1.id";
	//echo $query."<br>";	
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			echo $row->id.": ".$row->totpostnum." == ";
			
			// Calc max limit for advs
			$blimit = Buyer_LoadLimits($row->id);
			
			$limit_cur = Board_PostsNumByAuthor( $row->id, "", -1, 1 );
			
			echo "Limit: ".$blimit['max_post'].", cur: ".$limit_cur."<br>";
			
			//$blimit['max_post'] = 1;
			
			if( $limit_cur > $blimit['max_post'] )
			{							
				
				$postarr = Array();
				// send to arc old posts				
				$query1 = "SELECT id, colored, targeting, up_dt, case when ( (colored=1) OR (targeting=1) ) then 1 else 0 end as spezsort  
					FROM $TABLE_ADV_POST 
					WHERE author_id='".$row->id."' AND archive=0 
					ORDER BY spezsort DESC, up_dt DESC";
				if( $res1 = mysqli_query($upd_link_db,$query1) )
				{
					while($row1 = mysqli_fetch_object($res1))
					{
						//echo $row1->id.". ".$row1->colored.", ".$row1->targeting.", ".$row1->up_dt."<br>";						
						$postarr[] = $row1->id;
					}
					mysqli_free_result($res1);
				}
				else
					echo mysqli_error($upd_link_db)."<br>";
				
				$deactarr = array_slice($postarr, $blimit['max_post']);
				//for( $i=0; $i<count($postarr); $i++ )
				//{
				//}
				
				$query1 = "UPDATE $TABLE_ADV_POST SET archive=1 WHERE id IN (".implode(",", $deactarr).")";
				echo "<b>Clear</b> - ".$query1."<br>";
				if( !mysqli_query($upd_link_db,$query1) )
					echo mysqli_error($upd_link_db)."<br>";				
			}
			
			echo "<br>";
		}
		mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db)."<br>";
		

	////////////////////////////////////////////////////////////////////////////
	include "../inc/close-inc.php";

?>