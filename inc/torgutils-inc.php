<?php
error_reporting(E_ALL);
function sendMail_NewBestBid($to, $from, $bid_val, $bid_amount, $lotinfo, $lotlink) { global $upd_link_db;
	$subj = "Новое лучшее предложение в вашем лоте";
	//$txt = "В торгах №".Torg_LotIdStr($lotinfo['id']).", где вы принимаете участие появилось новое лучшее предложение.
//\r\nПерейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."
//\r\nСлужба торгов, Агротендер";

	$place_str = "";
	if( isset($lotinfo['elev']['id']) )
	{
		$place_str = 'Место проведения тендера «'.$lotinfo['elev']['name'].'». ';
	}
	$txt = $place_str.'В тендере №'.Torg_LotIdStr($lotinfo['id']).', в котором Вы принимаете участие,  появилось новое предложение на объем «'.$bid_amount.' т.» со ставкой «'.$bid_val.' грн.»

Перейдите по ссылке, чтобы посмотреть эту информацию: '.$lotlink.'

Служба торгов, Агротендер
';

 	send1251mail($to, $subj, $txt);
}

function sendMail_YouWin($to, $from, $win_bid, $win_amount, $lotinfo, $lotlink) { global $upd_link_db;
	global $TORG_BUY;

	$subj = "Торги окончены - вы выиграли торги";

//	$txt = "В торгах №".Torg_LotIdStr($lotinfo['id']).", где вы принимаете участие, объявлены победители. Вы становитесь победителем торгов со ставкой $win_bid грн.
//Объём - $win_amount т. Перейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."
//\r\nСлужба торгов, Агротендер";

	$place_str = "";
	if( isset($lotinfo['elev']['id']) )
	{
		$place_str = "Место проведения тендера «".$lotinfo['elev']['name']."». ";
	}
	$txt = $place_str."В тендере №".Torg_LotIdStr($lotinfo['id']).", где Вы принимаете участие, объявлены победители. Вы становитесь победителем тендера.

".($lotinfo['trade'] == $TORG_BUY ? "Закупка" : "Продажа")." «".$lotinfo['cult_name']."» объёмом – «".$win_amount." т.»  по «".$win_bid." грн.»
".($lotinfo['buyer']['orgname'] != "" ? "Название: «".$lotinfo['buyer']['orgname']."»" : "")."
Контактное лицо: «".$lotinfo['buyer']['name']."»
Телефон: «".$lotinfo['buyer']['phone']."»
E-mail адрес: «".$lotinfo['buyer']['email']."»

Перейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."

Служба торгов, Агротендер
";

 	send1251mail($to, $subj, $txt);
}

function sendMail_EndTorgForOwner($to, $from, $lotinfo, $lotlink, $winnerstxt = "") { global $upd_link_db;
	global $TORG_BUY;

	$subj = "Торги окончены - тендер №".Torg_LotIdStr($lotinfo['id']);

//	$txt = "В торгах №".Torg_LotIdStr($lotinfo['id']).", где вы принимаете участие, объявлены победители. Вы становитесь победителем торгов со ставкой $win_bid грн.
//Объём - $win_amount т. Перейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."
//\r\nСлужба торгов, Агротендер";

	$place_str = "";
	if( isset($lotinfo['elev']['id']) )
	{
		$place_str = "Место проведения тендера «".$lotinfo['elev']['name']."». ";
	}
	$txt = $place_str."Тендер № ".Torg_LotIdStr($lotinfo['id']).", который Вы организовали, окончен.  Объявлены победители:

".$winnerstxt."
Перейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."

Служба торгов, Агротендер
";

 	send1251mail($to, $subj, $txt);
}

function sendMail_NewProposal($to, $from, $bid_val, $bid_amount, $lotinfo, $lotlink) { global $upd_link_db;
	$subj = "Вы получили новое ценовое предложение";
//	$txt = "В торгах №".Torg_LotIdStr($lotinfo['id']).", которые вы организовали появилось новое предложение со ставкой $bid_val грн.
//Объём - $bid_amount т. Перейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."
//\r\nСлужба торгов, Агротендер";

	$place_str = "";
	if( isset($lotinfo['elev']['id']) )
	{
		$place_str = "Место проведения тендера «".$lotinfo['elev']['name']."». ";
	}
	$txt = $place_str."В тендере №".Torg_LotIdStr($lotinfo['id']).", который Вы организовали, появилось новое предложение на объем «".$bid_amount." т.» со ставкой «".$bid_val." грн.»

Перейдите по ссылке, чтобы посмотреть эту информацию: ".$lotlink."

Служба торгов, Агротендер»
";

 	send1251mail($to, $subj, $txt);
}

function Show_Price($price) { global $upd_link_db;
 	return number_format($price,0,""," ");
}

function Show_Number($val) { global $upd_link_db;
 	return number_format($val,0,""," ");
}

function makeDtStr($dt) { global $upd_link_db;
	$mnarr = Array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

	$dtp = explode('.', $dt);

	return $dtp[0]." ".$mnarr[$dtp[1] - 1]." ".$dtp[2];
}

function makeDtVal($dt) { global $upd_link_db;
	$dtp = explode('.', $dt);
	$dd = $dtp[0]+1;
	$dm = $dtp[1]+1;
	$dy = $dtp[2]+1;

	if( is_int($dd) && is_int($dm) && is_int($dy) )
	{
		if( checkdate($dtp[1], $dtp[0], $dtp[2]) )
		{
			return mktime(1, 0, 0,$dtp[1], $dtp[0], $dtp[2]);
		}
	}

	return null;
}

function makeDtSql($dt) { global $upd_link_db;
	$drsql = explode('.', $dt);
	return ($drsql[2]."-".$drsql[1]."-".$drsql[0]);
}

function checkDt($dt) { global $upd_link_db;
	$dtp = explode('.', $dt);

	$dd = $dtp[0]+1;
	$dm = $dtp[1]+1;
	$dy = $dtp[2]+1;

	if( is_int($dd) && is_int($dm) && is_int($dy) )
	{
		if( checkdate($dtp[1], $dtp[0], $dtp[2]) )
		{
			return true;
		}
	}

	return false;
}

function leftDtFromMinute($minute, $txtmode="normal") { global $upd_link_db;
	$daysarr = Array("дней","день","дня","дня","дня","дней","дней","дней","дней","дней","дней","дней","дней","дней","дней");
	$hsarr = Array("часов","час","часа","часа","часа","часов","часов","часов","часов","часов","часов","часов","часов","часов","часов","часов");
	$minsarr = Array("минут","минута","минуты","минуты","минуты","минут","минут","минут","минут","минут","минут","минут","минут","минут","минут","минут");

	$daysleft = $dd = floor($minute / (60*24));
	$hoursleft = $dh = floor( ($minute - $dd*(60*24)) / 60 );
	$minsleft = $dm = $minute - $dd*(60*24) - $dh*60;

	$less3hour = false;
	$fromnow = false;

	if( $txtmode == "short" )
	{
		if( $daysleft > 0 )
		{
			return (($less3hour && $fromnow) ? '<span style="color: red;">' : '').sprintf("%d %s %d %s %d %s",
			$daysleft, "дн.",
			$hoursleft, "ч.",
			$minsleft, "мин.").($less3hour ? '</span>' : '');
		}
		else
		{
			return (($less3hour && $fromnow) ? '<span style="color: red;">' : '').sprintf("%d %s %d %s",
			$hoursleft, "ч.",
			$minsleft, "мин.").($less3hour ? '</span>' : '');
		}
	}

	return (($less3hour && $fromnow) ? '<span style="color: red;">' : '').sprintf("%d %s %d %s %d %s",
		$daysleft, ($daysleft < 15 ? $daysarr[$daysleft] : $daysarr[$daysleft%10]),
		$hoursleft, ($hoursleft < 15 ? $hsarr[$hoursleft] : $hsarr[$hoursleft%10]),
		$minsleft, ($minsleft < 15 ? $minsarr[$minsleft] : $minsarr[$minsleft%10])).($less3hour ? '</span>' : '');

	return "";
}

function leftDtFromNow($dt, $fromnow = true, $hour = 0, $minute = 0, $txtmode = "normal") { global $upd_link_db;
	$daysarr = Array("дней","день","дня","дня","дня","дней","дней","дней","дней","дней","дней","дней","дней","дней","дней");
	$hsarr = Array("часов","час","часа","часа","часа","часов","часов","часов","часов","часов","часов","часов","часов","часов","часов","часов");
	$minsarr = Array("минут","минута","минуты","минуты","минуты","минут","минут","минут","минут","минут","минут","минут","минут","минут","минут","минут");

	$dtp = explode('.', $dt);
	$dd = $dtp[0]+1;
	$dm = $dtp[1]+1;
	$dy = $dtp[2]+1;

	if( is_int($dd) && is_int($dm) && is_int($dy) )
	{
		if( checkdate($dtp[1], $dtp[0], $dtp[2]) )
		{
			if( $fromnow )
			{
				$endtime = mktime(23, 0, 0, $dtp[1], $dtp[0], $dtp[2]);
				$nowtime = time();

				if( $endtime <= $nowtime )
				{
					return '<span style="color: #888888;">время закончилось</a>';
				}
			}
			else
			{
				$endtime = time();
				$nowtime = mktime($hour, $minute, 0, $dtp[1], $dtp[0], $dtp[2]);

				//echo " ! ".date("d.m.Y H:i:s", $nowtime)." - ".date("d.m.Y H:i:s", $endtime)."<br />";
			}

			$diffinsec = ($endtime - $nowtime);
			if( $diffinsec < 0 )	// Если вдруг время на MySQL сервер и PHP сервер разное, то тогда может получиться отрицательная разница
				$diffinsec = 0;

			//echo "!!".$diffinsec."!!";

			$less3hour = ( $diffinsec <= 10800 );	// 3600 * 3 = 10800

			$daysleft = floor( $diffinsec / (3600*24) );
			$diffinsec = ($diffinsec % (3600*24));
			$hoursleft = floor( $diffinsec / 3600 );
			$diffinsec = ($diffinsec % 3600);
			$minsleft = floor( $diffinsec / 60 );

			if( $txtmode == "short" )
			{
				return (($less3hour && $fromnow) ? '<span style="color: red;">' : '').sprintf("%d %s %d %s %d %s",
				$daysleft, "дн.",
				$hoursleft, "ч.",
				$minsleft, "мин.").($less3hour ? '</span>' : '');
			}

			return (($less3hour && $fromnow) ? '<span style="color: red;">' : '').sprintf("%d %s %d %s %d %s",
				$daysleft, ($daysleft < 15 ? $daysarr[$daysleft] : $daysarr[$daysleft%10]),
				$hoursleft, ($hoursleft < 15 ? $hsarr[$hoursleft] : $hsarr[$hoursleft%10]),
				$minsleft, ($minsleft < 15 ? $minsarr[$minsleft] : $minsarr[$minsleft%10])).($less3hour ? '</span>' : '');
		}
	}

	return "";
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//MAKE URL FOR TORG AUCTION AND GOODS
function TorgItem_GenerateUrl($LangId, $prodid, $prodname="", $make_url="" ) { global $upd_link_db;
	return $prodid;
}

function Torg_BuildUrl_PHP($LangId, $viewp, $obl_url="", $obl_id=0, $ray_url="", $torgt=0, $cult_url="", $cult_id=0, $elev_url="", $sortby="", $pi=0, $pn=15) { global $upd_link_db;
	$url = "";

	$bpage = "torgi.php";

	if( $viewp == "add" )
	{
		$bpage = "addtorg.php";
	}

	if( ($obl_id == 0) && ($obl_url == "") )
	{
		$url = "index.php";
	}
	else if( $ray_url == "" )
	{
		$url = $bpage."?obl=".$obl_id;
	}
	else
	{
		$url = $bpage."?obl=".$obl_id."&ray_url=".$ray_url;
	}

	if( $viewp == "block" )
	{
		$url .= "&viewmod=".$viewp;
	}

	if( $torgt != 0 )
	{
		$url .= "&trade=".$torgt;
	}

	if( $cult_id != 0 )
	{
		$url .= "&cult=".$cult_id;
	}

	if( $elev_url != "" )
	{
		$url .= "&elev_url=".$elev_url;
	}

	if( $sortby != "" )
	{
		$url .= "&sortby=".$sortby;
	}

	if( $pi != 0 )
	{
		$url .= "&pi=".$pi."&pn=".$pn;
	}

	return $url;
}

function Torg_BuildUrl_HTML($LangId, $viewp, $obl_url="", $obl_id=0, $ray_url="", $torgt=0, $cult_url="", $cult_id=0, $elev_url="", $sortby="", $pi=0, $pn=15) { global $upd_link_db;
	global $WWWHOST;

	$domen = substr($WWWHOST, 7, strlen($WWWHOST)-8);

	$url = ( $obl_url == "" ? $WWWHOST : "http://".$obl_url.".".$domen."/" );
	//$url = $WWWHOST.( $obl_url == "" ? "" : "obl".($viewp == "block" ? "bl" : "")."_".$obl_url."/" );

	//if( $torgt != 0 )
	//{
	if( $viewp == "add" )
	{
		$url .= "add_".( $torgt == 2 ? "sell" : "buy" )."/".($cult_id == 0 ? "index" : $cult_url);//.".html";
		return $url;
	}

	//if ($torgt == 0 )
	//	return $url;

	$url2 = "";
	$url3 = "";
	if( $ray_url != "" )
	{
		$url2 .= "ray_".$ray_url."/";
	}

	if( $cult_id != 0 )
	{
		$url .= ( $torgt == 2 ? "prodaga" : ($torgt == 0 ? "all" : "kupit") ).($viewp == "block" ? "_vblock" : "")."/";
		$url2 .= $cult_url;
	}
	else
	{
		if( $torgt == 0 )
		{
		}
		else
		{
			$url .= ( $torgt == 2 ? "prodaga" : "kupit" ).($viewp == "block" ? "_vblock" : "")."/";
		}
		$url2 .= "index";
	}

	if($sortby != "")
	{
		$url3 .= "_sort_".$sortby;
	}

	if( $pi > 1 )
	{
		$url3 .= "_p_".$pi;
	}

	if( ($url3 != "") && ($torgt == 0) && ($cult_id == 0) )
	{
		$url .= "all".($viewp == "block" ? "_vblock" : "")."/";
	}

	$url = $url.$url2.$url3;//.".html";

	return $url;
}

function Torg_BuildUrl($LangId, $viewp="list", $obl_url="", $obl_id=0, $ray_url="", $torgt=0, $cult_url="", $cult_id=0, $elev_url="", $sortby="", $pi=0, $pn=15) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return (
		$WWW_LINK_MODE == "php" ?
			$wwwlink.Torg_BuildUrl_PHP($LangId, $viewp, $obl_url, $obl_id, $ray_url, $torgt, $cult_url, $cult_id, $elev_url, $sortby, $pi, $pn) :
			//$WWWHOST.Torg_BuildUrl_HTML($LangId, $viewp, $obl_url, $obl_id, $ray_url, $torgt, $cult_url, $cult_id, $elev_url, $sortby, $pi, $pn)
			Torg_BuildUrl_HTML($LangId, $viewp, $obl_url, $obl_id, $ray_url, $torgt, $cult_url, $cult_id, $elev_url, $sortby, $pi, $pn)
		);
}


