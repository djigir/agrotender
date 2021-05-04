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
	
	
	////////////////////////////////////////////////////////////////////////////
	$runs = Array();
	
	$query = "SELECT * FROM $TABLE_ADV_TOPIC_POSTNUM_RUNS ORDER BY obl_id";
	if( $res = mysqli_query($upd_link_db,  $query ) )	
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$runs[$row->obl_id] = Array("id" => $row->id, "dt" => $row->modify_date);
			
			echo $row->obl_id." - ".$REGIONS[$row->obl_id]." = ".$row->modify_date."<br>";
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	$regadd = Array();
	
	foreach($REGIONS as $oblid => $name)
	{
		if( isset($runs[$oblid]) )
		{
			// record exists...
		}
		else
		{
			$regadd[] = $oblid;
		}
	}
	
	// 
	echo "Добавить данные для областeй: ".implode(",",$regadd)."<br>";
	
	$regmode = "update";
	$regadd_id = -1;
	$run_id = 0;
	if( count($regadd)>0 )
	{
		$regadd_id = $regadd[0];
		$regmode = "add";
	}
	
	if( $regadd_id == -1 )
	{
		echo "Обновить данные по существующим областям - все записи есть в базе, добавлять нечего<br>";
		
		// find data to refresh
		$query = "SELECT * FROM $TABLE_ADV_TOPIC_POSTNUM_RUNS WHERE modify_date<DATE_SUB(NOW(), INTERVAL 6 HOUR) ORDER BY modify_date LIMIT 0,1";
		if( $res = mysqli_query($upd_link_db,  $query ) )	
		{
			if( $row = mysqli_fetch_object( $res ) )
			{				
				$regadd_id = $row->obl_id;
				$run_id = $row->id;
			}
			mysqli_free_result( $res );
		}
		
		if( $regadd_id != -1 )
		{
			echo "Будем обновлять - ".$regadd_id." - ".$REGIONS[$regadd_id]."<br>";
		}
		else
		{
			echo "Все данные актуальны, обновлять не надо<br>";
		}
	}
	else
	{
		echo "Выбрали для добавления - ".$regadd_id." - ".$REGIONS[$regadd_id]."<br>";
	}	
	
	if( ($regmode == "add") && ($regadd_id != -1) )
	{
		$query1 = "INSERT INTO $TABLE_ADV_TOPIC_POSTNUM_RUNS (obl_id, type_id, add_date, modify_date) VALUES ('$regadd_id','0', NOW(), NOW())";
		if( !mysqli_query($upd_link_db,  $query1 ) )
		{
			echo mysqli_error($upd_link_db);
		}
		else
		{
			$run_id = mysqli_insert_id();
		}
	}
	
	if( ($run_id != 0) && ($regadd_id != -1) )
	{
		// Calculate posts in topics in selected obl (region)
		$adobl = $regadd_id;
		
		$topgr = Board_TopicGroups( $LangId, 0 );
		//$topics = Board_TopicLevel($LangId, 0, "bygroups");
		for($i1=0;$i1<count($topgr);$i1++)
		{
			//echo '<li><span>'.$catname.'</span>';
			$prev_col_ind = -100;
				
			//$sect1 = Board_TopicLevel( $LangId, 0, "", $topgr[$i1]['id'] );
			$sect1 = Board_TopicLevel( $LangId, 0, "sortbycols", $topgr[$i1]['id'] );
			if( count($sect1) > 0 )
			{
				$group_id = -1;
				$group_num = 0;
				for( $j=0; $j<count($sect1); $j++ )
				{
					if( $sect1[$j]['sort'] != $prev_col_ind )
					{
						$prev_col_ind = $sect1[$j]['sort'];
					}

					//$TURL = Board_BuildUrl($LangId, "list", $REGIONS_URL[$adobl], $adtype, $sect1[$j]['id']);
					//echo '<li><a href="'.$TURL.'">'.$sect1[$j]['name'].'</a>
					//	<ul>';

					$sect2 = Board_TopicLevel( $LangId, $sect1[$j]['id'], "cronpostnum", 0, $adobl );
					for( $i2=0; $i2<count($sect2); $i2++ )
					{
						// Save post num to db
						$db_id = 0;
						
						$query1 = "SELECT * FROM $TABLE_ADV_TOPIC_POSTNUM WHERE topic_id='".$sect2[$i2]['id']."' AND obl_id='$adobl' AND type_id=0";
						if( $res = mysqli_query($upd_link_db,  $query1 ) )	
						{
							if( $row = mysqli_fetch_object( $res ) )
							{				
								$db_id = $row->id;
							}
							mysqli_free_result( $res );
						}
						
						if( $db_id != 0 )
						{
							$query1 = "UPDATE $TABLE_ADV_TOPIC_POSTNUM SET all_num='".$sect2[$i2]['pnum']."', modify_date=NOW() WHERE id='$db_id'";
							if( !mysqli_query($upd_link_db,  $query1 ) )
							{
								echo mysqli_error($upd_link_db);
							}
						}
						else
						{
							$query1 = "INSERT INTO $TABLE_ADV_TOPIC_POSTNUM (topic_id, obl_id, type_id, all_num, add_date, modify_date) 
								VALUES ('".$sect2[$i2]['id']."','$adobl', 0, '".$sect2[$i2]['pnum']."', NOW(), NOW())";
							if( !mysqli_query($upd_link_db,  $query1 ) )
							{
								echo mysqli_error($upd_link_db);
							}
						}
						
						//$CATLINK = Board_BuildUrl($LangId, "list", $REGIONS_URL[$adobl], $adtype, $sect2[$i2]['id']);
						//echo '<li><a href="'.$CATLINK.'">'.$sect2[$i2]['name'].'</a> ('.$sect2[$i2]['pnum'].')</li>';
					}

					//echo '</ul>
					//</li>';
				}						
			}					
		} // for groups
		
		$query = "UPDATE $TABLE_ADV_TOPIC_POSTNUM_RUNS SET modify_date=NOW() WHERE id='$run_id'";
		if( !mysqli_query($upd_link_db,  $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
		
	}
	
	/*
	{
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
	*/

	////////////////////////////////////////////////////////////////////////////

	include "../inc/close-inc.php";

?>