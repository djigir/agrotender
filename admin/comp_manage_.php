<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/utils-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }

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

	$strings['tipedit']['en'] = "Edit This Company";
   	$strings['tipdel']['en'] = "Delete This Company";
   	$strings['hdrlist']['en'] = "Company List";
   	$strings['hdradd']['en'] = "Add Company";
   	$strings['hdredit']['en'] = "Edit Company";
   	$strings['rowdate']['en'] = "Comment date";
   	$strings['rowtitle']['en'] = "Name";
   	$strings['rowfirst']['en'] = "Preview Page";
   	$strings['rowtext']['en'] = "Company Text";
   	$strings['rowbrand']['en'] = "Company Source";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No companies in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";
	$strings['product']['en'] ="Product";

    $strings['tipedit']['ru'] = "Редактировать эту компанию";
   	$strings['tipdel']['ru'] = "Удалить эту компанию";
   	$strings['hdrlist']['ru'] = "Список компаний";
   	$strings['hdradd']['ru'] = "Добавить компанию";
   	$strings['hdredit']['ru'] = "Редакировать компанию";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Показывать на сайте";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет компаний";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";
	$strings['product']['ru']="Продукт";
	$strings['article']['ru']="Статья";

	$PAGE_HEADER['ru'] = "Редактировать компании";
	$PAGE_HEADER['en'] = "Comment Editing";



	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$ntype = GetParameter("ntype", 0);

	$typeid = GetParameter("typeid", 0);
	$topicid = GetParameter("topicid", "0:0");
	$oblid = GetParameter("oblid", 0);
	
	$sortby = GetParameter("sortby", "byreg");

	$fltmail = trim(strip_tags(GetParameter("fltmail", ""), ""));
	$flttel = trim(strip_tags(GetParameter("flttel", ""), ""));
	$fltname = trim(strip_tags(GetParameter("fltname", ""), ""));
	$fltid = trim(strip_tags(GetParameter("fltid", 0), ""));

	$isprice = GetParameter("isprice", 0);

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 200);

	$topicsel = explode(":", $topicid);
	$topicparent = ($topicsel[0] == 0);
	$topicsid = $topicsel[1];

	$datest = GetParameter("datest", date("d.m.Y", time()));
	
	$msg = "";
	
	$porttitle = "";	
	
	$tarpacks = Pack_List(false);
	$tarpacks_byid = Array();
	
	for( $i=0; $i<count($tarpacks); $i++ )
	{
		$tarpacks_byid[$tarpacks[$i]['id']] = $tarpacks[$i];
	}


	switch( $action )
	{
		case "delete":
			$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_COMPANY_ITEMS WHERE id=".$com_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_COMPANY_ITEMS2TOPIC WHERE item_id='".$com_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }

                    if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_COMPANY_RATE WHERE item_id='".$com_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }

                    if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_COMPANY_STARTPAGE WHERE comp_id='".$com_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }

                    $query = "SELECT * FROM $TABLE_COMPANY_COMMENT WHERE item_id='".$com_id[$i]."'";
                    if( $res = mysqli_query($upd_link_db, $query ) )
                    {
                    	while( $row = mysqli_fetch_object( $res ) )
                    	{
                    		$query1 = "DELETE FROM $TABLE_COMPANY_COMMENT_LANGS WHERE item_id=".$row->id;
							if( !mysqli_query($upd_link_db, $query1 ) )
							{
								echo mysqli_error($upd_link_db);
							}
                    	}
                    	mysqli_free_result( $res );
                    }

                    if( !mysqli_query($upd_link_db, "UPDATE $TABLE_ADV_POST SET company_id=0 WHERE company_id='".$com_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }

    				$query = "SELECT * FROM $TABLE_COMPANY_ADVTOPICS WHERE comp_id='".$com_id[$i]."'";
					if( $res = mysqli_query($upd_link_db, $query ) )
					{
						while( $row = mysqli_fetch_object( $res ) )
						{
							$query1 = "DELETE FROM $TABLE_COMPANY_POST2ADVTOPICS WHERE topic_id=".$row->id;
							if( !mysqli_query($upd_link_db, $query1 ) )
							{
								echo mysqli_error($upd_link_db);
							}
						}
						mysqli_free_result( $res );
					}

    				$query = "DELETE FROM $TABLE_COMPANY_ADVTOPICS WHERE comp_id='".$com_id[$i]."'";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_COMPANY_ITEMS WHERE id=".$item_id." "))
			{
       			echo "<b>".mysqli_error($upd_link_db)."</b>";
   			}
   			else
   			{
   				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_COMPANY_ITEMS2TOPIC WHERE item_id='".$item_id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}

				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_COMPANY_RATE WHERE item_id='".$item_id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}

				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_COMPANY_STARTPAGE WHERE comp_id='".$item_id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}

				$query = "SELECT * FROM $TABLE_COMPANY_COMMENT WHERE item_id='".$item_id."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$query1 = "DELETE FROM $TABLE_COMPANY_COMMENT_LANGS WHERE item_id=".$row->id;
						if( !mysqli_query($upd_link_db, $query1 ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
					mysqli_free_result( $res );
				}

				$query = "SELECT * FROM $TABLE_COMPANY_ADVTOPICS WHERE comp_id='".$item_id."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$query1 = "DELETE FROM $TABLE_COMPANY_POST2ADVTOPICS WHERE topic_id=".$row->id;
						if( !mysqli_query($upd_link_db, $query1 ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
					mysqli_free_result( $res );
				}

   				$query = "DELETE FROM $TABLE_COMPANY_ADVTOPICS WHERE comp_id='".$item_id."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}

				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_ADV_POST SET company_id=0 WHERE company_id='".$item_id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
   			}
    		break;

		case "update":
			$item_id = GetParameter("item_id", "0");
			$newstitle = GetParameter("newstitle", "");
    		// $newscont = GetParameter("newscont", "", false);
    		// $newsshort = GetParameter("newsshort", "", false);
			// $newskont = GetParameter("newskont", "", false);
			// $newscity = GetParameter("newscity", "");
			// $newsphone = GetParameter("newsphone", "");
			// $newsmail = GetParameter("newsmail", "");
			// $newsobl = GetParameter("newsobl", 1);
			$newstrader = GetParameter("newstrader", 0);
			$newstradersort = GetParameter("newstradersort", 0);
			$newstraderprem = GetParameter("newstraderprem", 0);
			
			$newstrader2 = GetParameter("newstrader2", 0);
			$newstradersort2 = GetParameter("newstradersort2", 0);
			$newstraderprem2 = GetParameter("newstraderprem2", 0);
			
    		//$newsfirst = GetParameter("newsfirst", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");
    		// $newstraderurl = GetParameter("newstraderurl", "");
			
			$newspackid = GetParameter("newspackid", $tarpacks[0]['id']);
			
			$news_rateadm1 = GetParameter("news_rateadm1", "1");
			$news_rateadm2 = GetParameter("news_rateadm2", "0");
			
			$newstypes = GetParameter("newstypes", null);
			
			if( $newstrader == 0 )
				$newstraderprem = 0;
			
			if( $newstrader2 == 0 )
				$newstraderprem2 = 0;

    		// $tchk = GetParameter("tchk", null);
			//$a=getdate();
			//$time=$a['hours'].":".$a['minutes'].":".$a['seconds'];
    		//$db_datest = substr($datest, 6, 4)."-".substr($datest, 3, 2)."-".substr($datest, 0, 2)." ".$time;
			
			// Get current company info
			$compinfo = Comp_ItemInfo($LangId, $item_id);

			$query = "UPDATE $TABLE_COMPANY_ITEMS SET 
				title='".addslashes($newstitle)."',
				trader_price_avail='$newstrader', trader_premium='$newstraderprem', trader_sort='$newstradersort',
				trader_price_sell_avail='$newstrader2', trader_premium_sell='$newstraderprem2', trader_sort_sell='$newstradersort2', 
				rate_admin1='$news_rateadm1', rate_admin2='$news_rateadm2', site_pack_id='".$newspackid."'  
				WHERE id='".$item_id."'";
			if(!mysqli_query($upd_link_db, $query ))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			
			if( $compinfo['site_pack'] != $newspackid )
			{
				$query = "UPDATE $TABLE_ADV_POST SET targeting=0 WHERE company_id='$item_id'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			// $query = "DELETE FROM $TABLE_COMPANY_ITEMS2TOPIC WHERE item_id='$item_id'";
			// if( !mysqli_query($upd_link_db, $query ) )
			// {
			// 	echo mysqli_error($upd_link_db);
			// }

			// for($i=0; $i<count($tchk); $i++)
			// {
			// 	$query = "INSERT INTO $TABLE_COMPANY_ITEMS2TOPIC (topic_id, item_id, add_date) VALUES ('".$tchk[$i]."', '$item_id', NOW())";
			// 	if( !mysqli_query($upd_link_db, $query ) )
			// 	{
			// 		echo mysqli_error($upd_link_db);
			// 	}
			// }
			
			$query = "DELETE FROM $TABLE_TRADER_TYPES2ITEMS WHERE item_id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			
			for($i=0; $i<count($newstypes); $i++)
			{
				$query = "INSERT INTO $TABLE_TRADER_TYPES2ITEMS (type_id, item_id, add_date) VALUES ('".$newstypes[$i]."', '$item_id', NOW())";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			break;
			
		case "addport":
			$mode = "edit";
			$item_id = GetParameter("item_id", "0");
			$portid = GetParameter("portid", 0);
			$porttitle = GetParameter("porttitle", "");
			
			$tr_buyerid = 0;
			if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_COMPANY_ITEMS m1 WHERE m1.id='$item_id'"))
			{
				if($row = mysqli_fetch_object($res))
				{
					$tr_buyerid = $row->author_id;
				}
				mysqli_free_result($res);
			}
			
			if( $tr_buyerid != 0 )
			{
				/*
				$ports_cur = Trader_GetPortList($LangId, 0, $tr_buyerid);
				$ports_cur_byids = Array();
				for( $i=0; $i<count($ports_cur); $i++ )
				{
					$ports_cur_byids[$ports_cur[$i]['id']] = true;
				}
				*/
				
				//var_dump($ports_cur_byids);
				///echo "<br>";
				
				$portinf = Trader_GetPortInfo($LangId, $portid);
				
						
				// Add new assign
				$query1 = "INSERT INTO $TABLE_TRADER_PR_PLACES (buyer_id, port_id, obl_id, type_id, place, is_port) 
					VALUES ('$tr_buyerid', '".$portid."', '".$portinf['obl_id']."', '".$TRADER_PLACE_PORT."', '".addslashes($porttitle)."', 1)";
				if( !mysqli_query($upd_link_db,$query1) )
				{
					echo mysqli_error($upd_link_db)."<br>";
				}	
				else
				{
					$porttitle = "";
				}
			}			
			break;
			
		case "addports":
			$mode = "edit";
			$item_id = GetParameter("item_id", "0");
			$portids = GetParameter("portids", null);
			
			$tr_buyerid = 0;
			if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_COMPANY_ITEMS m1 WHERE m1.id='$item_id'"))
			{
				if($row = mysqli_fetch_object($res))
				{
					$tr_buyerid = $row->author_id;
				}
				mysqli_free_result($res);
			}
			
			if( $tr_buyerid != 0 )
			{
				$ports_cur = Trader_GetPortList($LangId, 0, $tr_buyerid);
				$ports_cur_byids = Array();
				for( $i=0; $i<count($ports_cur); $i++ )
				{
					$ports_cur_byids[$ports_cur[$i]['id']] = true;
				}
				
				//var_dump($ports_cur_byids);
				//echo "<br>";
				
				for( $i=0; $i<count($portids); $i++ )
				{
					$port_place_id = 0;
					$query = "SELECT * FROM $TABLE_TRADER_PR_PLACES pl1 WHERE pl1.buyer_id='$tr_buyerid' AND pl1.port_id='".$portids[$i]."'";
					if( $res = mysqli_query($upd_link_db,$query) )
					{
						while( $row = mysqli_fetch_object($res) )
						{
							$port_place_id = $row->id;							
						}
						mysqli_fetch_object($res);
					}
					
					if( $port_place_id == 0 )
					{
						$portinf = Trader_GetPortInfo($LangId, $portids[$i]);
						
						// Add new assign
						$query1 = "INSERT INTO $TABLE_TRADER_PR_PLACES (buyer_id, port_id, obl_id, type_id, place, is_port) 
							VALUES ('$tr_buyerid', '".$portids[$i]."', '".$portinf['obl_id']."', '".$TRADER_PLACE_PORT."', '', 1)";
						if( !mysqli_query($upd_link_db,$query1) )
						{
							echo mysqli_error($upd_link_db)."<br>";
						}
					}
					
					if( isset($ports_cur_byids[$portids[$i]]) )
					{
						$ports_cur_byids[$portids[$i]] = false;
					}
				}
				
				//var_dump($ports_cur_byids);
				//echo "<br>";
				
				// Delete all unchecked ports
				$port_ids_del = Array();
				foreach($ports_cur_byids as $portid => $todel)
				{
					if( $todel )
						$port_ids_del[] = $portid;
				}
				
				//var_dump($port_ids_del);
				//echo "<br>";
				
				if( count($port_ids_del)>0 )
				{
					$placeids = Array();
					$query = "SELECT id FROM $TABLE_TRADER_PR_PLACES WHERE buyer_id='$tr_buyerid' AND port_id IN (".implode(",", $port_ids_del).")";
					if( $res = mysqli_query($upd_link_db,$query) )
					{
						while( $row = mysqli_fetch_object($res) )
						{
							$placeids[] = $row->id;
						}
						mysqli_free_result($res);
					}
					
					//echo "places: <br>";
					//var_dump($placeids);
					//echo "<br>";
										
					if( count($placeids) > 0 )
					{
						$query = "DELETE FROM $TABLE_TRADER_PR_PRICES WHERE place_id IN ('".implode(",", $placeids)."')";
						if( !mysqli_query($upd_link_db,$query) )
						{
							echo mysqli_error($upd_link_db);
						}
					}					
					
					$query1 = "DELETE FROM $TABLE_TRADER_PR_PLACES WHERE buyer_id='$tr_buyerid' AND port_id IN (".implode(",", $port_ids_del).")";
					if( !mysqli_query($upd_link_db,$query1) )
					{
						echo mysqli_error($upd_link_db)."<br>";
					}
				}
			}			
			break;
			
		case "deleteport":
			$mode = "edit";
			$item_id = GetParameter("item_id", "0");
			$place_id = GetParameter("place_id", 0);
			
			$tr_buyerid = 0;
			if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_COMPANY_ITEMS m1 WHERE m1.id='$item_id'"))
			{
				if($row = mysqli_fetch_object($res))
				{
					$tr_buyerid = $row->author_id;
				}
				mysqli_free_result($res);
			}
			
			if( $tr_buyerid != 0 )
			{
				$port_id = 0;
				
				$query = "SELECT * FROM $TABLE_TRADER_PR_PLACES WHERE buyer_id='$tr_buyerid' AND id='".addslashes($place_id)."'";
				if( $res = mysqli_query($upd_link_db,$query) )
				{
					if($row = mysqli_fetch_object($res))
					{
						$port_id = $row->port_id;
					}
					mysqli_free_result($res);
				}
				
				if( $port_id != 0 )
				{									
					$query = "DELETE FROM $TABLE_TRADER_PR_PRICES WHERE place_id='".$place_id."'";
					if( !mysqli_query($upd_link_db,$query) )
					{
						echo mysqli_error($upd_link_db);
					}
					
					$query = "DELETE FROM $TABLE_TRADER_PR_PLACES WHERE id='".$place_id."'";
					if( !mysqli_query($upd_link_db,$query) )
					{
						echo mysqli_error($upd_link_db)."<br>";
					}
				}
			}
			break;
			
		case "moveportprice":
			$mode = "edit";
			$item_id = GetParameter("item_id", "0");
			
			$oldportid = GetParameter("oldportid", 0);
			$portid = GetParameter("portid", 0);
			
			if( ($oldportid != 0) && ($portid != 0) )
			{
				$tr_buyerid = 0;
				if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_COMPANY_ITEMS m1 WHERE m1.id='$item_id'"))
				{
					if($row = mysqli_fetch_object($res))
					{
						$tr_buyerid = $row->author_id;
					}
					mysqli_free_result($res);
				}
				
				//echo "Перенос цен для Buyer_id = ".$tr_buyerid."<br>";
				
				if( $tr_buyerid != 0 )
				{
					// Now try to find all assigned culters to old ports
					$cult2ptype = Array();
					//$is_assigned = 0;
					$query = "SELECT * FROM $TABLE_TRADER_PR_CULTS2BUYER WHERE buyer_id='$tr_buyerid' AND type_id='$TRADER_PLACE_OLDPORT'"; 
					if( $res = mysqli_query($upd_link_db, $query ) )
					{
						while( $row = mysqli_fetch_object( $res ) )
						{
							//$is_assigned = $row->id;
							$cult2ptype[] = Array(
								"cult_id" => $row->cult_id,
								"acttype" =>$row->acttype
							);
						}
						mysqli_free_result( $res );
					}
					
					//var_dump($cult2ptype);
					//echo "<br><br>";

					for( $i=0; $i<count($cult2ptype); $i++ )
					{
						$is_assigned = 0;
						$query = "SELECT * FROM $TABLE_TRADER_PR_CULTS2BUYER WHERE buyer_id='$tr_buyerid' AND type_id='$TRADER_PLACE_PORT' 
							AND cult_id='".$cult2ptype[$i]['cult_id']."' AND acttype='".$cult2ptype[$i]['acttype']."'"; 
						
						//echo $query."<br>";
							
						if( $res = mysqli_query($upd_link_db, $query ) )
						{
							while( $row = mysqli_fetch_object( $res ) )
							{
								$is_assigned = $row->id;
							}
							mysqli_free_result( $res );
						}
						
						//echo "Found assign = ".$is_assigned."<br>";
						
						if( $is_assigned == 0 )
						{
							$query = "INSERT INTO $TABLE_TRADER_PR_CULTS2BUYER (buyer_id, cult_id, type_id, acttype, sort_ind) 
								VALUES ('$tr_buyerid', '".$cult2ptype[$i]['cult_id']."', '$TRADER_PLACE_PORT', '".$cult2ptype[$i]['acttype']."', '0')";
							if( !mysqli_query($upd_link_db, $query ) )
							{
								echo mysqli_error($upd_link_db)."<br>";
							}
							else
							{
								//$msg .= "В таблицу цен добавлен новый товар.<br>";
							}
						}
					}
				}
				
				
				
				// Move prices from old place to new port_place record
				$query = "UPDATE $TABLE_TRADER_PR_PRICESARC SET place_id='$portid' WHERE place_id='".$oldportid."'";
				//echo $query."<br>";
				if( !mysqli_query($upd_link_db,$query) )
				{
					echo mysqli_error($upd_link_db)."<br>";
				}
				
				$query = "UPDATE $TABLE_TRADER_PR_PRICES SET place_id='$portid' WHERE place_id='".$oldportid."'";
				//echo $query."<br>";
				if( !mysqli_query($upd_link_db,$query) )
				{
					echo mysqli_error($upd_link_db)."<br>";
				}
			}
			
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newstitle = "";
		// $newscont = "";
		// $newsshort = "";
		// $newskont = "";
		// $newscity = "";
		// $newsphone = "";
		// $newsmail = "";
		// $newsobl = 1;
		$newstrader = 0;
		// $newstraderurl = "";
		$newstradersort = 0;
		$newstraderprem = 0;
		
		$newstrader2 = 0;
		$newstradersort2 = 0;
		$newstraderprem2 = 0;
		
		$news_rateadm1 = 1.0;
		$news_rateadm2 = 0;
		
		$news_buyerid = 0;

		//$newsfirst = 0;
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_COMPANY_ITEMS m1 WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$news_buyerid = $row->author_id;
				
				$newstitle= stripslashes($row->title);
				// $newscont = stripslashes($row->content);
				// $newsshort = stripslashes($row->short);
				// $newskont = stripslashes($row->contacts);
				// $newscity = stripslashes($row->city);
				// $newsphone = stripslashes($row->phone);
				// $newsmail = stripslashes($row->email);
				// $newsobl = $row->obl_id;
				$newstrader = $row->trader_price_avail;
				//$newsfirst = $row->visible;
				//$newsbrand = $row->brand_id;
				//$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);
				$myfile = stripslashes($row->logo_file);
				// $newstraderurl = stripslashes($row->trader_old_url);
				$newstradersort = $row->trader_sort;
				$newstraderprem = $row->trader_premium;
				
				$newstrader2 = $row->trader_price_sell_avail;
				$newstradersort2 = $row->trader_sort_sell;
				$newstraderprem2 = $row->trader_premium_sell;
				
				$news_rateadm1 = $row->rate_admin1;
				$news_rateadm2 = $row->rate_admin2;
			}
			mysqli_free_result($res);
		}

		$cinfo = Comp_ItemInfo( $LangId, $item_id );

		//echo "ID: $item_id<br />";
?>
	<div style="padding: 10px 0px 20px 0px; text-align: center;"><a href="<?=$PHP_SELF;?>">Вернуться к списку компаний</a></div>
	
	<?=( $msg != "" ? '<div style="padding: 10px 20px; text-align: center;">'.$msg.'</div>' : '' );?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="ntype" value="<?=$ntype;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
	<input type="hidden" name="topicid" value="<?=$topicid;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff">Лого:</td><td class="fr"><?=( $myfile != "" ? '<img src="'.$WWWHOST.$myfile.'" alt="" />' : 'нет логотипа' );?></td></tr>
	<!-- <tr><td class="ff">Краткое описание:</td><td class="fr"><textarea class="ckeditor" rows="3" cols="80" name="newsshort"><?=$newsshort;?></textarea></td></tr>
	<tr><td class="ff">Полное описание:</td><td class="fr"><textarea class="ckeditor" rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	<tr><td class="ff">Контактная информация:</td><td class="fr"><textarea class="ckeditor" rows="10" cols="80" name="newskont"><?=$newskont;?></textarea></td></tr> -->
	<!-- <tr><td class="ff">Область:</td><td class="fr">
		<select name="newsobl">
	<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.( $i == $newsobl ? ' selected' : '' ).'>'.$REGIONS[$i].'</option>';
		}
	?>
		</select>
	</td></tr>
	<tr><td class="ff">Город:</td><td class="fr"><input type="text" size="40" name="newscity" value="<?=$newscity;?>" /></td></tr>
	<tr><td class="ff">Телефон:</td><td class="fr"><input type="text" size="40" name="newsphone" value="<?=$newsphone;?>" /></td></tr>
	<tr><td class="ff">email:</td><td class="fr"><input type="text" size="40" name="newsmail" value="<?=$newsmail;?>" /></td></tr>
    <tr><td class="ff">Старый УРЛ:</td><td class="fr"><input type="text" size="60" name="newstraderurl" value="<?=$newstraderurl;?>" /></td></tr> -->
    <tr><td class="ff">Таблица закупок:</td><td class="fr"> Активна: <select name="newstrader" style="margin-right: 10px">
		<option value="0"<?=($newstrader == 0 ? " selected" : "");?>>Нет</option>
		<option value="1"<?=($newstrader == 1 ? " selected" : "");?>>Да</option>
	</select>
	Премиум:<select name="newstraderprem" style="margin-right: 10px">
		<option value="0"<?=($newstraderprem == 0 ? " selected" : "");?>>Нет</option>
		<option value="1"<?=($newstraderprem == 1 ? " selected" : "");?>>Да</option>
	</select>
	Приоритет: <input type="text" name="newstradersort" size="2" value="<?=$newstradersort;?>" />
	</td></tr>	
<?php
	/*
	<tr>
		<td class="ff">Тип трейдера:</td>
		<td class="fr">
	<?php
		$tlist = Array();
		$query = "SELECT t1.*, case when t2i.id IS NULL then 0 else t2i.id end as t2iid 
			FROM $TABLE_TRADER_TYPES t1 
			LEFT JOIN $TABLE_TRADER_TYPES2ITEMS t2i ON t1.id=t2i.type_id AND t2i.item_id='".$item_id."' 
			ORDER BY t1.sort_num, t1.name";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while( $row = mysqli_fetch_object($res) )
			{
				$ti = Array();
				$ti['id'] = $row->id;
				$ti['checked'] = ($row->t2iid != 0);
				$ti['t2i'] = $row->t2iid;
				$ti['name'] = stripslashes($row->name);
				$ti['url'] = stripslashes($row->url);
				
				$tlist[] = $ti;
			}
			mysqli_free_result($res);
		}
		
		for( $i=0; $i<count($tlist); $i++ )
		{
			echo '<input type="checkbox" name="newstypes[]" value="'.$tlist[$i]['id'].'" '.($tlist[$i]['checked'] ? ' checked' : '').'> &nbsp; '.$tlist[$i]['name'].'<br>';
		}
	?>
		</td>
	</tr>	
	*/
?>
	<tr><td class="ff">Таблица продаж:</td><td class="fr"> Активна: <select name="newstrader2" style="margin-right: 10px">
		<option value="0"<?=($newstrader2 == 0 ? " selected" : "");?>>Нет</option>
		<option value="1"<?=($newstrader2 == 1 ? " selected" : "");?>>Да</option>
	</select>
	Премиум:<select name="newstraderprem2" style="margin-right: 10px">
		<option value="0"<?=($newstraderprem2 == 0 ? " selected" : "");?>>Нет</option>
		<option value="1"<?=($newstraderprem2 == 1 ? " selected" : "");?>>Да</option>
	</select>
	Приоритет: <input type="text" name="newstradersort2" size="2" value="<?=$newstradersort2;?>" />
	</td></tr>

	<!-- <tr><td class="ff">Цены трейдера:</td><td class="fr"><select name="newstrader">
		<option value="0"<?=($newstrader == 0 ? " selected" : "");?>>Нет</option>
		<option value="1"<?=($newstrader == 1 ? " selected" : "");?>>Да</option>
	</select></td></tr>
	<tr><td class="ff">Премиум трейдер:</td><td class="fr"><select name="newstraderprem">
		<option value="0"<?=($newstraderprem == 0 ? " selected" : "");?>>Нет</option>
		<option value="1"<?=($newstraderprem == 1 ? " selected" : "");?>>Да</option>
	</select></td></tr> -->
	<tr><td class="ff">Пакет размещения:</td><td class="fr"><select name="newspackid">
<?php
	for( $i=0; $i<count($tarpacks); $i++ )
	{
		echo '<option value="'.$tarpacks[$i]['id'].'"'.($newspackid == $tarpacks[$i]['id'] ? " selected" : "").'>'.$tarpacks[$i]['title'].'</option>';
	}
?>
	</select></td></tr>	 
	<!-- <tr><td class="ff">Приоритет трейдера:</td><td class="fr"><input type="text" name="newstradersort" size="2" value="<?=$newstradersort;?>" /></td></tr> -->
	
	<tr><td class="ff">К рейтинга Admin1:</td><td class="fr"><input type="text" name="news_rateadm1" size="5" value="<?=$news_rateadm1;?>" /></td></tr>
	<tr><td class="ff">К рейтинга Admin2:</td><td class="fr"><input type="text" name="news_rateadm2" size="5" value="<?=$news_rateadm2;?>" /></td></tr>
		
	<!-- <tr><td class="fr" colspan="2">
	<?php
		$grcols = 0;
		$grid_old = -1;
		$query = "SELECT t1.*, g1.id as grid, g1.title as grname
			FROM $TABLE_COMPANY_TOPIC t1
			LEFT JOIN $TABLE_COMPANY_TGROUPS g1 ON t1.menu_group_id=g1.id
			WHERE t1.parent_id='0'
			ORDER BY g1.sort_num, g1.id, t1.sort_num, t1.title";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				if($grid_old != $row->grid)
				{
					if( $grid_old != -1 )
					{
						echo '</div>';

						if( $grcols % 4 == 0 )
						{
							echo '<div class="both"></div>';
						}
					}

					$grid_old = $row->grid;
					$grcols++;

					echo '<div class="tgcol">
						<div class="tghdr"><b>'.stripslashes($row->grname).'</b></div>';
				}

				$checked = false;
				if( $mode == "edit" )
				{
					for( $i=0; $i<count($cinfo['topics']); $i++ )
					{
						if( $cinfo['topics'][$i]['id'] == $row->id )
						{
							$checked = true;
							break;
						}
					}
				}

				echo '<input type="checkbox" name="tchk[]" value="'.$row->id.'" '.($checked ? ' checked' : '').' /> '.stripslashes($row->title).'<br />';

				$query1 = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id=".$row->id;
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$checked = false;
						if( $mode == "edit" )
						{
							for( $i=0; $i<count($cinfo['topics']); $i++ )
							{
								if( $cinfo['topics'][$i]['id'] == $row1->id )
								{
									$checked = true;
									break;
								}
							}
						}

						echo '&nbsp;&nbsp;&nbsp; <input type="checkbox" name="tchk[]" value="'.$row1->id.'" '.($checked ? ' checked' : '').' /> '.stripslashes($row1->title).'<br />';
					}
					mysqli_free_result( $res1 );
				}
			}
			mysqli_free_result( $res );
		}

		if( $grid_old != -1 )
		{
			echo '</div>';
		}
	?>

	</td></tr> -->
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnrefresh'][$lang];?> "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
		