function TorgItem_BuildUrl_PHP($LangId, $item_id, $item_url, $obl_url, $ray_url, $torgt, $cult, $pi, $pn) { global $upd_link_db;
 	$url = "";

	$url = "iteminfo.php?pid=".$item_id."&obl=".$obl_url;

    if( $pi != 0 )
    {
    	$url .= "&pi=".$pi;
    }

    return $url;
}

function TorgItem_BuildUrl_HTML($LangId, $item_id, $item_url, $obl_url, $ray_url, $torgt, $cult, $pi, $pn) { global $upd_link_db;
	global $WWWHOST;

	$domen = substr($WWWHOST, 7, strlen($WWWHOST)-8);

	$url = ( $obl_url == "" ? $WWWHOST : "http://".$obl_url.".".$domen."/" );
	$url .= "lots/".$item_id;//.".html";

    return $url;
}

function TorgItem_BuildUrl($LangId, $item_id, $item_url="", $obl_url="", $ray_url="", $torgt=0, $cult="", $pi=0, $pn=20) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return (
		$WWW_LINK_MODE == "php" ?
			$wwwlink.TorgItem_BuildUrl_PHP($LangId, $item_id, $item_url, $obl_url, $ray_url, $torgt, $cult, $pi, $pn) :
			//$WWWHOST.TorgItem_BuildUrl_HTML($LangId, $item_id, $item_url, $obl_url, $ray_url, $torgt, $cult, $pi, $pn)
			TorgItem_BuildUrl_HTML($LangId, $item_id, $item_url, $obl_url, $ray_url, $torgt, $cult, $pi, $pn)
		);
}


function TorgCab_BuildUrl_PHP($LangId, $mode, $item_id, $torgt, $sortby, $pi, $pn, $viewfilt, $viewbids) { global $upd_link_db;
 	$url = "";

	$url = "bcab_cabinet.php?".($mode == "lotinfofin" ? "action=finishlot&" : "")."trade=".$torgt;

	if( ($mode == "lotinfo") || ($mode == "lotinfofin") )
	{
		$url .= "&lotid=".$item_id;
	}

	if( $viewfilt != 0 )
	{
		$url .= "&viewfilt=".$viewfilt;
	}

	if( $viewbids != 0 )
	{
		$url .= "&viewbids=".$viewbids;
	}

	if( $sortby != "" )
	{
		$url .= "&sortby=".$sortby;
	}

    if( $pi >= 0 )
    {
    	$url .= "&pi=".$pi."&pn=".$pn;
    }

    return $url;
}

function TorgCab_BuildUrl_HTML($LangId, $mode, $item_id, $torgt, $sortby, $pi, $pn, $viewfilt, $viewbids) { global $upd_link_db;
	$url = TorgCab_BuildUrl_PHP($LangId, $mode, $item_id, $torgt, $sortby, $pi, $pn, $viewfilt, $viewbids);
	/*
 	$url = "";

    if( $viewmode == "" )
    {
        //$url = "p/".$make_url."/".$prod_url.".html";
        $url = "p/".$prod_url.".html";
    }
    else
    {
    	if( $pi == 0 )
        	//$url = "p/".$make_url."/".$prod_url."-".$viewmode.".html";
        	$url = "p/".$prod_url."-".$viewmode.".html";
     	else
     		//$url = "p/".$make_url."/".$prod_url."-".$viewmode."-p".$pi.".html";
     		$url = "p/".$prod_url."-".$viewmode."-p".$pi.".html";
    }
    */

    return $url;
}

function TorgCab_BuildUrl($LangId, $mode, $item_id, $torgt=0, $sortby="", $pi=0, $pn=10, $viewfilt = 0, $viewbids = 0) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return (
		$WWW_LINK_MODE == "php" ?
			$wwwlink.TorgCab_BuildUrl_PHP($LangId, $mode, $item_id, $torgt, $sortby, $pi, $pn, $viewfilt, $viewbids) :
			$WWWHOST.TorgCab_BuildUrl_HTML($LangId, $mode, $item_id, $torgt, $sortby, $pi, $pn, $viewfilt, $viewbids)
		);
}

function TorgElev_BuildUrl_PHP($LangId, $elev_id, $elev_url="", $obl_url="", $torgt=0, $sortby="", $pi=0, $pn=20) { global $upd_link_db;
 	$url = "";

	$url = "elevinfo.php";

	if( $elev_id != 0 )
		$url .= "?elevid=".$elev_id;

	if( $torgt != 0 )
	{
		$url .= "&trade=".$torgt;
	}

	if( $sortby != "" )
	{
		$url .= "&sortby=".$sortby;
	}

    if( $pi != 0 )
    {
    	$url .= "&pi=".$pi."&pn=".$pn;
    }

    return $url;
}

function TorgElev_BuildUrl_HTML($LangId, $elev_id, $elev_url, $obl_url, $torgt=0, $sortby="", $pi=0, $pn=20) { global $upd_link_db;
	global $WWWHOST, $TORG_BUY;

	$domen = substr($WWWHOST, 8, strlen($WWWHOST)-9);

	$url = ( $obl_url == "" ? $WWWHOST : "http://".$obl_url.".".$domen."/" );

	if( $elev_id != 0 )
	{
	    if( $sortby == "" )
	    {
	        //$url = "p/".$make_url."/".$prod_url.".html";
	        //$url .= "elev/".$elev_id."-".$elev_url.".html";
	        $url .= "elev/".$elev_url;
	        if($torgt > 0)
	        	$url .= "/".($torgt == $TORG_BUY ? "buy" : "sell");//.".html";
	        //else
	        	//$url .= ".html";
	    }
	    else
	    {
	    	//$url .= "elev/".$elev_id."-".$elev_url."/".($torgt > 0 ? ($torgt == $TORG_BUY ? "buy-" : "sell-") : "");
	    	$url .= "elev/".$elev_url."/".($torgt > 0 ? ($torgt == $TORG_BUY ? "buy-" : "sell-") : "");

	    	if( $pi <= 1 )
	        	//$url = "p/".$make_url."/".$prod_url."-".$viewmode.".html";
	        	$url .= $sortby;//.".html";
	     	else
	     		//$url = "p/".$make_url."/".$prod_url."-".$viewmode."-p".$pi.".html";
	     		$url .= $sortby."-p".$pi;//.".html";
	    }
	}
	else
	{
		if( $obl_url == "" )
			$url = $WWWHOST."elevinfo";//.html";
		else
			$url .= "elev/";//index.html";
	}

    return $url;
}

function TorgElev_BuildUrl($LangId, $elev_id=0, $elev_url="", $obl_url="", $torgt=0, $sortby="", $pi=0, $pn=20) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return (
		$WWW_LINK_MODE == "php" ?
			$wwwlink.TorgElev_BuildUrl_PHP($LangId, $elev_id, $elev_url, $obl_url, $torgt, $sortby, $pi, $pn) :
			//$WWWHOST.TorgElev_BuildUrl_HTML($LangId, $elev_id, $elev_url, $obl_url, $torgt, $sortby, $pi, $pn)
			TorgElev_BuildUrl_HTML($LangId, $elev_id, $elev_url, $obl_url, $torgt, $sortby, $pi, $pn)
		);
}



//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Torgi
function Torg_BuyerInfo( $LangId, $buyer_id ) { global $upd_link_db;
	global $TABLE_TORG_BUYERS;

	$bi = Array("id" => 0);

	$query = "SELECT * FROM $TABLE_TORG_BUYERS WHERE id='$buyer_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$bi['id'] = $row->id;
			$bi['name'] = stripslashes($row->name);
			$bi['name2'] = stripslashes($row->name2);
			$bi['name3'] = stripslashes($row->name3);
			$bi['login'] = stripslashes($row->login);
			$bi['city'] = stripslashes($row->city);
			$bi['phone'] = stripslashes($row->phone);
			$bi['phonenew'] = stripslashes($row->newphone);
			$bi['phone_checked'] = stripslashes($row->smschecked);
			$bi['tel2'] = stripslashes($row->phone2);
			$bi['tel3'] = stripslashes($row->phone3);
			$bi['email'] = stripslashes($row->email);
			$bi['icq'] = stripslashes($row->icq);
			$bi['skype'] = stripslashes($row->skype);
			$bi['orgname'] = stripslashes($row->orgname);
			$bi['orgaddr'] = stripslashes($row->address);
			$bi['obl_id'] = $row->obl_id;
			$bi['ray_id'] = $row->ray_id;
			$bi['active'] = $row->isactive;
			$bi['active_web'] = $row->isactive_web;
			$bi['discount_level'] = $row->discount_level_id;
			$bi['availpost'] = $row->avail_adv_posts;
			$bi['maxpost'] = $row->max_adv_posts;			
			$bi['maxfishka'] = $row->max_fishka;
			
			$bi['subscr_adv_deact'] = $row->subscr_adv_deact;
			$bi['subscr_adv_up'] = $row->subscr_adv_up;
			$bi['subscr_trprice'] = $row->subscr_tr_price;			
		}
		mysqli_free_result( $res );
	}

	return $bi;
}

function Buyer_Balance($buyer_id) { global $upd_link_db;
	global $TABLE_PAY_BALANCE_OPER;
	
	$cur_balance = 0;
		
	$query = "SELECT sum(amount) as balancenow FROM $TABLE_PAY_BALANCE_OPER WHERE buyer_id='$buyer_id'";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$cur_balance = $row->balancenow;
		}
		mysqli_free_result( $res );
	}
	
	return $cur_balance;
}

function Buyer_BalanceNumop($buyer_id) { global $upd_link_db;
	global $TABLE_PAY_BALANCE_OPER;
	
	$cur_balance = 0;
	
	$sql_cond = "";
	if( $buyer_id != 0 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." b1.buyer_id='$buyer_id' ";
	
	$query = "SELECT count(b1.id) as balnum FROM $TABLE_PAY_BALANCE_OPER b1 $sql_cond ";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$cur_balance = $row->balnum;
		}
		mysqli_free_result( $res );
	}
	
	return $cur_balance;
}

