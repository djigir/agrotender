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

	$DAYS_HISTORY = 7;
	$DAYS_HISTORY_TRADER = 183;

	$DAYS_HISTORY_COMPANY = 365;
	
	$action = GetParameter("action", "views");

	////////////////////////////////////////////////////////////////////////////
	// Delete all old statistics
	//$query = "DELETE FROM $TABLE_ADV_POST_RATE WHERE dt < DATE_SUB(NOW(), INTERVAL 30 DAY)";
	//if( !mysqli_query($upd_link_db,  $query ) )
	//{
	//	echo mysqli_error($upd_link_db);
	//}
	
	//$query = "DELETE FROM $TABLE_COMPANY_RATE WHERE dt < DATE_SUB(NOW(), INTERVAL ".$DAYS_HISTORY_COMPANY." DAY)";
	//if( !mysqli_query($upd_link_db,  $query ) )
	//{
	//	echo mysqli_error($upd_link_db);
	//}
	
	////////////////////////////////////////////////////////////////////////////
	// Update Product Views Rating
	/*
	$query = "SELECT c1.*, count(n1.id) as totnews, count(v1.id) as totvac, count(pr1.id) as totprs, count(ct1.id) as totcont, count(p1.id) as totadvs, DATEDIFF(NOW(), c1.add_date) as daysexist
		FROM $TABLE_COMPANY_ITEMS c1 
		LEFT JOIN $TABLE_COMPANY_NEWS n1 ON c1.id=n1.comp_id AND n1.visible=1 
		LEFT JOIN $TABLE_COMPANY_VACANCY v1 ON c1.id=v1.comp_id AND v1.visible=1 
		LEFT JOIN $TABLE_TRADER_PR_PRICES pr1 ON c1.author_id=pr1.buyer_id 
		LEFT JOIN $TABLE_COMPANY_CONTACTS ct1 ON c1.id=ct1.comp_id  
		LEFT JOIN $TABLE_ADV_POST p1 ON c1.id=p1.company_id AND p1.active=1 
		GROUP BY c1.id 
	";
	*/
	
	$processed_rows = 0;
	
	if( $action == "contacts" )
	{	
		$query = "SELECT p1.id, sum(r1.amount) as totview
			FROM $TABLE_ADV_POST p1 			
			LEFT JOIN $TABLE_ADV_POST_RATE r1 ON p1.id=r1.post_id AND metrictype=$VIEWSTAT_CONT AND r1.dt>=DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
			WHERE p1.active=1 		
			GROUP BY p1.id
		";
		if( $res = mysqli_query($upd_link_db,  $query ) )	
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$processed_rows++;
				
				$query1 = "UPDATE $TABLE_ADV_POST SET viewnum_cont='".$row->totview."' WHERE id=".$row->id;
				if( !mysqli_query($upd_link_db,  $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			mysqli_free_result( $res );
		}
		else
			echo mysqli_error($upd_link_db);
	}
	else
	{
		/*
		$query = "SELECT p1.id, c1.id as compid, sum(r1.amount) as totview
			FROM $TABLE_ADV_POST p1 
			INNER JOIN $TABLE_COMPANY_ITEMS c1 ON c1.id=p1.company_id 
			LEFT JOIN $TABLE_ADV_POST_RATE r1 ON p1.id=r1.post_id AND metrictype=$VIEWSTAT_ADVS AND r1.dt>DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
			WHERE p1.active=1 		
			GROUP BY p1.id
		";
		*/
		$query = "SELECT p1.id, sum(r1.amount) as totview
			FROM $TABLE_ADV_POST p1 
			LEFT JOIN $TABLE_ADV_POST_RATE r1 ON p1.id=r1.post_id AND metrictype=$VIEWSTAT_ADVS AND r1.dt>DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
			WHERE p1.active=1 		
			GROUP BY p1.id
		";
		if( $res = mysqli_query($upd_link_db,  $query ) )	
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$processed_rows++;
				
				$query1 = "UPDATE $TABLE_ADV_POST SET viewnum_uniq='".$row->totview."' WHERE id=".$row->id;
				if( !mysqli_query($upd_link_db,  $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			mysqli_free_result( $res );
		}
		else
			echo mysqli_error($upd_link_db);
	}
	
	echo "<br>All done<br><br>Processed ".$processed_rows." rows<br>";

	////////////////////////////////////////////////////////////////////////////

	include "../inc/close-inc.php";

?>