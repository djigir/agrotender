<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

function Trader_BuildUrl($trid, $trurl, $oblurl="", $culturl="", $typeurl="", $porturl="", $onlyport="", $curtype=-2, $removepars=false)
{
	global $WWWHOST, $acttype, $curt, $viewmod;
	
	//$url = Trader_Prices_BuildUrl($acttype, $trid, $trurl, $oblurl, $culturl, $typeurl, $onlyport);
	$url = Trader_Prices_BuildUrl($acttype, $trid, $trurl, $oblurl, $culturl, $porturl, $onlyport);
	
	$newcurt = ( $curtype != -2 ? $curtype : $curt );
	
	$addurlp = "";
	if( $removepars )
	{
		// don't add any params
	}
	else
	{
		if( ($viewmod != "") && ($culturl != "") )
		{
			$addurlp .= ($addurlp != "" ? "&" : "")."viewmod=".$viewmod;
		}
		
		if( $newcurt != -1 )
		{		
			$addurlp .= ($addurlp != "" ? "&" : "").'curt='.$newcurt;
			//if( strpos($url, "?") > 0 )
			//	$url .= '&curt='.$newcurt;
			//else
			//	$url .= '?curt='.$newcurt;
		}
	}
	
	if( $addurlp != "" )
	{
		if( strpos($url, "?") > 0 )
			$url .= '&'.$addurlp;
		else
			$url .= '?'.$addurlp;
	}
	
	return $url;
}
	
/*
function Trader_BuildUrl($trid, $trurl, $oblurl="", $culturl="", $typeurl="", $onlyport="")
{
	global $WWWHOST, $acttype;

	if( $trid != 0 )
	{
		return $WWWHOST."traders/".$trid."-".$trurl.".html";
	}
	
	$url = "";
	
	//echo "!".$oblurl."!".$typeurl."!".$culturl."<br>";
	if( ($oblurl == "") && ($typeurl == "") && ($culturl == "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "").".html";
	}
	else if( ($oblurl == "") && ($typeurl == "") && ($culturl != "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/region_ukraine/".$culturl.".html";
	}
	else if( ($oblurl == "") && ($typeurl != "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/ttype_".$typeurl."/".($culturl == "" ? "index" : $culturl).".html";
	}
	else if( ($oblurl != "") && ($typeurl == "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/region_".$oblurl."/".($culturl == "" ? "index" : $culturl).".html";
	}
	else
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/region_".$oblurl."_ttype_".$typeurl."/".($culturl == "" ? "index" : $culturl).".html";
	}
	
	$url .= ($onlyport == "yes" ? "?showportonly=yes" : "");
	
	//$url = "traders/region_".$oblurl."/".($culturl == "" ? "index" : $culturl).".html".($onlyport == "" ? "" : "?showportonly=yes");

	return $WWWHOST.$url;
}
*/