function Buyer_BalanceList($LangId, $buyer_id=0, $debkred=-1, $optype=-1, $pi=-1, $pn=50, $sortby="", $mode = "") { global $upd_link_db;
	global $TABLE_PAY_BALANCE_OPER, $TABLE_PAY_BILL, $TABLE_TORG_BUYERS, $TABLE_PAYED_PACK_ORDERS, $TABLE_ADV_POST;
	
	$its = Array();
	
	$sql_cond = "";
	$limit_cond = "";
	
	if( $buyer_id != 0 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." b1.buyer_id='$buyer_id' ";
	
	if( $pi == 0 )
		$pi = 1;
	if( $pi>0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn";
	}
	
	$sort_cond = " b1.add_date DESC, b1.oper_debkred ASC ";
	switch($sortby)
	{		
		case "amount":	$sort_cond = " b1.amount ASC ";	break;
		case "debkred":	$sort_cond = " b1.oper_debkred ASC, b1.add_date DESC ";	break;
		case "bywho":	$sort_cond = " b1.oper_by ASC, b1.add_date DESC ";	break;
		case "buyer":	$sort_cond = " b1.buyer_id ASC, b1.add_date DESC ";	break;
		case "ktype":	$sort_cond = " b1.kredit_type ASC, b1.add_date DESC ";	break;
		case "dtype":	$sort_cond = " b1.debit_type ASC, b1.add_date DESC ";	break;
	}
	
	$join_fields = "";
	$join_cond = "";
	if( $mode == "withbuyer" )
	{
		$join_fields = ", u1.login, u1.orgname, u1.name as username ";
		$join_cond = " INNER JOIN $TABLE_TORG_BUYERS u1 ON b1.buyer_id=u1.id ";
	}
	else if( $mode == "withdebitop" )
	{
		$join_fields = ", o1.post_id, o1.pack_id, DATE_FORMAT(o1.stdt, '%d.%m.%Y') as stdtstr, DATE_FORMAT(o1.endt, '%d.%m.%Y') as endtstr, o1.comments, p1.title as advtitle ";
		$join_cond = " LEFT JOIN $TABLE_PAYED_PACK_ORDERS o1 ON b1.order_id=o1.id 
		LEFT JOIN $TABLE_ADV_POST p1 ON o1.post_id=p1.id ";
	}
	
	$query = "SELECT b1.* $join_fields FROM $TABLE_PAY_BALANCE_OPER b1 
		$join_cond 
		$sql_cond 
		ORDER BY $sort_cond 
		$limit_cond";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['buyer_id'] = $row->buyer_id;
			$ai['bill_id'] = $row->bill_id;
			$ai['order_id'] = $row->order_id;
			$ai['oper_by'] = $row->oper_by;
			$ai['oper_debkred'] = $row->oper_debkred;
			$ai['ktype'] = $row->kredit_type;
			$ai['dtype'] = $row->debit_type;
			$ai['add'] = $row->add_date;
			$ai['amount'] = $row->amount;
			//$ai['serv_id'] = $row->serv_id;
			//$ai['ooo_id'] = $row->payer_ooo_id;
			//$ai['addr_id'] = $row->payer_addr_id;
			
			if( $mode == "withbuyer" )
			{
				$ai['b_login'] = stripslashes($row->login);
				$ai['b_name'] = stripslashes($row->username);
				$ai['b_orgname'] = stripslashes($row->orgname);
			}
			else if( $mode == "withdebitop" )
			{
				$ai['o_post_id'] = ( $row->post_id != null ? $row->post_id : 0 );
				$ai['o_pack_id'] = ( $row->pack_id != null ? $row->pack_id : 0 );
				$ai['o_stdt'] = ( $row->stdtstr != null ? $row->stdtstr : '' );
				$ai['o_endt'] = ( $row->endtstr != null ? $row->endtstr : '' );
				$ai['o_com'] = ( $row->comments != null ? stripslashes($row->comments) : '' );
				
				$ai['p_title'] = ( $row->advtitle != null ? stripslashes($row->advtitle) : '' );
			}
			
			$ai['purpose'] = ' ';
						
			$its[] = $ai;
		}
		mysqli_free_result( $res );
	}
	
	return $its;
}

function Buyer_BillAddrList($LangId, $buyer_id, $sortby = "") { global $upd_link_db;
	global $TABLE_PAY_BILL_ADDR;
	
	$its = Array();
	
	$sql_cond = "";
	if( $buyer_id != 0 )
		$sql_cond .= " WHERE buyer_id='".addslashes($buyer_id)."' ";
	
	$query = "SELECT * FROM $TABLE_PAY_BILL_ADDR ORDER BY add_date";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['type'] = $row->addr_type;
			$ai['add'] = $row->add_date;
			$ai['obl'] = $row->obl_id;
			$ai['city'] = stripslashes($row->city);
			$ai['zip'] = stripslashes($row->zip);
			$ai['address'] = stripslashes($row->address);			
			
			$its[] = $ai;
		}
		mysqli_free_result( $res );
	}
	
	return $its;
}

function Buyer_BillFirmList($LangId, $buyer_id, $type = -1, $sortby = "") { global $upd_link_db;
	global $TABLE_PAY_BILL_OOO;
	
	$its = Array();
	
	$sql_cond = "";
	if( $type >= 0 )
		$sql_cond = " AND payer_type='$type' ";
	
	$query = "SELECT * FROM $TABLE_PAY_BILL_OOO 
		WHERE buyer_id='".addslashes($buyer_id)."' $sql_cond 
		ORDER BY payer_type, otitle";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['type'] = $row->payer_type;
			$ai['add'] = $row->add_date;
			$ai['addr_id'] = $row->bill_addr_id;
			$ai['name'] = stripslashes($row->otitle);
			$ai['ipn'] = stripslashes($row->oipn);
			$ai['kod'] = stripslashes($row->okode);
			$ai['obl'] = $row->obl_id;
			$ai['city'] = stripslashes($row->city);
			$ai['zip'] = stripslashes($row->zip);
			$ai['address'] = stripslashes($row->address);
			
			$its[] = $ai;
		}
		mysqli_free_result( $res );
	}
	
	return $its;
}

function Buyer_BillFirmInfo($LangId, $firm_id, $buyer_id=0) { global $upd_link_db;
	global $TABLE_PAY_BILL_OOO;
	
	$firm_id0 = sprintf("%d", $firm_id);
	
	$it = Array("id" => 0);
	
	$sql_cond = "";
	if( $buyer_id != 0 )
		$sql_cond = " AND buyer_id='$buyer_id' ";
	
	$query = "SELECT * FROM $TABLE_PAY_BILL_OOO 
		WHERE id='$firm_id0' $sql_cond ";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['type'] = $row->payer_type;
			$ai['add'] = $row->add_date;
			$ai['addr_id'] = $row->bill_addr_id;
			$ai['name'] = stripslashes($row->otitle);
			$ai['ipn'] = stripslashes($row->oipn);
			$ai['kod'] = stripslashes($row->okode);
			$ai['obl'] = $row->obl_id;
			$ai['city'] = stripslashes($row->city);
			$ai['zip'] = stripslashes($row->zip);
			$ai['address'] = stripslashes($row->address);
			
			$it = $ai;
		}
		mysqli_free_result( $res );
	}
	
	return $it;
}

function Buyer_BillList($LangId, $buyer_id=0, $pi=-1, $pn=50, $sortby="", $mode = "", $dopsql = "") { global $upd_link_db;
	global $TABLE_PAY_BILL, $TABLE_TORG_BUYERS;
	
	$its = Array();
	
	$sql_cond = "";
	$limit_cond = "";
	
	if( $dopsql != "" )
		$sql_cond = " WHERE $dopsql ";
	
	if( $buyer_id != 0 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." b1.buyer_id='$buyer_id' ";
	
	if( $pi == 0 )
		$pi = 1;
	if( $pi>0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn";
	}
	
	$sort_cond = " b1.add_date DESC ";
	switch($sortby)
	{
		case "amount":	$sort_cond = " b1.amount ASC ";	break;
		case "status":	$sort_cond = " b1.status ASC, b1.add_date DESC ";	break;
		case "paymeth":	$sort_cond = " b1.paymeth_type ASC, b1.add_date DESC ";	break;
		case "org":		$sort_cond = " b1.payer_ooo_id ASC, b1.add_date DESC ";	break;
		case "type":	$sort_cond = " b1.orgtype ASC, b1.add_date DESC ";	break;
	}
	
	$join_fields = "";
	$join_cond = "";
	if( $mode == "withbuyer" )
	{
		$join_fields = ", u1.login, u1.orgname, u1.name as username ";
		$join_cond = " INNER JOIN $TABLE_TORG_BUYERS u1 ON b1.buyer_id=u1.id ";		
	}
	
	$query = "SELECT b1.* $join_fields FROM $TABLE_PAY_BILL b1 
		$join_cond 
		$sql_cond 
		ORDER BY $sort_cond 
		$limit_cond";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['buyer_id'] = $row->buyer_id;
			$ai['pay_meth'] = $row->paymeth_type;
			$ai['orgtype'] = $row->orgtype;
			$ai['status'] = $row->status;
			$ai['aktstatus'] = $row->aktstatus;
			$ai['add'] = $row->add_date;
			$ai['amount'] = $row->amount;
			$ai['serv_id'] = $row->serv_id;
			$ai['ooo_id'] = $row->payer_ooo_id;
			$ai['addr_id'] = $row->payer_addr_id;
			
			if( $mode == "withbuyer" )
			{
				$ai['b_login'] = stripslashes($row->login);
				$ai['b_name'] = stripslashes($row->username);
				$ai['b_orgname'] = stripslashes($row->orgname);
			}
			
			$ai['purpose'] = ' ';
						
			$its[] = $ai;
		}
		mysqli_free_result( $res );
	}
	
	return $its;
}

function Buyer_BillInfo($LangId, $bill_id, $buyer_id=0) { global $upd_link_db;
	global $TABLE_PAY_BILL;
	
	$it = Array("id" => 0);
	
	$sql_cond = "";
	if( $buyer_id != 0 )
		$sql_cond .= " AND buyer_id='$buyer_id' ";
		
	$query = "SELECT *, DATE_FORMAT(add_date, '%d.%m.%Y') as dtstr FROM $TABLE_PAY_BILL WHERE id='".addslashes($bill_id)."' $sql_cond ";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['buyer_id'] = $row->buyer_id;
			$ai['pay_meth'] = $row->paymeth_type;
			$ai['orgtype'] = $row->orgtype;
			$ai['status'] = $row->status;
			$ai['aktstatus'] = $row->aktstatus;
			$ai['add'] = $row->add_date;
			$ai['dt'] = $row->dtstr;
			$ai['amount'] = $row->amount;
			$ai['serv_id'] = $row->serv_id;
			$ai['ooo_id'] = $row->payer_ooo_id;
			$ai['addr_id'] = $row->payer_addr_id;
			
			$ai['purpose'] = ' ';
						
			$it = $ai;
		}
		mysqli_free_result( $res );
	}
	
	return $it;
}

function Buyer_BillDocList($LangId, $buyer_id=0, $bill_id=0, $ooo_id=0, $doctype=-1, $pi=-1, $pn=50, $sortby="", $withbillinf=false) { global $upd_link_db;
	global $TABLE_PAY_BILL, $TABLE_PAY_BILL_DOC;
	
	$its = Array();
	
	$sql_cond = "";
	$limit_cond = "";
	
	if( $buyer_id != 0 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." d1.buyer_id='$buyer_id' ";
	if( $bill_id != 0 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." d1.bill_id='$bill_id' ";
	if( $doctype >= 0 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." d1.doc_type='$doctype' ";
	
	if( $pi == 0 )
		$pi = 1;
	if( $pi>=0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn";
	}
	
	$sql_join = "";
	$sql_fields = "";
	if( $withbillinf )
	{
		$sql_fields = ", b1.payer_ooo_id, b1.status as billstatus, b1.amount, DATE_FORMAT(b1.add_date, '%d.%m.%Y') as billdt "; 
		$sql_join = " LEFT JOIN $TABLE_PAY_BILL b1 ON d1.bill_id=b1.id "; 		
	}
	
	$sort_cond = " d1.add_date DESC ";
	switch($sortby)
	{
		case "amount":	$sort_cond = " d1.sum_tot ASC ";	break;
		case "status":	$sort_cond = " b1.status ASC, d1.add_date DESC ";	break;
		case "bill":	$sort_cond = " d1.bill_id ASC, d1.add_date DESC ";	break;
		case "buyer":	$sort_cond = " d1.buyer_id ASC, d1.add_date DESC ";	break;
		case "org":		$sort_cond = " b1.payer_ooo_id ASC, d1.add_date DESC ";	break;
		case "type":	$sort_cond = " d1.doc_type ASC, d1.add_date DESC ";	break;
	}
	
	$query = "SELECT d1.* $sql_fields FROM $TABLE_PAY_BILL_DOC d1 
		$sql_join 
		$sql_cond 
		ORDER BY $sort_cond 
		$limit_cond";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['buyer_id'] = $row->buyer_id;
			$ai['bill_id'] = $row->bill_id;
			$ai['type'] = $row->doc_type;
			$ai['add'] = $row->add_date;
			$ai['amount'] = $row->sum_tot;
			$ai['file'] = stripslashes($row->filename);
			
			$ai['bill_ooo_id'] = ( $withbillinf && ($row->payer_ooo_id != null) ? $row->payer_ooo_id : 0 );
			$ai['bill_status'] = ( $withbillinf && ($row->billstatus != null) ? $row->billstatus : 0 );
			$ai['bill_amount'] = ( $withbillinf && ($row->amount != null) ? $row->amount : 0 );
			$ai['bill_dt'] = ( $withbillinf && ($row->billdt != null) ? $row->billdt : '' );
						
			$its[] = $ai;
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);
	
	return $its;
}

function Buyer_BillDocInf($LangId, $bill_doc_id, $withbillinf=false) { global $upd_link_db;
	global $TABLE_PAY_BILL, $TABLE_PAY_BILL_DOC;
	
	$it = Array("id" => 0);
	
	$sql_cond = "";
	$limit_cond = "";
			
	$sql_join = "";
	$sql_fields = "";
	if( $withbillinf )
	{
		$sql_fields = ", b1.payer_ooo_id, b1.status as billstatus, b1.amount, DATE_FORMAT(b1.add_date, '%d.%m.%Y') as billdt "; 
		$sql_join = " LEFT JOIN $TABLE_PAY_BILL b1 ON d1.bill_id=b1.id "; 		
	}	
	
	$query = "SELECT d1.* $sql_fields FROM $TABLE_PAY_BILL_DOC d1 
		$sql_join 
		WHERE d1.id='".addslashes($bill_doc_id)."'
		$limit_cond";
	//echo $query."<br>";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ai = Array();
			$ai['id'] = $row->id;
			$ai['buyer_id'] = $row->buyer_id;
			$ai['bill_id'] = $row->bill_id;
			$ai['type'] = $row->doc_type;
			$ai['add'] = $row->add_date;
			$ai['amount'] = $row->sum_tot;
			$ai['file'] = stripslashes($row->filename);
			
			$ai['bill_ooo_id'] = ( $withbillinf && ($row->payer_ooo_id != null) ? $row->payer_ooo_id : 0 );
			$ai['bill_status'] = ( $withbillinf && ($row->billstatus != null) ? $row->billstatus : 0 );
			$ai['bill_amount'] = ( $withbillinf && ($row->amount != null) ? $row->amount : 0 );
			$ai['bill_dt'] = ( $withbillinf && ($row->billdt != null) ? $row->billdt : '' );
						
			$it = $ai;
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);
	
	return $it;
}

function Torg_BuyerBanCount($LangId, $buyer_id, $byip=false, $byses=false) { global $upd_link_db;
	global $TABLE_TORG_BUYER_BAN;

	$bannum = 0;

	$query = "SELECT count(*) as totban FROM $TABLE_TORG_BUYER_BAN WHERE user_id='$buyer_id'";
	if( $byip )
		$query = "SELECT count(*) as totban FROM $TABLE_TORG_BUYER_BAN WHERE user_id='$buyer_id' AND ban_ip<>''";
	if( $byses )
		$query = "SELECT count(*) as totban FROM $TABLE_TORG_BUYER_BAN WHERE user_id='$buyer_id' AND ban_ses<>''";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$bannum = $row->totban;
		}
		mysqli_free_result( $res );
	}

	return $bannum;
}