<?php		


		// Это трейдер, показать в каких портах он может публиковать цены
		if( $newstrader == 1 )
		{
			$ports = Trader_GetPortList($LangId, 0, $news_buyerid);
			$ports_chk = Array();
			for($i=0; $i<count($ports); $i++)
			{
				$ports_chk[$ports[$i]['id']] = true;
			}
			/*
			$ports = Array();
			$ports_chk = Array();
			
			$query = "SELECT pl1.id as placeid, p1.*, p2.portname 
				FROM $TABLE_TRADER_PR_PLACES pl1 
				INNER JOIN $TABLE_TRADER_PR_PORTS p1 ON pl1.port_id=p1.id 
				INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
				WHERE pl1.buyer_id='$news_buyerid' 
				ORDER BY p1.obl_id, p2.portname";
			if( $res = mysqli_query($upd_link_db,$query) )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					$pp = Array();
					$pp['id'] = $row->id;
					$pp['obl_id'] = $row->obl_id;
					$pp['placeid'] = $row->placeid;
					$pp['url'] = stripslashes($row->url);
					$pp['name'] = stripslashes($row->portname);
					$pp['act'] = $row->active;
					
					$ports[] = $pp;
					
					$ports_chk[$row->id] = true;
				}
				mysqli_fetch_object($res);
			}
			*/
			
			echo '<br><br>
			<h3>Перечень портов для Трейдера</h3>
			<table align="center" cellspacing="2" cellpadding="0">
			'.( false ? '<form action="'.$PHP_SELF.'" method=POST>
			<input type="hidden" name="action" value="delete" />' : '' ).'
			<tr>
				<th>&nbsp;</th>
				<th>Область</th>    	
				<th>Название</th>
				<th>Дополн.</th>
				<th>Активн.</th>
				<th>Функции</th>
			</tr>
			';
			
			for( $i=0; $i<count($ports); $i++ )
			{
				echo '<tr>
				<td>&nbsp;</td>
				<td>'.$REGIONS[$ports[$i]['obl_id']].'</td>
				<td>'.$ports[$i]['name'].'</td>
				<td>'.$ports[$i]['placename'].'</td>
				<td>'.( $ports[$i]['act'] ? 'Да' : '<span style="color: red;">Нет</span>' ).'</td>
				<td><a onclick="return confirm(\'Отвязать порт '.$ports[$i]['name'].'?\')" href="'.$PHP_SELF.'?action=deleteport&item_id='.$item_id.'&place_id='.$ports[$i]['placeid'].'" title="Отвязать порт от трейдера"><img src="img/delete.gif" width="20" height="20" border="0" alt="'.$strings['tipdel'][$lang].'" /></a>&nbsp;</td>
				</tr>';
			}
			
			echo '</table>
			<br>';
			
			
			$ports = Trader_GetPortList($LangId);
			/*
			$ports = Array();			
			$query = "SELECT p1.*, p2.portname 
				FROM $TABLE_TRADER_PR_PORTS p1 
				INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
				ORDER BY p1.obl_id, p2.portname";
			if( $res = mysqli_query($upd_link_db,$query) )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					$pp = Array();
					$pp['id'] = $row->id;
					$pp['obl_id'] = $row->obl_id;
					$pp['url'] = stripslashes($row->url);
					$pp['name'] = stripslashes($row->portname);
					$pp['act'] = $row->active;
					
					$ports[] = $pp;					
				}
				mysqli_fetch_object($res);
			}
			*/
			
			echo '<br><br>
			<h3>Привязка портов для Трейдера</h3>
			<form action="'.$PHP_SELF.'" method=POST>
			<input type="hidden" name="action" value="addport" />
			<input type="hidden" name="item_id" value="'.$item_id.'" />';
			
			echo '<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">
				<tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="porttitle" value="'.$porttitle.'" /></td></tr>
				<tr><td class="ff">Порт:</td><td class="fr"><select name="portid">
				';
				
			for( $i=0; $i<count($ports); $i++ )
			{
				echo '<option value="'.$ports[$i]['id'].'">'.$REGIONS[$ports[$i]['obl_id']].' :: '.$ports[$i]['name'].' ('.( $ports[$i]['act'] ? 'Да' : '<span style="color: red;">Нет</span>' ).')</option>';
			}	
				
				echo '</select></td></tr>
				<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Добавить порт "></td></tr>
				</table>
			</td></tr>
			</table>';
			
			/*
			echo '<table align="center" cellspacing="2" cellpadding="0">			
			<tr>
				<th>&nbsp;</th>
				<th>Область</th>    	
				<th>Название</th>
				<th>Активн.</th>
			</tr>
			';
			
			for( $i=0; $i<count($ports); $i++ )
			{
				echo '<tr>
				<td><input type="checkbox" name="portids[]" value="'.$ports[$i]['id'].'" '.( isset($ports_chk[$ports[$i]['id']]) ? ' checked' : '' ).'></td>
				<td>'.$REGIONS[$ports[$i]['obl_id']].'</td>
				<td>'.$ports[$i]['name'].'</td>
				<td>'.( $ports[$i]['act'] ? 'Да' : '<span style="color: red;">Нет</span>' ).'</td>				
				</tr>';
			}
			
			echo '
			<tr><td align="center" colspan="4"><input type="submit" name="savebut" value=" Применить " /></td></tr>			
			</table>';
			*/
			
			echo '</form>
			<br>
			';
			
			$oldports = Trader_GetPlaces($LangId, $news_buyerid, $TRADER_PLACE_OLDPORT, "", 0, true);
			$ports = Trader_GetPortList($LangId, 0, $news_buyerid);
			
			//
			echo '<br><br>
			<h3>Перенос цен со старых портов</h3>
			<form action="'.$PHP_SELF.'" method=POST>
			<input type="hidden" name="action" value="moveportprice" />
			<input type="hidden" name="item_id" value="'.$item_id.'" />
			<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">				
				<tr><td class="ff">Старая точка:</td><td class="fr">
				<select name="oldportid">
					<option value="0">--- Выбрать старое место ---</option>';
			
			for( $i=0; $i<count($oldports); $i++ )
			{
				if( ($oldports[$i]['price_num'] == 0) && ($oldports[$i]['pricea_num'] == 0) )
					continue;
				
				echo '<option value="'.$oldports[$i]['id'].'">'.$REGIONS[$oldports[$i]['obl_id']].' :: '.$oldports[$i]['place'].' (цен: '.$oldports[$i]['price_num'].':'.$oldports[$i]['pricea_num'].')</option>';
			}
			
			echo '</select>
				</td></tr>
				<tr><td class="ff">Новый Порт:</td><td class="fr">
					<select name="portid">
						<option value="0">--- Выбрать порт ---</option>';
			
			for( $i=0; $i<count($ports); $i++ )
			{
				echo '<option value="'.$ports[$i]['placeid'].'">'.$REGIONS[$ports[$i]['obl_id']].' :: '.$ports[$i]['name'].' ('.( $ports[$i]['act'] ? 'Да' : '<span style="color: red;">Нет</span>' ).')</option>';
			}
			
			echo '</select></td></tr>
				<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Перепривязать цены "></td></tr>
				</table>
			</td></tr>
			</table>
			</form>';
		}

	}
	else
	{
?>
    <h3><?=$strings['hdrlist'][$lang];?></h3>

    <form action="<?=$PHP_SELF;?>" name="bselfrm" method="POST">
	<input type="hidden" name="sortby" value="<?=$sortby;?>" />
    <div style="padding: 10px 0px 4px 10px;">Область: &nbsp;	
    	<select name="oblid" onchange="document.forms['bselfrm'].submit();">
    		<option value="0">--- Все области ---</option>
<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($oblid == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}
?>
		</select>
		&nbsp;&nbsp;&nbsp; Секция:
		<select name="topicid">
			<option value="0:0">--- Все секции ---</option>
	<?php
		$grcols = 0;
		$grid_old = -1;
		$query = "SELECT t1.*, g1.id as grid, g1.title as grname
			FROM $TABLE_COMPANY_TOPIC t1
			LEFT JOIN $TABLE_COMPANY_TGROUPS g1 ON t1.menu_group_id=g1.id
			WHERE t1.parent_id='0'
			ORDER BY g1.sort_num, g1.id, t1.sort_num, t1.title";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				if($grid_old != $row->grid)
				{
					$grid_old = $row->grid;
					$grcols++;

					echo '<option value="0:0">'.stripslashes($row->grname).'</option>';
				}

				echo '<option value="0:'.$row->id.'" '.($topicsid == $row->id ? ' selected' : '').'>&nbsp; &nbsp; &nbsp '.stripslashes($row->title).'</option>';

				$query1 = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id=".$row->id;
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						echo '<option value="1:'.$row1->id.'" '.($topicsid == $row1->id ? ' selected' : '').'>&nbsp; &nbsp; &nbsp &nbsp; &nbsp; '.stripslashes($row1->title).'</option>';
					}
					mysqli_free_result( $res1 );
				}
			}
			mysqli_free_result( $res );
		}
	?>
		</select>
	<?php
	/* &nbsp;&nbsp;&nbsp; Тип объявления:
		<select name="typeid" onchange="document.forms['bselfrm'].submit();">
<?php
		for( $i=0; $i<count($ADVTYPE); $i++ )
		{
			echo '<option value="'.$i.'"'.($typeid == $i ? ' selected' : '').'>'.$ADVTYPE[$i].'</option>';
		}
?>
		</select> &nbsp;&nbsp;&nbsp; Секция:
		<select name="topicid" onchange="document.forms['bselfrm'].submit();">
			<option value="0">--- Все секции ---</option>
<?php
		$topics = Board_TopicLevel($LangId, 0, "bygroups");

		$grcurname = "";

		for( $i=0; $i<count($topics); $i++ )
		{
			if( $grcurname != $topics[$i]['group'] )
			{
				echo '<option value="0:0">'.( $topics[$i]['group'] != "" ? $topics[$i]['group'] : 'Разное').'</option>';
				$grcurname = $topics[$i]['group'];
			}
			echo '<option value="0:'.$topics[$i]['id'].'"'.($topicsid == $topics[$i]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp;'.$topics[$i]['name'].'</option>';

			$subtopics = Board_TopicLevel($LangId, $topics[$i]['id']);
			for( $j=0; $j<count($subtopics); $j++ )
			{
				echo '<option value="1:'.$subtopics[$j]['id'].'"'.($topicsid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
			}
		}
?>
		</select>
	*/
	?>
		&nbsp;&nbsp;&nbsp; Показать по:
		<select name="pn" onchange="document.forms['bselfrm'].submit();">
			<option value="25"<?=($pn == 25 ? ' selected' : '');?>>25</option>
            <option value="50"<?=($pn == 50 ? ' selected' : '');?>>50</option>
			<option value="100"<?=($pn == 100 ? ' selected' : '');?>>100</option>
            <option value="200"<?=($pn == 100 ? ' selected' : '');?>>200</option>
		</select>
		&nbsp;&nbsp;&nbsp; Пакет:
		<select name="isprice" onchange="document.forms['bselfrm'].submit();">
			<option value="1"<?=($isprice == 1 ? ' selected' : '');?>>Трейдер (закуп.)</option>
			<option value="2"<?=($isprice == 2 ? ' selected' : '');?>>Трейдер (продажи)</option>
			<option value="0"<?=($isprice == 0 ? ' selected' : '');?>>Все компании</option>

		</select>
    </div>
    <div style="padding: 1px 0px 10px 10px;">
    	Фильтровать по E-mail: <input type="text" name="fltmail" value="<?=$fltmail;?>" /> &nbsp;&nbsp;&nbsp;&nbsp; по Тел. <input type="text" name="flttel" value="<?=$flttel;?>" />
    	&nbsp;&nbsp;&nbsp; по Автору <input type="text" name="fltname" value="<?=$fltname;?>" /> &nbsp;&nbsp;&nbsp; по ID <input type="text" name="fltid" value="<?=$fltid;?>" size="5" /><input type="submit" value="Применить" />
    </div>
    </form>

    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="ntype" value="<?=$ntype;?>" />
    <input type="hidden" name="oblid" value="<?=$oblid;?>" />
	<input type="hidden" name="topicid" value="<?=$topicid;?>" />
	<input type="hidden" name="sortby" value="<?=$sortby;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th><?=( $sortby == "byidc" ? "ID" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byids&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">ID</a>' );?></th>
    	<th style="width: 130px;">Лого</th>
    	<th style="padding: 1px 10px 1px 20px">
			<?=( $sortby == "byname" ? "Компания" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byname&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Компания</a>' );?>/
			<?=( $sortby == "byfio" ? "ФИО" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byfio&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">ФИО</a>' );?>/
			<?=( $sortby == "bylogin" ? "Логин" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=bylogin&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Логин</a>' );?>/
            <?=( $sortby == "byobl" ? "Область" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byobl&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Область</a>' );?>
        </th>
    	<!--<th>Пароль</th>-->
		<th>
			<?=( $sortby == "byreg" ? "Дата рег." : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byreg&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Дата рег.</a>' );?>/
			<?=( $sortby == "bylastacc" ? "входа" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=bylastacc&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">входа</a>' );?></th>		
    	<!--<th>Трейдер</th>-->
    	<th>Т/З/У</th>
		<!--<th>К рейт</th>-->
		<th>
            <?=( $sortby == "byrate" ? "Рейт" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byrate&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Рейт</a>' );?>
        </th>
    	<!--<th>№ Сорт</th>-->
		<th><?=( $sortby == "byviews" ? "Посещений" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=byviews&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Посещений</a>' );?></th>
		<th><?=( $sortby == "bypack" ? "Пакет" : '<a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&sortby=bypack&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">Пакет</a>' );?></th>
    	<th>Отзывов</th>    	
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php
		$sel_cond = "";

		$limit_cond = "";
		if( $pi > 0 )
		{
			$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
		}

		$sel_cond = "";
		$topic_cond = "";
		//if( $typeid != 0 )
		//	$sel_cond .= " AND p1.type_id=".$typeid." ";

		//if( ($topicid != 0) && !$parenttopic )
		//	$sel_cond .= " AND p1.topic_id=".$topicid." ";

		if( ($fltid != "") && ($fltid != 0) )
			$sel_cond .= " AND m1.id='$fltid' ";

		if( $oblid != 0 )
			$sel_cond .= " AND m1.obl_id=".$oblid." ";

		if( $fltname != "" )
			$sel_cond .= " AND m1.title LIKE '%".addslashes($fltname)."%' ";

		if( $fltmail != "" )
			$sel_cond .= " AND ((m1.email LIKE '%".addslashes($fltmail)."%') OR (e1.login LIKE '%".addslashes($fltmail)."%')) ";

		if( $flttel != "" )
			$sel_cond .= " AND m1.phone LIKE '%".addslashes($flttel)."%' ";

		if( $isprice == 1 )
			$sel_cond .= " AND m1.trader_price_avail=1 ";
		else if( $isprice == 2 )
			$sel_cond .= " AND m1.trader_price_sell_avail=1 ";

		if( $topicsid != 0 )
		{
			$topic_cond = " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC t1 ON m1.id=t1.item_id AND t1.topic_id='".$topicsid."' ";
		}

		if( $sel_cond != "" )
			$sel_cond = " WHERE m1.id>0 ".$sel_cond;

		$its_num = 0;
		$query = "SELECT count(*) as totu FROM $TABLE_COMPANY_ITEMS $topic_cond $sel_cond";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$its_num = $row->totu;
			}
			mysqli_free_result( $res );
		}
		
		$sort_cond = " m1.add_date DESC ";
		switch($sortby)
		{
			case "byidc":
				$sort_cond = " m1.id ";
				break;
			case "byname":
				$sort_cond = " m1.title ";
				break;
			case "byfio":
				$sort_cond = " e1.name ";
				break;
			case "bylogin":
				$sort_cond = " e1.login ";
				break;
			case "byobl":
				$sort_cond = " m1.obl_id ";
				break;
			case "byreg":
				$sort_cond = " m1.add_date DESC ";
				break;
			case "bylastacc":
				$sort_cond = " e1.last_login DESC ";
				break;
			case "byrate":
				$sort_cond = " m1.rate_formula DESC ";
				break;
			case "byviews":
				$sort_cond = " m1.rate DESC ";
				break;
			case "bypack":
				//$sort_cond = " e1.last_login DESC ";
				break;
		}

    	$found_news = 0;
    	$query = "SELECT m1.*, e1.login, e1.passwd, e1.name, e1.last_login, count(p1.id) as totposts, count(c1.id) as totcomments
			FROM $TABLE_COMPANY_ITEMS m1
			INNER JOIN $TABLE_TORG_BUYERS e1 ON m1.author_id=e1.id
			$topic_cond
			LEFT JOIN $TABLE_ADV_POST p1 ON m1.id=p1.company_id
			LEFT JOIN $TABLE_COMPANY_COMMENT c1 ON m1.id=c1.item_id
			$sel_cond
			GROUP BY m1.id
			ORDER BY $sort_cond 
			$limit_cond";

		//echo $query."<br />";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while($row=mysqli_fetch_object($res))
			{
				$u_name = stripslashes($row->name)."<br>".stripslashes($row->login);
				$u_pass = "Пароль: ".stripslashes($row->passwd);
				/*
				$u_name = "";
				$query = "SELECT e1.* FROM $TABLE_TORG_BUYERS e1 WHERE e1.id='".$row->author_id."'";
				if( $result= mysqli_query($upd_link_db,$query) )
				{
					if( $myrow = mysqli_fetch_object($result) )
					{
						$u_name = stripslashes($myrow->name)."</td><td>".stripslashes($myrow->login)."</td><td> Пароль: ".stripslashes($myrow->passwd).")";
					}
					mysqli_free_result($result);
				}
				else
					echo mysqli_error($upd_link_db);
				*/

				$viewarc = 0;
				$postnum_buy = Board_PostsNumByAuthor($row->author_id, "", 1, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_BUY );
				$postnum_sell = Board_PostsNumByAuthor($row->author_id, "", 1, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SELL );
				$postnum_serv = Board_PostsNumByAuthor($row->author_id, "", 1, ( $viewarc == 0 ? 1 : 2 ), $BOARD_PTYPE_SERV );
				
				$tarif_pack_id = $row->site_pack_id;
				$tarif_pack_name = '<span style="color: red;">Не определен</span>';
				if( isset($tarpacks_byid[$tarif_pack_id]) )
				{
					$tarif_pack_name = $tarpacks_byid[$tarif_pack_id]['title'];
				}

				$found_news++;

				echo "<tr>
					<td><input type=\"checkbox\" name='com_id[]' value=\"".$row->id."\" /></td>
					<td><a href=\"".Comp_BuildUrl($LangId,"item","", 0,0, $row->id)."\" target=\"_blank\">".$row->id."</a></td>
					<td>".($row->logo_file != "" ? '<img src="'.$WWWHOST.stripslashes($row->logo_file).'" width="100" height="30" alt="" />' : '&nbsp;' )."</td>
					<td style=\"padding: 2px 10px 2px 10px;\"><b>".stripslashes($row->title)."</b><br />".$u_name. "</br>" .$REGIONS[$row->obl_id]."</td>
					<td>".$row->add_date."<br>".$row->last_login."</td>
					".( false ? "<td align=\"center\">".( $row->trader_price_avail == 0 ? "" : '<span style="font-weight: bold; color: red;">Да</span>' )."</td>" : "" )."
					".( false ? "<td align=\"center\">".( $row->trader_price_avail != 0 ? $row->trader_sort : "&nbsp;" )."</td>" : "" )."
					<td align=\"center\">
						<a href=\"board.php?compid=".$row->id."&typeid=".$BOARD_PTYPE_SELL."\">".$postnum_sell."</a> / 
						<a href=\"board.php?compid=".$row->id."&typeid=".$BOARD_PTYPE_BUY."\">".$postnum_buy."</a> / 
						<a href=\"board.php?compid=".$row->id."&typeid=".$BOARD_PTYPE_SERV."\">".$postnum_serv."</a>
					</td>					
					".( false ? "<td align=\"center\">".( $row->rate_admin1." / ".$row->rate_admin2 )."</td>" : "" )."
					<td align=\"center\">".( $row->rate_formula )."</td>										
					".( false ? "<td align=\"center\"><a href=\"board.php?compid=".$row->id."\">".$row->totposts."</a></td>" : "")."					
					<td align=\"center\">".$row->rate."</td>
					<td align=\"center\">".$tarif_pack_name."</td>
					<td align=\"center\">".$row->totcomments."</td>
					<td align=\"center\">
						<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."&topicid=".($topicparent ? "0" : "1").':'.$topicsid."&oblid=".$oblid."&sortby=".$sortby."&pi=".$pi."&pn=".$pn."&fltmail=".$fltmail."&flttel=".$flttel."&fltname=".$fltname."&fltid=".$fltid."\" onclick=\"return confirm('Действительно хотите удалить компанию?')\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						<a href=\"$PHP_SELF?mode=edit&item_id=".$row->id."&topicid=".($topicparent ? "0" : "1").':'.$topicsid."&oblid=".$oblid."&sortby=".$sortby."&pi=".$pi."&pn=".$pn."&fltmail=".$fltmail."&flttel=".$flttel."&fltname=".$fltname."&fltid=".$fltid."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
						<br><a href=\"".$WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($row->login)."&buyerpass=".stripslashes($row->passwd)."\" target=\"_blank\">Залогиниться</a>
					</td>
				</tr>
				<tr><td colspan=\"15\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";

			}
			mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"15\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"15\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"17\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <?php
    	if( $its_num > $pn )
    	{
    		$PAGES_NUM = ceil( $its_num/$pn );
    		echo '<div style="padding: 20px 20px 20px 20px; text-align: center;">Страницы: ';

    		for( $i=1; $i<=$PAGES_NUM; $i++ )
    		{
    			if( $i == $pi )
    				echo ' <b>'.($i).'</b> ';
    			else
    				echo ' <a href="'.$PHP_SELF.'?topicid='.($topicparent ? "0" : "1").':'.$topicsid.'&oblid='.$oblid.'&pi='.$i.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">'.$i.'</a> ';
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