function Trader_GetList($obl=0, $cultid=0, $showportonly="", $premiumonly=false, $sortby="", $acttype=0)
{
	global $TABLE_COMPANY_ITEMS, $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PLACES;
	global $WWWHOST, $REGIONS;
	
	$sort_cond = "";
	
	$sort_cond = " p1.trader_sort".($acttype == 1 ? "_sell" : "").", p1.rate_formula DESC, p1.title ";
	if( $sortby == "rand" )
		$sort_cond = " RAND() ";
	
	$trlist = Array();
	if( ($obl != 0) || ($cultid != 0) )
	{
		$sql_cond = "";
		$join_cond = "";		

		if( $obl != 0 )
		{
			if( $showportonly == "yes" )
			{
				$port_cond = " AND pl1.type_id=1 ";
			}
		
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' ".( $cultid != 0 ? " AND pr1.cult_id='$cultid' " : "" )."
			INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.obl_id='$obl' $port_cond ";
		}
		else if( $cultid != 0 )
		{
			if( $showportonly == "yes" )
			{
				$port_cond = " INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1 ";
			}
			
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' AND pr1.cult_id='$cultid' $port_cond ";
		}
		else if( $showportonly == "yes" )
		{
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' 
			INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1 ";
		}

		if( $acttype == 1 )
		{
			$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
			case when p1.trader_price_sell_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
			FROM $TABLE_COMPANY_ITEMS p1
			$join_cond
			WHERE p1.trader_price_sell_avail=1 AND p1.trader_price_sell_visible=1 ".($premiumonly ? ' AND p1.trader_premium_sell=1 ' : '' )."
			ORDER BY $sort_cond
			";
		}
		else
		{
			$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
			case when p1.trader_price_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
			FROM $TABLE_COMPANY_ITEMS p1
			$join_cond
			WHERE p1.trader_price_avail=1 AND p1.trader_price_visible=1 ".($premiumonly ? ' AND p1.trader_premium=1 ' : '' )."
			ORDER BY $sort_cond
			";
		}
	}
	else
	{
		if( $acttype == 1 )
		{
			if( $showportonly == "yes" )
			{
				$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_sell_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt 				
				FROM $TABLE_COMPANY_ITEMS p1
				INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' 
				INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1  
				WHERE p1.trader_price_sell_avail=1 AND p1.trader_price_sell_visible=1 ".($premiumonly ? ' AND p1.trader_premium_sell=1 ' : '' )." 
				ORDER BY $sort_cond
				";
			}
			else
			{
				$query = "SELECT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_sell_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				WHERE p1.trader_price_sell_avail=1 AND p1.trader_price_sell_visible=1 ".($premiumonly ? ' AND p1.trader_premium_sell=1 ' : '' )." 
				ORDER BY $sort_cond
				";
			}
		}
		else
		{
			if( $showportonly == "yes" )
			{
				$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' 
				INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1  
				WHERE p1.trader_price_avail=1 AND p1.trader_price_visible=1 ".($premiumonly ? ' AND p1.trader_premium=1 ' : '' )." 
				ORDER BY $sort_cond
				";
			}
			else
			{
				$query = "SELECT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				WHERE p1.trader_price_avail=1 AND p1.trader_price_visible=1 ".($premiumonly ? ' AND p1.trader_premium=1 ' : '' )." 
				ORDER BY $sort_cond
				";
			}
		}
	}
	$its = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['buyer_id'] = $row->author_id;
			$it['title'] = stripslashes($row->title);
			$it['titlefull'] = stripslashes($row->title_full);
			$it['text'] = stripslashes($row->content);
			$it['short'] = stripslashes($row->short);
			$it['contacts'] = stripslashes($row->contacts);
			$it['bname'] = stripslashes($row->author);
			$it['bphone'] = stripslashes($row->phone);
			$it['bemail'] = stripslashes($row->email);
			$it['bcity'] = stripslashes($row->city);
			$it['logo'] = ( stripslashes($row->logo_file) != "" ? $WWWHOST.stripslashes($row->logo_file) : "" );
			$it['logo_w'] = stripslashes($row->logo_file_w);
			$it['logo_h'] = stripslashes($row->logo_file_h);
			//$it['topic'] = stripslashes($row->topic);
			$it['obl_id'] = $row->obl_id;
			$it['type_id'] = $row->type_id;
			$it['topic_id'] = $row->topic_id;
			$it['dt'] = $row->add_date;
			$it['dt_str'] = $row->dtreg;
			$it['trader'] = $row->trader_price_avail;
			$it['trader_vis'] = $row->trader_price_visible;
			$it['trader_updt'] = $row->dt_trader_updt;
			
			$it['trader2'] = $row->trader_price_sell_avail;
			$it['trader2_vis'] = $row->trader_price_sell_visible;
			$it['trader2_updt'] = $row->dt_trader_updt;//$row->dt_trader_sell_updt;
			
			$it['sort'] = $row->trader_sort;
			$it['rate'] = $row->rate_formula;

			//$it['dt'] = $row->add_date;
			//$it['dt'] = sprintf("%02d.%02d.%04d %02d:%02d", $row->dd, $row->dm, $row->dy, $row->dh, $row->dmm);
			//$it['dt_short'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

			$it['obl'] = $REGIONS[$row->obl_id];

			$trlist[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $trlist;
}


function fltnum_ByObl($obl_id)
{
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PLACES, $TABLE_TORG_BUYERS, $TABLE_COMPANY_ITEMS;
	
	$totnum = 0;
	
	$query = "SELECT count(DISTINCT b1.id) as tottraders 
		FROM $TABLE_TRADER_PR_PRICES pr1 
		INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON pr1.buyer_id=b1.id
		INNER JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id AND i1.trader_price_avail=1 AND i1.trader_price_visible=1 
		WHERE pl1.obl_id='$obl_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totnum = $row->tottraders;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $totnum;
}

function fltnum_ByType($type_id, $isport=false)
{
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_CULTS, $TABLE_TORG_BUYERS, $TABLE_COMPANY_ITEMS, $TABLE_TRADER_TYPES2ITEMS;
	
	$totnum = 0;
	
	$query = "SELECT count(DISTINCT b1.id) as tottraders 
		FROM $TABLE_TRADER_PR_PRICES pr1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON pr1.buyer_id=b1.id
		INNER JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id AND i1.trader_price_avail=1 AND i1.trader_price_visible=1  
		INNER JOIN $TABLE_TRADER_TYPES2ITEMS t1 ON i1.id=t1.item_id 
		WHERE  t1.type_id='$type_id' ";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totnum = $row->tottraders;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $totnum;
}

function fltnum_ByPort($isport=true)
{
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PLACES, $TABLE_TRADER_PR_CULTS, $TABLE_TORG_BUYERS, $TABLE_COMPANY_ITEMS, $TABLE_TRADER_TYPES2ITEMS;
	
	$totnum = 0;
	
	$query = "SELECT count(DISTINCT b1.id) as tottraders 
		FROM $TABLE_TRADER_PR_PRICES pr1 
		INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON pr1.buyer_id=b1.id		
		INNER JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id AND i1.trader_price_avail=1 AND i1.trader_price_visible=1  
		WHERE pl1.type_id='1' ";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totnum = $row->tottraders;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $totnum;
}

function fltnum_ByProd($cult_id)
{
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_CULTS, $TABLE_TORG_BUYERS, $TABLE_COMPANY_ITEMS;
	
	$totnum = 0;
	
	$query = "SELECT count(DISTINCT b1.id) as tottraders 
		FROM $TABLE_TRADER_PR_PRICES pr1 
		INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON pr1.cult_id=c1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON pr1.buyer_id=b1.id
		INNER JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id AND i1.trader_price_avail=1 AND i1.trader_price_visible=1  
		WHERE pr1.cult_id='$cult_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totnum = $row->tottraders;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $totnum;
}


function trFilters_ByUser($UserId)
{
	global $TABLE_TRADER_PR_FILTERS;
	
	$its = Array();
	$query = "SELECT * FROM $TABLE_TRADER_PR_FILTERS WHERE buyer_id='".$UserId."'";
	if( $res= mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['title'] = stripslashes($row->title);
			$it['url'] = stripslashes($row->final_url);
			
			$it['oblids'] = stripslashes($row->obl_ids);
			$it['typeids'] = stripslashes($row->type_ids);
			$it['cultids'] = stripslashes($row->cult_ids);
			$it['isport'] = $row->is_port;
			
			$its[] = $it;
		}
		mysqli_free_result($res);
	}
	//else
	//	echo mysqli_error($upd_link_db);
	
	return $its;
}