function Torg_BuyerIsBan($LangId, $buyer_id, $banphone="", $banemail="", $banip="", $bansesid="") { global $upd_link_db;
	global $TABLE_TORG_BUYER_BAN;

	$baninf = Array("id" => 0, "end" => "00.00.0000", "period" => 0, "add" => "", "item_id" => 0);

	if( $buyer_id != 0 )
	{
		$query = "SELECT *, DATE_FORMAT(add_date, '%d.%m.%Y') as dtst, DATE_FORMAT(end_date, '%d.%m.%Y') as dten
		FROM $TABLE_TORG_BUYER_BAN WHERE user_id='$buyer_id' AND is_disabled=0 AND add_date<=NOW() AND end_date>NOW()";
	}
	else if( $banphone != "" )
	{
		$query = "SELECT *, DATE_FORMAT(add_date, '%d.%m.%Y') as dtst, DATE_FORMAT(end_date, '%d.%m.%Y') as dten
		FROM $TABLE_TORG_BUYER_BAN
		WHERE user_id=0 AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(ban_phone,' ',''), '-', ''), '+', ''),'(', ''),')','') LIKE '%".addslashes($banphone)."%' AND is_disabled=0 AND add_date<=NOW() AND end_date>NOW()";
	}
	else if( $banip != "" )
	{
		$query = "SELECT *, DATE_FORMAT(add_date, '%d.%m.%Y') as dtst, DATE_FORMAT(end_date, '%d.%m.%Y') as dten
		FROM $TABLE_TORG_BUYER_BAN WHERE ban_ip='$banip' AND is_disabled=0 AND add_date<=NOW() AND end_date>NOW()";
	}
	else if( $bansesid != "" )
	{
		$query = "SELECT *, DATE_FORMAT(add_date, '%d.%m.%Y') as dtst, DATE_FORMAT(end_date, '%d.%m.%Y') as dten
		FROM $TABLE_TORG_BUYER_BAN WHERE ban_ip='$bansesid' AND is_disabled=0 AND add_date<=NOW() AND end_date>NOW()";
	}
	else //if( $banemail != "" )
	{
		$query = "SELECT *, DATE_FORMAT(add_date, '%d.%m.%Y') as dtst, DATE_FORMAT(end_date, '%d.%m.%Y') as dten
		FROM $TABLE_TORG_BUYER_BAN
		WHERE user_id=0 AND ban_email LIKE '%".addslashes($banemail)."%' AND is_disabled=0 AND add_date<=NOW() AND end_date>NOW()";
	}
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$baninf['id'] = $row->id;
			$baninf['end'] = $row->dten;
			$baninf['add'] = $row->dtst;
			$baninf['period'] = $row->period_days;
			$baninf['item_id'] = $row->item_id;
		}
		mysqli_free_result( $res );
	}

	return $baninf;
}

function Torg_ElevInfo( $LangId, $elev_id ) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS, $TABLE_RAYON, $TABLE_RAYON_LANGS;

	$it = null;

	$query = "SELECT e1.*, e2.*, r2.name as rayon FROM $TABLE_TORG_ELEV e1
		INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON e1.ray_id=r1.id
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE e1.id='".$elev_id."'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $elev_id;
			$it['obl_id'] = $row->obl_id;
			$it['ray_id'] = $row->ray_id;
			$it['rate'] = $row->rate;
			$it['url'] = stripslashes($row->elev_url);
			$it['name'] = stripslashes($row->name);
			$it['addr'] = stripslashes($row->addr);
			$it['orgname'] = stripslashes($row->orgname);
			$it['orgaddr'] = stripslashes($row->orgaddr);
			$it['rayon'] = stripslashes($row->rayon);
			$it['serv_hold'] = stripslashes($row->holdcond);
			$it['serv_podr'] = stripslashes($row->descr_podr);
			$it['serv_qual'] = stripslashes($row->descr_qual);
			$it['director'] = stripslashes($row->director);
			$it['phone'] = stripslashes($row->phone);
			$it['email'] = stripslashes($row->email);
			$it['pic'] = ( stripslashes($row->filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->filename) : '' );
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);

	return $it;
}

function Torg_ElevList( $LangId, $obl_id, $ray_ids=null ) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS;

	$ray_cond = "";
	if( $ray_ids != null )
	{
		//for( $i=0; $i<count($ray_ids); $i++ )
		//{
			$ray_cond = " AND e1.ray_id IN (".join(",",$ray_ids).") ";
		//}
	}

	$its = Array();

	$query = "SELECT e1.*, e2.name, e2.addr FROM $TABLE_TORG_ELEV e1
		INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
		WHERE e1.obl_id='".$obl_id."' $ray_cond
		ORDER BY e2.name";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['obl_id'] = $row->obl_id;
			$it['ray_id'] = $row->ray_id;
			$it['rate'] = $row->rate;
			$it['url'] = stripslashes($row->elev_url);
			$it['name'] = stripslashes($row->name);
			$it['addr'] = stripslashes($row->addr);
			$it['email'] = stripslashes($row->email);
			$it['pic'] = ( stripslashes($row->filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->filename) : '' );

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Torg_LotIdStr( $id ) { global $upd_link_db;
	return sprintf("%04d", $id);
}

function Torg_CultList( $LangId ) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_TORG_PROFILE, $TABLE_TORG_PROFILE_LANGS;

	$clist = Array();

	$query = "SELECT p1.*, p2.type_name, p2.descr
		FROM $TABLE_TORG_PROFILE p1
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		ORDER BY p2.type_name";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ci = Array();
			$ci['id'] = $row->id;
			$ci['name'] = stripslashes($row->type_name);
			$ci['url'] = stripslashes($row->url);
			$ci['descr'] = stripslashes($row->descr);
			$ci['ico'] = ( $row->icon_filename != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : "" );

			$clist[] = $ci;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $clist;
}

function Torg_RayonByObl( $LangId, $obl_id, $mode = "byidind" ) { global $upd_link_db;
	global $TABLE_RAYON, $TABLE_RAYON_LANGS;

	$rarr = Array();

	$query = "SELECT r1.*, r2.name FROM $TABLE_RAYON r1
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE r1.obl_id='".$obl_id."' ORDER BY r2.name";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ri = Array();
			$ri['id'] = $row->id;
			$ri['url'] = stripslashes($row->ray_url);
			$ri['name'] = stripslashes($row->name);

			if( $mode == "byidind" )
				$rarr[$row->id] = $ri;
			else
				$rarr[] = $ri;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $rarr;
}

function Torg_RayonById( $LangId, $ray_id ) { global $upd_link_db;
	global $TABLE_RAYON, $TABLE_RAYON_LANGS;

	$rarr = Array();

	$query = "SELECT r1.*, r2.name FROM $TABLE_RAYON r1
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE r1.id='".$ray_id."'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ri = Array();
			$ri['id'] = $row->id;
			$ri['url'] = stripslashes($row->ray_url);
			$ri['name'] = stripslashes($row->name);

			$rarr = $ri;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $rarr;
}

function Torg_CultParams( $LangId, $cult_id ) { global $upd_link_db;
	global $TABLE_TORG_PARAMS,$TABLE_TORG_PROFILE_PARAMS, $TABLE_TORG_PARAMS_LANGS, $TABLE_TORG_GROUP_PARAM, $TABLE_TORG_GROUP_PARAM_LANGS;

	$params = Array();

	$query="SELECT p1.id as ppid, p2.id, p2.isbasic, p2.param_display_type_id, p3.name, p3.izm, p3.sample, p1.group_id,
			g2.name as group_name, g1.sort_num
			FROM $TABLE_TORG_PROFILE_PARAMS p1
			INNER JOIN $TABLE_TORG_PARAMS p2 ON p2.id=p1.param_id
			INNER JOIN $TABLE_TORG_PARAMS_LANGS p3 ON p2.id=p3.param_id AND p3.lang_id='$LangId'
			INNER JOIN $TABLE_TORG_GROUP_PARAM g1 ON p1.group_id=g1.id
        	INNER JOIN $TABLE_TORG_GROUP_PARAM_LANGS g2 ON g1.id=g2.item_id AND g2.lang_id='$LangId'
			WHERE p1.profile_id='$cult_id'
			ORDER BY g1.sort_num, p1.sort_ind, p3.name";
	if( $res = mysqli_query($upd_link_db, $query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$item = Array();
			$item['param_id'] = $row->id;
			$item['name'] = stripslashes($row->name);
			$item['disp_type'] = $row->param_display_type_id;
			$item['izm'] = stripslashes($row->izm);
			$item['sample'] = stripslashes($row->sample);
			$item['is_basic'] = $row->isbasic;
			$item['group_id'] = $row->group_id;
			$item['group_name'] = stripslashes($row->group_name);

			$params[] = $item;
		}
		mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db);

	return $params;
}

function Torg_CultParamsOpts( $LangId, $param_id ) { global $upd_link_db;
	global $TABLE_TORG_PARAM_OPTIONS, $TABLE_TORG_PARAM_OPTIONS_LANGS;

	$paropts = Array();

	// Extract all option values for this parameter and print
	$query1 = "SELECT o1.*, o2.option_text
		FROM $TABLE_TORG_PARAM_OPTIONS o1, $TABLE_TORG_PARAM_OPTIONS_LANGS o2
		WHERE o1.param_id='".$param_id."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
		ORDER BY o1.sort_ind";
	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
		while( $row1 = mysqli_fetch_object($res1) )
		{
			$pi = Array();
			$pi['id'] = $row1->id;
			$pi['text'] = stripslashes( $row1->option_text );
			$paropts[] = $pi;
	    }
	    mysqli_free_result($res1);
	}

	return $paropts;
}

function Torg_LotInfo( $LangId, $lotid, $mode = "" ) { global $upd_link_db;
	global $TABLE_TORG_ITEMS, $TABLE_TORG_ITEMS_LANGS, $TABLE_TORG_ITEM2RAY, $TABLE_RAYON, $TABLE_RAYON_LANGS,
		$TABLE_TORG_PROFILE, $TABLE_TORG_PROFILE_LANGS, $TABLE_TORG_ITEM2ELEV, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS,
		$TORG_BUY;

	$lot = null;
	$query = "SELECT i1.*, i2.descr, i2.descr0, r2.name as rayon, i2i.ray_id, r1.obl_id, p1.type_name as cult_name, p0.icon_filename,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p0 ON i1.profile_id=p0.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p1 ON p0.id=p1.profile_id AND p1.lang_id='$LangId'
		WHERE i1.id='$lotid'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$lot = Array();
			$lot['id'] = $row->id;
			$lot['buyer_id'] = $row->publisher_id;
			$lot['rayon_id'] = $row->ray_id;
			$lot['rayon'] = stripslashes($row->rayon);
			$lot['cult_name'] = stripslashes($row->cult_name);
			$lot['cult_id'] = $row->profile_id;
			$lot['cult_ico'] = stripslashes($row->icon_filename);
			$lot['obl_id'] = $row->obl_id;
			$lot['amount'] = $row->amount;
			$lot['cost'] = $row->cost;
			$lot['dtst'] = $row->dtst;
			$lot['dten'] = $row->dten;
			$lot['descr'] = stripslashes($row->descr);
			$lot['descr0'] = stripslashes($row->descr0);
			$lot['status'] = $row->status;
			$lot['trade'] = $row->torg_type;

			$lot['costbest'] = TorgItem_BidMinMax( $LangId, $row->id, ($row->torg_type == $TORG_BUY ? "min" : "max") );

			// Check if it is elevator place
			$lot['elev'] = null;
			$query1 = "SELECT *, e1.*, e2.name, e2.addr FROM $TABLE_TORG_ITEM2ELEV e2i
				INNER JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
				INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
				WHERE e2i.item_id='".$row->id."'";
			if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$lot['elev'] = Array();
					$lot['elev']['id'] = $row1->id;
					$lot['elev']['name'] = stripslashes($row1->name);
					$lot['elev']['addr'] = stripslashes($row1->addr);
				}
				mysqli_free_result( $res1 );
			}

			if( $mode == "buyer" )
			{
				$lot['buyer'] = Torg_BuyerInfo( $LangId, $lot['buyer_id'] );
			}
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $lot;
}

function Torg_LotNum( $LangId, $obl_id, $ray_ids=null, $trade=0, $cult=0, $elev_ids=null, $srcmode="all" ) { global $upd_link_db;
	global $TABLE_TORG_ITEMS, $TABLE_TORG_ITEM2RAY, $TABLE_TORG_ITEMS_LANGS, $TABLE_TORG_PROFILE_LANGS, $TABLE_RAYON_LANGS,
		$TABLE_TORG_ITEM2ELEV, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS, $TABLE_RAYON;

	$totalnum = 0;

	$ray_cond = "";
	if( ($ray_ids != null) && (count($ray_ids)>0) )
	{
		$ray_cond = " AND i2i.ray_id IN (".join($ray_ids).") ";
	}

	$where_cond = "";
	if( $cult != 0 )
	{
		$where_cond .= " AND i1.profile_id='$cult' ";
	}
	if( $trade != 0 )
	{
		$where_cond .= " AND i1.torg_type='$trade' ";
	}

	$elev_cond = "";
	if( (($elev_ids != null) && (count($elev_ids)>0)) || ($srcmode == "elev") )
	{
		//for( $i=0; $i<count($elev_ids); $i++ )
		//{
			$elev_cond = " INNER JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id
				".( ($elev_ids != null) && (count($elev_ids)>0) ? " AND e2i.elev_id IN (".join(",",$elev_ids).") " : "" )."
				INNER JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
				INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
			";
		//}
	}
	else if( $srcmode == "hoz" )
	{
  		$elev_cond = " LEFT JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id ";
  		$elev_fields = ", e2i.id as item2elev ";
  		$where_cond .= " AND e2i.id IS NULL ";
	}

	$query = "SELECT count(*) as totitems
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id $ray_cond
		$elev_cond
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p1 ON i1.profile_id=p1.profile_id AND p1.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id ".( $obl_id != 0 ? " AND r1.obl_id='$obl_id' " : "" )."
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE i1.dt_end>NOW() AND i1.dt_start<NOW() $where_cond";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totalnum = $row->totitems;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $totalnum;
}

function Torg_LotList( $LangId, $obl_id, $ray_ids=null, $trade=0, $cult=0, $elev_ids=null, $srcmode="all", $sortby="", $sortdir="up", $pi=-1, $pn=20, $excludelotid=0 ) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_TORG_ITEMS, $TABLE_TORG_ITEM2RAY, $TABLE_TORG_ITEMS_LANGS, $TABLE_TORG_PROFILE_LANGS, $TABLE_RAYON_LANGS,
		$TABLE_TORG_ITEM2ELEV, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS, $TABLE_TORG_PROFILE, $TABLE_RAYON;

	$its = Array();

	$ray_cond = "";
	if( ($ray_ids != null) && (count($ray_ids)>0) )
	{
		$ray_cond = " AND i2i.ray_id IN (".join(",",$ray_ids).") ";
	}

	$where_cond = "";
	if( $cult != 0 )
	{
		$where_cond .= " AND i1.profile_id='$cult' ";
	}
	if( $trade != 0 )
	{
		$where_cond .= " AND i1.torg_type='$trade' ";
	}
	if( $excludelotid != 0 )
	{
		$where_cond .= " AND i1.id<>'$excludelotid' ";
	}

	$elev_cond = "";
	$elev_fields = "";
	if( (($elev_ids != null) && (count($elev_ids)>0)) || ($srcmode == "elev") )
	{
		//for( $i=0; $i<count($elev_ids); $i++ )
		//{
			$elev_cond = " INNER JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id
				".( ($elev_ids != null) && (count($elev_ids)>0) ? " AND e2i.elev_id IN (".join(",",$elev_ids).") " : "" )."
				INNER JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
				INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
			";
			$elev_fields = ", e1.id as elevator_id, e2.name as elevname ";
		//}
	}
	else if( $srcmode == "hoz" )
	{
  		$elev_cond = " LEFT JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id ";
  		$elev_fields = ", e2i.id as item2elev ";
  		$where_cond .= " AND e2i.id IS NULL ";
	}
	else
	{
		$elev_cond = " LEFT JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id
			LEFT JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
			LEFT JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
		";
		$elev_fields = ", e1.id as elevator_id, e2.name as elevname ";
	}

	$limit_cond = "";
	if( $pi == 0 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",$pn ";
	}
	else if( $pi > 0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
	}

	$sort_cond = "";
	switch( $sortby )
	{
		case "lotid":
			$sort_cond = " ORDER BY i1.id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timeend":
			$sort_cond = " ORDER BY i1.dt_end ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "amount":
			$sort_cond = " ORDER BY i1.amount ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "ray":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "obl":
			$sort_cond = " ORDER BY r1.obl_id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "stcost":
			$sort_cond = " ORDER BY i1.cost ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "nowcost":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "bidnum":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "cult":
			$sort_cond = " ORDER BY p2.type_name ".($sortdir == "down" ? "DESC" : "").",i1.dt_end";
			break;
	}

	$query = "SELECT i1.*, i2.descr, p1.icon_filename, p2.type_name, r2.name as rayon, r1.obl_id,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten $elev_fields
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id $ray_cond
		$elev_cond
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id ".( $obl_id != 0 ? " AND r1.obl_id='$obl_id' " : "" )."
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE i1.archive=0 AND i1.active=1 AND i1.dt_end>NOW() AND i1.dt_start<NOW() $where_cond
		$sort_cond
		$limit_cond";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['status'] = $row->status;
			$it['torg_type'] = $row->torg_type;
			$it['amount'] = $row->amount;
			$it['cost'] = $row->cost;
			$it['st'] = $row->dt_start;
			$it['en'] = $row->dt_end;
			$it['dtst'] = $row->dtst;
			$it['dten'] = $row->dten;
			$it['descr'] = stripslashes($row->descr);
			$it['cultname'] = stripslashes($row->type_name);
			$it['cultico'] = ( stripslashes($row->icon_filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : '' );
			$it['cultico_rel'] = stripslashes($row->icon_filename);
			$it['rayon'] = stripslashes($row->rayon);
			$it['status'] = $row->status;
			$it['obl_id'] = $row->obl_id;

			$it['elev_id'] = 0;
			$it['elev_name'] = "";
			if( ($elev_cond != "") && ($srcmode != "hoz") )
			{
				$it['elev_id'] = $row->elevator_id;
				$it['elev_name'] = stripslashes($row->elevname);
			}
			else if( isset($row->elevator_id) && ($row->elevator_id != null) )
			{
				$it['elev_id'] = $row->elevator_id;
				$it['elev_name'] = stripslashes($row->elevname);
			}

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Torg_LotListByElev( $LangId, $elev_id, $trade=0, $sortby="", $sortdir="up", $pi=-1, $pn=20 ) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_TORG_ITEMS, $TABLE_TORG_ITEM2ELEV, $TABLE_TORG_ITEM2RAY, $TABLE_TORG_ITEMS_LANGS,
		$TABLE_TORG_PROFILE, $TABLE_TORG_PROFILE_LANGS, $TABLE_RAYON_LANGS;

	$its = Array();

	$where_cond = "";
	if( $trade != 0 )
	{
		$where_cond .= " AND i1.torg_type='$trade' ";
	}

	$sort_cond = "";
	switch( $sortby )
	{
		case "lotid":
			$sort_cond = " ORDER BY i1.id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "torg":
			$sort_cond = " ORDER BY i1.torg_type ".($sortdir == "down" ? "DESC" : "").", i1.dt_end ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timeend":
			$sort_cond = " ORDER BY i1.dt_end ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timest":
			$sort_cond = " ORDER BY i1.dt_start ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "amount":
			$sort_cond = " ORDER BY i1.amount ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "ray":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "cult":
			$sort_cond = " ORDER BY p1.type_name ".($sortdir == "down" ? "DESC" : "").", i1.dt_end ".($sortdir == "down" ? "DESC" : "");
			break;
		case "stcost":
			$sort_cond = " ORDER BY i1.cost ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "nowcost":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "bidnum":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
	}

	$query = "SELECT i1.*, i2.descr, p1.icon_filename, p2.type_name, r2.name as rayon,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id AND e2i.elev_id='".$elev_id."'
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON_LANGS r2 ON i2i.ray_id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE i1.archive=0 AND i1.active=1 AND i1.dt_end>NOW() AND i1.dt_start<NOW() $where_cond
		$sort_cond";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['torg_type'] = $row->torg_type;
			$it['status'] = $row->status;
			$it['amount'] = $row->amount;
			$it['cost'] = $row->cost;
			$it['st'] = $row->dt_start;
			$it['en'] = $row->dt_end;
			$it['dtst'] = $row->dtst;
			$it['dten'] = $row->dten;
			$it['descr'] = stripslashes($row->descr);
			$it['cultname'] = stripslashes($row->type_name);
			$it['cultico'] = ( stripslashes($row->icon_filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : '' );
			$it['cultico_rel'] = stripslashes($row->icon_filename);
			$it['rayon'] = stripslashes($row->rayon);

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}

	return $its;
}

function Torg_LotsByOwnerNum($LangId, $buyer_id, $trade=0, $mode="all") { global $upd_link_db;
	global $TABLE_TORG_ITEMS, $TABLE_TORG_ITEM2RAY, $TABLE_TORG_ITEMS_LANGS, $TABLE_TORG_PROFILE_LANGS, $TABLE_RAYON_LANGS;
	global $TORG_STATUS_ACT, $TORG_STATUS_PAUSE, $TORG_STATUS_CLOSE, $TORG_STATUS_FINISH;

	$its_num = 0;

	$ray_cond = "";
	//if( ($ray_ids != null) && (count($ray_ids)>0) )
	//{
	//	$ray_cond = " AND i2i.ray_id IN (".join($ray_ids).") ";
	//}

	$where_cond = "";
	//if( $cult != 0 )
	//{
	//	$where_cond .= " AND i1.profile_id='$cult' ";
	//}
	if( $trade != 0 )
	{
		$where_cond .= " AND i1.torg_type='$trade' ";
	}

	switch( $mode )
	{
		case "finished":
			$where_cond .= " AND i1.status=$TORG_STATUS_FINISH ";
			break;
		case "stopped":
			$where_cond .= " AND i1.status=$TORG_STATUS_CLOSE ";
			break;
		case "current":
			$where_cond .= " AND (i1.status=$TORG_STATUS_ACT OR i1.status=$TORG_STATUS_PAUSE) AND i1.dt_end>NOW() AND i1.dt_start<NOW() ";
			break;
		case "lastmonth":
			$where_cond .= " AND i1.status=$TORG_STATUS_FINISH AND i1.dt_end>DATE_SUB( NOW(), INTERVAL 30 DAY )";
			break;
		default:
			$where_cond .= "";
			break;
	}

	$query = "SELECT count(*) as totlots
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id $ray_cond
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p1 ON i1.profile_id=p1.profile_id AND p1.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON_LANGS r2 ON i2i.ray_id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE i1.publisher_id='$buyer_id' $where_cond ";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$its_num = $row->totlots;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its_num;
}