function trPlaces_ByCult($trader_id, $cults, $obls, $acttype=0, $place_type=-1, $ports=null)
{
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PLACES, $TABLE_TRADER_PR_PORTS, $TABLE_TRADER_PR_PORTS_LANGS;
	global $LangId;
	
	$sql_cond = "";
	$sql_cond2 = "";
	if( count($cults) > 0 )
	{
		$sql_cond = " AND pr1.cult_id IN (".implode(",", $cults).") ";
	}
	if( count($obls) > 0 )
	{
		$sql_cond2 = " AND p1.obl_id IN (".implode(",", $obls).") ";
	}
	if( count($ports)>0 )
	{
		$sql_cond2 = " AND p1.port_id IN (".implode(",", $ports).") ";
	}
	
	if( $place_type>=0 )
	{
		$sql_cond2 .= " AND p1.type_id='".$place_type."' ";
	}
	
	$its = Array();
	$query = "SELECT DISTINCT p1.*, port1.url as porturl, port2.portname 
		FROM $TABLE_TRADER_PR_PRICES pr1 
		INNER JOIN $TABLE_TRADER_PR_PLACES p1 ON pr1.place_id=p1.id $sql_cond2 
		LEFT JOIN $TABLE_TRADER_PR_PORTS port1 ON p1.port_id=port1.id 
		LEFT JOIN $TABLE_TRADER_PR_PORTS_LANGS port2 ON port1.id=port2.port_id AND port2.lang_id='$LangId' 
		WHERE pr1.buyer_id='$trader_id' AND pr1.acttype='$acttype' $sql_cond 
		ORDER BY p1.type_id, p1.obl_id, p1.place";
	//echo $query."<br>";
	if( $res= mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['title'] = stripslashes($row->place);			
			$it['oblid'] = stripslashes($row->obl_id);
			$it['typeid'] = stripslashes($row->type_id);
			$it['portid'] = 0;
			$it['porturl'] = "";
			$it['portname'] = "";
			if( ($row->port_id != 0) && ($row->portname != null) )
			{
				$it['portid'] = $row->port_id;
				$it['porturl'] = stripslashes($row->porturl);
				$it['portname'] = stripslashes($row->portname);
			}
			
			$its[] = $it;
		}
		mysqli_free_result($res);
	}	
	//else
	//	echo mysqli_error($upd_link_db);
	
	return $its;
}


?>