function Torg_LotsByOwner($LangId, $buyer_id, $trade=0, $sortby="", $sortdir="up", $pi=-1, $pn=20, $mode = "all") { global $upd_link_db;
	global  $WWWHOST, $FILE_DIR, $TABLE_TORG_ITEMS, $TABLE_TORG_ITEM2RAY, $TABLE_TORG_ITEMS_LANGS, $TABLE_TORG_PROFILE_LANGS, $TABLE_RAYON_LANGS,
		$TABLE_TORG_PROFILE, $TABLE_TORG_ITEM2ELEV, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS, $TABLE_RAYON;
	global $TORG_STATUS_ACT, $TORG_STATUS_PAUSE, $TORG_STATUS_CLOSE, $TORG_STATUS_FINISH;

	$its = Array();

	$ray_cond = "";
	//if( ($ray_ids != null) && (count($ray_ids)>0) )
	//{
	//	$ray_cond = " AND i2i.ray_id IN (".join($ray_ids).") ";
	//}

	$where_cond = "";
	//if( $cult != 0 )
	//{
	//	$where_cond .= " AND i1.profile_id='$cult' ";
	//}
	if( $trade != 0 )
	{
		$where_cond .= " AND i1.torg_type='$trade' ";
	}

	switch( $mode )
	{
		case "finished":
			$where_cond .= " AND i1.status=$TORG_STATUS_FINISH ";
			break;
		case "stopped":
			$where_cond .= " AND i1.status=$TORG_STATUS_CLOSE ";
			break;
		case "current":
			$where_cond .= " AND (i1.status=$TORG_STATUS_ACT OR i1.status=$TORG_STATUS_PAUSE) AND i1.dt_end>NOW() AND i1.dt_start<NOW() ";
			break;
		default:
			$where_cond .= "";
			break;
	}

	$limit_cond = "";
	if( $pi == 0 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",$pn ";
	}
	else if( $pi > 0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
	}

	$sort_cond = "";
	switch( $sortby )
	{
		case "lotid":
			$sort_cond = " ORDER BY i1.id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timest":
			$sort_cond = " ORDER BY i1.dt_start ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timeen":
			$sort_cond = " ORDER BY i1.dt_end ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "ttype":
			$sort_cond = " ORDER BY i1.torg_type ".($sortdir == "down" ? "DESC" : "").", i1.id ";
			break;
		case "amount":
			$sort_cond = " ORDER BY i1.amount ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "cult":
			$sort_cond = " ORDER BY p2.type_name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "rayon":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "obl":
			//$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			$sort_cond = " ORDER BY r1.obl_id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "plac":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "stcost":
			$sort_cond = " ORDER BY i1.cost ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "curcost":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "propnum":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
	}

	$query = "SELECT i1.*, i2.descr, p1.icon_filename, p2.type_name, r1.obl_id, r2.name as rayon, e1.id as elevator_id, e2.name as elevname,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id $ray_cond
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		LEFT JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id
		LEFT JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
		LEFT JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
		WHERE i1.publisher_id='$buyer_id' $where_cond
		$sort_cond
		$limit_cond";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['ttype'] = $row->torg_type;
			$it['status'] = $row->status;
			$it['amount'] = $row->amount;
			$it['cost'] = $row->cost;
			$it['st'] = $row->dt_start;
			$it['en'] = $row->dt_end;
			$it['dtst'] = $row->dtst;
			$it['dten'] = $row->dten;
			$it['descr'] = stripslashes($row->descr);
			$it['cultname'] = stripslashes($row->type_name);
			$it['cultico'] = ( stripslashes($row->icon_filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : '' );
			$it['rayon'] = stripslashes($row->rayon);
			$it['obl_id'] = $row->obl_id;

			$it['elev_id'] = 0;
			$it['elev_name'] = "";
			if( $row->elevator_id != null )
			{
				$it['elev_id'] = $row->elevator_id;
				$it['elev_name'] = stripslashes($row->elevname);
			}

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Torg_LotsByBider($LangId, $buyer_id, $trade=0, $sortby="", $sortdir="up", $pi=-1, $pn=20, $mode=0) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_TORG_BIDS, $TABLE_TORG_ITEMS, $TABLE_TORG_ITEM2RAY, $TABLE_TORG_ITEMS_LANGS, $TABLE_TORG_PROFILE_LANGS,
	$TABLE_RAYON, $TABLE_RAYON_LANGS, $TABLE_TORG_PROFILE, $TABLE_TORG_ITEM2ELEV, $TABLE_TORG_ELEV, $TABLE_TORG_ELEV_LANGS;
	global $TORG_STATUS_ACT, $TORG_STATUS_PAUSE, $TORG_STATUS_CLOSE, $TORG_STATUS_FINISH, $BID_STATUS_WIN;

	$its = Array();

	$ray_cond = "";
	//if( ($ray_ids != null) && (count($ray_ids)>0) )
	//{
	//	$ray_cond = " AND i2i.ray_id IN (".join($ray_ids).") ";
	//}

	$where_cond = "";
	//if( $cult != 0 )
	//{
	//	$where_cond .= " AND i1.profile_id='$cult' ";
	//}
	if( $trade != 0 )
	{
		$where_cond .= " AND i1.torg_type='$trade' ";
	}

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",$pn ";
	}

	$sort_cond = "";
	switch( $sortby )
	{
		case "id":
			$sort_cond = " ORDER BY i1.id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timeen":
			$sort_cond = " ORDER BY i1.dt_end ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "ttype":
			$sort_cond = " ORDER BY i1.torg_type ".($sortdir == "down" ? "DESC" : "").", i1.id ";
			break;
		case "amount":
			$sort_cond = " ORDER BY i1.amount ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "rayon":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "obl":
			$sort_cond = " ORDER BY r1.obl_id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "stcost":
			$sort_cond = " ORDER BY i1.cost ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "curcost":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "propnum":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
	}

	switch( $mode )
	{
		case -1:
			break;
		case 1: // Все оконченные
			$where_cond .= " AND i1.status=$TORG_STATUS_FINISH ";
			break;
		default:
			$where_cond .= " AND i1.dt_end>NOW() AND i1.dt_start<NOW() ";
			break;
	}

	$query = "SELECT DISTINCT i1.*, i2.descr, p1.icon_filename, p2.type_name, r1.obl_id, r1.id as ray_id, r2.name as rayon, e1.id as elevator_id, e2.name as elevname,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten, b1.bid_status, b1.win_amount, b1.amount as bid_amount
		FROM $TABLE_TORG_BIDS b1
		INNER JOIN $TABLE_TORG_ITEMS i1 ON b1.item_id=i1.id
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id $ray_cond
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		LEFT JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id
		LEFT JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
		LEFT JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
		WHERE i1.archive=0 AND i1.active=1 AND b1.buyer_id='$buyer_id' $where_cond
		$sort_cond
		$limit_cond";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['ttype'] = $row->torg_type;
			$it['amount'] = $row->amount;
			$it['status'] = $row->status;
			$it['cost'] = $row->cost;
			$it['st'] = $row->dt_start;
			$it['en'] = $row->dt_end;
			$it['dtst'] = $row->dtst;
			$it['dten'] = $row->dten;
			$it['descr'] = stripslashes($row->descr);
			$it['cultname'] = stripslashes($row->type_name);
			$it['cultico'] = ( stripslashes($row->icon_filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : '' );
			$it['rayon'] = stripslashes($row->rayon);
			$it['rayon'] = stripslashes($row->rayon);
			$it['ray_id'] = $row->ray_id;
			$it['obl_id'] = $row->obl_id;
			$it['iswin'] = ( $row->bid_status == $BID_STATUS_WIN );
			$it['iswinamount'] = $row->win_amount;

			$it['elev_id'] = 0;
			$it['elev_name'] = "";
			if( $row->elevator_id != null )
			{
				$it['elev_id'] = $row->elevator_id;
				$it['elev_name'] = stripslashes($row->elevname);
			}

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function TorgItem_UpdateRate($prod_id) { global $upd_link_db;
	global $TABLE_TORG_ITEMS_RATE;

	// Calculate daily item rate
	$daily_rate_id = 0;

	$query = "SELECT * FROM $TABLE_TORG_ITEMS_RATE WHERE item_id='".$prod_id."' AND dt=CURDATE()";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$daily_rate_id = $row->id;
		}
		mysqli_free_result( $res );
	}

	if( $daily_rate_id == 0 )
	{
		$query = "INSERT INTO $TABLE_TORG_ITEMS_RATE (item_id, dt, amount) VALUES ('".$prod_id."', CURDATE(), 1)";
		if( !mysqli_query($upd_link_db,  $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	else
	{
		$query = "UPDATE $TABLE_TORG_ITEMS_RATE SET amount=amount+1 WHERE id=$daily_rate_id";
		if( !mysqli_query($upd_link_db,  $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
}

function TorgItem_BidMinMax($LangId, $lotid, $minmax = "min") { global $upd_link_db;
	global $TABLE_TORG_BIDS;

	$minp = 0;
	if( $minmax == "min" )
		$query = "SELECT min(price) as bestprice FROM $TABLE_TORG_BIDS WHERE item_id='$lotid'";
	else
		$query = "SELECT max(price) as bestprice FROM $TABLE_TORG_BIDS WHERE item_id='$lotid'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$minp = $row->bestprice;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $minp;
}

function TorgItem_BidMinMaxMy($LangId, $lotid, $uid, $minmax = "min") { global $upd_link_db;
	global $TABLE_TORG_BIDS;

	$minp = 0;
	if( $minmax == "min" )
		$query = "SELECT min(price) as bestprice FROM $TABLE_TORG_BIDS WHERE item_id='$lotid' AND buyer_id='$uid'";
	else
		$query = "SELECT max(price) as bestprice FROM $TABLE_TORG_BIDS WHERE item_id='$lotid' AND buyer_id='$uid'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$minp = $row->bestprice;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $minp;
}

function TorgItem_BidNum($LangId, $lotid) { global $upd_link_db;
	global $TABLE_TORG_BIDS;

	$nump = 0;
	$query = "SELECT count(*) as bidnum FROM $TABLE_TORG_BIDS WHERE item_id='$lotid'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$nump = $row->bidnum;
		}
		mysqli_free_result( $res );
	}

	return $nump;
}

function TorgItem_Bids($LangId, $lotid) { global $upd_link_db;
	global $TABLE_TORG_BIDS;

	$bids = Array();

	$query = "SELECT *, DATE_FORMAT(update_date, '%d.%m.%Y %H:%i') as biddate FROM $TABLE_TORG_BIDS WHERE item_id='$lotid' ORDER BY update_date";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$bi = Array();
			$bi['id'] = $row->id;
			$bi['buyer_id'] = $row->buyer_id;
			$bi['price'] = $row->price;
			$bi['amount'] = $row->amount;
			$bi['date'] = $row->biddate;
			$bi['datesrc'] = $row->update_date;
			$bi['status'] = $row->bid_status;
			$bi['win_amount'] = $row->win_amount;
			$bi['win_date'] = $row->win_date;
			$bids[] = $bi;
		}
		mysqli_free_result( $res );
	}

	return $bids;
}

function TorgItem_GetOblId($LangId, $lotid) { global $upd_link_db;
	global $TABLE_TORG_ITEM2RAY, $TABLE_RAYON;

	$obl_id = 0;
	$query = "SELECT r1.obl_id FROM $TABLE_TORG_ITEM2RAY i1r
		INNER JOIN $TABLE_RAYON r1 ON i1r.ray_id=r1.id
		WHERE i1r.item_id='".$lotid."'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$obl_id = $row->obl_id;
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);

	return $obl_id;
}

/////////////////////////////////////////////////////////////////////////////////

function Catalog_MakeIdByUrl( $brand_url ) { global $upd_link_db;
	global $TABLE_CAT_MAKE;

	$brand_id = 0;

	$query = "SELECT id FROM $TABLE_CAT_MAKE WHERE url='".addslashes($brand_url)."'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$brand_id = $row->id;
		}
		mysqli_free_result( $res );
	}

	return $brand_id;
}

function Catalog_SectIdByUrl( $sect_url ) { global $upd_link_db;
	global $TABLE_CAT_CATALOG;

	$sect_id = 0;

	$query = "SELECT id FROM $TABLE_CAT_CATALOG WHERE url='".addslashes($sect_url)."'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$sect_id = $row->id;
		}
		mysqli_free_result( $res );
	}

	return $sect_id;
}

function Catalog_MakeInfo( $LangId, $make_id ) { global $upd_link_db;
	global $TABLE_CAT_MAKE, $TABLE_CAT_MAKE_LANGS;
	global $WWWHOST, $FILE_DIR;

	$brand_info = Array();

	$query = "SELECT m1.*, m2.make_name, m2.descr FROM $TABLE_CAT_MAKE m1
		INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
		WHERE m1.id='$make_id'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$brand_info['id'] = $row->id;
			$brand_info['url'] = stripslashes($row->url);
			$brand_info['name'] = stripslashes($row->make_name);
			$brand_info['descr'] = stripslashes($row->descr);
			$brand_info['logo'] = (isset($row->logo_filename) ? $WWWHOST.$FILE_DIR.stripslashes($row->logo_filename) : "" );
		}
		mysqli_free_result( $res );
	}

	return $brand_info;
}

function Catalog_MakeList( $LangId, $sect_id=0, $pi=-1, $pn=20, $sort="" ) { global $upd_link_db;
	global $TABLE_CAT_MAKE, $TABLE_CAT_MAKE_LANGS, $TABLE_CAT_CATITEMS, $TABLE_CAT_ITEMS;
	global $WWWHOST, $FILE_DIR;

	$brands = Array();

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).", $pn ";
	}

	$sort_cond = " m2.make_name ";
	if( $sort == "rand" )
	{
		$sort_cond = " RAND() ";
	}

	if( $sect_id == 0 )
	{
		$query = "SELECT m1.*, m2.make_name, m2.descr FROM $TABLE_CAT_MAKE m1
			INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
			ORDER BY $sort_cond $limit_cond";
	}
	else
	{
		$query = "SELECT DISTINCT m1.id, m1.url, m2.make_name, m2.descr
			FROM $TABLE_CAT_CATITEMS c1
			INNER JOIN $TABLE_CAT_ITEMS i1 ON c1.item_id=i1.id
			INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
			INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
			WHERE c1.sect_id='$sect_id'
			ORDER BY $sort_cond $limit_cond";
	}
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$bi = Array();
			$bi['id'] = $row->id;
			$bi['url'] = stripslashes($row->url);
			$bi['name'] = stripslashes($row->make_name);
			$bi['descr'] = stripslashes($row->descr);
			$bi['logo'] = (isset($row->logo_filename) && ($row->logo_filename != "") ? $WWWHOST.$FILE_DIR.stripslashes($row->logo_filename) : "" );

			$brands[] = $bi;
		}
		mysqli_free_result( $res );
	}

	return $brands;
}

function Catalog_BrandInSubsect( $brandid, $cursect ) { global $upd_link_db;
	global $TABLE_CAT_ITEMS, $TABLE_CAT_CATITEMS, $TABLE_CAT_CATALOG;

	$thisprod = 0;
	$query = "SELECT count(*) as totprod FROM $TABLE_CAT_CATITEMS p1
		INNER JOIN $TABLE_CAT_ITEMS i1 ON p1.item_id=i1.id AND i1.make_id='$brandid'
		WHERE p1.sect_id='$cursect'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$thisprod = $row->totprod;
		}
		mysqli_free_result( $res );
	}

	if( $thisprod > 0 )
	{
		return true;
	}

	$query = "SELECT s1.* FROM $TABLE_CAT_CATALOG s1 WHERE s1.parent_id='$cursect'";
    if( $res = mysqli_query($upd_link_db,  $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
            if( Catalog_BrandInSubsect($brandid, $row->id) )
            {
            	mysqli_free_result($res);
            	return true;
            }
        }
        mysqli_free_result($res);
    }
    else
    	echo mysqli_error($upd_link_db);

	return false;
}

function Catalog_ListProductSubsect($langid, $cursect, $brandid) { global $upd_link_db;
	global $PHP_SELF, $TABLE_CAT_ITEMS, $TABLE_CAT_ITEMS_LANGS, $TABLE_CAT_MAKE, $TABLE_CAT_MAKE_LANGS,
		$TABLE_CAT_CATITEMS, $TABLE_CAT_CATALOG, $TABLE_CAT_CATALOG_LANGS, $TABLE_CAT_PRICES, $TABLE_CAT_ITEMS_PICS;

	// Collect items from subsections
	$condstr = "";
	if( $brandid != 0 )
		$condstr .= " AND m1.id='$brandid' ";

	// Get Section name
	$thissectname = "";
	$query1 = "SELECT s1.*, s2.name FROM $TABLE_CAT_CATALOG s1
		INNER JOIN $TABLE_CAT_CATALOG_LANGS s2 ON s1.id=s2.sect_id AND s2.lang_id='$langid'
		WHERE s1.id='".$cursect."'";
	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
	    if( $row1 = mysqli_fetch_object($res1) )
	    {
	    	$thissectname = stripslashes($row1->name);
	    }
	    mysqli_free_result($res1);
	}

	$thisarr = Array();
	$query = "SELECT b1.id as bid, b1.sect_id, i1.*, i2.descr, m2.make_name
				FROM $TABLE_CAT_CATITEMS b1
		    		INNER JOIN $TABLE_CAT_ITEMS i1 ON b1.item_id=i1.id
		    		INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$langid'
		            INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
		            INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$langid'
		            WHERE b1.sect_id='$cursect' $condstr
		            ORDER BY b1.sort_num, m2.make_name, i1.model";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
	    while( $row = mysqli_fetch_object($res) )
	    {
			$it = Array();
			$it['id'] = $row->id;
			$it['make'] = stripslashes($row->make_name);
			$it['model'] = stripslashes($row->model);
			$it['makemodel'] = $it['make']." ".$it['model'];
			$it['descr'] = stripslashes($row->descr);
			$it['sectid'] = $row->sect_id;
			$it['sectname'] = $thissectname;
			$ittext = strip_tags($it['descr']);

			if( strlen($ittext) > 300 )
				$ittext = substr($ittext, 0, 300)."...";

			$it['descr'] = $ittext;

			$prod_pic = Product_Photos( $langid, $row->id, 1 );

			$it['img'] = ( count($prod_pic) > 0 ? $prod_pic[0]['thumb'] : 'img/spacer.gif' );

            // Now we should find the price and availiablity for this item
			$thiscost = 0;
			$query2 = "SELECT * FROM $TABLE_CAT_PRICES WHERE item_id='".$row->id."'";
			if( $res2 = mysqli_query($upd_link_db,  $query2 ) )
			{
			while( $row2 = mysqli_fetch_object( $res2 ) )
			{
				$thiscost = $row2->price;
			}
			mysqli_free_result( $res2 );
			}
			$it['price'] = $thiscost;
            $thisarr[] = $it;
         	//$index++;
		}
		mysqli_free_result($res);
	}
	else
	    echo mysqli_error($upd_link_db);

 	$arr = Array();
	$query = "SELECT s1.* FROM $TABLE_CAT_CATALOG s1 WHERE s1.parent_id='$cursect'";
    if( $res = mysqli_query($upd_link_db,  $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	if( $brandid != 0 )
        	{
	            if( Catalog_BrandInSubsect($brandid, $row->id) )
	            {
              		$curarr = Catalog_ListProductSubsect($langid, $row->id, $brandid);
              		$arr = array_merge( $arr, $curarr );
	            }
	        }
	        else
	        {
	        	$curarr = Catalog_ListProductSubsect($langid, $row->id, $brandid );
              	$arr = array_merge( $arr, $curarr );
	        }
        }
        mysqli_free_result($res);
    }
    else
    	echo mysqli_error($upd_link_db);

    $arr = array_merge( $arr, $thisarr );

	return $arr;
}

function Catalog_SectLevel( $langid, $iid, $with_prod_num = false, $orderby = "", $pi=-1, $pn=10 ) { global $upd_link_db;
	global $TABLE_CAT_CATALOG, $TABLE_CAT_CATALOG_LANGS, $TABLE_CAT_CATITEMS, $sid;

	$sort_cond = "c1.sort_num";
	switch( $orderby )
	{
		case "rate":
			$sort_cond = "c1.sect_rate DESC, c1.sort_num";
			break;

		case "show":
			$sort_cond = "c1.show_first DESC, c1.sort_num";
			break;
	}

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",".($pn)." ";
	}

	$sects = Array();

	$query1 = "SELECT c1.parent_id, c1.id, c1.url, c1.filename, c2.name, c2.descr
		FROM $TABLE_CAT_CATALOG c1
		INNER JOIN $TABLE_CAT_CATALOG_LANGS c2 ON c1.id=c2.sect_id AND c2.lang_id='$langid'
		WHERE c1.parent_id='$iid' AND c1.visible=1
		ORDER BY $sort_cond
		$limit_cond";

	if( $with_prod_num )
	{
		$query1 = "SELECT c1.parent_id, c1.id, c1.url, c1.filename, c2.name, c2.descr, count(cc1.id) as totprods
		FROM $TABLE_CAT_CATALOG c1
		INNER JOIN $TABLE_CAT_CATALOG_LANGS c2 ON c1.id=c2.sect_id AND c2.lang_id='$langid'
		LEFT JOIN $TABLE_CAT_CATITEMS cc1 ON c1.id=cc1.sect_id
		WHERE c1.parent_id='$iid' AND c1.visible=1
		GROUP BY c1.id
		ORDER BY $sort_cond
		$limit_cond";
	}

	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$si = Array();
			$is_selected = false;
			$si['id'] = $row1->id;
			$si['name'] = stripslashes($row1->name);
			$si['descr'] = stripslashes($row1->descr);
			$si['ico'] = stripslashes($row1->filename);
			$si['url'] = stripslashes($row1->url);
			if($sid==$si['id']){
				$is_selected = true;
			}
			$si['selected'] = $is_selected;

			$si['prod_num'] = 0;
			if( $with_prod_num )
			{
				$si['prod_num'] = $row1->totprods;
			}

			$sects[] = $si;
		}
		mysqli_free_result( $res1 );
	}
	else
		echo mysqli_error($upd_link_db);

	return $sects;
}

function Catalog_SectLevelByGroups( $langid, $iid ) { global $upd_link_db;
	global $TABLE_CAT_CATALOG, $TABLE_CAT_CATALOG_LANGS, $TABLE_CAT_CATITEMS, $TABLE_CAT_SECTGROUPS, $sid;

	$sects = Array();

	$query1 = "SELECT c1.parent_id, c1.id, c1.url, c1.filename, c2.name, c2.descr, c1.menu_group_id, g1.title as grouptitle, g1.id as groupid,
 		case when g1.sort_num IS NOT NULL then g1.sort_num else 1000 end as groupsort
		FROM $TABLE_CAT_CATALOG c1
		INNER JOIN $TABLE_CAT_CATALOG_LANGS c2 ON c1.id=c2.sect_id AND c2.lang_id='$langid'
		LEFT JOIN $TABLE_CAT_SECTGROUPS g1 ON c1.menu_group_id=g1.id
		WHERE c1.parent_id='$iid' AND c1.visible=1
		ORDER BY groupsort,c1.sort_num";
	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$si = Array();
			$is_selected = false;
			$si['id'] = $row1->id;
			$si['name'] = stripslashes($row1->name);
			$si['descr'] = stripslashes($row1->descr);
			$si['ico'] = stripslashes($row1->filename);
			$si['url'] = stripslashes($row1->url);
			if($sid==$si['id']){
				$is_selected = true;
			}
			$si['selected'] = $is_selected;

			$si['group_id'] = 0;
			$si['group_name'] = "";
			$si['group_sort'] = $row1->groupsort;
			if( $row1->menu_group_id != 0 )
			{
				$si['group_id'] = $row1->groupid;
				$si['group_name'] = $row1->grouptitle;
				$si['group_sort'] = $row1->groupsort;
			}

			$sects[] = $si;
		}
		mysqli_free_result( $res1 );
	}
	else
		echo mysqli_error($upd_link_db);

	return $sects;
}

function Catalog_SectPath( $langid, $iid) { global $upd_link_db;
	global $TABLE_CAT_CATITEMS, $TABLE_CAT_CATALOG, $TABLE_CAT_CATALOG_LANGS;

	$sits = Array();
	$sectid = $iid;

	if( $sectid != 0 )
	{
		do
		{
			$found = false;
			$query1 = "SELECT c1.id, c1.parent_id, c1.url, c2.name
			  	FROM $TABLE_CAT_CATALOG c1, $TABLE_CAT_CATALOG_LANGS c2
			  	WHERE c1.id='$sectid' AND c1.id=c2.sect_id AND c2.lang_id='$langid'";
			if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$si = Array();
					$si['id'] = $row1->id;
					$si['name'] = stripslashes($row1->name);
					$si['url'] = stripslashes($row1->url);
					$sits[] = $si;
	      			$sectid = $row1->parent_id;
	      			$found = true;
				}
				mysqli_free_result( $res1 );
			}
			else
				echo mysqli_error($upd_link_db);

			if( !$found )
				break;
		}
		while( $sectid != 0 );
	}

	return $sits;
}

function Catalog_SectIsInPath( $iid, $path ) { global $upd_link_db;
	for($i=0; $i<count($path); $i++)
	{
		if( $iid == $path[$i]['id'] )
			return true;
	}

	return false;
}

function Catalog_SectInfo( $langid, $iid ) { global $upd_link_db;
	global $TABLE_CAT_CATITEMS, $TABLE_CAT_CATALOG, $TABLE_CAT_CATALOG_LANGS;

	$it = Array();

	$query1 = "SELECT c1.id, c1.parent_id, c1.url, c2.name, c2.descr, c2.descr0, c1.product_layout, c1.section_layout, c1.filename,
		c1.make_filter
	  	FROM $TABLE_CAT_CATALOG c1, $TABLE_CAT_CATALOG_LANGS c2
	  	WHERE c1.id='$iid' AND c1.id=c2.sect_id AND c2.lang_id='$langid'";
	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
		if( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$it['id'] = $row1->id;
			$it['pid'] = $row1->parent_id;
			$it['name'] = stripslashes($row1->name);
			$it['descr'] = stripslashes($row1->descr);
			$it['descr0'] = stripslashes($row1->descr0);
			$it['layout'] = $row1->product_layout;
			$it['slayout'] = $row1->section_layout;
			$it['pic'] = stripslashes($row1->filename);
			$it['url'] = stripslashes($row1->url);

			$it['showmakefilt'] = $row1->make_filter;
		}
		mysqli_free_result( $res1 );
	}
	else
		echo mysqli_error($upd_link_db);

	return $it;
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Lang
function Lang_RespStr($num) { global $upd_link_db;
	$resp_str_arr = Array("отзывов", "отзыв", "отзыва", "отзыва", "отзыва", "отзывов", "отзывов", "отзывов", "отзывов", "отзывов", "отзывов",
					"отзывов", "отзывов", "отзывов", "отзывов");

	$resp_str = ( $num < 15 ? $resp_str_arr[$num] : $resp_str_arr[ ($num%10) ] );

	return $resp_str;
}

function Lang_PhotoStr($num) { global $upd_link_db;
	$resp_str_arr = Array("фотографий",
		"фотография", "фотографии", "фотографии", "фотографии", "фотографий", "фотографий", "фотографий", "фотографий", "фотографий", "фотографий",
					"фотографий", "фотографий", "фотографий", "фотографий");

	$resp_str = ( $num < 15 ? $resp_str_arr[$num] : $resp_str_arr[ ($num%10) ] );

	return $resp_str;
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// CART
function Shop_MakeOrderNumber($order_id) { global $upd_link_db;
	return ($order_id+10000);
}

function Buyer_Info($buyer_id) { global $upd_link_db;
	global $TABLE_SHOP_BUYERS;

	$bi = Array();

	$query = "SELECT * FROM $TABLE_SHOP_BUYERS WHERE id='$buyer_id'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$bi['id'] = $row->id;
			$bi['name'] = stripslashes($row->name);
			$bi['orgname'] = stripslashes($row->orgname);
			$bi['login'] = stripslashes($row->login);
			$bi['city'] = stripslashes($row->city);
			$bi['phone'] = stripslashes($row->phone);
			$bi['email'] = stripslashes($row->email);
			$bi['obl_id'] = $row->obl_id;
			$bi['active'] = $row->isactive;
			$bi['active_web'] = $row->isactive_web;
			$bi['discount_level'] = $row->discount_level_id;
		}
		mysqli_free_result( $res );
	}

	return $bi;
}

function Buyer_OrdersNum($buyer_id, $order_status = 0) { global $upd_link_db;
	global $TABLE_SHOP_BUYERS, $TABLE_SHOP_ORDERS;

	$order_status_cond = "";
	if( $order_status > 0 )
	{
		// Select orders, only with selected status
		$order_status_cond = " AND order_status='$order_status' ";
	}

	$orders_num = 0;

	$query = "SELECT count(*) as totorders FROM $TABLE_SHOP_ORDERS WHERE buyer_id=".$buyer_id." $order_status_cond";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
   			$orders_num = $row->totorders;
		}
		mysqli_free_result( $res );
	}

	return $orders_num;
}

function Buyer_Orders($buyer_id, $order_status = 0, $pi = -1, $pn = 5) { global $upd_link_db;
	global $TABLE_SHOP_BUYERS, $TABLE_SHOP_ORDERS;

	$order_status_cond = "";
	if( $order_status > 0 )
	{
		// Select orders, only with selected status
		$order_status_cond = " AND order_status='$order_status' ";
	}

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",$pn ";
	}

	$orders = Array();

	$query = "SELECT *, DATE_FORMAT(order_time, '%d.%m.%Y %H:%i') as ordertm, DATE_FORMAT(update_time, '%d.%m.%Y') as donedt
		FROM $TABLE_SHOP_ORDERS
		WHERE buyer_id=".$buyer_id." $order_status_cond
		ORDER BY order_time DESC
		$limit_cond";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
   			$oi = Array();
   			$oi['id'] = $row->id;
   			$oi['time'] = $row->ordertm;
   			$oi['date'] = mb_substr($row->ordertm, 0, 10,"UTF-8");
   			$oi['date_done'] = $row->donedt;
   			$oi['status'] = $row->order_status;
   			$oi['payed'] = $row->payment_status;
   			$oi['total_cost'] = $row->total_cost;
   			$oi['total_cost_grn'] = $row->total_cost_grn;
   			$oi['order_ue_kurs'] = $row->ue_kurs;

   			$orders[] = $oi;
		}
		mysqli_free_result( $res );
	}

	return $orders;
}

function Buyer_OrderInfo($LangId, $order_id) { global $upd_link_db;
	global $TABLE_SHOP_ORDERS, $TABLE_SHOP_CART_ORDERS, $TABLE_SHOP_CART, $TABLE_CAT_ITEMS, $TABLE_CAT_MAKE, $TABLE_CAT_MAKE_LANGS,
		$TABLE_CAT_CATITEMS, $TABLE_CAT_CATALOG, $TABLE_CAT_CATALOG_LANGS;/*, $TABLE_CAT_PRICES;*/

	$cart = Array();
	$cart['num'] = 0;
	$cart['pos'] = 0;
	$cart['cost'] = 0;
	$cart['order_cost'] = 0;
	$cart['order_cost_grn'] = 0;
	$cart['order_ue_kurs'] = 0;
	$cart['payed_status'] = 0;
	$cart['order_status'] = 0;
	$cart['items'] = Array();

	$total_num = 0;
	$total_pos = 0;
	$total_cost = 0;


	$query = "SELECT * FROM $TABLE_SHOP_ORDERS WHERE id='".$order_id."'";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$cart['order_cost'] = $row->total_cost;
			$cart['order_cost_grn'] = $row->total_cost_grn;
			$cart['order_ue_kurs'] = $row->ue_kurs;

			$cart['payed_status'] = $row->payment_status;
			$cart['order_status'] = $row->order_status;
		}
		mysqli_free_result( $res );
	}

	// Get if there are something in cart
	$query = "SELECT i1.id, c.id as cart_id, i1.articul, i1.model, i1.url, c.oborud_price as price, c.oborud_num, m1.url as make_url, m2.make_name,
			cc1.sect_id, s1.url as sect_url, s2.name
		FROM $TABLE_SHOP_CART_ORDERS oc1
		INNER JOIN $TABLE_SHOP_CART c ON oc1.cart_id=c.id
		INNER JOIN $TABLE_CAT_ITEMS i1 ON c.oborud_id=i1.id
		INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
		INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
		INNER JOIN $TABLE_CAT_CATITEMS cc1 ON i1.id=cc1.item_id
		INNER JOIN $TABLE_CAT_CATALOG s1 ON cc1.sect_id=s1.id
		INNER JOIN $TABLE_CAT_CATALOG_LANGS s2 ON s1.id=s2.sect_id AND s2.lang_id='$LangId'
		WHERE oc1.order_id='".$order_id."'";

	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$ca = Array();
			$ca['id'] = stripslashes($row->id);
			$ca['cart_id'] = stripslashes($row->cart_id);
			$ca['articul'] = stripslashes($row->articul);
			$ca['name'] = stripslashes($row->name);
			$ca['make'] = stripslashes($row->make_name);
			$ca['model'] = stripslashes($row->model);
			$ca['cnt'] = stripslashes($row->oborud_num);
			$ca['sect_id'] = stripslashes($row->sect_id);
			$ca['prod_url'] = stripslashes($row->url);
			$ca['make_url'] = stripslashes($row->make_url);
			$ca['sect_url'] = stripslashes($row->sect_url);
			$ca['price'] = $row->price;
			$ca['num'] = $row->oborud_num;

			$cart['items'][] = $ca;

			$cart['pos']++;
			$cart['num'] += $row->oborud_num;
			$cart['cost'] += ($row->oborud_num*$row->price);
		}
		mysqli_free_result($res);
	}

	return $cart;
}

function Buyer_OrdersPayedSum($buyer_id) { global $upd_link_db;
	global $TABLE_SHOP_ORDERS;

	$payed_sum = 0;

	// Find total payed sum in past for all order to calculate the bonus discount
	$query1 = "SELECT sum(total_cost_grn) as totpayed
		FROM $TABLE_SHOP_ORDERS
		WHERE buyer_id=".$buyer_id." AND order_status=4 AND payment_status=1";
	if( $res1 = mysqli_query($upd_link_db,  $query1 ) )
	{
		if( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$payed_sum = $row1->totpayed;
		}
		mysqli_free_result( $res1 );
	}
	else
		mysqli_error($upd_link_db)."<br />";

	return $payed_sum;
}


function Trader_UpdateRate($trader_id) { global $upd_link_db;
	global $TABLE_TRADER_RATE;

	// Calculate daily item rate
	$daily_rate_id = 0;

	$query = "SELECT * FROM $TABLE_TRADER_RATE WHERE item_id='".$trader_id."' AND dt=CURDATE()";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$daily_rate_id = $row->id;
		}
		mysqli_free_result( $res );
	}

	if( $daily_rate_id == 0 )
	{
		$query = "INSERT INTO $TABLE_TRADER_RATE (item_id, dt, amount) VALUES ('".$trader_id."', CURDATE(), 1)";
		if( !mysqli_query($upd_link_db,  $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	else
	{
		$query = "UPDATE $TABLE_TRADER_RATE SET amount=amount+1 WHERE id=$daily_rate_id";
		if( !mysqli_query($upd_link_db,  $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
}

function Trader_CommentNum($trader_id) { global $upd_link_db;
	global $TABLE_TRADER_COMMENT;

	$comments_num = 0;

	$query = "SELECT count(*) as totcomments FROM $TABLE_TRADER_COMMENT WHERE item_id='$trader_id' AND visible=1 ";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$comments_num = $row->totcomments;
		}
		mysqli_free_result( $res );
	}

	return $comments_num;
}

function Trader_CommentAvgRate($trader_id) { global $upd_link_db;
	global $TABLE_TRADER_COMMENT;

	$resp_avg = 0;

	$query = "SELECT avg(rate) as avgrate FROM $TABLE_TRADER_COMMENT WHERE item_id='$trader_id' AND visible=1 ";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$resp_avg = ($row->avgrate != null ? $row->avgrate : 0);
		}
		mysqli_free_result( $res );
	}

	return $resp_avg;
}

function Trader_Comments($LangId, $trader_id, $pi=-1, $pn=20, $dtsqltpl="") { global $upd_link_db;
	global $TABLE_TRADER_COMMENT, $TABLE_TRADER_COMMENT_LANGS;

	$coms = Array();

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pn*$pi).",$pn ";
	}

	$dtsqlfmt = '%H:%i:%s %d.%m.%Y';
	if( $dtsqltpl != "" )
		$dtsqlfmt = $dtsqltpl;

	$query = "SELECT c1.*, DATE_FORMAT(c1.add_date, '$dtsqlfmt') as dtstr, c2.content FROM $TABLE_TRADER_COMMENT c1
		INNER JOIN $TABLE_TRADER_COMMENT_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
		WHERE c1.item_id='$trader_id' AND c1.visible=1
		ORDER BY add_date DESC
		$limit_cond";
	if( $res = mysqli_query($upd_link_db,  $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ci = Array();
			$ci['id'] = $row->id;
			$ci['author'] = stripslashes($row->author);
			//$ci['sort'] = $row->sort_num;
			$ci['show'] = $row->visible;
			$ci['rate'] = $row->rate;
			$ci['dt0'] = $row->add_date;
			$ci['dt'] = $row->dtstr;
			$ci['comment'] = stripslashes($row->content);

			$coms[] = $ci;
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);

	return $coms;
}


function Torg_SeoDefTitle($LangId, $obl_name, $trade=0, $cult_id=0, $cult_name="", $sort_id=0) { global $upd_link_db;
	global $TABLE_TORG_TITLES, $TORG_BUY;

	$result = Array();

	$orgtitle = ($trade == $TORG_BUY ? "Закупки " : "Продажа ").( $cult_id == 0 ? "аграрной продукции" : $cult_name).", ".( $obl_name == "" ? "__oblname__" : $obl_name )." - онлайн тендеры от Агротендер";
	$orgkeyw = ($trade == $TORG_BUY ? "закупки, купить, " : "продажа, ").( $cult_id == 0 ? "" : $cult_name.", " )."аграрная продуция, ".( $obl_name == "" ? "__oblname__" : $obl_name );
	$orgdescr = "Сайт АгроТенедер предлагает ".($trade == $TORG_BUY ? "закупки " : "продажу ")."аграрной продукции, ".( $cult_id == 0 ? "" : $cult_name)." в ".( $obl_name == "" ? "__oblname2__" : $obl_name );

	/*
	switch($sort_id)
	{
		case 0:
			$orgtitle = "$sect_name ".($make_name != "" ? $make_name." " : "").". Купить $sect_name ".($make_name != "" ? $make_name." " : "")." - Продажа, Выбрать, Заказать, Цена.";
			$orgkeyw = "$sect_name, ".($make_name != "" ? $make_name.", " : "")."купить, продажа, каталог, интернет магазин, цены";
			$orgdescr = "$sect_name ".($make_name != "" ? $make_name." " : "")."в интернет магазине ".strtoupper($_SERVER['HTTP_HOST']).". У нас самые низкие цены на $sect_name".($make_name != "" ? " ".$make_name : "").".";
			break;

		case 1:
			$orgtitle = "Дешевые $sect_name ".($make_name != "" ? $make_name." " : "")."в интернет магазине ".strtoupper($_SERVER['HTTP_HOST'])." ";
			$orgkeyw = "дешевые, $sect_name, ".($make_name != "" ? $make_name.", " : "")."интернет магазин";
			$orgdescr = "Самые дешевые $sect_name ".($make_name != "" ? $make_name." " : "")."только в магазине ".strtoupper($_SERVER['HTTP_HOST']).". У нас самые низкие цены на $sect_name ".($make_name != "" ? $make_name." " : "").".";
			break;

		case 2:
			$orgtitle = "Популярные $sect_name ".($make_name != "" ? $make_name." " : "")."в интернет-магазине ".strtoupper($_SERVER['HTTP_HOST']);
			$orgkeyw = "популярные, $sect_name, ".($make_name != "" ? $make_name.", " : "")."интернет-магазин";
			$orgdescr = "Самые популярные $sect_name ".($make_name != "" ? $make_name." " : "")." - ".strtoupper($_SERVER['HTTP_HOST']).". Покупайте то что покупают все.";
			break;

		case 3:
			$orgtitle = "От дорогих к дешевым: $sect_name ".($make_name != "" ? $make_name." " : "")."в интернет магазине ".strtoupper($_SERVER['HTTP_HOST'])." ";
			$orgkeyw = "дорогие, $sect_name, ".($make_name != "" ? $make_name.", " : "")."интернет магазин";
			$orgdescr = "Самые дорогие $sect_name ".($make_name != "" ? $make_name." " : "")."только в магазине ".strtoupper($_SERVER['HTTP_HOST']).". У нас самые низкие цены на $sect_name ".($make_name != "" ? $make_name." " : "").".";
			break;
	}
	*/

	$orgcont = "";
	$orgwords = "";

	$result['title'] = $orgtitle;
	$result['descr'] = $orgdescr;
	$result['keyw'] = $orgkeyw;
	$result['txt1'] = $orgcont;
	$result['txt2'] = $orgwords;

    return $result;
}

function Torg_SeoTitleParse($obl_id, $str) { global $upd_link_db;
	global $REGIONS, $REGIONS2, $REGIONS_CITY, $REGIONS_CITY2, $REGIONS_CITY3;

	$obl1 = ( isset($REGIONS[$obl_id]) ? $REGIONS[$obl_id] : "" );
	$obl2 = ( isset($REGIONS2[$obl_id]) ? $REGIONS2[$obl_id] : "" );
	$city1 = ( isset($REGIONS_CITY[$obl_id]) ? $REGIONS_CITY[$obl_id] : "" );
	$city2 = ( isset($REGIONS_CITY2[$obl_id]) ? $REGIONS_CITY2[$obl_id] : "" );
	$city3 = ( isset($REGIONS_CITY3[$obl_id]) ? $REGIONS_CITY3[$obl_id] : "" );
	$seostr = $str;
	$seostr = str_replace("__oblname__", $obl1, $seostr);
	$seostr = str_replace("__oblname2__", $obl2, $seostr);
	$seostr = str_replace("__cityname__", $city1, $seostr);
	$seostr = str_replace("__cityname2__", $city2, $seostr);
	$seostr = str_replace("__cityname3__", $city3, $seostr);
	
	$year = date("Y", time());
	
	$seostr = str_replace("__year__", $year, $seostr);

	return $seostr;
}

?>
