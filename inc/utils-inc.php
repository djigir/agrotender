<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////
//

function check_reCaptcha($grecapt, $ip="", $params=null) { global $upd_link_db;
	global $RECAPTCHA_SECRET, $RECAPTCHA_URL;
	
	//$send_data = Array("action" => $action, "params" => serialize($params), "srvind" => $syncservind);		
	$send_data = Array("secret" => $RECAPTCHA_SECRET, "response" => $grecapt, "remoteip" => $ip);
	
	//$send_txt = serialize($send_data);

	///////////////////////////////////////////////////////////
	// Version php5
	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($send_data),
		),
	);
	$context  = stream_context_create($options);
	$response = file_get_contents($RECAPTCHA_URL, false, $context);
	
	//var_dump($response);
	//echo "<br>";
	$json_res = json_decode($response);
	
	return $json_res;
}

/////////////////////////////////////////////////////////////////////////////////////


function Post_Delete($UserId, $postid) { global $upd_link_db;
    global $TABLE_ADV_POST, $TABLE_FISHKA, $TABLE_LENTA;

    $realpostid = 0;
    $query = "SELECT * FROM $TABLE_ADV_POST WHERE id='$postid' AND author_id='$UserId'";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object( $res ) )
        {
            $realpostid = $row->id;
        }
        mysqli_free_result( $res );
    }
    else
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }

    if( $realpostid == 0 )
        return false;

    _post_Delete($realpostid);

    $query = "UPDATE $TABLE_FISHKA SET post_id=0, active=0 WHERE user_id='$UserId' AND post_id='$postid'";
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }
    $query = "DELETE FROM $TABLE_LENTA WHERE author_id='$UserId' AND post_id='$postid'";
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }

    return true;
}

function _post_Delete($postid) { global $upd_link_db;
    global $TABLE_ADV_POST_PICS, $TABLE_ADV_POST_PICS, $TABLE_ADV_POST_UPS, $TABLE_ADV_TAGS_2POST, $TABLE_ADV_POST, $TABLE_COMPANY_POST2ADVTOPICS;

    $query1 = "SELECT * FROM $TABLE_ADV_POST_PICS WHERE item_id=".$postid;
    if( $res1 = mysqli_query($upd_link_db, $query1 ) )
    {
        while( $row1 = mysqli_fetch_object( $res1 ) )
        {
            if( ($row1->filename != "") && file_exists(stripslashes($row1->filename)) )
                @unlink(stripslashes($row1->filename));
            if( ($row1->filename_ico != "") && file_exists(stripslashes($row1->filename_ico)) )
                @unlink(stripslashes($row1->filename_ico));
            if( ($row1->filename_big != "") && file_exists(stripslashes($row1->filename_big)) )
                @unlink(stripslashes($row1->filename_big));
            if( ($row1->filename_thumb != "") && file_exists(stripslashes($row1->filename_thumb)) )
                @unlink(stripslashes($row1->filename_thumb));
        }
        mysqli_free_result( $res1 );
    }


    $query = "DELETE FROM $TABLE_ADV_POST_PICS WHERE item_id=".$postid;
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }

    $query = "DELETE FROM $TABLE_ADV_POST_UPS WHERE item_id=".$postid;
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }

    $query = "DELETE FROM $TABLE_ADV_TAGS_2POST WHERE item_id=".$postid;
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }

    $query = "DELETE FROM $TABLE_ADV_POST WHERE id=$postid";
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }

    $query = "DELETE FROM $TABLE_COMPANY_POST2ADVTOPICS WHERE post_id=".$postid;
    if( !mysqli_query($upd_link_db, $query ) )
    {
        //echo mysqli_error($upd_link_db);
        debugMysql();
    }
}
// Make phone number in format XXXNNNNNNN (trimming all spaces, dashed, coutnry codes etc.)
// Also extract first phone number if more then one is enumerated by ,
function makeSimplePhoneNum($phone) { global $upd_link_db;
	$out_arr = explode(",", $phone);
	$out = preg_replace("/[^0-9]+/i", "", $out_arr[0]);	//str_replace(",", "", str_replace(",", "", str_replace("-", "", str_replace(" ", "", trim($phone," +()"))));

	//echo "-- ".$out."<br />";

	//if( (strlen($out) > 7) && (strncmp("38", $out, 2)==0) )
	//{
	//	$out = substr($out, 2);
	//}
	//else if( (strlen($out) > 10) && (strncmp("8", $out, 1)==0) )
	//{
	//	$out = substr($out, 1);
	//}

	return $out; //substr($out,0,10);
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function makeStrByNum($val, $strs) { global $upd_link_db;
	$num0 = $val % 100;
	
	return ( $num0 > 20 ? $strs[($num0 % 10)] : $strs[$num0] );
}

function daysStr($num) { global $upd_link_db;
	//$num0 = $num % 100;
	
	$da = Array("дней", "день", "дня", "дня", "дня", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней", "дней");
	
	return makeStrByNum($num, $da);
	
	//return ( $num0 > 20 ? $da[($num0 % 10)] : $da[$num0] );
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Basic functions
function make_seed() { global $upd_link_db;
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// GUID generation
function makeUuid() { global $upd_link_db;
	list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);

	srand($seed);

	$uuid = sprintf( "%08X-%04X-%04X-%04X-%06X%06X", rand(1000, (1024*1024*1023*2-1)), rand(0,65535), time() % 65535, rand(0,65535), rand(0,16777215), rand(0,16777215));
	return $uuid;
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Send windows 1251 email message (only for cp1251 page encoding)
function send1251mail($to, $subject, $body, $frommail="") { global $upd_link_db;
	global $continfo, $WWWHOST;
	
	$from_addr = $continfo['infomail'];
	if( $frommail != "" )
		$from_addr = $frommail;

	$mailto = $to;
	$mailsub = "=?windows-1251?b?".base64_encode($subject)."?=";
	$mailbody = $body;
	$mailfrom = "Служба поддержки ".substr($WWWHOST, 7, strlen($WWWHOST)-8);
	$mailhdr = "From: =?windows-1251?b?".base64_encode($mailfrom)."?= <".$from_addr.">\r\nReply-To: =?windows-1251?b?".base64_encode($mailfrom)."?= <".$from_addr.">\r\nContent-Type: text/plain; charset=\"windows-1251\"";
	return mail( $mailto, $mailsub, $mailbody, $mailhdr );
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//
function doPhoneStr($tel) { global $upd_link_db;
	$buyerphone = $tel;
	$buyerphone = str_replace(" ", "", $buyerphone);
	$buyerphone = str_replace("-", "", $buyerphone);
	$buyerphone = str_replace("(", "", $buyerphone);
	$buyerphone = str_replace(")", "", $buyerphone);

	if( (strlen($buyerphone) > 9) && (strncmp($buyerphone, "80", 2) == 0) )
	{
		$buyerphone = "+3".$buyerphone;
	}
	else if( (strlen($buyerphone) == 10) && (strncmp($buyerphone, "0", 1) == 0) )
	{
		$buyerphone = "+38".$buyerphone;
	}

	return $buyerphone;
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// GET method query processing methods
function ClearSQLInject( $str ) { global $upd_link_db;
	$strval = $str;

	$strval = str_replace("\'",'',$strval);
	$strval = str_replace('"','',$strval);
	$strval = str_replace("'",'',$strval);
	$strval = str_replace('\"','',$strval);
	$strval = str_replace('%27','',$strval);
	$strval = str_replace("%22",'',$strval);

	return $strval;
}

function StripParamFromQuery( $querystr, $stripname ) { global $upd_link_db;
	$params = split( "&", $querystr );
	$out_query = "";
	for($i=0; $i<count($params); $i++)
	{
    	$it = split( "=", $params[$i] );
      	if( count($it) == 2 )
      	{
      		if( $it[0] != $stripname )
      		{
      			$out_query .= ($out_query == "" ? "" : "&").$params[$i];
      		}
      	}
	}
	return $out_query;
}

function TranslitEncode($string) { global $upd_link_db;
	$converter = array(
	'а' => 'a',   'б' => 'b',   'в' => 'v',
	'г' => 'g',   'д' => 'd',   'е' => 'e',
	'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	'и' => 'i',   'й' => 'y',   'к' => 'k',
	'л' => 'l',   'м' => 'm',   'н' => 'n',
	'о' => 'o',   'п' => 'p',   'р' => 'r',
	'с' => 's',   'т' => 't',   'у' => 'u',
	'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	'ь' => "",   'ы' => 'y',   'ъ' => "",
	'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
	' ' => '_',   '%' => '_',
	'А' => 'A',   'Б' => 'B',   'В' => 'V',
	'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	'О' => 'O',   'П' => 'P',   'Р' => 'R',
	'С' => 'S',   'Т' => 'T',   'У' => 'U',
	'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	'Ь' => "",  'Ы' => 'Y',   'Ъ' => "",
	'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	'!' => '', '#' => '_', '№' => '_', '$' => '_', '%' => '_', '*' => '_', '?' => '_', '@' => '_', ':' => '_', ';' => '_', "'" => '',
	'/' => '_', '\\' => '_', '"' => '', '\'' => '', '(' => '_', ')' => '_', '[' => '_', ']' => '_', '.' => '_', ',' => '', '&' => '_', '+' => '_'
	);

	$conv_double = array('_________' => '_', '________' => '_', '_______' => '_', '______' => '_',
	'_____' => '_', '____' => '_', '___' => '_', '__' => '_', '_' => '_');

	$string = str_replace("&quot;", "", $string);
	$tmp1 = strtr($string, $converter);

	return trim( strtr($tmp1, $conv_double), "_" );
}

function holdQuotes($str) { global $upd_link_db;
	return str_replace("\"", "&quot;", $str);
}
function unholdQuotes($str) { global $upd_link_db;
	return str_replace("&quot;", "\"", $str);
}

////////////////////////////////////////////////////////////////////////////////
//
//
//
////////////////////////////////////////////////////////////////////////////////

function Image_RecalcSize($w, $h, $dw, $dh) { global $upd_link_db;
	$ow = 0;
	$oh = 0;
	if( ($w <= $dw) && ($h<=$dh) )
	{
		$ow = $w;
		$oh = $h;
	}
	else
	{
		if( ($w/$dw) > ($h/$dh) )
		{
			$oh = floor( ($dw*$h)/$w );
			$ow = $dw;
		}
		else
		{
			$ow = floor( ($dh*$w)/$h );
			$oh = $dh;
		}
	}

	return Array("w" => $ow, "h" => $oh);
}

// Get slides for splash banner
function Sildes_Get($LangId) { global $upd_link_db;
	global $TABLE_SLIDES, $WWWHOST, $FILE_DIR;

	$slides = Array();
	if( $res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_SLIDES ORDER BY sort_num") )
	{
		while( $row = mysqli_fetch_object($res) )
		{
		    $item['url'] = stripslashes($row->url);
		    $item['filename'] = $WWWHOST.$FILE_DIR.stripslashes($row->filename);
		    $item['alt'] = stripslashes($row->title);
		    $item['comment'] = stripslashes($row->comment);

		    $slides[] = $item;
		}
		mysqli_free_result($res);
	}

	return $slides;
}

// Get website contact information
function Contacts_Get($langid) { global $upd_link_db;
	global $TABLE_SITE_OPTIONS;

	$continfo = Array();
    $query = "SELECT * FROM $TABLE_SITE_OPTIONS WHERE lang_id=$langid ORDER BY id";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	if( ($row->id % 10) == 1 )		$continfo['infomail'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 2 )	$continfo['supmail'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 3 )	$continfo['phone1'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 4 )	$continfo['phone2'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 5 )	$continfo['fax'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 6 )	$continfo['address'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 7 )	$continfo['skype'] = stripslashes($row->value);
        	else if( ($row->id % 10) == 8 )	$continfo['icq'] = stripslashes($row->value);
        	//else if( ($row->id % 10) == 9 )	$continfo['ffax'] = stripslashes($row->value);
        	//else if( ($row->id % 10) == 0 )	$continfo['femail'] = stripslashes($row->value);
        }
        mysqli_free_result($res);
    }

    return $continfo;
}

// Extract text resources for website
function Resources_Get($langid) { global $upd_link_db;
	global $TABLE_RESOURCE, $TABLE_RESOURCE_LANGS;

	$txt_res = Array();

	// Now we should extract all text resources to display on page
	$query = "SELECT r1.*, r2.content FROM $TABLE_RESOURCE r1
		INNER JOIN $TABLE_RESOURCE_LANGS r2 ON r1.id=r2.item_id AND r2.lang_id='$langid'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ri = Array();
			$ri['id'] = $row->id;
			$ri['name'] = stripslashes($row->name);
			$ri['title'] = stripslashes($row->title);
			$ri['text'] = stripslashes($row->content);
			$txt_res[$row->name] = $ri;
		}
		mysqli_free_result( $res );
	}

    return $txt_res;
}

////////////////////////////////// BANNERS /////////////////////////////////////

// Get banners
function Banners_Get($LangId, $pagepos=-1, $pageurl="", $usemask=false ) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_BANNERS, $TABLE_BANNERS_LANGS;

	$cond = "b1.managetype=1";
	$sort = "b1.id";
	if( $pageurl != "" )
	{
		$cond = " b1.managetype=0 AND b1.page_url LIKE '".addslashes($pageurl).($usemask ? "%" : "")."' ";
		$sort = "b1.sort_num";
	}

	if( $pagepos != -1 )
	{
		$cond .= " AND b1.disppos='".$pagepos."' ";
		$sort = "b1.sort_num";
	}

	$bans = Array();

	$query = "SELECT b1.*, bl1.alttext FROM $TABLE_BANNERS b1
		INNER JOIN $TABLE_BANNERS_LANGS bl1 ON b1.id=bl1.banner_id AND bl1.lang_id='$LangId'
		WHERE $cond
		ORDER BY $sort";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$bi = Array();
			$bi['id'] = $row->id;
			$bi['link'] = stripslashes($row->linkurl);
			$bi['alt'] = stripslashes($row->alttext);
			$bi['url'] = trim(stripslashes($row->ban_link));
			$bi['file'] = ( trim(stripslashes($row->filename)) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->filename) : "" );
			$bi['type'] = $row->disptype;
			$bi['pos'] = $row->disppos;
			$bi['w'] = $row->width;
			$bi['h'] = $row->height;

			$bans[] = $bi;
		}
		mysqli_free_result( $res );
	}

	return $bans;
}

function Banners_Show($banobj) { global $upd_link_db;
	global $BANNER_TYPE_FLASH;

	if( !$banobj )
		return "";

	$bancode = "";
	if( isset($banobj) && isset($banobj['file']) && ($banobj['file'] != "") )
	{
		if( $banobj['type'] == $BANNER_TYPE_FLASH )
		{
			$bancode = '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="'.$banobj['w'].'" HEIGHT="'.$banobj['h'].'" id="BANNER'.$banobj['id'].'" ALIGN="">
 <PARAM NAME=movie VALUE="'.$banobj['file'].'"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="'.$banobj['file'].'" quality=high bgcolor=#FFFFFF  WIDTH="'.$banobj['w'].'" HEIGHT="'.$banobj['h'].'" NAME="BANNER'.$banobj['id'].'" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>';
		}
		else
		{
			$bancode = "<a href=\"".$banobj['link']."\"><img src=\"".$banobj['file']."\" width=\"".$banobj['w']."\" height=\"".$banobj['h']."\" alt=\"".$banobj['alt']."\" border=\"0\" /></a>";
		}
	}

	return $bancode;
}

function Banners_Places($LangId, $pagetype=-1) { global $upd_link_db;
	global $TABLE_BANNER_PLACES;

	$cond = "";
	if( $pagetype >= 0 )
	{
		$cond = " WHERE p1.page_type='$pagetype' ";
	}

	$its = Array();

	$query = "SELECT p1.* FROM $TABLE_BANNER_PLACES p1 $cond ORDER BY p1.page_type, p1.position";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['page'] = $row->page_type;
			$it['pos'] = $row->position;
			$it['w'] = $row->size_w;
			$it['h'] = $row->size_h;
			$it['cost'] = $row->cost_grn;
			$it['name'] = stripslashes($row->name);

			$its[] = $it;
		}
		mysqli_free_result($res);
	}

	return $its;
}

function Banners_PlaceInfo($LangId, $placeid) { global $upd_link_db;
	global $TABLE_BANNER_PLACES;

	$cond = " WHERE p1.id='$placeid' ";

	$it = Array();

	$query = "SELECT p1.* FROM $TABLE_BANNER_PLACES p1 $cond ORDER BY p1.page_type, p1.position";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['page'] = $row->page_type;
			$it['pos'] = $row->position;
			$it['w'] = $row->size_w;
			$it['h'] = $row->size_h;
			$it['cost'] = $row->cost_grn;
			$it['name'] = stripslashes($row->name);
		}
		mysqli_free_result($res);
	}

	return $it;
}

function Banners_Place_Reqs($LangId, $placeid, $mode="now", $cityid=0) { global $upd_link_db;
	global $TABLE_BANNER_ROTATE;

	$cond = "";
	switch($mode)
	{
		case "all":
			$cond = "";
			break;

		case "current":
			$cond = " AND dt_start<=NOW() AND dt_end>=NOW() AND inrotate=1 ";
			break;

		default:
			$cond = " AND dt_end>=NOW() ";
			break;
	}

	$its = Array();
	$query = "SELECT * FROM $TABLE_BANNER_ROTATE WHERE place_id='$placeid' AND city_id='$cityid' $cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['place_id'] = $row->place_id;
			$it['city_id'] = $row->city_id;
			$it['user_id'] = $row->user_id;
			$it['pay_type'] = $row->pay_type;

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}

	return $its;
}

function Banners_Place_Rotate($LangId, $cityid=0) { global $upd_link_db;
	global $TABLE_BANNER_ROTATE, $TABLE_BANNER_PLACES;

	$cond = " AND dt_start<=NOW() AND dt_end>=NOW() AND archive=0 AND inrotate=1 ";

	$its = Array();
	$query = "SELECT r1.*, p1.page_type, p1.position, p1.size_w, p1.size_h
		FROM $TABLE_BANNER_ROTATE r1
		INNER JOIN $TABLE_BANNER_PLACES p1 ON r1.place_id=p1.id
		WHERE city_id='$cityid' $cond
		ORDER BY p1.page_type, p1.position";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			if( empty($its[$row->page_type]) )
			{
				$pi = Array("id" => $row->page_type, "places" => Array());
				$its[$row->page_type] = $pi;
			}

			if( empty($its[$row->page_type]['places'][$row->position]) )
			{
				$its[$row->page_type]['places'][$row->position] = Array();
			}

			$it = Array();
			$it['id'] = $row->id;
			$it['place_id'] = $row->place_id;
			$it['position'] = $row->position;
			$it['city_id'] = $row->city_id;
			$it['user_id'] = $row->user_id;
			$it['pay_type'] = $row->pay_type;
			$it['ban_file'] = stripslashes($row->ban_file);
			$it['ban_url'] = stripslashes($row->ban_link);
			$it['ban_w'] = $row->size_w;
			$it['ban_h'] = $row->size_h;

			$it['ban_alt'] = stripslashes($row->promo);

			$its[$row->page_type]['places'][$row->position][] = $it;
		}
		mysqli_free_result( $res );
	}

	return $its;
}

function Banners_Place_Show($pagetype, $placepos, $bans) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR;

	$ret_html = "";
	////Random plase

	if( isset($bans[$pagetype]) )
	{
	//var_dump($bans[$pagetype]);
	//	echo "<pre>";
	//	print_r($bans[$pagetype]['places']);
	//	echo "</pre>";
		if( isset($bans[$pagetype]['places'][$placepos]) )
		{
			if( count($bans[$pagetype]['places'][$placepos]) > 0 )
			{
				$rnd = array();
				$BannCount = count($bans[$pagetype]['places'][$placepos]);
				for ($i = 0; $i < $BannCount ; $i++)
				{
					$localrandom = rand (0 , $BannCount-1);
					if (!in_array ($localrandom, $rnd))
						$rnd[$i] = $localrandom;
					else
						$i--;
					
				}

				//Костыль для зернотранса!!
//				$CurBann = 0;
//				if ($placepos ==13)
//				{
//					for ($i = 0 ; $i < count($bans[$pagetype]['places'][$placepos]); $i++)
//					{
//						if ($bans[$pagetype]['places'][$placepos][$i]['id'] == 326)
//							$CurBann = $i;
//					//	echo $bans[$pagetype]['places'][$placepos][$i]['id']." " ;
//					}
//					$localrandom = rand (0 , 2);
//					if (($rnd[0] != $CurBann) && ($rnd[1] != $CurBann) && ($rnd[2] != $CurBann))
//						$rnd[$localrandom] = $CurBann;
//				}
				/////////////////////////				
				for ($i = 0 ; $i < count($bans[$pagetype]['places'][$placepos]) && $i<($placepos == 13 ? 3 : 5) ; $i++)
				{
				

				
				
					$banner = $bans[$pagetype]['places'][$placepos][$rnd[$i]];
				//	print_r ($banner);
					if( $banner['ban_file'] != "" )
					{
						// check extension
						$fext = "";
						$fextp = strrpos($banner['ban_file'], ".");
						if( $fextp !== FALSE )
						{
							$fext = strtolower(substr($banner['ban_file'], $fextp+1));
						}

						if( $fext == "swf" )
						{
							$ret_html .= '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="'.$banner['ban_w'].'" HEIGHT="'.$banner['ban_h'].'" id="BANNER'.$banner['id'].'" ALIGN="">
 <PARAM NAME=movie VALUE="'.$WWWHOST.$FILE_DIR.$banner['ban_file'].'"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="'.$WWWHOST.$FILE_DIR.$banner['ban_file'].'" quality=high bgcolor=#FFFFFF  WIDTH="'.$banner['ban_w'].'" HEIGHT="'.$banner['ban_h'].'" NAME="BANNER'.$banner['id'].'" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>';
						}
						else
						{
							if( $banner['ban_url'] != "" )
							{
								$lnk_blank = "";
								$agropos = strpos($banner['ban_url'], "agt.weehub.io");
								if( $agropos === FALSE )
								{
									$lnk_blank = ' target="_blank"';
								}
								$ret_html .= '<div><noindex><a href="'.$banner['ban_url'].'" rel="nofollow" '.$lnk_blank.'><img src="'.$WWWHOST.$FILE_DIR.$banner['ban_file'].'" width="'.$banner['ban_w'].'" height="'.$banner['ban_h'].'" alt="" /></a></noindex></div>';
							}
							else
							{
								$ret_html .= '<div><img src="'.$WWWHOST.$FILE_DIR.$banner['ban_file'].'" width="'.$banner['ban_w'].'" height="'.$banner['ban_h'].'" alt="" /></div>';
							}
						}
					}
				}
			}
		}
	}
//	echo $ret_html;
//echo count($bans[$pagetype]['places'][$placepos]);
	return $ret_html;
}

////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//
//                                 Page Utils
//
////////////////////////////////////////////////////////////////////////////////
function Page_BuildUrl_PHP($LangId, $pname="", $ipage="") { global $upd_link_db;
	// sample URLS
	//	somepage.php
	//	info.php?page=anotherpage
	$url = "";

	if( $ipage == "" )
	{
		$url = $pname.".php";
	}
	else
	{
		$url = ($pname == "" ? "info" : $pname).".php?page=".$ipage;
	}

	return $url;
}

function Page_BuildUrl_HTML($LangId, $pname="", $ipage="") { global $upd_link_db;
	// sample URLS
	//	somepage.html
	//	info/anotherpage.html
	$url = "";

	if( $ipage == "" )
	{
		$url = $pname;//.".html";
	}
	else
	{
		$url = ($pname == "" ? "info" : $pname)."/".$ipage;//.".html";
	}

	return $url;
}

function Page_BuildUrl($LangId, $pname="", $ipage="") { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return ( $WWW_LINK_MODE == "php" ?  $wwwlink.Page_BuildUrl_PHP($LangId, $pname, $ipage) : $WWWHOST.Page_BuildUrl_HTML($LangId, $pname, $ipage) );
}

function Page_GetResource($LangId, $pid, $disp) { global $upd_link_db;
	global $TABLE_RESOURCE, $TABLE_RESOURCE_LANGS, $TABLE_PAGE_RESOURCES;

	$pageres = Array();
	$query = "SELECT pr1.id as assid, pr1.display_type, pr1.sort_num, r1.*, r2.content
		FROM $TABLE_PAGE_RESOURCES pr1
		INNER JOIN $TABLE_RESOURCE r1 ON pr1.item_id=r1.id
		INNER JOIN $TABLE_RESOURCE_LANGS r2 ON r1.id=r2.item_id AND r2.lang_id='$LangId'
		WHERE pr1.page_id='$pid' AND pr1.display_type='$disp'
		ORDER BY pr1.sort_num";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ri = Array();
			$ri['id'] = $row->id;
			$ri['assignid'] = $row->assid;
			$ri['disp'] = $row->display_type;
			$ri['sort'] = $row->sort_num;
			$ri['name'] = stripslashes($row->name);
			$ri['title'] = stripslashes($row->title);
			$ri['text'] = stripslashes($row->content);
			$pageres[] = $ri;
		}
		mysqli_free_result( $res );
	}

	return $pageres;
}

function Page_GetIdByName($pname) { global $upd_link_db;
	global $TABLE_PAGES;

	$pid = 0;

	$query = "SELECT * FROM $TABLE_PAGES WHERE page_name='".addslashes($pname)."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$pid = $row->id;
		}
		mysqli_free_result( $res );
	}

	return $pid;
}

function Menu_GetLevel($parentid, $menutype, $curpname, $LangId) { global $upd_link_db;
	global $WWWHOST;
	global $TABLE_PAGES, $TABLE_PAGES_LANGS;
	global $page;

	$mitems = Array();

	$itemcond = "";
	if ( $menutype != null )
		$itemcond = " AND p1.show_in_menu=".$menutype." ";

	$query = "SELECT p1.*, p2.page_mean FROM $TABLE_PAGES p1
		INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.parent_id=".$parentid." $itemcond
		ORDER BY p1.sort_num,p1.id";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$link_file = "";
			$is_selected = false;
			switch( $row->page_record_type )
			{
				case 1:
					//$link_file = $WWWHOST.stripslashes($row->page_name).'.php';
					$link_file = Page_BuildUrl($LangId, stripslashes($row->page_name),"");
					if( stripslashes($row->page_name) == "index" )
						$link_file = $WWWHOST;
					if( stripslashes($row->page_name) == $curpname )
						$is_selected = true;
					break;
				case 2:
					$link_file = stripslashes($row->page_name).'/';
					break;
				case 3:
					//$link_file = $WWWHOST."info.php?page=".stripslashes($row->page_name);
					$link_file = Page_BuildUrl($LangId, "info", stripslashes($row->page_name));
					if( ($curpname == "info") && ($page == stripslashes($row->page_name)) )
					{
						$is_selected = true;
					}
					break;
				case 4:
					$link_file = stripslashes($row->page_name);
					//$link_file=split("[\.=]", stripslashes($row->page_name));
					//$link_file = BuildPageUrl($link_file[0],$link_file[2]);
					//$link_file = Page_BuildUrl($LangId, "info", stripslashes($row->page_name));
					break;
			}

			$mi = Array();

			$mi['id'] = $row->id;
			$mi['link'] = $link_file;
			$mi['name'] = stripslashes($row->page_mean);
			$mi['selected'] = $is_selected;
			$mi['pname'] = stripslashes($row->page_name);

			$mitems[] = $mi;
		}
		mysqli_free_result( $res );
	}

	return $mitems;
}

function Page_GetPath($LangId, $iid) { global $upd_link_db;
	global $WWWHOST;
	global $TABLE_PAGES, $TABLE_PAGES_LANGS;

	$pits = Array();

	$pageid = $iid;

	if( $pageid != 0 )
	{
		do
		{
			$found = false;
			$query1 = "SELECT c1.*, c2.page_mean as name
			  	FROM $TABLE_PAGES c1, $TABLE_PAGES_LANGS c2
			  	WHERE c1.id='$pageid' AND c1.id=c2.item_id AND c2.lang_id='$LangId'";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$si = Array();
					$si['id'] = $row1->id;
					$si['name'] = stripslashes($row1->name);

					$link_file = "";
					switch( $row1->page_record_type )
					{
						case 1:
							//$link_file = BuildPageUrl(stripslashes($row1->page_name),"");
							$link_file = Page_BuildUrl($LangId, stripslashes($row1->page_name),"");
							if( stripslashes($row1->page_name) == "index" )
								$link_file = $WWWHOST;
							break;
						case 2:
							$link_file = stripslashes($row1->page_name).'/';
							break;
						case 3:
							//$link_file = BuildPageUrl("info",stripslashes($row1->page_name));
							$link_file = Page_BuildUrl($LangId, "info", stripslashes($row1->page_name));
							break;
						case 4:
							//$link_file=split("[\.=]", stripslashes($row1->page_name));
							//$link_file = BuildPageUrl($link_file[0],$link_file[2]);
							$link_file = stripslashes($row1->page_name);
							break;
					}

					$si['url'] = $link_file;


					$pits[] = $si;

	      			$pageid = $row1->parent_id;
	      			$found = true;
				}
				mysqli_free_result( $res1 );
			}
			else
				echo mysqli_error($upd_link_db);

			if( !$found )
				break;
		}
		while( $pageid != 0 );
	}

	return $pits;
}

function Page_Video($LangId, $page_id) { global $upd_link_db;
	global $TABLE_PAGE_VIDEO, $TABLE_PAGE_VIDEO_LANGS;

	$videos = Array();
	$query1 = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
		FROM $TABLE_PAGE_VIDEO p1
		INNER JOIN $TABLE_PAGE_VIDEO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.item_id=".$page_id."
		ORDER BY p1.sort_num,p1.add_date";

	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$pi = Array();
			$pi['id'] = $row1->id;
			$pi['alt'] = stripslashes($row1->title);
			$pi['descr'] = stripslashes($row1->descr);
			$pi['snum'] = $row1->sort_num;
			$pi['clip'] = stripslashes($row1->filename);
			$pi['clip_w'] = $row1->src_w;
			$pi['clip_h'] = $row1->src_h;
			$pi['ico'] = stripslashes($row1->filename_ico);
			$pi['ico_w'] = $row1->ico_w;
			$pi['ico_h'] = $row1->ico_h;
			$pi['tubecode'] = stripslashes($row1->tube_code);
			$pi['date'] = sprintf("%02d.%02d.%04d", $row1->dd, $row1->dm, $row1->dy);

			$videos[] = $pi;
		}
		mysqli_free_result( $res1 );
	}

	return $videos;
}

function Page_Photo($LangId, $page_id) { global $upd_link_db;
	global $TABLE_PAGE_PHOTO, $TABLE_PAGE_PHOTO_LANGS;

	$photos = Array();
	$query1 = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
		FROM $TABLE_PAGE_PHOTO p1
		INNER JOIN $TABLE_PAGE_PHOTO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.item_id=".$page_id."
		ORDER BY p1.sort_num,p1.add_date";
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$pi = Array();
			$pi['id'] = $row1->id;
			$pi['alt'] = stripslashes($row1->title);
			$pi['snum'] = $row1->sort_num;
			$pi['pic'] = $WWWHOST.stripslashes($row1->filename);
			$pi['pic_w'] = $row1->src_w;
			$pi['pic_h'] = $row1->src_h;
			$pi['thumb'] = $WWWHOST.stripslashes($row1->filename_thumb);
			$pi['thumb_w'] = $row1->thumb_w;
			$pi['thumb_h'] = $row1->thumb_h;
			$pi['ico'] = $WWWHOST.stripslashes($row1->filename_ico);
			$pi['ico_w'] = $row1->ico_w;
			$pi['ico_h'] = $row1->ico_h;
			$pi['date'] = sprintf("%02d.%02d.%04d", $row1->dd, $row1->dm, $row1->dy);

			$photos[] = $pi;
		}
	    mysqli_free_result( $res1 );
	}

	return $photos;
}

function Page_GetInfo($LangId, $pagename) { global $upd_link_db;
	global $TABLE_PAGES, $TABLE_PAGES_LANGS;

	$page1 = Array();

	if( $result = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean, p2.page_title, p2.page_keywords, p2.page_descr,
			p2.title, p2.header, p2.content
			FROM $TABLE_PAGES p1
			INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.page_name='".$pagename."'") )
	{
		if( $row = mysqli_fetch_object($result) )
		{
			$page1['id'] = $row->id;
			$page1['pid'] = $row->parent_id;
			$page1['pfile'] = stripslashes($row->page_name);
			$page1['pmean'] = stripslashes($row->page_mean);
			$page1['seo_title'] = stripslashes($row->page_title);
			$page1['seo_keywords'] = stripslashes($row->page_keywords);
			$page1['seo_descr'] = stripslashes($row->page_descr);
			$page1['pcreated'] = $row->create_date;
			$page1['pmodified'] = $row->modify_date;
			$page1['pagename'] = stripslashes($row->page_name);
   			$page1['title'] = stripslashes($row->title);
			$page1['header'] = stripslashes($row->header);
			$page1['content'] = stripslashes($row->content);
			$page1['show'] = $row->show_in_menu;
			$page1['type'] = $row->page_record_type;
			$page1['sort'] = $row->sort_num;

			$page1['pics'] = Page_Video($LangId, $row->id);
			$page1['clips'] = Page_Video($LangId, $row->id);
		}
		mysqli_free_result( $result );
	}

	return $page1;
}

function Page_Subpages($LangId, $page_id) { global $upd_link_db;
	global $TABLE_PAGES, $TABLE_PAGES_LANGS;
	global $pname, $page;

	$subpages = Array();

	$query = "SELECT p1.*, p2.page_mean, p2.page_title, p2.page_keywords, p2.page_descr, p2.title, p2.header, p2.content
		FROM $TABLE_PAGES p1
		INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.parent_id=".$page_id."
		ORDER BY p1.sort_num";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$link_file = "";
			$is_selected = false;
			switch( $row->page_record_type )
			{
				case 1:
					$link_file = Page_BuildUrl($LangId, stripslashes($row->page_name),"");
					if( stripslashes($row->page_name) == $pname )
						$is_selected = true;
					if( $link_file == "index.php" )
						$link_file = $WWWHOST;
					break;
				case 2:
					$link_file = stripslashes($row->page_name).'/';
					break;
				case 3:
					$link_file = Page_BuildUrl($LangId, "info",stripslashes($row->page_name));
					if( ($pname == "info") && ($page == stripslashes($row->page_name)) )
					{
						$is_selected = true;
					}
					break;
				case 4:
					//$link_file = stripslashes($row->page_name);
					$link_file=split("[\.=]", stripslashes($row->page_name));
					$link_file = Page_BuildUrl($LangId, $link_file[0],$link_file[2]);
					break;
			}

			if( $link_file != "")
			{
				$subpi = Array();
				$subpi['link'] = $link_file;
				$subpi['name'] = stripslashes($row->title);
				$subpages[] = $subpi;
			}
		}
		mysqli_free_result( $res );
	}

	return $subpages;
}

////////////////////////////////////////////////////////////////////////////////
//
//							Partner/links utils
//
////////////////////////////////////////////////////////////////////////////////

function Partners_List($LangId) { global $upd_link_db;
	global $TABLE_LINKS, $TABLE_LINKS_LANGS, $WWWHOST, $FILE_DIR;

	$its = Array();
	$query = "SELECT i1.*, i2.orgname, i2.descr
		FROM $TABLE_LINKS i1
		INNER JOIN $TABLE_LINKS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		ORDER BY i1.sort_num, i2.orgname";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['url'] = stripslashes($row->weburl);
			$it['email'] = stripslashes($row->email);
			$it['phone'] = stripslashes($row->phone);
			$it['name'] = stripslashes($row->orgname);
			$it['descr'] = stripslashes($row->descr);

			$it['pic'] = ( $row->logo_filename != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->logo_filename) : '' );

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}

	return $its;
}

function Partners_Info($LangId, $id) { global $upd_link_db;
	global $TABLE_LINKS, $TABLE_LINKS_LANGS, $WWWHOST, $FILE_DIR;

	$it = Array();
	$query = "SELECT i1.*, i2.orgname, i2.descr
		FROM $TABLE_LINKS i1
		INNER JOIN $TABLE_LINKS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		WHERE i1.id='".$id."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it['id'] = $row->id;
			$it['url'] = stripslashes($row->weburl);
			$it['email'] = stripslashes($row->email);
			$it['phone'] = stripslashes($row->phone);
			$it['name'] = stripslashes($row->orgname);
			$it['descr'] = stripslashes($row->descr);

			$it['pic'] = ( $row->logo_filename != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->logo_filename) : '' );
		}
		mysqli_free_result( $res );
	}

	return $it;
}

////////////////////////////////////////////////////////////////////////////////
//
//							FAQ Utils
//
////////////////////////////////////////////////////////////////////////////////

function Faq_BuildUrl_PHP($LangId, $id=0, $pi=0, $pn=20, $gid=0) { global $upd_link_db;
	global $PHP_SELF;
	// sample link styles
	//   faq.php
	//   faq.php?pi=2&pn=20
	//   faq.php?id=10
	$url = "faq.php";

	if( $gid != 0 )
	{
  		$url .= "?gid=".$gid.($pi == 0 ? "" : "&pi=".$pi);
	}
	else if( $id == 0 )
	{
		// The faq item not specified
		$url .= ($pi == 0 ? "" : "?pi=".$pi."&pn=".$pn);
	}
	else
	{
		// Faq item is specified
		$url .= "?id=".$id;
	}

	return $url;
}

function Faq_BuildUrl_HTML($LangId, $id=0, $pi=0, $pn=20, $gid=0) { global $upd_link_db;
	// sample link styles
	//   faq/index.html
	//   faq/page_2_20.html
	//   faq/10.html

	$url = "faq/";

	if( ($gid == 0) && ($id == 0) && ($pi == 0) )
	{
		$url = "faq";//.html";
	}
	else if( $gid != 0 )
	{
//		$url .= $gid."/".( $pi > 0 ? "p_".$pi.".html" : "index.html" );
		$url .= $gid."/".( $pi > 0 ? "p_".$pi : "" );
	}
	else if( ($id == 0) || ($id == "") )
	{
		// The faq item not specified
//		$url .= ( $pi > 0 ? "p_".$pi.".html" : "index.html" );
		$url .= ( $pi > 0 ? "p_".$pi : "" );
	}
	else
	{
		// Faqs item is specified
		$url .= $id;//.".html";
	}

	return $url;
}

function Faq_BuildUrl($LangId, $id=0, $pi=0, $pn=20, $gid=0) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return (
		$WWW_LINK_MODE == "php" ?
			$wwwlink.Faq_BuildUrl_PHP($LangId, $id, $pi, $pn, $gid) :
			$WWWHOST.Faq_BuildUrl_HTML($LangId, $id, $pi, $pn, $gid)
		);
}


function Faq_GroupInfo($LangId, $gid) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_FAQ_GROUP, $TABLE_FAQ_GROUP_LANGS;

	$fgi = Array();
	$query = "SELECT g1.*, g2.type_name
		FROM $TABLE_FAQ_GROUP g1
		INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		WHERE g1.id=".$gid;
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$fgi = Array();
			$fgi['id'] = $row->id;
			$fgi['name'] = stripslashes($row->type_name);
			$fgi['url'] = stripslashes($row->url);
			$fgi['ico'] = ( trim(stripslashes($row->icon_filename)) != "" ? $WWWHOST.$FILE_DIR.trim(stripslashes($row->icon_filename)) : "" );
			$fgi['sort'] = $row->sort_num;
		}
		mysqli_free_result( $res );
	}

	return $fgi;
}

function Faq_GroupList($LangId, $withfaqnum = false) { global $upd_link_db;
	global $WWWHOST, $FILE_DIR, $TABLE_FAQ_GROUP, $TABLE_FAQ_GROUP_LANGS, $TABLE_FAQ;

	$fgroups = Array();

	if( $withfaqnum )
	{
		$query = "SELECT g1.*, g2.type_name, count(f1.id) as totfaq
		FROM $TABLE_FAQ_GROUP g1
		INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		LEFT JOIN $TABLE_FAQ f1 ON g1.id=f1.group_id
		GROUP BY g1.id
		ORDER BY g1.sort_num";
	}
	else
	{
		$query = "SELECT g1.*, g2.type_name
		FROM $TABLE_FAQ_GROUP g1
		INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		ORDER BY g1.sort_num";
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$fgi = Array();
			$fgi['id'] = $row->id;
			$fgi['name'] = stripslashes($row->type_name);
			$fgi['url'] = stripslashes($row->url);
			$fgi['ico'] = ( trim(stripslashes($row->icon_filename)) != "" ? $WWWHOST.$FILE_DIR.trim(stripslashes($row->icon_filename)) : "" );
			$fgi['sort'] = $row->sort_num;
			$fgi['faqnum'] = ( $row->totfaq != null ? $row->totfaq : 0 );

			$fgroups[] = $fgi;
		}
		mysqli_free_result( $res );
	}

	return $fgroups;
}

function Faq_ItemsNum($group_id=0) { global $upd_link_db;
	global $TABLE_FAQ;

	$sel_cond = "";
	if( $group_id != 0 )
	{
		$sel_cond = " WHERE group_id='".$group_id."' ";
	}

	$totitems = 0;

	$query = "SELECT count(*) as totitems FROM $TABLE_FAQ $sel_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$totitems = $row->totitems;
		}
		mysqli_free_result( $res );
	}

	return $totitems;
}

function Faq_Items($LangId, $group_id=0, $pi=-1, $pn=100, $sort="") { global $upd_link_db;
	global $TABLE_FAQ, $TABLE_FAQ_LANGS, $TABLE_FAQ_GROUP, $TABLE_FAQ_GROUP_LANGS;

	$sel_cond = "";
	if( $group_id != 0 )
	{
		$sel_cond = " WHERE f1.group_id='".$group_id."' ";
	}

	$sort_cond = "g1.sort_num, g2.type_name, f1.sort_num, f2.title";
	if( $sort == "rand" )
	{
		$sort_cond = " RAND() ";
	}
	else if( $sort == "date" )
	{
		$sort_cond = " f1.add_date DESC ";
	}

	$limit_cond = "";
	if( ($pi >=0) && ($pn > 0) )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",$pn ";
	}

	$items = Array();

	$query = "SELECT f1.*, f2.title, f2.content, g2.type_name as groupname
		FROM $TABLE_FAQ f1
		INNER JOIN $TABLE_FAQ_LANGS f2 ON f1.id=f2.item_id AND f2.lang_id='$LangId'
		INNER JOIN $TABLE_FAQ_GROUP g1 ON f1.group_id=g1.id
		INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		$sel_cond
		ORDER BY $sort_cond $limit_cond";
	//echo $query."<br />";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$fi = Array();
			$fi['id'] = $row->id;
			$fi['title'] = stripslashes($row->title);
			$fi['url'] = stripslashes($row->url);
			$fi['text'] = stripslashes($row->content);
			$fi['file'] = stripslashes($row->filename);
			$fi['sort'] = $row->sort_num;
			$fi['view_num'] = $row->view_num;
			$fi['gid'] = $row->group_id;
			$fi['group'] = stripslashes($row->groupname);

			$items[] = $fi;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $items;
}

function Faq_ItemInfo($LangId, $faq_id) { global $upd_link_db;
	global $TABLE_FAQ, $TABLE_FAQ_LANGS, $TABLE_FAQ_GROUP, $TABLE_FAQ_GROUP_LANGS;

	$fi = Array();

	$query = "SELECT f1.*, f2.title, f2.content, g2.type_name as groupname
		FROM $TABLE_FAQ f1
		INNER JOIN $TABLE_FAQ_LANGS f2 ON f1.id=f2.item_id AND f2.lang_id='$LangId'
		INNER JOIN $TABLE_FAQ_GROUP g1 ON f1.group_id=g1.id
		INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		WHERE f1.id='$faq_id'
		ORDER BY g1.sort_num, g2.type_name, f1.sort_num, f2.title";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$fi['id'] = $row->id;
			$fi['title'] = stripslashes($row->title);
			$fi['url'] = stripslashes($row->url);
			$fi['text'] = stripslashes($row->content);
			$fi['file'] = stripslashes($row->filename);
			$fi['sort'] = $row->sort_num;
			$fi['view_num'] = $row->view_num;
			$fi['gid'] = $row->group_id;
			$fi['group'] = stripslashes($row->groupname);
		}
		mysqli_free_result( $res );
	}

	return $fi;
}

////////////////////////////////////////////////////////////////////////////////
//
//                                  Popup info dialogs
//
////////////////////////////////////////////////////////////////////////////////
function PopupDialog_GetList($LangId, $userid, $seenids=null) { global $upd_link_db;
	global $TABLE_POPUP, $TABLE_POPUP_LANGS, $TABLE_POPUP_VIEWS;
	
	$seenarr = Array();
	for( $i=0; $i<count($seenids); $i++ )
	{
		$sid = sprintf("%d", $seenids[$i]);
		if( (trim($sid) != "") && ($sid != 0) )
		{
			$seenarr[] = $sid;
		}
	}
	
	$its = Array();
	
	if( $userid != 0 )
	{
		$query = "SELECT p1.*, p2.title, p2.content, p2.btntext, 
				case when v1.id IS NULL then 0 else 1 end as viewed 
			FROM $TABLE_POPUP p1 
			INNER JOIN $TABLE_POPUP_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId' 
			LEFT JOIN $TABLE_POPUP_VIEWS v1 ON p1.id=v1.item_id AND v1.user_id='".$userid."' 
			WHERE p1.first_page=1 AND p1.end_date>NOW() 
			ORDER BY viewed, p1.dtime DESC
			LIMIT 0,1";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while($row = mysqli_fetch_object($res))
			{
				if( $row->viewed > 0 )
				{
					continue;
				}
				
				$it = Array();
				$it['id'] = $row->id;
				$it['title'] = stripslashes($row->title);
				$it['content'] = stripslashes($row->content);
				$it['url'] = trim(stripslashes($row->urlgo));
				$it['btntxt'] = trim(stripslashes($row->btntext));
				
				$its[] = $it;
			}
			mysqli_free_result($res);
		}
	}
	else
	{
		$query = "SELECT p1.*, p2.title, p2.content, p2.btntext	 				
			FROM $TABLE_POPUP p1 
			INNER JOIN $TABLE_POPUP_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId' 
			WHERE p1.first_page=1 AND p1.end_date>NOW() ".( count($seenarr)>0 ? " AND p1.id NOT IN (".implode(",",$seenarr).") " : "" )."
			ORDER BY p1.dtime DESC
			LIMIT 0,1";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while($row = mysqli_fetch_object($res))
			{
				$it = Array();
				$it['id'] = $row->id;
				$it['title'] = stripslashes($row->title);
				$it['content'] = stripslashes($row->content);
				$it['url'] = trim(stripslashes($row->urlgo));
				$it['btntxt'] = trim(stripslashes($row->btntext));
				
				$its[] = $it;
			}
			mysqli_free_result($res);
		}
	}
	
	return $its;
}

function PopupDialog_Get($LangId, $dlgid) { global $upd_link_db;
	global $TABLE_POPUP, $TABLE_POPUP_LANGS, $TABLE_POPUP_VIEWS;
	
	$it = Array("id" => 0);	
	
	$itid = sprintf("%d", $dlgid);
	
	$query = "SELECT p1.*, p2.title, p2.content, p2.btntext	
		FROM $TABLE_POPUP p1 
		INNER JOIN $TABLE_POPUP_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId' 
		WHERE p1.id='".$itid."'";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row = mysqli_fetch_object($res))
		{
			//$it = Array();
			$it['id'] = $row->id;
			$it['title'] = stripslashes($row->title);
			$it['content'] = stripslashes($row->content);			
			$it['url'] = trim(stripslashes($row->urlgo));
			$it['btntxt'] = trim(stripslashes($row->btntext));
		}
		mysqli_free_result($res);
	}
	
	return $it;
}

////////////////////////////////////////////////////////////////////////////////
//
//                                  Image utils
//
////////////////////////////////////////////////////////////////////////////////
function MakeLocalImage($itemid, $producer, $model) { global $upd_link_db;
	global $PIC_DIR, $PIC_TMB_DIR;

	$quote_model = TranslitEncode( $model );
	$quote_prod = TranslitEncode( $producer );

    $localfilename = $quote_prod."_".$quote_model."_".$itemid;

    return $localfilename;
}

function GetImageSizeAll( $srcimg, $srcext ) { global $upd_link_db;
	$ret = null;

	$img_ext = strtolower( $srcext );

	switch($img_ext)
    {
        case ".jpg":
        case ".jpeg":
             $im = @imagecreatefromjpeg( $srcimg );
             break;
        case ".png":
             $im = @imagecreatefrompng( $srcimg );
             break;
        case ".gif":
             $im = @imagecreatefromgif( $srcimg );
             break;
    }

    if( empty($im) || ($im == null) )
    	return $ret;

    $img_w = @imagesx( $im );
    $img_h = @imagesy( $im );

	if( ($img_w > 0) && ($img_w < 3000) && ($img_h > 0) && ($img_h < 3000) )
	{
		$ret = Array('w' => $img_w, 'h' => $img_h);
	}

	return $ret;
}

function ResizeImage( $srcimg, $dstimg, $srcext, $outformat, $max_w, $max_h, $truesize = false, $jpg_quality = 90, $truecolor = true, $with_copyright = false, $copyright_pic = "", $copyright_str = "Авторадости" ) { global $upd_link_db;
    $img_ext = $srcext;
    $extform = strtolower($outformat); 	// Could be '.jpg', '.png', '.gif'
    $THUMB_W = $max_w;								// Destination image width
    $THUMB_H = $max_h;								// Destination image hight

    //$namefiles = $FILE_DIR.$namefiles;
	//$img_ext = strtolower(substr( $srcimg, strrpos($srcimg, ".") ));

    switch($img_ext)
    {
        case ".jpg":
        case ".jpeg":
             $im = imagecreatefromjpeg( $srcimg );
             break;
        case ".png":
             $im = imagecreatefrompng( $srcimg );
             break;
        case ".gif":
             $im = imagecreatefromgif( $srcimg );
             break;
        default:
            $im = NULL;
    }


    // If error occure while opening file then return ERROR
    if( $im == NULL )
    	return false;

    // Get the source image size
    $src_w = imagesx( $im );
    $src_h = imagesy( $im );

    // Calculate destination image size
    if( $truesize )
    {
    	$dst_w = $THUMB_W;
        $dst_h = $THUMB_H;

    	if( ($src_w/$src_h) > ($dst_w/$dst_h) )
    	{
    		$src_ch = $src_h;
    		$src_cw = ceil( $src_h * ($dst_w/$dst_h) );
    	}
    	else
    	{
    		$src_cw = $src_w;
    		$src_ch = ceil( $src_w * ($dst_h/$dst_w) );
    	}
        //$src_ch = $src_cw = ($src_w > $src_h ? $src_h : $src_w);
    }
    else
    {
    	if( ($src_w > $THUMB_W) || ($src_h > $THUMB_H) )
    	{
	        $dst_w = $THUMB_W;
	        $dst_h = ceil($dst_w * ($src_h / $src_w));

	        if( $dst_h > $THUMB_H )
	        {
	            $dst_h = $THUMB_H;
	            $dst_w = ceil($dst_h * ($src_w / $src_h));
	        }
	    }
	    else
	    {
	    	$dst_w = $src_w;
	    	$dst_h = $src_h;
	    }
    }

    // Create new image and put resized picture to it
    if( $truecolor )
        $dst_im = imagecreatetruecolor($dst_w, $dst_h);
    else
        $dst_im = imagecreate($dst_w, $dst_h);

    imagealphablending( $dst_im, true );

    //if( $img_ext == ".png" )
    //{
    	// Fill white rectangle to avoid the transparent pixels to be black
    	imagefilledrectangle($dst_im, 0, 0, $dst_w, $dst_h, imagecolorallocate($dst_im, 255, 255, 255));
    //}

    if( $truesize )
        //imagecopyresized( $dst_im, $im, 0, 0, floor( ($src_w - $src_cw) / 2 ), floor( ($src_h - $src_ch) / 2 ), $dst_w, $dst_h, $src_cw, $src_ch );
        imagecopyresampled( $dst_im, $im, 0, 0, floor( ($src_w - $src_cw) / 2 ), floor( ($src_h - $src_ch) / 2 ), $dst_w, $dst_h, $src_cw, $src_ch );
    else
        //imagecopyresized( $dst_im, $im, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h );
        imagecopyresampled( $dst_im, $im, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h );


	if( $with_copyright )
	{
		if( $copyright_pic != "" )
		{
			// make copyright watermark logo from picture
			$im_logo = imagecreatefrompng( $copyright_pic );
			if( $im_logo )
			{
				$logo_w = imagesx( $im_logo );
    			$logo_h = imagesy( $im_logo );

    			imagecopy( $dst_im, $im_logo, 5, $dst_h-$logo_h-5, 0, 0, $logo_w, $logo_h ) ;
			}
		}
		else
		{
			// make copyright watermark text
			$conv_from = "CP1251";
			$conv_to = "UTF-8";
			//$font_file_name = "font/verdana.ttf";
			//$font_file_logo = "font/futura.ttf";
			$font_file_name = "font/verdana.ttf";
			$font_size = "12";
			$txt_x = $dst_w - 110;
			$txt_y = $dst_h - 12;
		    // No parameters given for drawing so display error message for end user
		    $txt_color = imagecolorallocate($im, 0xFF,0xFF, 0xFF);
		    $txt_color_black = imagecolorallocate($im, 0x33,0x33, 0x33);
		    imagettftext($dst_im, $font_size, 0, $txt_x, $txt_y, $txt_color_black, $font_file_name, iconv($conv_from, $conv_to, $copyright_str));
		    imagettftext($dst_im, $font_size, 0, $txt_x+1, $txt_y+1, $txt_color, $font_file_name, iconv($conv_from, $conv_to, $copyright_str));
		    //imagettftext($dst_im, $font_size, 0, $txt_x, $txt_y, $txt_color_black, $font_file_name, $copiright_str);
		    //imagettftext($dst_im, $font_size, 0, $txt_x+1, $txt_y+1, $txt_color, $font_file_name, $copiright_str);
		}
	}

    // Check if output file already exists then delete it.
    if( file_exists( $dstimg ) )
    {
        unlink( $dstimg );
    }

    // Write destination image to disk
    switch( $extform )
    {
        case ".jpg":
            imagejpeg( $dst_im, $dstimg, $jpg_quality );
            break;
        case ".png":
            imagepng( $dst_im, $dstimg );
            break;
        case ".gif":
            imagegif( $dst_im, $dstimg );
            break;
    }

	return true;
}


////////////////////////////////////////////////////////////////////////////////
//
//
//
////////////////////////////////////////////////////////////////////////////////


function toJson($mValue) { global $upd_link_db;
	if (is_array($mValue))
	{
		//$mValue = array_map("winToUtf", $mValue);
		array_walk_recursive($mValue, "winToUtf");
	}
	return json_encode($mValue);
}

function mb_ucfirst($string) { global $upd_link_db;
	$string = mb_ereg_replace("^[\ ]+","", $string);
	$string = mb_strtoupper(mb_substr($string, 0, 1, "UTF-8"), "UTF-8").mb_substr($string, 1, mb_strlen($string), "UTF-8" );
	return $string;
}

//Function recursive delete section or page
function DeletAllSub($p_id,$level,$mode) { global $upd_link_db;
	if($mode=='section')
	{
		global $THIS_TABLE, $THIS_TABLE_LANG;

		if($level==0)
		{
			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id='".$p_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			else
			{
				if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE sect_id='".$p_id."'") )
				{
					echo mysqli_error($upd_link_db);
				}
			}
		}

		$query = "SELECT id FROM $THIS_TABLE WHERE parent_id='$p_id'";
		if( $res=mysqli_query($upd_link_db,$query) )
		{
			if(mysqli_num_rows($res)>0)
			{
				while($row=mysqli_fetch_object($res))
				{
					if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$row->id." "))
					{
						echo "<b>".mysqli_error($upd_link_db)."</b>";
					}
					if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE sect_id='".$row->id."'" ) )
					{
						echo mysqli_error($upd_link_db);
					}
					$level++;
					DeletAllSub($row->id,$level,'section');
				}
			}
		}
		else
		{
			echo mysqli_error($upd_link_db);
		}
	}
	else if($mode=="page")
	{
		global $TABLE_PAGES, $TABLE_PAGES_LANGS;

		if($level==0)
		{
			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_PAGES WHERE id='".$p_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			else
			{
				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_PAGES_LANGS WHERE item_id='".$p_id."'") )
				{
					echo mysqli_error($upd_link_db);
				}
			}
		}

		$query = "SELECT id FROM $TABLE_PAGES WHERE parent_id='$p_id'";
		if($res=mysqli_query($upd_link_db,$query))
		{
			if(mysqli_num_rows($res)>0)
			{
				while($row=mysqli_fetch_object($res))
				{

					if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_PAGES WHERE id=".$row->id." "))
					{
						echo "<b>".mysqli_error($upd_link_db)."</b>";
					}
					if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_PAGES_LANGS WHERE item_id='".$row->id."'" ) )
					{
						echo mysqli_error($upd_link_db);
					}
					$level++;
					DeletAllSub($row->id,$level,'page');
				}
			}
		}
		else
		{
			echo mysqli_error($upd_link_db);
		}
	}
}

////////////////////////////////////////////////////////////////////////////////
// All
function User_Info($buyer_id) { global $upd_link_db;
	global $TABLE_TORG_BUYERS;

	$bi = Array();

	$query = "SELECT * FROM $TABLE_TORG_BUYERS WHERE id='$buyer_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
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


////////////////////////////////////////////////////////////////////////////////
// Board
function Board_BuildUrl_PHP($LangId, $mode = "list", $oblid="", $typeid=0, $topicid=0, $pi=0, $pn=20) { global $upd_link_db;
	// sample URLS
	//	board.php
	//	board.php?action=add
	$url = "board.php";

	if( $mode == "add" )
	{
		$url .= "?action=add";
	}
	else if( $mode == "item" )
	{
		$url .= "?action=viewitem&postid=".$pi;
	}
	else if( $mode == "addphoto" )
	{
		$url .= "?action=addphoto&postid=".$pi;
	}
	else if( $mode == "delphoto" )
	{
		$url .= "?action=delphoto&postid=".$pi."&photoid=".$pn;
	}
	else
	{
		//$url = "";
		$urlpar = "oblurl=".$oblid;
		$urlpar .= "&adtype=".$typeid;
		$urlpar .= "&adtopic=".$topicid;

		if( $pi > 0 )
		{
			$urlpar .= "&pi=".$pi;
		}

		$url = $url."?".$urlpar;
	}

	return $url;
}

// topicid contains board topic id, or author id in author mode

function Board_BuildUrl_HTML($LangId, $mode = "list", $oblid="", $typeid=0, $topicid=0, $pi=0, $pn=20) { global $upd_link_db;
	// sample URLS
	//	somepage.html
	//	info/anotherpage.html
	$url = "";

	if( ($mode == "add") || ($mode == "addc") )
	{
		//$url = "addpost.html";
		$url = ( $mode == "add" ? "addpost" : "addcpost" );//.".html";
		if( $typeid != 0 )
		{
			$url .= "?advtype=".$typeid;
		}
	}
	else if( $mode == "addphoto" )
	{
		$url = "edit".$pi."addpic";//.html";
	}
	else if( $mode == "delphoto" )
	{
		$url = "edit".$pi."delpic".$pn;//.".html";
	}
	else if( ($mode == "item") || ($mode == "itemcomp") )
	{
		$url = "post-".$pi;//.".html";
	}
	else if( $mode == "author" )
	{
		$url = "author/".$topicid;
		if( $pi > 1 )
  		{
  			$url .= "_p".$pi;
  		}
		//$url .= ".html";
	}
	else
	{
  		if( $oblid != "" )
  		{
  			$url .= "region_".$oblid."/";
  		}

  		$typeurlarr = Array("all", "buy", "sell", "serv");
  		$url .= $typeurlarr[$typeid];

  		if( $topicid != 0 )
  		{
  			$url .= "_t".$topicid;
  		}

  		if( $pi > 1 )
  		{
  			$url .= "_p".$pi;
  		}

  		//$url .= ".html";

//  		if( $url == "all.html" )
  		if( $url == "all" )
  			$url = "";
	}

	if( $url == "" )
	{
		return "board";//.html";
	}

	return ( $mode == "itemcomp" ? "kompanii/" : "board/" ).$url;
}

function Board_BuildUrl($LangId, $mode = "list", $oblid="", $typeid=0, $topicid=0, $pi=0, $pn=20) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return ( $WWW_LINK_MODE == "php" ?  $wwwlink.Board_BuildUrl_PHP($LangId, $mode, $oblid, $typeid, $topicid, $pi, $pn) : $WWWHOST.Board_BuildUrl_HTML($LangId, $mode, $oblid, $typeid, $topicid, $pi, $pn) );
}

function Board_TopicGroups($LangId, $tid=0, $mode = "") { global $upd_link_db;
	global $TABLE_ADV_TOPIC, $TABLE_ADV_POST, $TABLE_ADV_TGROUPS;

	$topics = Array();
	$query = "SELECT DISTINCT g1.id as grid, g1.title as grname, g1.sort_num
		FROM $TABLE_ADV_TOPIC t1
		LEFT JOIN $TABLE_ADV_TGROUPS g1 ON t1.menu_group_id=g1.id
		WHERE t1.parent_id='$tid'
		ORDER BY g1.sort_num, g1.title";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$tit = Array();
			$tit['id'] = $row->grid;
			$tit['name'] = stripslashes($row->grname);
			$tit['sort'] = $row->sort_num;

			$topics[] = $tit;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $topics;
}

function Board_TopicLevel($LangId, $tid=0, $mode = "", $grid = 0, $oblid = 0, $advtypeid=0, $invisible=true) { global $upd_link_db;
	global $TABLE_ADV_TOPIC, $TABLE_ADV_POST, $TABLE_ADV_TGROUPS, $TABLE_ADV_TOPIC_POSTNUM;

	$topics = Array();

	$grcond = "";
	if( $grid != 0 )
	{
		$grcond .= " AND t1.menu_group_id='$grid' ";
	}
	
	if( !$invisible )
	{
		$grcond .= " AND t1.visible=1 ";
	}
	

	$oblcond = "";
	if( $oblid != 0 )
	{
		$oblcond = " AND p1.obl_id='$oblid' ";
	}

	if( $mode == "withpostnum" )
	{
		/*
		$query = "SELECT t1.*, count(p1.id) as pnum FROM $TABLE_ADV_TOPIC t1
			LEFT JOIN $TABLE_ADV_POST p1 ON t1.id=p1.topic_id $oblcond and p1.archive = 0 and p1.active = 1
			WHERE t1.parent_id='$tid' $grcond
			GROUP BY t1.id
			ORDER BY t1.sort_num, t1.title";
		*/
		/*
		$query = "SELECT t1.* FROM $TABLE_ADV_TOPIC t1
			WHERE t1.parent_id='$tid' $grcond
			GROUP BY t1.id
			ORDER BY t1.sort_num, t1.title";
		*/
		$query = "SELECT t1.*, tpn.all_num as pnum FROM $TABLE_ADV_TOPIC t1 
			LEFT JOIN $TABLE_ADV_TOPIC_POSTNUM tpn ON t1.id=tpn.topic_id AND tpn.obl_id='$oblid' AND tpn.type_id=0 
			WHERE t1.parent_id='$tid' $grcond
			GROUP BY t1.id
			ORDER BY t1.sort_num, t1.title";		
	}
	else if( $mode == "cronpostnum" )
	{
		$query = "SELECT t1.*, count(p1.id) as pnum FROM $TABLE_ADV_TOPIC t1
			LEFT JOIN $TABLE_ADV_POST p1 ON t1.id=p1.topic_id $oblcond and p1.archive=0 and p1.active=1
			WHERE t1.parent_id='$tid' $grcond
			GROUP BY t1.id
			ORDER BY t1.sort_num, t1.title";		
	}
	else if( $mode == "bygroups" )
	{
		$query = "SELECT t1.*, g1.id as grid, g1.title as grname FROM $TABLE_ADV_TOPIC t1
			LEFT JOIN $TABLE_ADV_TGROUPS g1 ON t1.menu_group_id=g1.id
			WHERE t1.parent_id='$tid' $grcond
			ORDER BY g1.sort_num, t1.sort_num, t1.title";
	}
	else if( $mode == "sortbycols" )
	{
		$query = "SELECT * FROM $TABLE_ADV_TOPIC t1 WHERE t1.parent_id='$tid' $grcond ORDER BY sort_num, sort_incol, title";
	}
	else
	{
		$query = "SELECT * FROM $TABLE_ADV_TOPIC t1 WHERE t1.parent_id='$tid' $grcond ORDER BY sort_num, title";
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$tit = Array();
			$tit['id'] = $row->id;
			$tit['name'] = stripslashes($row->title);
			$tit['sort'] = $row->sort_num;
			$tit['sort_incol'] = $row->sort_incol;
			$tit['vis'] = $row->visible;

			if( $mode == "cronpostnum" )
			{
				$tit['pnum'] = $row->pnum;
			}
			else if( $mode == "withpostnum" )
			{
				$tit['pnum'] = $row->pnum;	//30;	//$row->pnum;
			}
			else if( $mode == "bygroups" )
			{
				$tit['group'] = ($row->grname != null ? stripslashes($row->grname) : "");
			}

			$topics[] = $tit;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $topics;
}

function Board_TopicInfo($LangId, $tid) { global $upd_link_db;
	global $TABLE_ADV_TOPIC, $TABLE_ADV_POST;

	$topic = Array();
	$query = "SELECT t1.*, count(p1.id) as pnum FROM $TABLE_ADV_TOPIC t1
		LEFT JOIN $TABLE_ADV_POST p1 ON t1.id=p1.topic_id
		WHERE t1.id='$tid'
		GROUP BY t1.id
		ORDER BY t1.sort_num, t1.title";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$tit = Array();
			$tit['id'] = $row->id;
			$tit['pid'] = $row->parent_id;
			$tit['name'] = stripslashes($row->title);
			$tit['sort'] = $row->sort_num;

			$tit['descr'] = stripslashes($row->descr);

			$tit['seo_h1'] = stripslashes($row->page_h1);
			$tit['seo_title'] = stripslashes($row->page_title);
			$tit['seo_keyw'] = stripslashes($row->page_keywords);
			$tit['seo_descr'] = stripslashes($row->page_descr);

			$tit['seo_h1_buy'] = stripslashes($row->seo_h1_buy);
			$tit['seo_title_buy'] = stripslashes($row->seo_title_buy);
			$tit['seo_keyw_buy'] = stripslashes($row->seo_keyw_buy);
			$tit['seo_descr_buy'] = stripslashes($row->seo_descr_buy);
			$tit['seo_text_buy'] = stripslashes($row->seo_text_buy);

			$tit['seo_h1_sell'] = stripslashes($row->seo_h1_sell);
			$tit['seo_title_sell'] = stripslashes($row->seo_title_sell);
			$tit['seo_keyw_sell'] = stripslashes($row->seo_keyw_sell);
			$tit['seo_descr_sell'] = stripslashes($row->seo_descr_sell);
			$tit['seo_text_sell'] = stripslashes($row->seo_text_sell);

			$tit['pnum'] = $row->pnum;

			$topic = $tit;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $topic;
}

function Board_PostsNumByAuthor($uid, $uemail="", $onlycomp=0, $viewall=0, $type_id=0, $targeting=-1, $comptopicid=0, $comptopicparent=false) { global $upd_link_db;
	global $TABLE_ADV_POST, $TABLE_COMPANY_POST2ADVTOPICS, $TABLE_COMPANY_ADVTOPICS;

	$totpost = 0;

	if( $viewall == -10 )
	{
		$sel_cond = " WHERE p1.active>=0 ";
	}
	else
	{
		$sel_cond = " WHERE p1.active=1 ";
	}
	
	if( $uid > 0 )
	{
		$sel_cond .= " AND p1.author_id='$uid' ";
	}
	else
	{
		$sel_cond .= ($uid == 0 ? " AND p1.author_id=0 " : "")." AND p1.email LIKE '".addslashes($uemail)."' ";
	}

	if( $onlycomp == 1 )
	{
		$sel_cond .= " AND p1.company_id<>0 ";
	}
	else if( $onlycomp == 0 )
	{
		$sel_cond .= " AND p1.company_id=0 ";
	}

	if( $viewall == -10 )
	{
		$sel_cond .= " AND p1.archive>=0 ";
	}
	else if( $viewall == 1 )
	{
		$sel_cond .= " AND p1.archive=0 ";
	}
	else if( $viewall == 2 )
	{
		$sel_cond .= " AND p1.archive=1 ";
	}

	if( $type_id > 0 )
	{
		$sel_cond .= " AND p1.type_id='".$type_id."' ";
	}
	
	if( $targeting != -1 )
	{
		$sel_cond .= " AND p1.targeting='".$targeting."' ";
	}
	
	$inner_cond = "";
	if( $comptopicid != 0 )
	{
		if( $comptopicparent )
			$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id
				INNER JOIN $TABLE_COMPANY_ADVTOPICS cpa1 ON cp1.topic_id=cpa1.id AND ((cpa1.parent_id='$comptopicid') OR (cpa1.id='$comptopicid'))
			";
			//$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id
			//	INNER JOIN $TABLE_COMPANY_ADVTOPICS cpa1 ON cp1.topic_id=cpa1.id AND cpa1.id='$comptopicid'
			//";
		else
			$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id AND cp1.topic_id='$comptopicid' ";
	}

	$query = "SELECT count(p1.id) as totpost 
		FROM $TABLE_ADV_POST p1 
		$inner_cond 
		$sel_cond";
	//echo $query."<br />";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totpost = $row->totpost;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $totpost;
}

function Board_PostsNum($LangId, $typeid=0, $topicid=0, $parenttopic=false, $oblid=0, $compid=0, $fltmail="", $flttel="", $fltname="", $flttip="", $fltip="", $archive=false, $comptopicid=0, $comptopicparent=false, $period=0, $fltses="", $modertype=1, $moderwordstype=1) { global $upd_link_db;
	global $TABLE_TORG_BUYERS, $TABLE_ADV_POST, $TABLE_ADV_TOPIC, $TABLE_ADV_POST2OBL, $TABLE_COMPANY_POST2ADVTOPICS, $TABLE_COMPANY_ADVTOPICS;
	global $upgrdtype;

	$totpost = 0;

	$sel_cond = "";
	$obl_cond = "";
	$inner_cond = "";
	//$buyer_cond = "";

	/*
	$act_cond = " p1.active=1 AND p1.moderated=1 ";
	if( $modertype == -1 )
	{
		$act_cond = " p1.active=1 ";
	}
	else
	{
		$act_cond = " p1.active=1 AND p1.moderated='".$modertype."' ";
	}
	*/
	$act_cond = " p1.active=1 ";
	if( $modertype == -1 )
	{
		$act_cond = "";
	}
	else if( $modertype >= 0 )
	{
		$act_cond = " p1.active='$modertype' ";
	}
	
	if( $moderwordstype >= 0 )
	{
		$act_cond .= ($act_cond != "" ? " AND " : "" )." p1.moderated='".$moderwordstype."' ";
	}
	else if( $moderwordstype == -1 )
	{
		//$act_cond = " p1.active=1 ";
	}
	
	if( $archive == -10 )
	{
		//echo "!!!";
		$act_cond .= ($act_cond != "" ? " AND " : "" )." p1.archive>=0 ";		
		//$act_cond = " p1.active>=0 ";
	}
	else
		$act_cond .= ($act_cond != "" ? " AND " : "" )." p1.archive=".( $archive ? 1 : 0 )." ";

	
	if( $act_cond == "" )
		$act_cond = " p1.active>=0 ";


	if( $typeid != 0 )
		$sel_cond .= " AND p1.type_id=".$typeid." ";

	if( ($topicid != 0) && !$parenttopic )
		$sel_cond .= " AND p1.topic_id=".$topicid." ";

	if( !is_numeric($compid) && ($compid == "onlycomp") )
		$sel_cond .= " AND p1.company_id<>0 ";
	else if( !is_numeric($compid) && ($compid == "onlyadv") )
		$sel_cond .= " AND p1.company_id=0 ";
	else if( $compid != 0 )
		$sel_cond .= " AND p1.company_id=".$compid." ";

	if( $oblid != 0 )
		//$sel_cond .= " AND p1.obl_id=".$oblid." ";
		$obl_cond = " INNER JOIN $TABLE_ADV_POST2OBL o1 ON p1.id=o1.post_id AND o1.obl_id=".$oblid." ";

	if( $fltmail != "" )
		$sel_cond .= " AND ((p1.email LIKE '%".addslashes($fltmail)."%') OR (b1.email LIKE '%".addslashes($fltmail)."%') OR (b1.login LIKE '%".addslashes($fltmail)."%')) ";

	if( $flttel != "" )
		$sel_cond .= " AND ((p1.phone LIKE '%".addslashes($flttel)."%') OR (b1.phone LIKE '%".addslashes($flttel)."%')) ";

	if( $fltname != "" )
		$sel_cond .= " AND ((p1.author LIKE '%".addslashes($fltname)."%') OR (b1.name LIKE '%".addslashes($fltname)."%')) ";

	if( $flttip != "" )
		$sel_cond .= " AND p1.title LIKE '%".addslashes($flttip)."%' ";

	if( $fltip != "" )
		$sel_cond .= " AND p1.remote_ip='".addslashes($fltip)."' ";
	
	if( $fltses != "" )
		$sel_cond .= " AND p1.remote_ip='".addslashes($fltses)."' ";
	
	if( $period > 0 )
	{
		$sel_cond .= " AND p1.add_date>DATE_SUB(NOW(), INTERVAL ".$period." DAY) ";
	}
	
	if( isset($upgrdtype) && ($upgrdtype != 0) )
	{
		switch($upgrdtype)
		{
			case 1:	$sel_cond .= " AND p1.targeting=1 ";	break;
			case 2:	$sel_cond .= " AND p1.colored=1 ";	break;
		}
	}	

	if( $comptopicid != 0 )
	{
		if( $comptopicparent )
			$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id
				INNER JOIN $TABLE_COMPANY_ADVTOPICS cpa1 ON cp1.topic_id=cpa1.id AND cpa1.parent_id='$comptopicid' ";
		else
			$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id AND cp1.topic_id='$comptopicid' ";
	}
	//if( $sel_cond != "" )
	//	$sel_cond = " WHERE p1.id>0 ".$sel_cond;

 	$query = "SELECT count(*) as totpost FROM $TABLE_ADV_POST p1
 		$obl_cond
 		$inner_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id ".( ($topicid != 0) && $parenttopic ? " AND t1.parent_id='".$topicid."' " : "")." 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id 
 		WHERE $act_cond $sel_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totpost = $row->totpost;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $totpost;
}

function Board_PostOblNum($postid) { global $upd_link_db;
	global $TABLE_ADV_POST2OBL;

	$obl_num = 0;

	$query = "SELECT count(*) as totobl FROM $TABLE_ADV_POST2OBL WHERE post_id='".$postid."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$obl_num = $row->totobl;
		}
		mysqli_free_result( $res );
	}

	return $obl_num;
}

function trimWordEndRu($word) { global $upd_link_db;
	$wordends = Array("ый", "ий", "ом", "ая", "ую", "аю", "а", "и", "ы", "у");
	
	$word0 = $word;
	
	$word_len = strlen($word0);
	
	if( $word_len>3 )
	{	
		for($i=0; $i<count($wordends); $i++)
		{
			//$ppos = strripos($word0, $wordends[$i]);
			//$ppos0 = strpos($word0, $wordends[$i]);
			$ppos = strrpos($word0, $wordends[$i]);
			//$ppos2 = stripos($word0, $wordends[$i]);
			
			//echo "check &quot;".$word0."&quot; - ".$wordends[$i]." = ".$ppos.";".$ppos0.";".$ppos1.";".$ppos2."<br>";
			
			if( ($ppos > 0) && ( ($word_len-strlen($wordends[$i])) == $ppos ) )
			{
				// find word ending
				$word0 = substr($word0, 0, $ppos);
			}
		}
	}
	
	return $word0;
}

function Board_Posts($LangId, $typeid=0, $topicid=0, $parenttopic=false, $oblid=0, $pi=0, $pn=20, $tagid=0, $paruserid=0, $postid=0, $compid=0, $fltmail="", $flttel="", $fltname="", $flttip="", $fltip="", $fltid=0, $sortby="", $sortby_dir="up", $archive=false, $comptopicid=0, $comptopicparent=false, $srchtxt="", $srchintext=false, $targeting=false, $period=0, $fltses="", $modertype=1, $moderwordstype=1) { global $upd_link_db;
	global $TABLE_TORG_BUYERS, $TABLE_ADV_TOPIC, $TABLE_ADV_POST, $TABLE_ADV_TAGS_2POST, $TABLE_ADV_POST2OBL, $TABLE_COMPANY_ITEMS, $TABLE_COMPANY_POST2ADVTOPICS, $TABLE_COMPANY_ADVTOPICS, $REGIONS;
	global $BOARD_LIMITS, $BOARD_UTYPE_ANONIM, $BOARD_UTYPE_USER, $BOARD_UTYPE_COMP, $BOARD_UP_PERIOD, $PREFS;
	global $SHOW_DEBUG_INFUNC;
	global $upgrdtype;

	$userid = 0;
	$nouserid = 0;
	if( $paruserid > 0 )
		$userid = $paruserid;
	else
		$nouserid = abs($paruserid);

	$psect = Array();
	$query = "SELECT * FROM $TABLE_ADV_TOPIC WHERE parent_id=0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$psect[$row->id] = stripslashes($row->title);
		}
		mysqli_free_result( $res );
	}

	$limit_cond = "";
	if( $pi > 0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
	}
	if( $pi == -10 )
	{
		$limit_cond = " LIMIT 0,$pn ";
	}

	$sel_cond = "";
	$obl_cond = "";
	$inner_cond = "";
	$act_cond = " p1.active=1 ";
	if( $modertype == -1 )
	{
		$act_cond = "";
	}
	else if( $modertype >= 0 )
	{
		$act_cond = " p1.active='$modertype' ";
	}
	
	if( $moderwordstype >= 0 )
	{
		$act_cond .= ($act_cond != "" ? " AND " : "" )." p1.moderated='".$moderwordstype."' ";
	}
	else if( $moderwordstype == -1 )
	{
		//$act_cond = " p1.active=1 ";
	}
	//else
	//{
	//	$act_cond = " p1.active=1 AND p1.moderated='".$moderwordstype."' ";
	//}
	//echo $archive."<br>";

	if( $archive == -10 )
	{
		//echo "!!!";
		$act_cond .= ($act_cond != "" ? " AND " : "" )." p1.archive>=0 ";		
		//$act_cond = " p1.active>=0 ";
	}
	else
		$act_cond .= ($act_cond != "" ? " AND " : "" )." p1.archive=".( $archive ? 1 : 0 )." ";

	
	if( $act_cond == "" )
		$act_cond = " p1.active>=0 ";
	

	if( $typeid != 0 )
		$sel_cond .= " AND p1.type_id=".$typeid." ";

	if( (($topicid != 0) && ($topicid != -1)) && !$parenttopic )
		$sel_cond .= " AND p1.topic_id=".$topicid." ";

	if( $oblid != 0 )
	{
		if( $oblid > 0 )		
		{
			$obl_cond = " INNER JOIN $TABLE_ADV_POST2OBL o1 ON p1.id=o1.post_id AND o1.obl_id=".$oblid." ";
		}
		else
		{
			$obl_cond = " INNER JOIN $TABLE_ADV_POST2OBL o1 ON p1.id=o1.post_id AND o1.obl_id<>".abs($oblid)." ";
		}
	}
	
	if( $fltmail != "" )
		$sel_cond .= " AND ((p1.email LIKE '%".addslashes($fltmail)."%') OR (b1.email LIKE '%".addslashes($fltmail)."%') OR (b1.login LIKE '%".addslashes($fltmail)."%')) ";

	if( $flttel != "" )
		$sel_cond .= " AND ((p1.phone LIKE '%".addslashes($flttel)."%') OR (b1.phone LIKE '%".addslashes($flttel)."%')) ";

	if( $fltname != "" )
		$sel_cond .= " AND ((p1.author LIKE '%".addslashes($fltname)."%') OR (b1.name LIKE '%".addslashes($fltname)."%')) ";

	if( $flttip != "" )
		$sel_cond .= " AND p1.title LIKE '%".addslashes($flttip)."%' ";
		
	if( $fltip != "" )
		$sel_cond .= " AND p1.remote_ip='".addslashes($fltip)."' ";
	
	if( $fltses != "" )
		$sel_cond .= " AND p1.remote_ip='".addslashes($fltses)."' ";
	
	if( $fltid != 0 )
		$sel_cond .= " AND p1.id='$fltid' ";
	
	if( isset($upgrdtype) && ($upgrdtype != 0) )
	{
		switch($upgrdtype)
		{
			case 1:	$sel_cond .= " AND p1.targeting=1 ";	break;
			case 2:	$sel_cond .= " AND p1.colored=1 ";	break;
		}
	}
	else if( $targeting )
		$sel_cond .= " AND p1.targeting=1 ";
	
	if( $period > 0 )
	{
		$sel_cond .= " AND p1.add_date>DATE_SUB(NOW(), INTERVAL ".$period." DAY) ";
	}
	
	// Make more complex search algorithm
	//echo $srchtxt."<br>";
	$word_cond = "";
	if( $srchtxt != "" )
	{
		$srch_words0 = explode(" ", $srchtxt);
		
		$srch_words = Array();
		for($i=0; $i<count($srch_words0); $i++)
		{
			$word00 = trim($srch_words0[$i]);
			
			if( strlen($word00)<3 )
				continue;
									
			$word0 = trimWordEndRu($word00);
			
			//echo $word00." => ".$word0."<br>";
			
			$srch_words[] = $word0;
		}
		
		if( $srchintext && ($srchtxt != "") )
		{
			//$sel_cond .= " AND ((p1.title LIKE '%".addslashes($srchtxt)."%') OR (p1.content LIKE '%".addslashes($srchtxt)."%')) ";
			for($i=0; $i<count($srch_words); $i++)
			{
				$word_cond .= ($word_cond != "" ? " AND " : "")." ((p1.title LIKE '%".addslashes($srch_words[$i])."%') OR (p1.content LIKE '%".addslashes($srch_words[$i])."%')) ";
			}
			if( $word_cond != "" )
				$sel_cond .= " AND ($word_cond) ";
		}
		else if( $srchtxt != "" )
		{
			//$sel_cond .= " AND p1.title LIKE '%".addslashes($srchtxt)."%' ";
			for($i=0; $i<count($srch_words); $i++)
			{
				$word_cond .= ($word_cond != "" ? " AND " : "")." (p1.title LIKE '%".addslashes($srch_words[$i])."%') ";
			}
			if( $word_cond != "" )
				$sel_cond .= " AND ($word_cond) ";
		}
	}
		
	//echo $sel_cond."<br>";
	 

	//if( $comptopicid == -1 )
	//{
	//	$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id AND cp1.topic_id='$comptopicid' ";
	//}
	if( $comptopicid != 0 )
	{
		if( $comptopicparent )
			$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id
				INNER JOIN $TABLE_COMPANY_ADVTOPICS cpa1 ON cp1.topic_id=cpa1.id AND ((cpa1.parent_id='$comptopicid') OR (cpa1.id='$comptopicid'))
			";
			//$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id
			//	INNER JOIN $TABLE_COMPANY_ADVTOPICS cpa1 ON cp1.topic_id=cpa1.id AND cpa1.id='$comptopicid'
			//";
		else
			$inner_cond .= " INNER JOIN $TABLE_COMPANY_POST2ADVTOPICS cp1 ON p1.id=cp1.post_id AND cp1.topic_id='$comptopicid' ";
	}

	//if( $sel_cond != "" )
	//	$sel_cond = " WHERE p1.id>0 ".$sel_cond;

	$sortby_cond = "p1.archive, up_dt DESC ";
	switch($sortby)
	{
		// cabinet sort
		case "id":
			$sortby_cond = "p1.archive, p1.id ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;
		case "updt":
			$sortby_cond = "p1.archive, p1.up_dt ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;
		case "adddate":
			$sortby_cond = "p1.archive, p1.add_date ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;
		case "title":
			$sortby_cond = "p1.archive, p1.title ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;
		case "amount":
			$sortby_cond = "p1.archive, p1.amount ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;
		case "cost":
			$sortby_cond = "p1.archive, p1.cost ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;
		case "views":
			$sortby_cond = "p1.archive, p1.viewnum ".($sortby_dir == "down" ? "DESC" : "")." ";
			break;

		// basic
		case "obl":
			$sortby_cond = " obl_id, up_dt DESC ";
			break;
		case "sect":
			$sortby_cond = " topic, up_dt DESC ";
			break;
		case "name":
			$sortby_cond = " author, up_dt DESC ";
			break;
		case "mail":
			$sortby_cond = " email, up_dt DESC ";
			break;
		case "tel":
			$sortby_cond = " phone, up_dt DESC ";
			break;
		case "ip":
			$sortby_cond = " remote_ip, up_dt DESC ";
			break;
		case "date":
			$sortby_cond = " up_dt DESC ";
			break;
		case "dateadd":
			$sortby_cond = " add_date DESC ";
			break;
			
		case "rand":
			$sortby_cond = " RAND() ";
			break;
	}

	/*
 	$query = "SELECT p1.*, t1.title as topic, t1.parent_id, YEAR(p1.add_date) as dy, MONTH(p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd,
 			HOUR(p1.add_date) as dh, MINUTE(p1.add_date) as dmm, YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd
 		FROM $TABLE_ADV_POST p1
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id ".( ($topicid != 0) && $parenttopic ? " AND t1.parent_id='".$topicid."' " : "")."
 		$sel_cond
 		ORDER BY up_dt DESC
 		$limit_cond
 	";
 	*/
	
	if( $srchtxt != "" )
	{
		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			c1.title as compname, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id ".( ($topicid != 0) && $parenttopic ? " AND t1.parent_id='".$topicid."' " : "")." 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id 
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond $sel_cond
 		ORDER BY $sortby_cond
 		$limit_cond
 		";	
	}
 	else if( !is_numeric($compid) && (($compid == "onlycomp") || ($compid == "onlyadv")) )
 	{
 		//echo "22@ -".$compid."-";
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			TIMESTAMPDIFF(MINUTE,NOW(), DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_COMP]['upsfpd']." DAY)) as tmup, DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_COMP]['upsfpd']." DAY) as updt2,
			".( false ? 
				" case when (CURDATE() > DATE(DATE_ADD(p1.up_dt, INTERVAL ".($BOARD_UP_PERIOD)." DAY))) then 1 else 0 end as upallow, " :
				" case when (NOW() > DATE_ADD(p1.up_dt, INTERVAL ".($BOARD_UP_PERIOD)." DAY)) then 1 else 0 end as upallow, "
			)."
 			c1.title as compname, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		$inner_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond $sel_cond ".( $compid == "onlycomp" ? " AND p1.company_id<>0 " : " AND p1.company_id=0 " )." ".($typeid != 0 ? " AND p1.type_id=".$typeid." " : "" )."
 			".($userid != 0 ? " AND p1.author_id=".$userid." " : "")." ".($postid != 0 ? " AND p1.id<>'".$postid."' " : "")."
 		ORDER BY $sortby_cond
 		$limit_cond
 		";
 	}
 	else if( $compid != 0 )
 	{		
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			TIMESTAMPDIFF(MINUTE,NOW(), DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_COMP]['upsfpd']." DAY)) as tmup, DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_COMP]['upsfpd']." DAY) as updt2,			
			".( false ? " case when (CURDATE() > DATE(DATE_ADD(p1.up_dt, INTERVAL ".($BOARD_UP_PERIOD)." DAY))) then 1 else 0 end as upallow, " : 
				" case when (NOW() > DATE_ADD(p1.up_dt, INTERVAL ".($BOARD_UP_PERIOD)." DAY)) then 1 else 0 end as upallow, "
			)."
 			c1.title as compname, b1.login		
 		FROM $TABLE_ADV_POST p1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		$obl_cond
 		$inner_cond
 		".( $topicid == -1 ? " LEFT JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id " : " INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id " )."
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond $sel_cond ".( $compid == -1 ? " AND p1.company_id=0 " : " AND p1.company_id=$compid " )." ".($typeid != 0 ? " AND p1.type_id=".$typeid." " : "" )."
 			".($userid != 0 ? " AND p1.author_id=".$userid." " : "")." ".($postid != 0 ? " AND p1.id<>'".$postid."' " : "")."
 		ORDER BY $sortby_cond
 		$limit_cond
 		";
		
		if( $comptopicid == 148 )
		{
			//echo $query."<br>";
		}
 	}
 	else if( $userid != 0 )
 	{
		/*
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			TIMESTAMPDIFF(MINUTE,NOW(), DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_USER]['upsfpd']." DAY)) as tmup, DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_USER]['upsfpd']." DAY) as updt2, c1.title as compname,
			case when (CURDATE() > DATE(DATE_ADD(p1.up_dt, INTERVAL ".($BOARD_UP_PERIOD)." DAY))) then 1 else 0 end as upallow 
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond AND p1.author_id=$userid $sel_cond
 		ORDER BY $sortby_cond
 		";
		*/
		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			TIMESTAMPDIFF(MINUTE,NOW(), DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_USER]['upsfpd']." DAY)) as tmup, DATE_ADD(p1.up_dt, INTERVAL ".$BOARD_LIMITS[$BOARD_UTYPE_USER]['upsfpd']." DAY) as updt2, c1.title as compname,
			case when (NOW() > DATE_ADD(p1.up_dt, INTERVAL ".($BOARD_UP_PERIOD)." DAY)) then 1 else 0 end as upallow, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond AND p1.author_id=$userid $sel_cond
 		ORDER BY $sortby_cond
 		";
 	}
 	else if( $tagid != 0 )
 	{
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			c1.title as compname, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TAGS_2POST k1 ON p1.id=k1.item_id AND k1.tag_id=".$tagid."
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond 
 		ORDER BY $sortby_cond
 		";
 	}

 	else if($postid != 0)
 	{
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			c1.title as compname, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id ".( ($topicid != 0) && $parenttopic ? " AND t1.parent_id='".$topicid."' " : "")." 
		LEFT JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond $sel_cond AND p1.id<$postid ".($nouserid != 0 ? " AND p1.author_id<>'$nouserid' " : "")." ".($userid != 0 ? " AND p1.author_id='$userid' " : "")." 
 		ORDER BY add_date DESC
 		$limit_cond
 		";
 	}
 	else if($fltid != 0)
 	{
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			TIMESTAMPDIFF(MINUTE,NOW(), DATE_ADD(p1.up_dt, INTERVAL 3 DAY)) as tmup,
 			c1.title as compname, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id 
		LEFT JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond  AND p1.id='$fltid'
 		ORDER BY $sortby_cond
 		";
 	}
 	else
 	{
 		$query = "SELECT p1.*, t1.title as topic, t1.parent_id, 
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm, 
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt, 
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd,
 			c1.title as compname, b1.login
 		FROM $TABLE_ADV_POST p1
 		$obl_cond
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id ".( ($topicid != 0) && $parenttopic ? " AND t1.parent_id='".$topicid."' " : "")." 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON p1.author_id=b1.id  
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE $act_cond $sel_cond
 		ORDER BY $sortby_cond
 		$limit_cond
 		";
 	}
	
	if( isset($SHOW_DEBUG_INFUNC) && $SHOW_DEBUG_INFUNC )
	{
		echo "<br>".$query."<br />";
	}
	if( $fltses != '' )
	{

		$query = "SELECT ses.ses_id, p1.*,
			YEAR(p1.up_dt) as dy, MONTH(p1.up_dt) as dm, DAYOFMONTH(p1.up_dt) as dd, HOUR(p1.up_dt) as dh, MINUTE(p1.up_dt) as dmm,
			DATE_FORMAT(p1.add_date, '%d.%m.%Y %H:%i') as add_dt,
			YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd

 		FROM $TABLE_ADV_POST p1 JOIN `agt_torg_buyer_auth_arch` AS ses on (ses.user_login = p1.email) WHERE ses.ses_id = '".$fltses."'";
		//$query = "SELECT * FROM $TABLE_ADV_TOPIC WHERE parent_id=0";
	}

 	$its = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['act'] = $row->active;
			$it['arc'] = $row->archive;
			$it['moderated'] = $row->moderated;
			$it['color'] = $row->colored;
			$it['fixdone'] = $row->fixdone;
			$it['title'] = stripslashes($row->title);
			$it['text'] = stripslashes($row->content);
			$it['bname'] = stripslashes($row->author);
			$it['bname2'] = stripslashes($row->author2);
			$it['bname3'] = stripslashes($row->author3);
			$it['btel1'] = stripslashes($row->phone);
			$it['btel2'] = stripslashes($row->phone2);
			$it['btel3'] = stripslashes($row->phone3);
			$it['bemail'] = stripslashes($row->login);
			$it['bcity'] = stripslashes($row->city);
			$it['topic'] = stripslashes($row->topic);
			$it['utype'] = $row->publish_utype;
			$it['author_id'] = $row->author_id;
			$it['obl_id'] = $row->obl_id;
			$it['type_id'] = $row->type_id;
			$it['topic_id'] = $row->topic_id;
			$it['viewnum'] = $row->viewnum;					// Общее кол-во просмотров за все время - неуникальных
			$it['viewnum_uniq'] = $row->viewnum_uniq;		// Кол-во уникальных просмотров за 7 последних дней
			$it['viewnum_cont'] = $row->viewnum_cont;
			$it['target'] = $row->targeting;
			$it['ses_id'] = ( $fltses != '' ? $row->ses_id : '');
			
			$it['bphone'] = $it['btel1'];
			if( $it['btel2'] != "" )
				$it['bphone'] .= ($it['bphone'] != "" ? ", " : "").$it['btel2'];
			if( $it['btel3'] != "" )
				$it['bphone'] .= ($it['bphone'] != "" ? ", " : "").$it['btel3'];

			$it['company_id'] = $row->company_id;
			if( $it['utype'] == 2 )
			{
				if( $row->compname != null )
				{
					$it['bname'] = stripslashes($row->compname);
					$it['company'] = stripslashes($row->compname);
				}
			}

			$it['remote_ip'] = stripslashes($row->remote_ip);

			$it['amount'] = trim(stripslashes($row->amount));
			$it['izm'] = trim(stripslashes($row->izm));
			$it['cost'] = trim(stripslashes($row->cost));
			$it['cost_cur'] = $row->cost_cur;
			$it['cizm'] = trim(stripslashes($row->cost_izm));
			$it['cdog'] = $row->cost_dog;
			
			$it['upallow'] = false;

			if( $userid != 0 )
			{
				$it['upmin'] = $row->tmup;

				$it['updt'] = $row->up_dt;
				$it['updt2'] = $row->updt2;
				
				$it['upallow'] = ( $row->upallow == 1 );
			}

			$updt = mktime(10, 0, 0, $row->dm, $row->dd, $row->dy);
			$endupdt = $updt + ( $PREFS['BOARD_DEACTPERIOD'] * 24*3600 );
			
			//$it['dt'] = $row->add_date;
			$it['adddt'] = $row->add_dt; //sprintf("%02d.%02d.%04d %02d:%02d", $row->add, $row->adm, $row->ady, $row->adh, $row->admm);
			$it['dt'] = sprintf("%02d.%02d.%04d %02d:%02d", $row->dd, $row->dm, $row->dy, $row->dh, $row->dmm);
			$it['dt_short'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);
			$it['dt_short_end'] = date("d.m.Y", $endupdt);
			$it['today'] = ( ($row->dy == $row->cy) && ($row->dm == $row->cm) && ($row->dd == $row->cd) );

			$it['obl'] = $REGIONS[$row->obl_id];

			$it['ptopic_id'] = $row->parent_id;
			$it['ptopic'] = ( ($it['ptopic_id'] != 0) && (isset($psect[$it['ptopic_id']])) ? $psect[$it['ptopic_id']] : '' );

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Board_Post_UpdateView($LangId, $postid) { global $upd_link_db;
	global $TABLE_ADV_POST;
	
	$query = "UPDATE $TABLE_ADV_POST SET viewnum=(viewnum+1) WHERE id='$postid'";
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}
}

function Board_Post_UpdateRate($LangId, $viewtype_id, $compid, $postid, $ip) { global $upd_link_db;
	global $TABLE_ADV_POST_RATE, $TABLE_COMPANY_RATE, $TABLE_COMPANY_RATE_DATETMP;
	
	// First check if this is allowed by ip once more this day
	$num_this_ip = 0;
	$id_this_ip = 0;
	
	$resrate = Array("today" => 0, "wasadd" => false, "total" => 0, "type" => $viewtype_id, "func" => "post");
	
	$query = "SELECT * FROM $TABLE_COMPANY_RATE_DATETMP WHERE item_id='".$compid."' AND post_id='".$postid."' AND metrictype='".$viewtype_id."' AND dt=CURDATE() AND ip LIKE '".addslashes($ip)."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$id_this_ip = $row->id;
			$num_this_ip = $row->amount;
		}
		mysqli_free_result( $res );
	}
	
	$resrate["today"] = $num_this_ip;
	
	if( $num_this_ip == 0 )
	{
		// Add new
		$query = "INSERT INTO $TABLE_COMPANY_RATE_DATETMP (item_id, post_id, metrictype, amount, dt, add_time, ip) 
			VALUES ('".$compid."', '".$postid."', '".$viewtype_id."', 1, CURDATE(), NOW(), '".addslashes($ip)."')";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo "ins: ".mysqli_error($upd_link_db);
		}
	}
	else
	{		
		$query = "UPDATE $TABLE_COMPANY_RATE_DATETMP SET amount=(amount+1), add_time=NOW() WHERE id='$id_this_ip'";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo "upd: ".mysqli_error($upd_link_db);
		}
	}

	// Calculate daily item rate
	$daily_rate_id = 0;
	$daily_total = 0;
	
	if( $num_this_ip >= 2 )
	{
		return $resrate; //($num_this_ip+1);
	}
	
	$resrate["wasadd"] = true;
	
	$query = "SELECT * FROM $TABLE_ADV_POST_RATE WHERE item_id='".$compid."' AND post_id='".$postid."' AND metrictype='".$viewtype_id."' AND dt=CURDATE()";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$daily_rate_id = $row->id;
			$daily_total = $row->amount;
		}
		mysqli_free_result( $res );
	}
	$resrate["total"] = $daily_total;

	if( $daily_rate_id == 0 )
	{
		$query = "INSERT INTO $TABLE_ADV_POST_RATE (item_id, post_id, metrictype, dt, amount) VALUES ('".$compid."', '".$postid."', '".$viewtype_id."', CURDATE(), 1)";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	else
	{
		$query = "UPDATE $TABLE_ADV_POST_RATE SET amount=amount+1 WHERE id=$daily_rate_id";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	
	$resrate["today"]++;
	$resrate["total"] += 1;
	
	return $resrate;	//($num_this_ip+1);
}

function Board_PostInfo($LangId, $postid) { global $upd_link_db;
	global $TABLE_ADV_TOPIC, $TABLE_ADV_POST, $TABLE_ADV_POST2OBL, $TABLE_COMPANY_ITEMS, $REGIONS;


	$psect = Array();
	$query = "SELECT * FROM $TABLE_ADV_TOPIC WHERE parent_id=0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$psect[$row->id] = stripslashes($row->title);
		}
		mysqli_free_result( $res );
	}


 	$query = "SELECT p1.*, t1.title as topic, t1.parent_id, c1.title as compname, c1.www, c1.logo_file
 		FROM $TABLE_ADV_POST p1
 		LEFT JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id
 		LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON p1.company_id=c1.id
 		WHERE p1.id='".$postid."'
 	";

 	$it = Array();
 	$it['id'] = 0;
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it['id'] = $row->id;
			$it['author_id'] = $row->author_id;
			$it['title'] = stripslashes($row->title);
			$it['text'] = stripslashes($row->content);
			$it['bname'] = stripslashes($row->author);
			$it['bname2'] = stripslashes($row->author2);
			$it['bname3'] = stripslashes($row->author3);
			$it['btel1'] = stripslashes($row->phone);
			$it['btel2'] = stripslashes($row->phone2);
			$it['btel3'] = stripslashes($row->phone3);
			$it['bphone'] = stripslashes($row->phone);
			$it['bemail'] = stripslashes($row->email);
			$it['bcity'] = stripslashes($row->city);
			$it['topic'] = ( $row->topic != null ? stripslashes($row->topic) : "" );
			$it['obl_id'] = $row->obl_id;
			$it['type_id'] = $row->type_id;
			$it['topic_id'] = $row->topic_id;
			$it['utype'] = $row->publish_utype;

			$it['bphone'] = $it['btel1'];
			if( $it['btel2'] != "" )
				$it['bphone'] .= ($it['bphone'] != "" ? ", " : "").$it['btel2'];
			if( $it['btel3'] != "" )
				$it['bphone'] .= ($it['bphone'] != "" ? ", " : "").$it['btel3'];

			$it['company_id'] = $row->company_id;
			$it['company'] = "";
			$it['company_www'] = "";
			$it['company_logo'] = "";
			if( ($it['company_id'] != 0) && ($row->compname != null) )
			{
				$it['company'] = stripslashes($row->compname);
				$it['company_www'] = stripslashes($row->www);
				$it['company_logo'] = stripslashes($row->logo_file);
			}

			$it['amount'] = trim(stripslashes($row->amount));
			$it['izm'] = trim(stripslashes($row->izm));
			$it['cost'] = trim(stripslashes($row->cost));
			$it['cost_cur'] = $row->cost_cur;
			$it['cizm'] = trim(stripslashes($row->cost_izm));
			$it['costdog'] = $row->cost_dog;

			$it['dt'] = $row->add_date;
			$it['updt'] = $row->up_dt;
			$it['views'] = $row->viewnum;
			$it['moder'] = $row->moderated;

			$it['obl'] = $REGIONS[$row->obl_id];
			$it['allobl'] = Array();

			$query1 = "SELECT * FROM $TABLE_ADV_POST2OBL WHERE post_id=".$row->id." ORDER BY obl_id";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$it['allobl'][] = Array("id" => $row1->obl_id, "obl" => $REGIONS[$row1->obl_id]);
				}
				mysqli_free_result( $res1 );
			}

			$it['ptopic_id'] = ( $row->parent_id != null ? $row->parent_id : 0 );
			$it['ptopic'] = ( $it['ptopic_id'] != 0 ? $psect[$it['ptopic_id']] : '' );
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $it;
}

function Board_PostCompPath($LangId, $postid) { global $upd_link_db;
	global $TABLE_COMPANY_ADVTOPICS, $TABLE_COMPANY_POST2ADVTOPICS;
	
	$topicid = 0;
	
	$query = "SELECT * FROM $TABLE_COMPANY_POST2ADVTOPICS p2t WHERE p2t.post_id='$postid'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$topicid = $row->topic_id;
		}
		mysqli_free_result($res);
	}
	
	$path = Array();
	
	if( $topicid != 0 )
	{
		$curtid = $topicid;
		while($curtid != 0)
		{
			$parent_id = 0;
			$query = "SELECT * FROM $TABLE_COMPANY_ADVTOPICS t1 WHERE t1.id='$curtid'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				if( $row = mysqli_fetch_object( $res ) )
				{
					$pathi = Array();
					$pathi['id'] = $row->id;
					$pathi['pid'] = $row->parent_id;
					$pathi['name'] = stripslashes($row->name);
					
					$path[] = $pathi;
					
					$parent_id = $row->parent_id;
				}
				mysqli_free_result($res);
			}
			
			$curtid = $parent_id;
		}
	}
	
	return $path;
}

function Board_PostPhotosNum($prod_id) { global $upd_link_db;
	global $TABLE_ADV_POST_PICS;

	$photos_num = 0;

	$query = "SELECT count(*) as totpic FROM $TABLE_ADV_POST_PICS WHERE item_id='$prod_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$photos_num = $row->totpic;
		}
		mysqli_free_result( $res );
	}

	return $photos_num;
}

function Board_PostPhotos($LangId, $prod_id, $pn=0) { global $upd_link_db;
	global $TABLE_ADV_POST_PICS, $PICHOST;
	//$PICHOST = 'http://agrotender.local/';

	$photos = Array();

	$limit_cond = "";
	if( $pn > 0 )
	{
		$limit_cond = " LIMIT 0,$pn ";
	}

	$query = "SELECT * FROM $TABLE_ADV_POST_PICS WHERE item_id='$prod_id' ORDER BY sort_num $limit_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$pic = Array();
			$pic['id']      = $row->file_id;
			$pic['title']   = stripslashes($row->title);
			$pic['thumb']   = ( stripslashes($row->filename_thumb) != "" ? $PICHOST.stripslashes($row->filename_thumb) : '' );
			$pic['ico']     = ( stripslashes($row->filename_ico) != "" ? $PICHOST.stripslashes($row->filename_ico) : '' );
			$pic['src']     = ( stripslashes($row->filename) != "" ? $PICHOST.stripslashes($row->filename) : '' );
			//$pic['src']     = ( stripslashes($row->filename_big) != "" ? $PICHOST.stripslashes($row->filename_big) : '' );
			$pic['ico_w']   = $row->ico_w;
			$pic['ico_h']   = $row->ico_h;
			$pic['thumb_w'] = $row->thumb_w;
			$pic['thumb_h'] = $row->thumb_h;
			$pic['src_w']   = $row->src_w;
			$pic['src_h']   = $row->src_h;
			//$pic['src_w']   = $row->big_w;
			//$pic['src_h']   = $row->big_h;

			$photos[] = $pic;
		}
		mysqli_free_result( $res );
	}

	return $photos;
}

function Board_DefTitles($LangId, $trade=0, $cult_name="") { global $upd_link_db;
	global $TORG_BUY;

	$trade_str = Array("", "Покупка ", "Продажа ", "Услуги ");

	$result = Array();

	$orgtitle	= $trade_str[$trade].( $cult_name == "" ? "аграрной продукции" : $cult_name)." в __cityname2__ оптом. Агро объявления от Агротендер.";
	$orgkeyw	= ( $cult_name == "" ? "аграрная продукция" : $cult_name).", ".$trade_str[$trade].", объявления, __oblname__";
	$orgdescr	= "На агро доске объявлений __cityname3__ __oblname2__  ".$trade_str[$trade]." ".( $cult_name == "" ? "аграрной продукции" : $cult_name)." пройдет по наиболее выгодной цене и минимальными временными затратами.";
	$orgh1		= $trade_str[$trade].( $cult_name == "" ? "Аграрная продукция" : $cult_name)." в __cityname2__";
	$orgtext	= $trade_str[$trade].( $cult_name == "" ? "Аграрная продукция" : $cult_name)." в __cityname2__ __oblname2__";

	$result['title'] = $orgtitle;
	$result['descr'] = $orgdescr;
	$result['keyw']	= $orgkeyw;
	$result['h1']	= $orgh1;
	$result['txt']	= $orgtext;

    return $result;
}

function Board_TagList($LangId, $mode="", $num=20) { global $upd_link_db;
	global $TABLE_ADV_TAGS;

	$tag_list = Array();

	if( $mode == "best" )
	{
		$query = "SELECT * FROM $TABLE_ADV_TAGS WHERE visible=1 ORDER BY rate DESC LIMIT 0,$num";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$ti = Array();
				$ti['id'] = $row->id;
				$ti['name'] = stripslashes($row->tag);
				$ti['url'] = stripslashes($row->url);
				$ti['rate'] = $row->rate;
				$tag_list[] = $ti;
			}
			mysqli_free_result( $res );
		}
	}
	else
	{
		$query = "SELECT * FROM $TABLE_ADV_TAGS";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$ti = Array();
				$ti['id'] = $row->id;
				$ti['name'] = stripslashes($row->tag);
				$ti['url'] = stripslashes($row->url);
				$ti['rate'] = $row->rate;
				$ti['words'] = Array();
				$wlist = explode(",", $row->tag_words);
				if( count($wlist) > 0 )
				{
					if( trim($wlist[count($wlist)-1]) == "" )
					{
						$wlist = array_slice($wlist,0,count($wlist)-1);
					}
				}
				$ti['words'] = $wlist;

				$tag_list[] = $ti;
			}
			mysqli_free_result( $res );
		}
	}

	return $tag_list;
}

function Board_TagInfo($LangId, $tagurl="") { global $upd_link_db;
	global $TABLE_ADV_TAGS;

	$tag_info = Array();
	$tag_info['id'] = 0;

	$query = "SELECT * FROM $TABLE_ADV_TAGS WHERE url='".addslashes($tagurl)."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ti = Array();
			$ti['id'] = $row->id;
			$ti['name'] = stripslashes($row->tag);
			$ti['url'] = stripslashes($row->url);
			$ti['rate'] = $row->rate;
			$ti['words'] = Array();
			$wlist = explode(",", $row->tag_words);
			if( count($wlist) > 0 )
			{
				if( trim($wlist[count($wlist)-1]) == "" )
				{
					$wlist = array_slice($wlist,0,count($wlist)-1);
				}
			}
			$ti['words'] = $wlist;

			$tag_info = $ti;
		}
		mysqli_free_result( $res );
	}

	return $tag_info;
}

function Board_PostAssign2Tags($postid, $ptit, $ptxt, $tags) { global $upd_link_db;
	global $TABLE_ADV_TAGS_2POST;

	$found_tags = 0;

	for( $i=0; $i<count($tags); $i++ )
	{
		$found = false;
		if( preg_match("/(".implode("|",$tags[$i]['words']).")/i", $ptit) )
		{
			$found = true;
		}
		else if( preg_match("/(".implode("|",$tags[$i]['words']).")/i", $ptxt) )
		{
			$found = true;
		}

		if( $found )
		{
			$found_tags++;
			//echo "<b>".join(",", $tags[$i]['words'])."</b><br />";
			$query1 = "INSERT INTO $TABLE_ADV_TAGS_2POST (item_id, tag_id) VALUES (".$postid.",".$tags[$i]['id'].")";
			if( !mysqli_query($upd_link_db, $query1 ) )
			{
				echo mysqli_error($upd_link_db);
			}
		}
	}

	return $found_tags;
}

function BoardTag_BuildUrl($LangId, $tagurl="", $pi=0, $pn=20) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	$url = "board/tags/";

	if( $tagurl == "" )
	{
//		$url .= "index.html";
		$url .= "";
	}
	else
	{
		$url .= $tagurl.($pi > 0 ? '_p'.$pi : '');//.".html";
	}

	return $WWWHOST.$url;
}


////////////////////////////////////////////////////////////////////////////////
// company
function Comp_BuildUrl_PHP($LangId, $mode = "list", $oblid="", $typeid=0, $topicid=0, $pi=0, $pn=20, $subid=0) { global $upd_link_db;
	// sample URLS
	//	board.php
	//	board.php?action=add
	$url = "kompanii.php";

	if( $mode == "add" )
	{
		$url .= "?action=add";
	}
	else if( $mode == "item" )
	{
		$url .= "?action=viewitem&postid=".$pi;
	}
	else
	{
		//$url = "";
		$urlpar = "oblurl=".$oblid;
		$urlpar .= "&adtype=".$typeid;
		$urlpar .= "&adtopic=".$topicid;

		if( $pi > 0 )
		{
			$urlpar .= "&pi=".$pi;
		}

		$url = $url."?".$urlpar;
	}

	return $url;
}

function Comp_BuildUrl_HTML($LangId, $mode = "list", $oblid="", $typeid=0, $topicid=0, $compid=0, $pi=0, $pn=20, $subid=0) { global $upd_link_db;
	// sample URLS
	//	somepage.html
	//	info/anotherpage.html
	$url = "";

	$typeurlarr = Array("all", "buy", "sell", "serv", "news", "vacancy", "about", "cont", "board", "comment");

	if( $mode == "add" )
	{
		$url = "addcomp";//.html";
	}
	else if( $mode == "item" )
	{
		$url = "comp-".$compid;//.".html";

		//echo $topicid."-".$compid."-".$pi."<br />";
        if( $typeid > 0 )
        {
        	$url = "comp-".$compid."-".$typeurlarr[$typeid].($topicid != 0 ? '-s'.$topicid : '').($subid != 0 ? "-com".$subid : "");//.".html";
        	if( $pi > 1 )
        	{
        		$url = "comp-".$compid."-".$typeurlarr[$typeid].($topicid != 0 ? '-s'.$topicid : '')."-p".$pi;//.".html";
        	}
        }
	}
	else if( $mode == "newsitem" )
	{
 		$url = "comp-".$compid."-news-".$pi;//.".html";
	}
	else if( $mode == "vacitem" )
	{
 		$url = "comp-".$compid."-vacancy-".$pi;//.".html";
	}
	else if( $mode == "pricetbl" )
	{
		$url = "comp-".$compid."-pricetbl".($typeid == 1 ? "-2" : "");//.".html";
	}
	else if( $mode == "pricetblsell" )
	{
		$url = "comp-".$compid."-pricetblsell".($typeid == 1 ? "-2" : "");//.".html";
	}
	else
	{
  		//$url .= $typeurlarr[$typeid];

  		if( $topicid != 0 )
  		{
  			$url .= "t".$topicid;
  			if( $pi > 1 )
	  		{
	  			$url .= "_p".$pi;
	  		}
  		}
  		else
  		{
  			if( $pi > 1 )
	  		{
	  			$url .= "p".$pi;
	  		}
  		}


//  		$url .= ".html";

  		if( $url == ".html" )
  			$url = "index.html";

  		if( $oblid != "" )
  		{
  			$url = "region_".$oblid."/".$url;
  		}
	}

	if( $url == "" )
	{
		return "kompanii";//.html";
	}

	return "kompanii/".$url;
}

function Comp_BuildUrl($LangId, $mode = "list", $oblid="", $typeid=0, $topicid=0, $compid=0, $pi=0, $pn=20, $subid=0) { global $upd_link_db;
	global $WWW_LINK_MODE, $WWWHOST;

	if( $WWW_LINK_MODE == "php" )
		//$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
		$wwwlink = $WWWHOST;

	return ( $WWW_LINK_MODE == "php" ?  $wwwlink.Comp_BuildUrl_PHP($LangId, $mode, $oblid, $typeid, $topicid, $compid, $pi, $pn, $subid) : $WWWHOST.Comp_BuildUrl_HTML($LangId, $mode, $oblid, $typeid, $topicid, $compid, $pi, $pn, $subid) );
}

function Comp_TopicGroups($LangId, $tid=0, $mode = "") { global $upd_link_db;
	global $TABLE_COMPANY_TOPIC, $TABLE_COMPANY_TGROUPS;

	$topics = Array();
	$query = "SELECT DISTINCT g1.id as grid, g1.title as grname, g1.sort_num
		FROM $TABLE_COMPANY_TOPIC t1
		LEFT JOIN $TABLE_COMPANY_TGROUPS g1 ON t1.menu_group_id=g1.id
		WHERE t1.parent_id='$tid'
		ORDER BY g1.sort_num, g1.title";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$tit = Array();
			$tit['id'] = $row->grid;
			$tit['name'] = stripslashes($row->grname);
			$tit['sort'] = $row->sort_num;

			$topics[] = $tit;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $topics;
}

function Comp_TopicLevel($LangId, $tid=0, $mode = "", $grid = 0, $oblid = 0) { global $upd_link_db;
	global $TABLE_COMPANY_TOPIC, $TABLE_COMPANY_ITEMS, $TABLE_COMPANY_TGROUPS;

	$topics = Array();

	$grcond = "";
	if( $grid != 0 )
	{
		$grcond = " AND t1.menu_group_id='$grid' ";
	}

	$oblcond = "";
	if( $oblid != 0 )
	{
		$oblcond = " AND p1.obl_id='$oblid' ";
	}

	if( $mode == "withpostnum" )
	{
		$query = "SELECT t1.*, count(p1.id) as pnum FROM $TABLE_COMPANY_TOPIC t1
			LEFT JOIN $TABLE_COMPANY_ITEMS p1 ON t1.id=p1.topic_id $oblcond
			WHERE t1.parent_id='$tid' $grcond
			GROUP BY t1.id
			ORDER BY t1.sort_num, t1.title";
	}
	else if( $mode == "bygroups" )
	{
		$query = "SELECT t1.*, g1.id as grid, g1.title as grname FROM $TABLE_COMPANY_TOPIC t1
			LEFT JOIN $TABLE_COMPANY_TGROUPS g1 ON t1.menu_group_id=g1.id
			WHERE t1.parent_id='$tid' $grcond
			ORDER BY g1.sort_num, t1.sort_num, t1.title";
	}
	else
	{
		$query = "SELECT * FROM $TABLE_COMPANY_TOPIC t1 WHERE t1.parent_id='$tid' $grcond ORDER BY sort_num, title";
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$tit = Array();
			$tit['id'] = $row->id;
			$tit['name'] = stripslashes($row->title);
			$tit['sort'] = $row->sort_num;

			if( $mode == "withpostnum" )
			{
				$tit['pnum'] = $row->pnum;
			}
			else if( $mode == "bygroups" )
			{
				$tit['group'] = ($row->grname != null ? stripslashes($row->grname) : "");
			}

			$topics[] = $tit;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $topics;
}

function Comp_TopicInfo($LangId, $tid) { global $upd_link_db;
	global $TABLE_COMPANY_TOPIC, $TABLE_COMPANY_ITEMS;

	$topic = Array();
	$query = "SELECT t1.*, count(p1.id) as pnum FROM $TABLE_COMPANY_TOPIC t1
		LEFT JOIN $TABLE_COMPANY_ITEMS p1 ON t1.id=p1.topic_id
		WHERE t1.id='$tid'
		GROUP BY t1.id
		ORDER BY t1.sort_num, t1.title";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$tit = Array();
			$tit['id'] = $row->id;
			$tit['pid'] = $row->parent_id;
			$tit['name'] = stripslashes($row->title);
			$tit['sort'] = $row->sort_num;

			$tit['descr'] = stripslashes($row->descr);

			$tit['seo_h1'] = stripslashes($row->page_h1);
			$tit['seo_title'] = stripslashes($row->page_title);
			$tit['seo_keyw'] = stripslashes($row->page_keywords);
			$tit['seo_descr'] = stripslashes($row->page_descr);

			/*
			$tit['seo_h1_buy'] = stripslashes($row->seo_h1_buy);
			$tit['seo_title_buy'] = stripslashes($row->seo_title_buy);
			$tit['seo_keyw_buy'] = stripslashes($row->seo_keyw_buy);
			$tit['seo_descr_buy'] = stripslashes($row->seo_descr_buy);
			$tit['seo_text_buy'] = stripslashes($row->seo_text_buy);

			$tit['seo_h1_sell'] = stripslashes($row->seo_h1_sell);
			$tit['seo_title_sell'] = stripslashes($row->seo_title_sell);
			$tit['seo_keyw_sell'] = stripslashes($row->seo_keyw_sell);
			$tit['seo_descr_sell'] = stripslashes($row->seo_descr_sell);
			$tit['seo_text_sell'] = stripslashes($row->seo_text_sell);
			*/

			$tit['pnum'] = $row->pnum;

			$topic = $tit;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $topic;
}

function Comp_ItemsNum($LangId, $typeid=0, $topicid=0, $parenttopic=false, $oblid=0, $srchtxt="", $srchintext=false) { global $upd_link_db;
	global $TABLE_COMPANY_ITEMS, $TABLE_COMPANY_TOPIC, $TABLE_COMPANY_ITEMS2TOPIC;

	$totpost = 0;

	$sel_cond = "";
	if( $typeid != 0 )
		$sel_cond .= " AND p1.type_id=".$typeid." ";

	//if( ($topicid != 0) && !$parenttopic )
	//	$sel_cond .= " AND p1.topic_id=".$topicid." ";

	if( $oblid != 0 )
		$sel_cond .= " AND p1.obl_id=".$oblid." ";

	if( $sel_cond != "" )
		$sel_cond = " WHERE p1.id>0 ".$sel_cond;

	$topic_cond = "";
	if( ($topicid != 0) && !$parenttopic )
		$topic_cond = " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC i2t ON p1.id=i2t.item_id AND i2t.topic_id=".$topicid." ";
	else if( ($topicid != 0) && $parenttopic )
		$topic_cond = " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC i2t ON p1.id=i2t.item_id
			INNER JOIN $TABLE_COMPANY_TOPIC t1 ON i2t.topic_id=t1.id AND t1.parent_id=".$topicid." ";

 	$query = "SELECT count(*) as totpost FROM $TABLE_COMPANY_ITEMS p1
 		$topic_cond
 		$sel_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$totpost = $row->totpost;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $totpost;
}

function Comp_ItemByUser($LangId, $userid) { global $upd_link_db;
	global $TABLE_COMPANY_ITEMS;

	$comp_id = 0;

	$query = "SELECT * FROM $TABLE_COMPANY_ITEMS WHERE author_id='$userid'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$comp_id = $row->id;
		}
		mysqli_free_result( $res );
	}

	return $comp_id;
}

function Comp_UserByItem($LangId, $compid) { global $upd_link_db;
	global $TABLE_COMPANY_ITEMS;

	$user_id = 0;

	$query = "SELECT * FROM $TABLE_COMPANY_ITEMS WHERE id='$compid'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$user_id = $row->author_id;
		}
		mysqli_free_result( $res );
	}

	return $user_id;
}

function Comp_Items($LangId, $typeid=0, $topicid=0, $parenttopic=false, $oblid=0, $pi=0, $pn=20, $userid=0, $withpostnum=false, $sortby="", $srchtxt="", $srchintext=false) { global $upd_link_db;
	global $TABLE_COMPANY_TOPIC, $TABLE_COMPANY_ITEMS, $TABLE_COMPANY_ITEMS2TOPIC, $TABLE_ADV_POST, $REGIONS;

	$psect = Array();
	$query = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id=0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$psect[$row->id] = stripslashes($row->title);
		}
		mysqli_free_result( $res );
	}

	$limit_cond = "";
	if( $pi > 0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
	}
	if( ($pi == -10) || ($pi == 0))
	{
		$limit_cond = " LIMIT 0,$pn ";
	}

	$sel_cond = " ";

	if( $oblid != 0 )
		$sel_cond .= " AND p1.obl_id=".$oblid." ";
	if( $userid != 0 )
		$sel_cond .= " AND p1.author_id=".$userid." ";
	else
		$sel_cond .= " AND p1.visible=1 ";
	
	if( $srchintext && ($srchtxt != "") )
	{
		$sel_cond .= " AND ((p1.title LIKE '%".addslashes($srchtxt)."%') OR (p1.short LIKE '%".addslashes($srchtxt)."%') OR (p1.content LIKE '%".addslashes($srchtxt)."%')) ";
	}
	else if( $srchtxt != "" )
		$sel_cond .= " AND p1.title LIKE '%".addslashes($srchtxt)."%' ";

	if( $sel_cond != "" )
		$sel_cond = " WHERE p1.id>0 ".$sel_cond;

	$topic_cond = "";
	if( ($topicid != 0) && !$parenttopic )
		$topic_cond = " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC i2t ON p1.id=i2t.item_id AND i2t.topic_id=".$topicid." ";
	else if( ($topicid != 0) && $parenttopic )
		$topic_cond = " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC i2t ON p1.id=i2t.item_id
			INNER JOIN $TABLE_COMPANY_TOPIC t1 ON i2t.topic_id=t1.id AND t1.parent_id=".$topicid." ";

	/*
 	$query = "SELECT p1.*, t1.title as topic, t1.parent_id, YEAR(p1.add_date) as dy, MONTH(p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd,
 			HOUR(p1.add_date) as dh, MINUTE(p1.add_date) as dmm, YEAR(CURDATE()) as cy, MONTH(CURDATE()) as cm, DAYOFMONTH(CURDATE()) as cd
 		FROM $TABLE_ADV_POST p1
 		INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id ".( ($topicid != 0) && $parenttopic ? " AND t1.parent_id='".$topicid."' " : "")."
 		$sel_cond
 		ORDER BY up_dt DESC
 		$limit_cond
 	";
 	*/

 	$sort_cond = " p1.add_date DESC ";
 	switch( $sortby )
 	{
 		case "rand":
 			$sort_cond = " RAND() ";
 			break;
			
		case "calcrate":
			$sort_cond = " p1.rate_formula DESC ";
			break;
			
		case "viewrate":
			$sort_cond = " p1.rate DESC ";
			break;
 	}

	$query = "SELECT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg, DATEDIFF(NOW(), p1.add_date) as dtage 
	FROM $TABLE_COMPANY_ITEMS p1
	$topic_cond
	$sel_cond
	ORDER BY $sort_cond
	$limit_cond
	";

 	//echo "<br />$topicid:".$parenttopic." - ".$query."<br />";

 	$its = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['vis'] = $row->visible;
			$it['title'] = stripslashes($row->title);
			$it['titlefull'] = stripslashes($row->title_full);
			$it['text'] = stripslashes($row->content);
			$it['short'] = stripslashes($row->short);
			$it['contacts'] = stripslashes($row->contacts);
			$it['bname'] = stripslashes($row->author);
			$it['bphone'] = stripslashes($row->phone);
			$it['bemail'] = stripslashes($row->email);
			$it['bcity'] = stripslashes($row->city);
			$it['logo'] = stripslashes($row->logo_file);
			$it['logo_w'] = stripslashes($row->logo_file_w);
			$it['logo_h'] = stripslashes($row->logo_file_h);
			//$it['topic'] = stripslashes($row->topic);
			$it['obl_id'] = $row->obl_id;
			$it['type_id'] = $row->type_id;
			$it['topic_id'] = $row->topic_id;
			$it['dt'] = $row->add_date;
			$it['dt_age'] = $row->dtage;	// in days
			$it['dt_str'] = $row->dtreg;
			
			$it['trader'] = $row->trader_price_avail;
			$it['trader_vis'] = $row->trader_price_visible;
			$it['trader_trans'] = $row->trader_price_transpon;
			$it['trader_transcmp'] = $row->trader_pricecmp_transpon;
			
			$it['trader2'] = $row->trader_price_sell_avail;
			$it['trader2_vis'] = $row->trader_price_sell_visible;
			$it['trader2_trans'] = $row->trader_price_sell_transpon;
			

			//$it['dt'] = $row->add_date;
			//$it['dt'] = sprintf("%02d.%02d.%04d %02d:%02d", $row->dd, $row->dm, $row->dy, $row->dh, $row->dmm);
			//$it['dt_short'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

			$it['obl'] = $REGIONS[$row->obl_id];

			$it['posts'] = 0;
			/*
			$query1 = "SELECT count(*) as totposts FROM $TABLE_ADV_POST WHERE company_id=".$row->id;
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				if( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$it['posts'] = $row1->totposts;
				}
				mysqli_free_result( $res1 );
			}
			*/

			//$it['ptopic_id'] = $row->parent_id;
			//$it['ptopic'] = ( ($it['ptopic_id'] != 0) && (isset($psect[$it['ptopic_id']])) ? $psect[$it['ptopic_id']] : '' );

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Comp_ItemInfo($LangId, $compid) { global $upd_link_db;
	global $TABLE_COMPANY_ITEMS2TOPIC, $TABLE_COMPANY_TOPIC, $TABLE_COMPANY_ITEMS, $REGIONS;


	$psect = Array();
	$query = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id=0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$psect[$row->id] = stripslashes($row->title);
		}
		mysqli_free_result( $res );
	}


 	//$query = "SELECT p1.*, t1.title as topic, t1.parent_id FROM $TABLE_COMPANY_ITEMS p1
 	//	INNER JOIN $TABLE_COMPANY_TOPIC t1 ON p1.topic_id=t1.id
 	//	WHERE p1.id='".$compid."'";
 	$query = "SELECT p1.*, DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') as pr_update_dt, DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') as pr2_update_dt 
		FROM $TABLE_COMPANY_ITEMS p1 WHERE p1.id='".$compid."'";

 	$it = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it['id'] = $row->id;
			$it['author_id'] = $row->author_id;
			$it['title'] = stripslashes($row->title);
			$it['title_full'] = stripslashes($row->title_full);
			$it['text'] = stripslashes($row->content);
			$it['short'] = stripslashes($row->short);
			$it['contacts'] = stripslashes($row->contacts);
			$it['bname'] = stripslashes($row->author);
			$it['bphone'] = stripslashes($row->phone);
			$it['bphone2'] = stripslashes($row->phone2);
			$it['bfax'] = stripslashes($row->phone3);
			$it['bemail'] = stripslashes($row->email);
			$it['bwww'] = stripslashes($row->www);
			$it['bcity'] = stripslashes($row->city);
			$it['baddr'] = stripslashes($row->addr);
			$it['bzip'] = stripslashes($row->zipcode);
			$it['logo'] = stripslashes($row->logo_file);
			$it['logo_w'] = stripslashes($row->logo_file_w);
			$it['logo_h'] = stripslashes($row->logo_file_h);
			$it['headpic'] = stripslashes($row->head_file);
			//$it['topic'] = stripslashes($row->topic);
			$it['vis'] = $row->visible;
			$it['obl_id'] = $row->obl_id;
			$it['ray_id'] = $row->ray_id;
			$it['type_id'] = $row->type_id;
			$it['topic_id'] = $row->topic_id;
			
			$it['trader'] = $row->trader_price_avail;
			$it['trader_vis'] = $row->trader_price_visible;
			$it['trader_transpon'] = $row->trader_price_transpon;
			$it['trader_pr_update'] = $row->pr_update_dt;
			
			$it['trader2'] = $row->trader_price_sell_avail;
			$it['trader2_vis'] = $row->trader_price_sell_visible;
			$it['trader2_transpon'] = $row->trader_price_sell_transpon;
			$it['trader2_pr_update'] = $row->pr2_update_dt;
			
			$it['msngr_mail_notify'] = $row->msngr_mail_notify;
			
			$it['site_pack'] = $row->site_pack_id;

			$it['rate'] = $row->rate;
			$it['rate_formula'] = $row->rate_formula;
			$it['dt'] = $row->add_date;

			$it['obl'] = $REGIONS[$row->obl_id];

			//$it['ctopicid'] = 0;

			//$it['ptopic_id'] = $row->parent_id;
			//$it['ptopic'] = ( $it['ptopic_id'] != 0 ? $psect[$it['ptopic_id']] : '' );

			$titems = Array();

			$query1 = "SELECT t1.* FROM $TABLE_COMPANY_ITEMS2TOPIC i1
				INNER JOIN $TABLE_COMPANY_TOPIC t1 ON i1.topic_id=t1.id
				WHERE i1.item_id=".$row->id;
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					//$it['ctopicid'] = $row1->id;

					$ti = Array();
					$ti['id'] = $row1->id;
					$ti['pid'] = $row1->parent_id;
					$ti['ptopic'] = ( $ti['pid'] != 0 ? $psect[$ti['pid']] : '' );
					$ti['name'] = stripslashes($row1->title);
					$titems[] = $ti;
				}
				mysqli_free_result( $res1 );
			}

			$it['topics'] = $titems;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $it;
}

function Comp_ItemContacts($buyer_id, $comp_id, $conttype=0) { global $upd_link_db;
	global $TABLE_COMPANY_CONTACTS;

	$conts = Array();

	if( ($buyer_id == 0) && ($comp_id == 0) )
	{
		// no contacts
	}	
	else if( $conttype == 0 )
	{
		// no contacts
	}
	else
	{
		//$query = "SELECT * FROM $TABLE_COMPANY_CONTACTS WHERE comp_id='$comp_id' AND type_id='$conttype' ORDER BY sort_num, dolg, region";
		$query = "SELECT * FROM $TABLE_COMPANY_CONTACTS WHERE ".( $buyer_id != 0 ? " buyer_id='$buyer_id' " : " comp_id='$comp_id' " )." AND type_id='$conttype' ORDER BY sort_num, dolg, region";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$cont = Array();
				$cont['id'] = $row->id;
				$cont['region'] = stripslashes($row->region);
				$cont['dolg'] = stripslashes($row->dolg);
				$cont['fio'] = stripslashes($row->fio);
				$cont['tel'] = stripslashes($row->phone);
				$cont['fax'] = stripslashes($row->fax);
				$cont['email'] = stripslashes($row->email);
				$cont['sort'] = stripslashes($row->sort_num);

				$conts[] = $cont;
			}
			mysqli_free_result( $res );
		}
	}

	return $conts;
}

function Comp_UpdateRate2($comp_id, $viewtype_id, $ip) { global $upd_link_db;
	global $TABLE_COMPANY_RATE, $TABLE_COMPANY_RATE_DATETMP;
	
	// First check if this is allowed by ip once more this day
	$num_this_ip = 0;
	$id_this_ip = 0;
	
	$resrate = Array("today" => 0, "wasadd" => false, "total" => 0, "type" => $viewtype_id, "func" => "comp");
	
	$query = "SELECT * FROM $TABLE_COMPANY_RATE_DATETMP WHERE item_id='".$comp_id."' AND metrictype='".$viewtype_id."' AND dt=CURDATE() AND ip LIKE '".addslashes($ip)."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$id_this_ip = $row->id;
			$num_this_ip = $row->amount;
		}
		mysqli_free_result( $res );
	}
	
	$resrate["today"] = $num_this_ip;
	
	if( $num_this_ip == 0 )
	{
		// Add new
		$query = "INSERT INTO $TABLE_COMPANY_RATE_DATETMP (item_id, metrictype, amount, dt, add_time, ip) 
			VALUES ('".$comp_id."', '".$viewtype_id."', 1, CURDATE(), NOW(), '".addslashes($ip)."')";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo "ins: ".mysqli_error($upd_link_db);
		}
	}
	else
	{		
		$query = "UPDATE $TABLE_COMPANY_RATE_DATETMP SET amount=(amount+1), add_time=NOW() WHERE id='$id_this_ip'";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo "upd: ".mysqli_error($upd_link_db);
		}
	}

	// Calculate daily item rate
	$daily_rate_id = 0;
	$daily_total = 0;
	
	if( $num_this_ip >= 2 )
	{
		return $resrate; //($num_this_ip+1);
	}
	
	$resrate["wasadd"] = true;
	
	$query = "SELECT * FROM $TABLE_COMPANY_RATE WHERE item_id='".$comp_id."' AND metrictype='".$viewtype_id."' AND dt=CURDATE()";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$daily_rate_id = $row->id;
			$daily_total = $row->amount;
		}
		mysqli_free_result( $res );
	}
	
	$resrate["total"] = $daily_total;

	if( $daily_rate_id == 0 )
	{
		$query = "INSERT INTO $TABLE_COMPANY_RATE (item_id, metrictype, dt, amount) VALUES ('".$comp_id."', '".$viewtype_id."', CURDATE(), 1)";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	else
	{
		$query = "UPDATE $TABLE_COMPANY_RATE SET amount=amount+1 WHERE id=$daily_rate_id";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	
	$resrate["today"]++;
	$resrate["total"] += 1;
	
	return $resrate;	//($num_this_ip+1);
}

function Comp_UpdateRate($comp_id) { global $upd_link_db;
	global $TABLE_COMPANY_RATE;

	// Calculate daily item rate
	$daily_rate_id = 0;

	$query = "SELECT * FROM $TABLE_COMPANY_RATE WHERE item_id='".$comp_id."' AND dt=CURDATE()";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$daily_rate_id = $row->id;
		}
		mysqli_free_result( $res );
	}

	if( $daily_rate_id == 0 )
	{
		$query = "INSERT INTO $TABLE_COMPANY_RATE (item_id, dt, amount) VALUES ('".$comp_id."', CURDATE(), 1)";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
	else
	{
		$query = "UPDATE $TABLE_COMPANY_RATE SET amount=amount+1 WHERE id=$daily_rate_id";
		if( !mysqli_query($upd_link_db, $query ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}
}

function Comp_CommentNum($comp_id, $author_id=0, $reply_to=0) { global $upd_link_db;
	global $TABLE_COMPANY_COMMENT;

	$comments_num = 0;

	if( $reply_to != 0 )
	{
		$query = "SELECT count(*) as totcomments FROM $TABLE_COMPANY_COMMENT WHERE visible=1 AND reply_to_id='$reply_to'";
	}
	else if( $comp_id != 0 )
	{
		$query = "SELECT count(*) as totcomments FROM $TABLE_COMPANY_COMMENT WHERE item_id='$comp_id' AND visible=1 AND reply_to_id=0";
	}
	else
	{
		$query = "SELECT count(*) as totcomments FROM $TABLE_COMPANY_COMMENT WHERE author_id='$author_id' AND visible=1 AND reply_to_id=0";
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$comments_num = $row->totcomments;
		}
		mysqli_free_result( $res );
	}

	return $comments_num;
}

function Comp_CommentAvgRate($comp_id) { global $upd_link_db;
	global $TABLE_COMPANY_COMMENT;

	$resp_avg = 0;

	$query = "SELECT avg(rate) as avgrate FROM $TABLE_COMPANY_COMMENT WHERE item_id='$comp_id' AND visible=1 AND reply_to_id=0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$resp_avg = ($row->avgrate != null ? round($row->avgrate) : 0);
		}
		mysqli_free_result( $res );
	}

	return $resp_avg;
}

function Comp_Comments($LangId, $comp_id, $pi=-1, $pn=20, $dtsqltpl="", $viewer_id=0, $sortby="", $commentid=0) { global $upd_link_db;
	global $TABLE_COMPANY_COMMENT, $TABLE_COMPANY_COMMENT_LANGS, $TABLE_COMPANY_COMMENT_LIKES, $TABLE_COMPANY_ITEMS;

	$coms = Array();

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pn*$pi).",$pn ";
	}

	$dtsqlfmt = '%H:%i:%s %d.%m.%Y';
	if( $dtsqltpl != "" )
		$dtsqlfmt = $dtsqltpl;
	
	$sql_join = "";
	$sql_fld = "";
	if( $viewer_id != 0 )
	{
		$sql_fld = ", r1.id as likeid, r1.like_yesno ";
		$sql_join = " LEFT JOIN $TABLE_COMPANY_COMMENT_LIKES r1 ON c1.id=r1.comment_id AND r1.author_id='$viewer_id' ";
	}	
	
	$sort_cond_rep = " add_date ";
	$sort_cond = " add_date DESC ";
	if( $sortby == "popular" )
	{
		$sort_cond = " totlike DESC ";
	}
	
	$com_cond = "";
	if( $commentid != 0 )
	{
		$com_cond = " AND c1.id='".addslashes($commentid)."' ";
	}

	$query = "";
	if( $comp_id != 0 )
	{
		$query = "SELECT c1.*, (c1.like_yes + c1.like_no) as totlike, DATE_FORMAT(c1.add_date, '$dtsqlfmt') as dtstr, DATEDIFF(NOW(), c1.add_date) as daydiff, 
				c2.content, c2.content_plus, c2.content_minus, 
				k1.id as compid, k1.logo_file_w, k1.logo_file_h, k1.logo_file, k1.title as comptitle $sql_fld 
			FROM $TABLE_COMPANY_COMMENT c1
			INNER JOIN $TABLE_COMPANY_COMMENT_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
			LEFT JOIN $TABLE_COMPANY_ITEMS k1 ON c1.author_id=k1.author_id 
			$sql_join
			WHERE c1.item_id='$comp_id' AND c1.visible=1 AND c1.reply_to_id=0 $com_cond  
			ORDER BY $sort_cond
			$limit_cond";
	}
	else if( $viewer_id != 0 )
	{
		$query = "SELECT c1.*, (c1.like_yes + c1.like_no) as totlike, DATE_FORMAT(c1.add_date, '$dtsqlfmt') as dtstr, DATEDIFF(NOW(), c1.add_date) as daydiff, 
				c2.content, c2.content_plus, c2.content_minus, 
				cm1.id as tcompid, cm1.logo_file_w as logo_w, cm1.logo_file_h as logo_h, cm1.logo_file as logo, cm1.title as tcomptitle, 
				k1.id as compid, k1.logo_file_w, k1.logo_file_h, k1.logo_file, k1.title as comptitle $sql_fld 
			FROM $TABLE_COMPANY_COMMENT c1
			INNER JOIN $TABLE_COMPANY_ITEMS cm1 ON c1.item_id=cm1.id 
			INNER JOIN $TABLE_COMPANY_COMMENT_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
			LEFT JOIN $TABLE_COMPANY_ITEMS k1 ON c1.author_id=k1.author_id 
			$sql_join
			WHERE c1.author_id='$viewer_id' AND c1.visible=1 AND c1.reply_to_id=0 $com_cond  
			ORDER BY $sort_cond
			$limit_cond";
			
		//echo $query."<br>";
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ci = Array();
			$ci['id'] = $row->id;
			$ci['comp_id'] = $row->item_id;
			$ci['author_id'] = $row->author_id;
			$ci['author'] = stripslashes($row->author);
			
			if( $comp_id == 0 )
			{
				$ci['tcomp_id'] = $row->item_id;
				$ci['tcomp_name'] = stripslashes($row->tcomptitle);
				$ci['tlogo'] = stripslashes($row->logo);
				$ci['tlogo_w'] = $row->logo_w;
				$ci['tlogo_h'] = $row->logo_h;
			}
			
			//$ci['sort'] = $row->sort_num;
			$ci['show'] = $row->visible;
			$ci['rate'] = $row->rate;
			$ci['like_y'] = $row->like_yes;
			$ci['like_n'] = $row->like_no;
			$ci['like_byme'] = ( ($viewer_id != 0) && isset($row->likeid) && ($row->likeid != null) ? 1 : 0 );
			$ci['author_cid'] = ( $row->compid != null ? $row->compid : 0 );
			$ci['ctitle'] = '';
			$ci['logo'] = '';
			$ci['logo_w'] = 0;
			$ci['logo_h'] = 0;
			if( $ci['author_cid'] != 0 )
			{
				$ci['ctitle'] = stripslashes($row->comptitle);
				$ci['logo'] = stripslashes($row->logo_file);
				$ci['logo_w'] = $row->logo_file_w;
				$ci['logo_h'] = $row->logo_file_h;
			}
			$ci['dt0'] = $row->add_date;
			$ci['dt'] = $row->dtstr;
			$ci['daydiff'] = $row->daydiff;
			$ci['comment'] = stripslashes($row->content);
			$ci['comment_plus'] = ( $row->content_plus != null ? stripslashes($row->content_plus) : "" );
			$ci['comment_minus'] = ( $row->content_minus != null ? stripslashes($row->content_minus) : "" );
			
			$ci['replies'] = Array();
			
			$query1 = "SELECT c1.*, (c1.like_yes + c1.like_no) as totlike, DATE_FORMAT(c1.add_date, '$dtsqlfmt') as dtstr, DATEDIFF(NOW(), c1.add_date) as daydiff, 
					c2.content, c2.content_plus, c2.content_minus,  
					k1.id as compid, k1.logo_file_w, k1.logo_file_h, k1.logo_file, k1.title as comptitle $sql_fld
				FROM $TABLE_COMPANY_COMMENT c1
				INNER JOIN $TABLE_COMPANY_COMMENT_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
				LEFT JOIN $TABLE_COMPANY_ITEMS k1 ON c1.author_id=k1.author_id  
				$sql_join 
				WHERE c1.item_id='".$ci['comp_id']."' AND c1.visible=1 AND c1.reply_to_id='".$row->id."' 
				ORDER BY $sort_cond_rep 
				".( $commentid != 0 ? "" : " LIMIT 0,4" )." ";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$ci1 = Array();
					$ci1['id'] = $row1->id;
					$ci1['author_id'] = $row1->author_id;
					$ci1['author'] = stripslashes($row1->author);
					//$ci['sort'] = $row->sort_num;
					$ci1['show'] = $row1->visible;
					$ci1['rate'] = $row1->rate;
					$ci1['like_y'] = $row1->like_yes;
					$ci1['like_n'] = $row1->like_no;
					$ci1['like_byme'] = ( ($viewer_id != 0) && isset($row1->likeid) && ($row1->likeid != null) ? 1 : 0 );
					$ci1['author_cid'] = ( $row1->compid != null ? $row1->compid : 0 );
					$ci1['ctitle'] = '';
					$ci1['logo'] = '';
					$ci1['logo_w'] = 0;
					$ci1['logo_h'] = 0;
					if( $ci1['author_cid'] != 0 )
					{
						$ci1['ctitle'] = stripslashes($row1->comptitle);
						$ci1['logo'] = stripslashes($row1->logo_file);
						$ci1['logo_w'] = $row1->logo_file_w;
						$ci1['logo_h'] = $row1->logo_file_h;
					}
					$ci1['dt0'] = $row1->add_date;
					$ci1['dt'] = $row1->dtstr;
					$ci1['daydiff'] = $row1->daydiff;
					$ci1['comment'] = stripslashes($row1->content);
					$ci1['comment_plus'] = "";
					$ci1['comment_minus'] = "";

					$ci['replies'][] = $ci1;
				}
				mysqli_free_result( $res1 );
			}
			

			$coms[] = $ci;
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);

	return $coms;
}

/*
function Board_PostPhotosNum($prod_id) { global $upd_link_db;
	global $TABLE_ADV_POST_PICS;

	$photos_num = 0;

	$query = "SELECT count(*) as totpic FROM $TABLE_ADV_POST_PICS WHERE item_id='$prod_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$photos_num = $row->totpic;
		}
		mysqli_free_result( $res );
	}

	return $photos_num;
}

function Board_PostPhotos($LangId, $prod_id, $pn=0) { global $upd_link_db;
	global $TABLE_ADV_POST_PICS, $PICHOST;

	$photos = Array();

	$limit_cond = "";
	if( $pn > 0 )
	{
		$limit_cond = " LIMIT 0,$pn ";
	}

	$query = "SELECT * FROM $TABLE_ADV_POST_PICS WHERE item_id='$prod_id' ORDER BY sort_num $limit_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$pic = Array();
			$pic['id']      = $row->file_id;
			$pic['title']   = stripslashes($row->title);
			$pic['thumb']   = ( stripslashes($row->filename_thumb) != "" ? $PICHOST.stripslashes($row->filename_thumb) : '' );
			$pic['ico']     = ( stripslashes($row->filename_ico) != "" ? $PICHOST.stripslashes($row->filename_ico) : '' );
			$pic['src']     = ( stripslashes($row->filename) != "" ? $PICHOST.stripslashes($row->filename) : '' );
			//$pic['src']     = ( stripslashes($row->filename_big) != "" ? $PICHOST.stripslashes($row->filename_big) : '' );
			$pic['ico_w']   = $row->ico_w;
			$pic['ico_h']   = $row->ico_h;
			$pic['thumb_w'] = $row->thumb_w;
			$pic['thumb_h'] = $row->thumb_h;
			//$pic['src_w']   = $row->src_w;
			//$pic['src_h']   = $row->src_h;
			$pic['src_w']   = $row->big_w;
			$pic['src_h']   = $row->big_h;

			$photos[] = $pic;
		}
		mysqli_free_result( $res );
	}

	return $photos;
}
*/

function Comp_DefTitles($LangId, $trade=0, $cult_name="") { global $upd_link_db;
	global $TORG_BUY;

	$trade_str = Array("", "Покупка ", "Продажа ", "Услуги ");

	$result = Array();

	$orgtitle	= ( $cult_name == "" ? "аграрные компании" : $cult_name )." __cityname3__ __oblname2__ от Агротендер";
	$orgkeyw	= ( $cult_name == "" ? "аграрные компании" : $cult_name ).", __oblname__, каталог";
	$orgdescr	= "В каталоге компаний от Агротендер Вы всегда сможете найти информацию про ".( $cult_name == "" ? "аграрные компании" : $cult_name )." __cityname3__ __oblname2__, а так же их актуальные закупки и продажи";
	$orgh1		= "Каталог – ".( $cult_name == "" ? "Аграрная продукция" : $cult_name )." __cityname3__ __oblname2__";
	$orgtext	= $trade_str[$trade].( $cult_name == "" ? "Аграрная продукция" : $cult_name)." в __cityname2__ __oblname2__";

	$result['title'] = $orgtitle;
	$result['descr'] = $orgdescr;
	$result['keyw']	= $orgkeyw;
	$result['h1']	= $orgh1;
	$result['txt']	= $orgtext;

    return $result;
}


// NEW 07.2014
function Comp_News_Num($compid) { global $upd_link_db;
	global $TABLE_COMPANY_NEWS;

	$tot_num = 0;

	$query1 = "SELECT count(*) as totnum FROM $TABLE_COMPANY_NEWS WHERE comp_id=".$compid;
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$tot_num = $row1->totnum;
		}
		mysqli_free_result( $res1 );
	}

	return $tot_num;
}

function Comp_News_List($compid, $sortby="") { global $upd_link_db;
	global $TABLE_COMPANY_NEWS;

	$its = Array();

	$sort_cond = " add_date DESC ";
	if( $sortby == "down" )
	{
		$sort_cond = " add_date ASC ";
	}

	$query1 = "SELECT * FROM $TABLE_COMPANY_NEWS WHERE comp_id=".$compid." ORDER BY ".$sort_cond;
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$it = Array();
			$it['id'] = $row1->id;
			$it['visible'] = $row1->visible;
			$it['dt'] = $row1->add_date;
			$it['title'] = stripslashes($row1->title);
			$it['text'] = stripslashes($row1->content);
			$it['ico'] = stripslashes($row1->pic_ico);
			$its[] = $it;
		}
		mysqli_free_result( $res1 );
	}

	return $its;
}

function Comp_News_Item($compid, $nid) { global $upd_link_db;
	global $TABLE_COMPANY_NEWS;

	$it = Array();

	$query1 = "SELECT * FROM $TABLE_COMPANY_NEWS WHERE comp_id=".$compid." AND id='$nid'";
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$it = Array();
			$it['id'] = $row1->id;
			$it['visible'] = $row1->visible;
			$it['dt'] = $row1->add_date;
			$it['title'] = stripslashes($row1->title);
			$it['text'] = stripslashes($row1->content);
			$it['ico'] = stripslashes($row1->pic_ico);
		}
		mysqli_free_result( $res1 );
	}

	return $it;
}

function Comp_News_Delete($newsid) { global $upd_link_db;
	global $TABLE_COMPANY_NEWS;

	$query1 = "SELECT * FROM $TABLE_COMPANY_NEWS WHERE id=".$newsid;
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			if( ($row1->pic_src != "") && file_exists(stripslashes($row1->pic_src)) )
				@unlink(stripslashes($row1->pic_src));
			if( ($row1->pic_ico != "") && file_exists(stripslashes($row1->pic_ico)) )
				@unlink(stripslashes($row1->pic_ico));
		}
		mysqli_free_result( $res1 );
	}


	$query = "DELETE FROM $TABLE_COMPANY_NEWS WHERE id=".$newsid;
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}
}

function Comp_Vac_Num($compid) { global $upd_link_db;
	global $TABLE_COMPANY_VACANCY;

	$tot_num = 0;

	$query1 = "SELECT count(*) as totnum FROM $TABLE_COMPANY_VACANCY WHERE comp_id=".$compid;
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$tot_num = $row1->totnum;
		}
		mysqli_free_result( $res1 );
	}

	return $tot_num;
}

function Comp_Vac_List($compid, $sortby="") { global $upd_link_db;
	global $TABLE_COMPANY_VACANCY;

	$its = Array();

	$sort_cond = " add_date DESC ";
	if( $sortby == "down" )
	{
		$sort_cond = " add_date ASC ";
	}

	$query1 = "SELECT * FROM $TABLE_COMPANY_VACANCY WHERE comp_id=".$compid." ORDER BY ".$sort_cond;
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$it = Array();
			$it['id'] = $row1->id;
			$it['visible'] = $row1->visible;
			$it['dt'] = $row1->add_date;
			$it['title'] = stripslashes($row1->title);
			$it['text'] = stripslashes($row1->content);
			$its[] = $it;
		}
		mysqli_free_result( $res1 );
	}

	return $its;
}

function Comp_Vac_Item($compid, $vid) { global $upd_link_db;
	global $TABLE_COMPANY_VACANCY;

	$it = Array();

	$query1 = "SELECT * FROM $TABLE_COMPANY_VACANCY WHERE comp_id=".$compid." AND id='$vid'";
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$it = Array();
			$it['id'] = $row1->id;
			$it['visible'] = $row1->visible;
			$it['dt'] = $row1->add_date;
			$it['title'] = stripslashes($row1->title);
			$it['text'] = stripslashes($row1->content);
		}
		mysqli_free_result( $res1 );
	}

	return $it;
}

function Comp_Vac_Delete($newsid) { global $upd_link_db;
	global $TABLE_COMPANY_VACANCY;

	/*
	$query1 = "SELECT * FROM $TABLE_COMPANY_VACANCY WHERE id=".$newsid;
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			if( ($row1->pic_src != "") && file_exists(stripslashes($row1->pic_src)) )
				@unlink(stripslashes($row1->pic_src));
			if( ($row1->pic_ico != "") && file_exists(stripslashes($row1->pic_ico)) )
				@unlink(stripslashes($row1->pic_ico));
		}
		mysqli_free_result( $res1 );
	}
	*/

	$query = "DELETE FROM $TABLE_COMPANY_VACANCY WHERE id=".$newsid;
	if( !mysqli_query($upd_link_db, $query ) )
	{
		echo mysqli_error($upd_link_db);
	}
}

function Company_CabTopic_List($compid, $pid, $typeid) { global $upd_link_db;
	global $TABLE_COMPANY_ADVTOPICS;

	$tlist = Array();

	$query = "SELECT * FROM $TABLE_COMPANY_ADVTOPICS WHERE comp_id='$compid' AND parent_id='$pid' AND type_id='$typeid' ORDER BY sort_num, name";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ti = Array();
			$ti['id'] = $row->id;
			$ti['pid'] = $row->parent_id;
			$ti['sort'] = $row->sort_num;
			$ti['name'] = stripslashes($row->name);

			$tlist[] = $ti;
		}
		mysqli_free_result( $res );
	}

	return $tlist;
}

function Company_CabTopic_Info($compid, $tid) { global $upd_link_db;
	global $TABLE_COMPANY_ADVTOPICS;

	$ti = Array();

	$query = "SELECT * FROM $TABLE_COMPANY_ADVTOPICS WHERE comp_id='$compid' AND id='$tid'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$ti = Array();
			$ti['id'] = $row->id;
			$ti['pid'] = $row->parent_id;
			$ti['sort'] = $row->sort_num;
			$ti['name'] = stripslashes($row->name);
		}
		mysqli_free_result( $res );
	}

	return $ti;
}

function Company_CabTopic_BuildTree($compid, $view_type, $urlgo="") { global $upd_link_db;
	$tlev_html = '';

	if( $urlgo == "" )
	{
		$urlgo = 'bcab_posts.php?viewcomp=1&viewtype='.$view_type.'';
	}

	$tlev0 = Company_CabTopic_List($compid, 0, $view_type);

	for( $j=0; $j<count($tlev0); $j++ )
	{
        $tlev1 = Company_CabTopic_List($compid, $tlev0[$j]['id'], $view_type);

		$tlev_html .= '<li id="tl'.$tlev0[$j]['id'].'"><a href="'.$urlgo.'&ctopicid='.$tlev0[$j]['id'].'">'.$tlev0[$j]['name'].'</a>';
		if( count($tlev1) == 0 )
			$tlev_html .= '<a href="#" class="tlevdel" onclick="return deltsect('.$tlev0[$j]['id'].')"></a>';
		$tlev_in_html = '<ul>';
		for( $i=0; $i<count($tlev1); $i++ )
		{
			$tlev_in_html .= '<li id="tl'.$tlev1[$i]['id'].'"><a href="'.$urlgo.'&ctopicid='.$tlev1[$i]['id'].'">'.$tlev1[$i]['name'].'</a><a href="#" class="tlevdel" onclick="return deltsect('.$tlev1[$i]['id'].')"></a></li>';
		}
		$tlev_in_html .= '<li id="last'.$tlev0[$j]['id'].'" class="tliadd"><a class="tlev_add" href="#" rel="'.$tlev0[$j]['id'].'"><span>Добавить раздел</span></a></li>
		</ul>';
		$tlev_html .= $tlev_in_html.'</li>';
	}
	$tlev_html .= '<li id="last0" class="tliadd"><a class="tlev_add" href="#" rel="0"><span>Добавить раздел</span></a></li>';

	$tlev_html = '<ul class="tlev">'.$tlev_html.'</ul>';

	return $tlev_html;
}

function Company_CabTopic_BuildCombo($compid, $view_type, $lastlevelid = false, $withpostnum=false, $seltopicid=0) { global $upd_link_db;
	$tlev_html = '';

	//if( $urlgo == "" )
	//{
	//	$urlgo = 'bcab_posts.php?viewcomp=1&viewtype='.$view_type.'';
	//}

	$tlev0 = Company_CabTopic_List($compid, 0, $view_type);
	
	$tlev_html .= '<option value="0">'.( $withpostnum ? 'Все разделы' : '--- Корневой раздел ---' ).'</option>';

	for( $j=0; $j<count($tlev0); $j++ )
	{
        $tlev1 = Company_CabTopic_List($compid, $tlev0[$j]['id'], $view_type);

		//$tlev_html .= '<li id="tl'.$tlev0[$j]['id'].'"><a href="'.$urlgo.'&ctopicid='.$tlev0[$j]['id'].'">'.$tlev0[$j]['name'].'</a>';
		//if( count($tlev1) == 0 )
		//	$tlev_html .= '<a href="#" class="tlevdel" onclick="return deltsect('.$tlev0[$j]['id'].')"></a>';
	
		$tnumposts = 0;
		if( $withpostnum )
			$tnumposts = count_PostsInTopic($tlev0[$j]['id']);
	
		$tlev_html .= '<option value="'.$tlev0[$j]['id'].'"'.($seltopicid == $tlev0[$j]['id'] ? ' selected' : '').'>&nbsp;&nbsp;&nbsp; '.$tlev0[$j]['name'].( $withpostnum ? ' ('.$tnumposts.')' : '' ).'</option>';
	
		$tlev_in_html = '';
		//$tlev_in_html = '<ul>';		
		for( $i=0; $i<count($tlev1); $i++ )
		{
			//$tlev_in_html .= '<li id="tl'.$tlev1[$i]['id'].'"><a href="'.$urlgo.'&ctopicid='.$tlev1[$i]['id'].'">'.$tlev1[$i]['name'].'</a><a href="#" class="tlevdel" onclick="return deltsect('.$tlev1[$i]['id'].')"></a></li>';
			//$tlev_in_html .= '<option value="'.$tlev1[$i]['id'].'">'.$tlev1[$i]['name'].'</option>';
			
			$tnumposts = 0;
			if( $withpostnum )
				$tnumposts = count_PostsInTopic($tlev1[$i]['id']);
			
			$tlev_in_html .= '<option value="'.($lastlevelid || $withpostnum ? $tlev1[$i]['id'] : 0).'"'.($seltopicid == $tlev1[$i]['id'] ? ' selected' : '').'>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; '.$tlev1[$i]['name'].( $withpostnum ? ' ('.$tnumposts.')' : '' ).'</option>';
		}
		//$tlev_in_html .= '<li id="last'.$tlev0[$j]['id'].'" class="tliadd"><a class="tlev_add" href="#" rel="'.$tlev0[$j]['id'].'"><span>Добавить раздел</span></a></li>
		//</ul>';
		//$tlev_html .= $tlev_in_html.'</li>';
		$tlev_html .= $tlev_in_html;
	}
	//$tlev_html .= '<li id="last0" class="tliadd"><a class="tlev_add" href="#" rel="0"><span>Добавить раздел</span></a></li>';

	//$tlev_html = '<ul class="tlev">'.$tlev_html.'</ul>';

	return $tlev_html;
}


function Comp_Moder_List($userid, $mode = "all", $withobl = false) { global $upd_link_db;
	global $TABLE_TORG_BUYERS_MODERATORS, $TABLE_TORG_BUYERS;
	
	$sql_cond = "";
	if( $mode == "approved" )
	{
		$sql_cond = " AND m1.activated=1 ";
	}
	
	$its = Array();
	
	$query = "SELECT m1.*, u1.name, u1.login 
		FROM $TABLE_TORG_BUYERS_MODERATORS m1 
		INNER JOIN $TABLE_TORG_BUYERS u1 ON m1.moder_user_id=u1.id 
		WHERE m1.owner_id='$userid' $sql_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['user_id'] = $row->moder_user_id;
			$it['login'] = stripslashes($row->login);
			$it['name'] = stripslashes($row->name);
			$it['active'] = $row->activated;
			$it['dis'] = $row->disabled;
			$it['allow_pbuy'] = $row->allow_pbuy;
			$it['allow_psell'] = $row->allow_psell;
			$it['allow_pserv'] = $row->allow_pserv;
			$it['allow_msngr'] = $row->allow_msngr;
			$it['allow_elev'] = $row->allow_elev;
			$it['allow_contact'] = $row->allow_contact;
			$it['allow_price'] = $row->allow_price;
			$it['adddt'] = $row->add_date;
			
			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	
	return $its;
}


// Fishki
function Fishka_NumUsed($UserId) { global $upd_link_db;
	global $TABLE_FISHKA;

	$numused = 0;

	$query = "SELECT count(*) as totnum FROM $TABLE_FISHKA WHERE user_id='$UserId' AND active=1 AND running=1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$numused = $row->totnum;
		}
		mysqli_free_result( $res );
	}

	return $numused;
}

function Fishka_NumTotal($UserId) { global $upd_link_db;
	global $TABLE_FISHKA;

	$numused = 0;

	$query = "SELECT count(*) as totnum FROM $TABLE_FISHKA WHERE user_id='$UserId'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$numused = $row->totnum;
		}
		mysqli_free_result( $res );
	}

	return $numused;
}

function Fishka_FindFree($UserId) { global $upd_link_db;
	global $TABLE_FISHKA;

	$fish = Array("fid" => 0, "upok" => true);

	//$query = "SELECT * FROM $TABLE_FISHKA WHERE user_id='$UserId' AND active=0 AND NOW()>DATE_ADD(up_dt, INTERVAL 4 HOUR)";
	//$query = "SELECT * FROM $TABLE_FISHKA WHERE user_id='$UserId' AND running=0";
	$query = "SELECT * FROM $TABLE_FISHKA WHERE user_id='$UserId' AND active=0";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$fish['fid'] = $row->id;
		}
		mysqli_free_result( $res );
	}

	if( $fish['fid'] == 0 )
	{
		$query = "SELECT * FROM $TABLE_FISHKA WHERE user_id='$UserId' AND active=1 AND running=0";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			if( $row = mysqli_fetch_object( $res ) )
			{
				$fish['fid'] = $row->id;
				$fish['upok'] = false;
			}
			mysqli_free_result( $res );
		}
	}

	return $fish;
}

function Fishka_CheckPost($postid) { global $upd_link_db;
	global $TABLE_FISHKA;

	$isused = Array("used" => false, "date" => "");

	$query = "SELECT *, TIMESTAMPDIFF(MINUTE,add_date,NOW()) as mindiff FROM $TABLE_FISHKA WHERE post_id='$postid'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$isused = Array("used" => true, "id" => $row->id, "date" => $row->add_date, "up" => $row->up_dt, "tmdiff" => $row->mindiff, "active" => $row->active);
		}
		mysqli_free_result( $res );
	}

	return $isused;
}

// istrader = $LENTA_ALL=-1, $LENTA_SIMPLE=0, $LENTA_TRADER=2
function Lenta_GetItems($istrader=-1, $author_id=0, $comp_id=0, $type_id=0, $topic_id=0, $pi=0, $pn=20) { global $upd_link_db;
	global $TABLE_LENTA, $LENTA_TNEWCOST, $LENTA_TNEWCOSTSELL;

	$its = Array();

	$cond = "";
	if($author_id != 0)
	{
		$cond = " author_id='$author_id' ";
	}
	if($comp_id != 0)
	{
		$cond .= ($cond != "" ? " AND " : "")." comp_id='$comp_id' ";
	}
	else
	{
		$cond .= ($cond != "" ? " AND " : "")." only_same_comp=0 ";
	}
	
	if( $istrader != -1 )
	{
		$cond .= ($cond != "" ? " AND " : "")." lenta='$istrader' ";
	}

	if( is_array($type_id) )
	{
		$cond .= ($cond != "" ? " AND " : "")." type_id IN (".implode(",", $type_id).") ";
	}
	else if( $type_id != 0 )
	{
		$cond .= ($cond != "" ? " AND " : "")." type_id='$type_id' ";
	}
	else
	{
		//$cond .= ($cond != "" ? " AND " : "")." type_id='$type_id' ";
		//$cond .= ($cond != "" ? " AND " : "")." type_id<>'$LENTA_TNEWCOST' AND type_id<>'$LENTA_TNEWCOST' ";
		$cond .= ($cond != "" ? " AND " : "")." ( (type_id<>'$LENTA_TNEWCOST') AND (type_id<>'$LENTA_TNEWCOSTSELL') ) ";
	}

	if( is_array($topic_id)  )
	{
		$cond .= ($cond != "" ? " AND " : "")." topic_id IN (".implode(",", $topic_id).") ";
	}
	else if( $topic_id != 0 )
	{
		$cond .= ($cond != "" ? " AND " : "")." topic_id='$topic_id' ";
	}

	$query = "SELECT *, DATE_FORMAT(add_date, '%H:%i') as addtm, TIME_TO_SEC(TIMEDIFF(NOW(), up_dt)) as secdiff, DATE_FORMAT(NOW(), '%d.%m.%Y') as nowdt,  DATE_FORMAT(add_date, '%d.%m.%Y') as updt 
		FROM $TABLE_LENTA ".( $cond != "" ? " WHERE ".$cond : "" )." 
		ORDER BY up_dt 
		DESC LIMIT ".($pi*$pn).",$pn";
	//echo $query."<br />";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['post_id'] = $row->post_id;
			$it['other_id'] = $row->other_id;
			$it['type_id'] = $row->type_id;
			$it['topic_id'] = $row->topic_id;
			$it['comp_id'] = $row->comp_id;
			$it['author'] = stripslashes($row->author);
			$it['title'] = stripslashes($row->title);
			$it['difsec'] = $row->secdiff;
			$it['add_tm'] = $row->addtm;
			$it['add_or_udt'] = ($row->add_date == $row->up_dt);
			$it['today'] = ($row->nowdt == $row->updt);
			$it['difstr'] = "";

			//echo "ID: ".$row->id." - ".$row->secdiff." - ".$row->tmdiff."<br />";

			$updt_str = ( $it['add_or_udt'] ? "Добавлено" : "Обновлено" );

			if( $it['difsec'] <= 60 )
			{
				$it['difstr'] = $updt_str." ".$it['difsec']." сек. назад";
			}
			else if( $it['difsec'] <= 3600 )
			{
				$it['difstr'] = $updt_str." ".( floor($it['difsec'] / 60) )." мин. ".($it['difsec'] % 60)." сек. назад";
			}
			else if( $it['difsec'] > 3600*24 )
			{
				$dv = floor($it['difsec'] / (3600*24));
				$hv = floor( ($it['difsec'] - ($dv*3600*24)) / 3600 );
				$it['difstr'] = $updt_str." ".$dv." дн. ".$hv." ч. назад";
			}
			else
			{
				$hv = floor($it['difsec'] / 3600);
				$mv = floor( ($it['difsec'] - ($hv*3600)) / 60 );
				$sv = ( $it['difsec'] - ($hv*3600) - $mv*60 );
				$it['difstr'] = $updt_str." ".$hv." ч. ".$mv." мин. ".$sv." сек. назад";
			}

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Lenta_BuildHtml($LangId, $istrader, $seltype_id, $submode_topic=0, $maxnum = 20, $version = 0) { global $upd_link_db;
	global $PHP_SELF, $BOARD_PTYPE_BUY, $BOARD_PTYPE_SELL, $BOARD_PTYPE_SERV, $PICHOST;
	global $LENTA_TPOSTBUY, $LENTA_TPOSTSELL, $LENTA_TPOSTSERV, $LENTA_TNEWCOMP, $LENTA_TNEWNEWS, $LENTA_TNEWVAC, $LENTA_TNEWCOST, $LENTA_TNEWCOSTSELL;

	$out_html = '';

	$its = Lenta_GetItems($istrader, 0, 0, $seltype_id, (isset($submode_topic) ? $submode_topic : 0), 0, $maxnum);

	for( $i=0; $i<count($its); $i++ )
	{
		$css_type_class = "";
		$css_type_class2 = "";
		switch($its[$i]['type_id'])
		{
			case $BOARD_PTYPE_BUY:
				$css_type_class = "rit-buy";
				break;
			case $BOARD_PTYPE_SELL:
				$css_type_class = "rit-prod";
				break;
			case $BOARD_PTYPE_SERV:
				$css_type_class = "rit-serv";
				break;
			default:
				$css_type_class = "rit-news";
				break;
		}

		switch($its[$i]['type_id'])
       	{
       		case $LENTA_TPOSTBUY:
       		case $LENTA_TPOSTSELL:
       		case $LENTA_TPOSTSERV:
       			$GOURL = Board_BuildUrl($LangId, "itemcomp", "", $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['post_id']);
       			break;
       		case $LENTA_TNEWCOMP:
       			$GOURL = Comp_BuildUrl($LangId, "item", "", 0, 0, $its[$i]['other_id']);
       			break;
       		case $LENTA_TNEWNEWS:
       			$GOURL = Comp_BuildUrl($LangId, "newsitem", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
       			break;
       		case $LENTA_TNEWVAC:
       			$GOURL = Comp_BuildUrl($LangId, "vacitem", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
       			break;
       		case $LENTA_TNEWCOST:
       			$GOURL = Comp_BuildUrl($LangId, "pricetbl", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
				$its[$i]['title'] = str_replace("{PRTURL}", $GOURL, $its[$i]['title']);
				$css_type_class2 = "ilenta-it-prbuy";
       			break;
			case $LENTA_TNEWCOSTSELL:
       			$GOURL = Comp_BuildUrl($LangId, "pricetblsell", "", 0, 0, $its[$i]['comp_id'], $its[$i]['other_id']);
				$its[$i]['title'] = str_replace("{PRTURL}", $GOURL, $its[$i]['title']);
				$css_type_class2 = "ilenta-it-prsell";
       			break;
       	}

		$any_type_id = $its[$i]['type_id'];

		//$POSTURL = Board_BuildUrl($LangId, "item", $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['id']);
		//$POSTURL = Board_BuildUrl($LangId, "item", "", $its[$i]['type_id'], $its[$i]['topic_id'], $its[$i]['post_id']);		
		
		if( $version == 1515 )
		{
			$compi = Comp_ItemInfo($LangId, $its[$i]['comp_id']);
			//$yand = "yaCounter117048.reachGoal('".(preg_match ("/traders/", $_SERVER[PHP_SELF] ) ? 'LentaTrader' : 'LentaAllPages')."')";
			$yand = "";
			if( isset($_SERVER[$PHP_SELF]) )
				$yand = "yaCounter117048.reachGoal('".(preg_match ("/traders/", $_SERVER[$PHP_SELF] ) ? 'LentaTrader' : 'LentaAllPages')."')";
			$out_html .= '<li>
				<div class="ilenta-it '.$css_type_class2.'">
					<table onclick="'.$yand.'">
					<tr>
						<td>'.( ($compi['logo'] != null) && ($compi['logo'] != "") ? '<a href="'.$GOURL.'" onclick="'.$yand.'"><img src="'.$PICHOST.$compi['logo'].'" alt="'.$compi['title'].'" width="50" /></a>' : '').'
						<div class="ilenta-it-tm"><span>'.( $its[$i]['today'] ? $its[$i]['add_tm'] :'Вчера' ).'</span></div>						
						</td>
						<td><strong>'.$its[$i]['author'].'</strong><br/><a href="'.$GOURL.'" onclick="'.$yand.'">'.( false && (strlen(strip_tags($its[$i]['title'])) > 57) ? substr(strip_tags($its[$i]['title']), 0, 56)."..." : $its[$i]['title'] ).'</a></td>
					</tr>
					</table>


				</div>
			</li>';
			//echo $_SERVER[PHP_SELF];
		}
		else if( $version == 15 )
		{		
			$yand="yaCounter117048.reachGoal('LentaRight')";
			$out_html .= '<div class="lenta-adv-it" onclick="'.$yand.'">
				<a href="'.$GOURL.'">

				<div class="lenta-adv-who">'.$its[$i]['author'].'</div>
				<div class="lenta-adv-tit">'.$its[$i]['title'].'</div>
				<p>'.$its[$i]['difstr'].'</p>
				</a>
			</div>';
		}
		else
		{
			$out_html .= '<div class="rit'.($i % 2 == 0 ? ' rit-even' : '').($css_type_class != "" ? ' '.$css_type_class : '').'">
				<div>'.$its[$i]['author'].'</div>
				<a href="'.$GOURL.'">'.$its[$i]['title'].'</a>
				<p>'.$its[$i]['difstr'].'</p>
			</div>';
		}
	}

	return $out_html;
}

/* Trader contacts */
function Trader_GetContRegions($LangId, $comp_id) { global $upd_link_db;
	global $TABLE_TRADER_PR_CONTACTS_REGS;
	
	$its = Array();
	
	$query = "SELECT * FROM $TABLE_TRADER_PR_CONTACTS_REGS WHERE comp_id='".$buyer_id."' ORDER BY sort_num, name";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['name'] = stripslashes($row->name);
			$it['sort'] = $row->sort_num;
			$its[] = $it;			
		}
		mysqli_free_result($res);
	}
	
	return $its;
}

function Trader_GetContRegionIten($LangId, $reg_id) { global $upd_link_db;
	global $TABLE_TRADER_PR_CONTACTS_REGS;
	
	$it = Array("id" => 0);
	
	$query = "SELECT * FROM $TABLE_TRADER_PR_CONTACTS_REGS WHERE id='".$reg_id."'";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['name'] = stripslashes($row->name);
			$it['sort'] = $row->sort_num;
		}
		mysqli_free_result($res);
	}
	
	return $it;
}

function Trader_GetConts($LangId, $comp_id, $sort="") { global $upd_link_db;
	global $TABLE_TRADER_PR_CONTACTS, $TABLE_TRADER_PR_CONTACTS_REGS;

	$its = Array();

	$query = "SELECT r1.id as regid, r1.name as regname, c1.* FROM $TABLE_TRADER_PR_CONTACTS_REGS r1  
		LEFT JOIN $TABLE_TRADER_PR_CONTACTS c1 ON r1.id=c1.region_id 
		WHERE r1.comp_id='".$comp_id."' 
		ORDER BY r1.sort_num, r1.name, c1.sort_num, c1.fio";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{
			$it = Array();			
			$it['region'] = stripslashes($row->regname);
			$it['region_id'] = $row->regid;
			$it['id'] = 0;
			if( isset($row->id) && ($row->id != null) && ($row->id != 0) )
			{
				$it['id'] = $row->id;
				$it['fio'] = stripslashes($row->fio);
				$it['dolg'] = stripslashes($row->dolg);
				$it['tel'] = stripslashes($row->phone);
				$it['fax'] = stripslashes($row->fax);
				$it['email'] = stripslashes($row->email);
				$it['sort'] = $row->sort_num;
			}
			$its[] = $it;		
		}
		mysqli_free_result($res);
	}

	return $its;
}

function Trader_GetContItem($LangId, $cont_id) { global $upd_link_db;
	global $TABLE_TRADER_PR_CONTACTS, $TABLE_TRADER_PR_CONTACTS_REGS;

	$it = Array("id" => 0);

	$query = "SELECT r1.id as regid, r1.name as regname, c1.* FROM $TABLE_TRADER_PR_CONTACTS c1 
		INNER JOIN $TABLE_TRADER_PR_CONTACTS_REGS r1 ON r1.id=c1.region_id 
		WHERE c1.id='".$cont_id."'";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{
			$it = Array();			
			$it['region'] = stripslashes($row->regname);
			$it['region_id'] = $row->regid;
			$it['id'] = 0;
			//if( isset($row->id) && ($row->id != null) && ($row->id != 0) )
			//{
				$it['id'] = $row->id;
				$it['fio'] = stripslashes($row->fio);
				$it['dolg'] = stripslashes($row->dolg);
				$it['tel'] = stripslashes($row->phone);
				$it['fax'] = stripslashes($row->fax);
				$it['email'] = stripslashes($row->email);
				$it['sort'] = $row->sort_num;
			//}
			//$its[] = $it;		
		}
		mysqli_free_result($res);
	}

	return $it;
}

/* Trader prices */
function Trader_Prices_BuildUrl($acttype, $trid, $trurl, $oblurl="", $culturl="", $porturl="", $onlyport="") { global $upd_link_db;
	global $WWWHOST;

	if( $trid != 0 )
	{
		return $WWWHOST."traders/".$trid."-".$trurl;//.".html";
	}
	
	$url = "";
	
	//echo "!".$oblurl."!".$typeurl."!".$culturl."<br>";
	if( ($oblurl == "") && ($porturl == "") && ($culturl == "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "");//.".html";
	}
	else if( ($oblurl == "") && ($porturl == "") && ($culturl != "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/region_ukraine/".$culturl;//.".html";
	}
	else if( ($oblurl == "") && ($porturl != "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/tport_".$porturl."/".($culturl == "" ? "index" : $culturl);//.".html";
	}
	else if( ($oblurl != "") && ($porturl == "") )
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/region_".$oblurl."/".($culturl == "" ? "index" : $culturl);//.".html";
	}
	else
	{
		$url = "traders".($acttype == 1 ? "_sell" : "")."/region_".$oblurl."_tport_".$porturl."/".($culturl == "" ? "index" : $culturl);//.".html";
	}
	
	$url .= ($onlyport == "yes" ? "?showportonly=yes" : "");
	
	//$url = "traders/region_".$oblurl."/".($culturl == "" ? "index" : $culturl).".html".($onlyport == "" ? "" : "?showportonly=yes");

	return $WWWHOST.$url;
}
/*
function Trader_Prices_BuildUrl($acttype, $trid, $trurl, $oblurl="", $culturl="", $typeurl="", $onlyport="") { global $upd_link_db;
	global $WWWHOST;

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


function Trader_GetTypes($LangId) { global $upd_link_db;
	global $TABLE_TRADER_TYPES;
	
	$ttypes = Array();
	$query = "SELECT t1.* FROM $TABLE_TRADER_TYPES t1 ORDER BY t1.sort_num, t1.name";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$ti = Array();
			$ti['id'] = $row->id;
			$ti['name'] = stripslashes($row->name);
			$ti['url'] = stripslashes($row->url);
			$ti['checked'] = false;
			
			$ttypes[] = $ti;
		}
		mysqli_free_result($res);
	}	
	
	return $ttypes;
}

function Trader_GetPlaces($LangId, $buyer_id, $type_id=-1, $sort="", $acttype=0, $withpricenum=false) { global $upd_link_db;
	global $TABLE_TRADER_PR_PLACES, $TABLE_TRADER_PR_PORTS, $TABLE_TRADER_PR_PORTS_LANGS, $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PRICESARC;

	$sql_cond = "";
	$sort_cond = " type_id, obl_id, place";
	if( $sort == "typedown" )
		$sort_cond = " type_id DESC, obl_id, place";
	if( $type_id >= 0 )
	{
		$sql_cond = " AND type_id='".$type_id."' ";
	}

	$its = Array();

	$query = "SELECT * FROM $TABLE_TRADER_PR_PLACES 
		WHERE buyer_id='".$buyer_id."' AND acttype='$acttype' ".$sql_cond." 
		ORDER BY ".$sort_cond;
	if( $withpricenum )
	{
		$query = "SELECT p1.*, count(pr1.id) as prnum, count(pr2.id) as prarcnum 
			FROM $TABLE_TRADER_PR_PLACES p1 
			LEFT JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.id=pr1.place_id 
			LEFT JOIN $TABLE_TRADER_PR_PRICESARC pr2 ON p1.id=pr2.place_id 
			WHERE p1.buyer_id='".$buyer_id."' AND p1.acttype='$acttype' ".$sql_cond." 
			GROUP BY p1.id 
			ORDER BY ".$sort_cond;
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['obl_id'] = $row->obl_id;
			$it['type_id'] = $row->type_id;
			$it['place'] = stripslashes($row->place);
			$it['place0'] = stripslashes($row->place);
			$it['port_id'] = $row->port_id;
			$it['port_name'] = "";
			
			$it['price_num'] = 0;
			$it['pricea_num'] = 0;
			if( $withpricenum )
			{
				$it['price_num'] = $row->prnum;
				$it['pricea_num'] = $row->prarcnum;
			}
			
			$it['seo_title'] = '';
			$it['seo_h1'] = '';
			$it['seo_descr'] = '';
			$it['seo_text'] = '';
			if( $row->port_id != 0 )
			{
				$query1 = "SELECT p1.*, p2.portname, p2.p_title, p2.p_h1, p2.p_descr, p2.p_content 
					FROM $TABLE_TRADER_PR_PORTS p1 
					INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
					WHERE p1.id='".$row->port_id."'";
				if( $res1 = mysqli_query($upd_link_db,$query1) )
				{
					while($row1 = mysqli_fetch_object($res1) )
					{
						$it['port_name'] = stripslashes($row1->portname);
						
						$it['place'] = stripslashes($row1->portname).( $it['place'] != "" ? " - ".$it['place'] : "" );
						
						$it['seo_title'] = stripslashes($row1->p_title);
						$it['seo_h1'] = stripslashes($row1->p_h1);
						$it['seo_descr'] = stripslashes($row1->p_descr);
						$it['seo_text'] = stripslashes($row1->p_content);
					}
					mysqli_free_result($res1);
				}
				//else
				//	echo mysqli_error($upd_link_db)."<br>";
			}

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}

	return $its;
}

function Trader_GetPlaceInfo($LangId, $place_id) { global $upd_link_db;
	global $TABLE_TRADER_PR_PLACES, $TABLE_TRADER_PR_PORTS, $TABLE_TRADER_PR_PORTS_LANGS;

	$it = Array("id" => 0);

	$query = "SELECT * FROM $TABLE_TRADER_PR_PLACES WHERE id='".$place_id."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['obl_id'] = $row->obl_id;
			$it['type_id'] = $row->type_id;
			$it['place'] = stripslashes($row->place);
			$it['port_id'] = $row->port_id;
			
			$it['seo_title'] = '';
			$it['seo_h1'] = '';
			$it['seo_descr'] = '';
			$it['seo_text'] = '';
			
			if( $row->port_id != 0 )
			{
				$query1 = "SELECT p1.*, p2.portname, p2.p_title, p2.p_h1, p2.p_descr, p2.p_content 
					FROM $TABLE_TRADER_PR_PORTS p1 
					INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
					WHERE p1.id='".$row->port_id."'";
				if( $res1 = mysqli_query($upd_link_db,$query1) )
				{
					while($row1 = mysqli_fetch_object($res1) )
					{
						$it['place'] = stripslashes($row1->portname);
						
						$it['seo_title'] = stripslashes($row1->p_title);
						$it['seo_h1'] = stripslashes($row1->p_h1);
						$it['seo_descr'] = stripslashes($row1->p_descr);
						$it['seo_text'] = stripslashes($row1->p_content);
					}
					mysqli_free_result($res1);
				}
			}
		}
		mysqli_free_result( $res );
	}

	return $it;
}

function Trader_GetPortList($LangId, $obl_id=0, $buyer_id=0, $onlyactive=false) { global $upd_link_db;
	global $TABLE_TRADER_PR_PORTS, $TABLE_TRADER_PR_PORTS_LANGS, $TABLE_TRADER_PR_PLACES;
	
	$sql_cond = "";
	if( is_array($obl_id) && (count($obl_id)>0) )
	{
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." p1.obl_id IN (".implode(",", $obl_id).") ";
	}
	else if( is_numeric($obl_id) && ($obl_id != 0) )
	{
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." p1.obl_id='".$obl_id."' ";
	}
	if( $onlyactive )
	{
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." p1.active=1 ";
	}
	
	$ports = Array();			
	$query = "SELECT p1.*, p2.portname 
		FROM $TABLE_TRADER_PR_PORTS p1 
		INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
		$sql_cond 
		ORDER BY p1.obl_id, p2.portname";
	if( $buyer_id > 0 )
	{
		$query = "SELECT pl1.id as placeid, pl1.place as placename, p1.*, p2.portname 
			FROM $TABLE_TRADER_PR_PLACES pl1 
			INNER JOIN $TABLE_TRADER_PR_PORTS p1 ON pl1.port_id=p1.id 
			INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
			WHERE pl1.buyer_id='$buyer_id' 
			ORDER BY p1.obl_id, p2.portname";				
	}
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
			$pp['placeid'] = 0;
			$pp['placename'] = "";
			if( $buyer_id > 0)
			{
				$pp['placeid'] = $row->placeid;
				$pp['placename'] = stripslashes($row->placename);
			}
			
			$ports[] = $pp;					
		}
		mysqli_fetch_object($res);
	}
	
	return $ports;
}

function Trader_GetPortInfo($LangId, $portid=0) { global $upd_link_db;
	global $TABLE_TRADER_PR_PORTS, $TABLE_TRADER_PR_PORTS_LANGS;
	
	$sql_cond = "";
	//if( $obl_id != 0 )
	//{
	//	$sql_cond .= " AND p1.obl_id='".$obl_id."' ";
	//}
	
	$port = Array("id" => 0);
	$query = "SELECT p1.*, p2.portname, p2.p_title, p2.p_h1, p2.p_descr, p2.p_content  
		FROM $TABLE_TRADER_PR_PORTS p1 
		INNER JOIN $TABLE_TRADER_PR_PORTS_LANGS p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId' 
		WHERE p1.id='".addslashes($portid)."' $sql_cond ";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$pp = Array();
			$port['id'] = $row->id;
			$port['obl_id'] = $row->obl_id;
			$port['url'] = stripslashes($row->url);			
			$port['act'] = $row->active;
			
			$port['name'] = stripslashes($row->portname);
			
			$port['seo_title'] = stripslashes($row->p_title);
			$port['seo_h1'] = stripslashes($row->p_h1);
			$port['seo_descr'] = stripslashes($row->p_descr);
			$port['seo_text'] = stripslashes($row->p_content);
		}
		mysqli_fetch_object($res);
	}
	
	return $port;
}

function Trader_GetCultGroups($LangId, $sort="", $acttype=0) { global $upd_link_db;
	global $TABLE_TRADER_PR_CULT_GROUPS, $TABLE_TRADER_PR_CULT_GROUPS_LANGS;

	$sql_cond = "";
	$sort_cond = " g1.sort_num, g2.name";
	if( $sort == "name" )
		$sort_cond = " g2.name";

	$its = Array();

	$query = "SELECT g1.*, g2.name FROM $TABLE_TRADER_PR_CULT_GROUPS g1
		INNER JOIN $TABLE_TRADER_PR_CULT_GROUPS_LANGS g2 ON g1.id=g2.item_id AND g2.lang_id='$LangId'
		WHERE g1.acttype='$acttype' ".$sql_cond." ORDER BY ".$sort_cond;
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['sort'] = $row->sort_num;
			$it['name'] = stripslashes($row->name);

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);

	return $its;
}

function Trader_GetCults($LangId, $buyer_id, $sortby="", $modeall=false, $group_id=0, $type_id=-1, $acttype=0, $xml = null) { global $upd_link_db;
	global $TABLE_TRADER_PR_CULTS, $TABLE_TRADER_PR_CULTS_LANGS, $TABLE_TRADER_PR_CULTS2BUYER;

	$sql_cond = "";
	$sort_cond = " c2.name";

	if( $sortby == "tradersort" )
		$sort_cond = " c2b.sort_ind, c2.name";

	if( $group_id != 0 )
		$sql_cond = " WHERE c1.group_id='$group_id' ";
	if ($xml != null) {
      $sql_cond .= ($sql_cond != '') ? "&& c1.acttype = $acttype" : "where c1.acttype = $acttype";
	}
	$notype_mode = false;
	
	$distinct = "";
	$type_cond = "";
	if( $type_id == -2 )
	{
		$distinct = " DISTINCT ";
		$notype_mode = true;
	}
	else if( $type_id != -1 )
		$type_cond = " AND c2b.type_id='$type_id' ";	

	$its = Array();

	if( $buyer_id != 0 )
	{
		if( $notype_mode )
		{
			$query = "SELECT $distinct c1.*, c2.name 
			FROM $TABLE_TRADER_PR_CULTS2BUYER c2b
			INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON c2b.cult_id=c1.id ".( $group_id != 0 ? " AND c1.group_id='$group_id' " : "" )."
			INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
			WHERE c2b.buyer_id='".$buyer_id."' AND c2b.acttype='$acttype' $type_cond ORDER BY ".$sort_cond;
		}
		else if( $modeall )
		{
			$query = "SELECT c1.*, c2.name, c2b.id as b2id, c2b.sort_ind, case when c2b.id IS NULL then 0 else c2b.sort_ind end as sortind
			FROM $TABLE_TRADER_PR_CULTS c1
			INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
			LEFT JOIN $TABLE_TRADER_PR_CULTS2BUYER c2b ON c1.id=c2b.cult_id AND c2b.buyer_id='".$buyer_id."' AND c2b.acttype='$acttype' $type_cond 
			$sql_cond
			ORDER BY ".$sort_cond;
		}
		else
		{
			$query = "SELECT c2b.sort_ind, c2b.id as b2id, c1.*, c2.name 
			FROM $TABLE_TRADER_PR_CULTS2BUYER c2b
			INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON c2b.cult_id=c1.id ".( $group_id != 0 ? " AND c1.group_id='$group_id' " : "" )."
			INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
			WHERE c2b.buyer_id='".$buyer_id."' AND c2b.acttype='$acttype' $type_cond ORDER BY ".$sort_cond;
		}
	}
	else
	{
		$query = "SELECT c1.*, c2.name
			FROM $TABLE_TRADER_PR_CULTS c1
			INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
			$sql_cond
			ORDER BY ".$sort_cond;
	}
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['url'] = stripslashes($row->url);
			$it['name'] = stripslashes($row->name);
			$it['sort'] = (($buyer_id == 0) || ($notype_mode) ? 0 : ( $row->sort_ind != null ? $row->sort_ind : 0 ));
			$it['b2id'] = (($buyer_id == 0) || ($notype_mode) ? 0 : ( $row->b2id != null ? $row->b2id : 0 ));

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}

	return $its;
}

function Trader_CultInfo($LangId, $cult_id) { global $upd_link_db;
	global $TABLE_TRADER_PR_CULTS, $TABLE_TRADER_PR_CULTS_LANGS;
	
	$cult = Array("id" => 0);
	
	$query = "SELECT c1.*, c2.name 
		FROM $TABLE_TRADER_PR_CULTS c1 
		INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
		WHERE c1.id='".$cult_id."'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$cult['id'] = $row->id;
			$cult['url'] = stripslashes($row->url);
			$cult['name'] = stripslashes($row->name);
		}
		mysqli_free_result( $res );
	}
	//else
	//	echo mysqli_error($upd_link_db);
	
	return $cult;
}

function Trader_GetItemCost($buyer_id, $cult_id, $place_id, $curtype, $acttype=0) { global $upd_link_db;
	global $TABLE_TRADER_PR_PRICES;

	$cost = null;

	$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES WHERE buyer_id='".$buyer_id."' AND cult_id='".$cult_id."' AND place_id='".$place_id."' AND curtype='$curtype' AND acttype='$acttype'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$cost = $row->costval;
		}
		mysqli_free_result( $res );
	}

	return $cost;
}

function Trader_GetItemCostVal($buyer_id, $cult_id, $place_id, $curtype, $acttype=0) { global $upd_link_db;
	global $TABLE_TRADER_PR_PRICES;

	$val = '';

	$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES WHERE buyer_id='".$buyer_id."' AND cult_id='".$cult_id."' AND place_id='".$place_id."' AND curtype='$curtype' AND acttype='$acttype'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$val = stripslashes($row->comment);
		}
		mysqli_free_result( $res );
	}

	return $val;
}

function Trader_GetItemCostWithPrev($buyer_id, $cult_id, $place_id, $curtype, $acttype=0) { global $upd_link_db;
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PRICESARC;

	$cost = Array("cur" => null, "prev" => null);

	$src_date = "0000-00-00 00:00:00";	

	$query = "SELECT * FROM $TABLE_TRADER_PR_PRICES WHERE buyer_id='".$buyer_id."' AND cult_id='".$cult_id."' AND place_id='".$place_id."' AND curtype='$curtype' AND acttype='$acttype'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$cost['cur'] = $row->costval;
			$cost['txt'] = stripslashes($row->comment);
			$src_date = $row->add_date;
		}
		mysqli_free_result( $res );
	}

	$query = "SELECT * FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$buyer_id."' AND cult_id='".$cult_id."' AND place_id='".$place_id."' AND curtype='$curtype' AND acttype='$acttype' AND dt=DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$cost['prev'] = $row->costval;
		}
		mysqli_free_result( $res );
	}

	return $cost;
}

function Trader_GetItemCostCmp($buyer_id, $acttype, $cult_id, $place_id, $curtype, $cmpmode, $d1st, $d1en, $d2st, $d2en) { global $upd_link_db;
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PRICESARC;

	$cost1 = null;
	$cost2 = null;

	$query = "SELECT AVG(costval) as avgval FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$buyer_id."' AND cult_id='".$cult_id."' AND place_id='".$place_id."' AND curtype='$curtype' AND acttype='$acttype' AND dt>='".$d1st."' AND dt<='".$d1en."'";
	//echo $query." [1]<br />";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$cost1 = number_format($row->avgval, 2, ".", "");
			//echo $cost1."<br />";
		}
		mysqli_free_result( $res );
	}

	if( $cmpmode )
	{
		$query = "SELECT AVG(costval) as avgval FROM $TABLE_TRADER_PR_PRICESARC WHERE buyer_id='".$buyer_id."' AND cult_id='".$cult_id."' AND place_id='".$place_id."' AND curtype='$curtype' AND acttype='$acttype' AND dt>='".$d2st."' AND dt<='".$d2en."'";
		//echo $query."<br />";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			if( $row = mysqli_fetch_object( $res ) )
			{
				$cost2 = number_format($row->avgval, 2, ".", "");
				//echo $cost2."<br />";
			}
			mysqli_free_result( $res );
		}
	}

	return Array("pr1" => $cost1, "pr2" => $cost2);
}

// Get number of proposal in trader module
function fltnum_ByAllOpts($obl_id, $type_id, $cult_id, $isport=false, $acttype=0, $port_id=null) { global $upd_link_db;
	global $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PLACES, $TABLE_TRADER_PR_CULTS, $TABLE_TORG_BUYERS, $TABLE_COMPANY_ITEMS, $TABLE_TRADER_TYPES2ITEMS;
	
	$totnum = 0;
	
	$join_cond = "";
	
	$type_cond = "";
	$obl_cond = "";
	$cult_cond = "";
	$port_cond = "";
		
	if( count($obl_id)>0 )
	{
		$obl_cond = " AND pl1.obl_id IN (".implode(",", $obl_id).") ";
	}
	else if( is_numeric($obl_id) && ($obl_id != 0) )
	{
		$obl_cond = " AND pl1.obl_id='$obl_id' ";
	}
	
	if( $isport )
	{
		$port_cond = " AND pl1.type_id='1' ";
	}
		
	if( is_numeric($port_id) && ($port_id == -1) )
	{
		$port_cond = " AND pl1.port_id<>0 ";
	}
	else if( is_numeric($port_id) && ($port_id != 0) )
	{
		$port_cond = " AND pl1.port_id='$port_id' ";
	}
	else if( ($port_id != null) && (count($port_id)>0) )
	{
		$port_cond = " AND pl1.port_id IN (".implode(",", $port_id).") ";
	}
	
	if( count($type_id)>0 )
	{
		$type_cond = " AND t1.type_id IN (".implode(",", $type_id).") ";
	}
	else if( is_numeric($type_id) && ($type_id != 0) )
	{
		$type_cond = " AND t1.type_id='$type_id' ";
	}
	
	if( count($cult_id)>0 )
	{
		$cult_cond = " AND pr1.cult_id IN (".implode(",", $cult_id).") ";
	}
	else if( is_numeric($cult_id) && ($cult_id != 0) )
	{
		$cult_cond = " AND pr1.cult_id='$cult_id' ";
	}
	
	$query = "SELECT count(DISTINCT b1.id) as tottraders 
		FROM $TABLE_TRADER_PR_PRICES pr1 
		INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id $obl_cond $port_cond 
		INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON pr1.cult_id=c1.id 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON pr1.buyer_id=b1.id
	    INNER JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id AND ".( $acttype == 1 ? " i1.trader_price_sell_avail=1 AND i1.trader_price_sell_visible=1 " : " i1.trader_price_avail=1 AND i1.trader_price_visible=1 " )."
		".( $type_cond != "" ? " INNER JOIN $TABLE_TRADER_TYPES2ITEMS t1 ON i1.id=t1.item_id $type_cond " : "" )."
		WHERE pr1.costval<>'0' AND pr1.acttype='$acttype' $cult_cond ";
	
	//if( $_SERVER['REMOTE_ADDR'] == '77.120.133.226' )
	//{
		//echo "!!";
		//echo "<br>".$query."<br>";	
	//}
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

function Trader_GetList2($obl=null, $type=null, $cult=null, $port=null, $showportonly="", $premiumonly=false, $acttype=0, $curtype=-1) { global $upd_link_db;
	global $TABLE_COMPANY_ITEMS, $TABLE_TRADER_PR_PRICES, $TABLE_TRADER_PR_PLACES, $TABLE_TRADER_TYPES2ITEMS;
	global $WWWHOST, $REGIONS;
	
	$cur_sql_cond = "";
	if( $curtype >= 0 )
	{
		$cur_sql_cond = " AND pr1.curtype=".($curtype == 1 ? "1" : "0")." ";
	}
	
	$trlist = Array();
	if( (count($obl) > 0) || (count($cult) > 0) || (count($type) > 0) || (count($port) > 0) )
	{
		$sql_cond = "";
		$join_cond = "";
		
		$port_cond = "";			

		if( count($obl) > 0 )
		{
			if( $showportonly == "yes" )
			{
				$port_cond = " AND pl1.port_id<>0 ";
			}
			if( count($port) > 0 )
			{
				$port_cond .= " AND pl1.port_id IN (".implode(",", $port).") ";
			}
		
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond ".( count($cult) > 0 ? " AND pr1.cult_id IN (".implode(",",$cult).") " : "" )."
			INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.obl_id IN (".implode(",", $obl).") $port_cond ";
		}
		else if( count($cult)> 0 )
		{			
			if( count($port) > 0 )
			{
				$port_cond = " INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.port_id IN (".implode(",", $port).") ";
			}
			else if( $showportonly == "yes" )
			{
				//$port_cond = " INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1 ";
				$port_cond = " INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.port_id<>0 ";
			}
			
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond AND pr1.cult_id IN (".implode(",",$cult).") $port_cond ";
		}		
		else if( count($port)>0 )
		{
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond 
			INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.port_id IN (".implode(",", $port).") ";
		}
		else if( $showportonly == "yes" )
		{
			//$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond 
			//INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1 ";
			$join_cond = " INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond 
			INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.port_id<>0 ";
		}
		
		if( count($type) > 0 )
		{
			$join_cond .= " INNER JOIN $TABLE_TRADER_TYPES2ITEMS t2i ON p1.id=t2i.item_id AND t2i.type_id IN (".implode(",",$type).") ";
		}

		if( $acttype == 1 )
		{
			$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
			case when p1.trader_price_sell_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
			FROM $TABLE_COMPANY_ITEMS p1
			$join_cond
			WHERE p1.trader_price_sell_avail=1 AND p1.trader_price_sell_visible=1 ".($premiumonly ? ' AND p1.trader_premium_sell=1 ' : '' )."
			ORDER BY p1.trader_sort_sell, p1.rate_formula DESC, p1.title
			";
		}
		else
		{
			$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
			case when p1.trader_price_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
			FROM $TABLE_COMPANY_ITEMS p1
			$join_cond
			WHERE p1.trader_price_avail=1 AND p1.trader_price_visible=1 ".($premiumonly ? ' AND p1.trader_premium=1 ' : '' )."
			ORDER BY p1.trader_sort, p1.rate_formula DESC, p1.title
			";
		}
	}
	else
	{
		if( ($showportonly == "yes") || ($curtype >= 0) )
		{
			$placejoin = "";
			if( $showportonly == "yes" )
			{
				//$placejoin = " INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.type_id=1 ";
				$placejoin = " INNER JOIN $TABLE_TRADER_PR_PLACES pl1 ON pr1.place_id=pl1.id AND pl1.port_id<>0 ";
			}
			if( $acttype == 1 )
			{
				$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_sell_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond 
				$placejoin
				WHERE p1.trader_price_sell_avail=1 AND p1.trader_price_sell_visible=1 ".($premiumonly ? ' AND p1.trader_premium_sell=1 ' : '' )." 
				ORDER BY p1.trader_sort_sell, p1.rate_formula DESC, p1.title
				";
			}
			else
			{
				$query = "SELECT DISTINCT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				INNER JOIN $TABLE_TRADER_PR_PRICES pr1 ON p1.author_id=pr1.buyer_id AND pr1.acttype='$acttype' $cur_sql_cond 
				$placejoin 
				WHERE p1.trader_price_avail=1 AND p1.trader_price_visible=1 ".($premiumonly ? ' AND p1.trader_premium=1 ' : '' )." 
				ORDER BY p1.trader_sort, p1.rate_formula DESC, p1.title
				";
			}
		}
		else
		{
			if( $acttype == 1 )
			{
				$query = "SELECT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_sell_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_sell_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				WHERE p1.trader_price_sell_avail=1 AND p1.trader_price_sell_visible=1 ".($premiumonly ? ' AND p1.trader_premium_sell=1 ' : '' )." 
				ORDER BY p1.trader_sort_sell, p1.rate_formula DESC, p1.title
				";
			}
			else
			{
				$query = "SELECT p1.*, DATE_FORMAT(p1.add_date, '%d.%m.%Y') as dtreg,
				case when p1.trader_price_dtupdt IS NOT NULL then DATE_FORMAT(p1.trader_price_dtupdt, '%d.%m.%Y') else '' end as dt_trader_updt
				FROM $TABLE_COMPANY_ITEMS p1
				WHERE p1.trader_price_avail=1 AND p1.trader_price_visible=1 ".($premiumonly ? ' AND p1.trader_premium=1 ' : '' )." 
				ORDER BY p1.trader_sort, p1.rate_formula DESC, p1.title
				";
			}
		}
	}
	//echo $query."<br>";
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
			//$it['trader2_updt'] = $row->dt_trader_updt;
			
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

/* messenger */
function Msngr_PropNum($LangId, $author_id, $status=0) { global $upd_link_db;
	global $TABLE_TORG_MSNGR;
	
	$selcond = "";
	if( $author_id != 0 )
		$selcond .= ( $selcond != "" ? " AND " : " WHERE " )." m1.from_id='$author_id' ";
	
	//if( $status != 0 )
	$selcond .= ( $selcond != "" ? " AND " : " WHERE " )." m1.status='$status' ";
	
	$its_num = 0;
	
	$query = "SELECT count(m1.id) as totnum FROM $TABLE_TORG_MSNGR m1 $selcond ";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$its_num = $row->totnum;			
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $its_num;
}

function Msngr_PropList($LangId, $author_id, $sortby="", $pi=0, $pn=100, $viewtype=0) { global $upd_link_db;
	global $TABLE_TORG_MSNGR, $TABLE_TORG_MSNGR_P2P, $TABLE_COMPANY_ITEMS, $TABLE_TRADER_PR_CULTS, $TABLE_TRADER_PR_CULTS_LANGS;
	
	$selcond = "";
	if( $author_id != 0 )
		$selcond = " WHERE m1.from_id='$author_id' ";
	
	if( $viewtype != 0 )
		$selcond .= ($selcond != "" ? " AND " : " WHERE ")." m1.status='".($viewtype == 1 ? '0' : '1' )."' ";
	
	$limit_cond = "";
	if( $pi > 0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
	}
	
	$sort_cond = "m1.add_date DESC";
	switch($sortby)
	{
		case "bydate":
			$sort_cond = "m1.add_date DESC";
			break;
		case "bycult":
			$sort_cond = "c2.name, m1.add_date DESC";
			break;
		case "bytel":
			$sort_cond = "m1.phone, m1.add_date DESC";
			break;
		case "byname":
			$sort_cond = "m1.fio, m1.add_date DESC";
			break;
		case "bymail":
			$sort_cond = "m1.email, m1.add_date DESC";
			break;
		case "byamount":
			$sort_cond = "m1.amount, m1.add_date DESC";
			break;
		case "bystatus":
			$sort_cond = "m1.status DESC, m1.add_date DESC";
			break;
	}
	
	$query = "SELECT m1.*, DATE_FORMAT(m1.add_date, '%d.%m.%Y') as dt, DATE_FORMAT(m1.add_date, '%H:%i') as tm, c2.name as cultname 
		FROM $TABLE_TORG_MSNGR m1 		
		INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON m1.cult_id=c1.id 
		INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
		$selcond 
		ORDER BY $sort_cond 
		$limit_cond";
	
	$its = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['obl_id'] = $row->obl_id;
			$it['cult_id'] = $row->cult_id;
			$it['trader_id'] = $row->to_id;
			$it['status'] = $row->status;
			//$it['trader'] = stripslashes($row->orgname);
			$it['cult'] = stripslashes($row->cultname);
			$it['compname'] = stripslashes($row->company);
			$it['fio'] = stripslashes($row->fio);
			$it['phone'] = stripslashes($row->phone);
			$it['email'] = stripslashes($row->email);
			$it['amount'] = stripslashes($row->amount);
			$it['cost'] = stripslashes($row->cost);
			$it['comment'] = stripslashes($row->comment);
			$it['adddt'] = $row->add_date;
			$it['dt'] = $row->dt;
			$it['tm'] = $row->tm;
			
			$it['to'] = Array();
			$query1 = "SELECT p1.*, t1.title as orgname  
				FROM $TABLE_TORG_MSNGR_P2P p1 
				INNER JOIN $TABLE_COMPANY_ITEMS t1 ON p1.to_id=t1.id 
				WHERE p1.item_id=".$row->id." AND p1.from_id=".$row->from_id." ";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$it['to'][] = Array(
						"trader_id" => $row1->to_id, 
						"trader" => stripslashes($row1->orgname), 
						"status" => $row1->status, 
						"viewdt" => ($row1->view_date != null ? $row1->view_date : "") 
					);
				}
				mysqli_free_result( $res1 );
			}
			
			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $its;
}	

function Msngr_PropTraderList($LangId, $prop_id) { global $upd_link_db;
	global $TABLE_TORG_MSNGR_P2P, $TABLE_COMPANY_ITEMS;
	
	$its = Array();
	$query1 = "SELECT p1.*, t1.title as orgname  
		FROM $TABLE_TORG_MSNGR_P2P p1 
		INNER JOIN $TABLE_COMPANY_ITEMS t1 ON p1.to_id=t1.id 
		WHERE p1.item_id='".addslashes($prop_id)."' ";
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object( $res1 ) )
		{
			$its[] = Array(
				"trader_id" => $row1->to_id, 
				"trader" => stripslashes($row1->orgname), 
				"status" => $row1->status, 
				"viewdt" => ($row1->view_date != null ? $row1->view_date : "") 
			);
		}
		mysqli_free_result( $res1 );
	}
	
	return $its;
}

function Msngr_ReqNum($LangId, $trader_id, $viewtype=0, $viewstatus=-1, $debug=false) { global $upd_link_db;
	global $TABLE_TORG_MSNGR, $TABLE_TORG_MSNGR_P2P, $TABLE_COMPANY_ITEMS, $TABLE_TRADER_PR_CULTS, $TABLE_TRADER_PR_CULTS_LANGS, $TABLE_TORG_BUYERS;
	global $MSNGR_STATUS_DECLINED, $MSNGR_STATUS_APPROVED;
	
	$itnum = 0;
		
	$sql_cond = "";
	$sql_cond0 = "";
	if( $viewtype == 1 )		// Активные
	{	
		$sql_cond = " AND m1.status=0";
		$sql_cond0 = " AND mp1.status<>'$MSNGR_STATUS_DECLINED' ";
	}
	else if ( $viewtype == -1 )	// завершенные
	{
		$sql_cond = " AND m1.status=1";
	}
	
	if( $viewstatus != -1 )
	{
		$sql_cond0 .= " AND mp1.viewed='".$viewstatus."' ";
	}
	
	$query = "SELECT count(mp1.id) as totnum 
		FROM $TABLE_TORG_MSNGR_P2P mp1 
		INNER JOIN $TABLE_TORG_MSNGR m1 ON mp1.item_id=m1.id $sql_cond 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON mp1.from_id=b1.id 	
		WHERE mp1.to_id='$trader_id' $sql_cond0";
		
	if( $debug )
		echo $query."<br>";
	
	$its = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$itnum = $row->totnum;			
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $itnum;
}

function Msngr_ReqList($LangId, $trader_id, $sortby="", $viewtype) { global $upd_link_db;
	global $TABLE_TORG_MSNGR, $TABLE_TORG_MSNGR_P2P, $TABLE_COMPANY_ITEMS, $TABLE_TRADER_PR_CULTS, $TABLE_TRADER_PR_CULTS_LANGS, $TABLE_TORG_BUYERS;
	global $MSNGR_STATUS_DECLINED, $MSNGR_STATUS_APPROVED;
	
	$sort_cond = " m1.add_date DESC ";
	switch($sortby)
	{
		case "obl":
			$sort_cond = " m1.obl_id ";
			break;
		case "cult":
			$sort_cond = " cultname, m1.add_date DESC ";
			break;
		case "org":
			$sort_cond = " i1.title, m1.add_date DESC ";
			break;
		case "cost":
			$sort_cond = " m1.cost, m1.add_date DESC ";
			break;
	}
	
	$sql_cond = "";
	$sql_cond0 = "";
	if( $viewtype == 1 )	// активные
	{
		$sql_cond = " AND m1.status=0";
		$sql_cond0 = " AND mp1.status<>'$MSNGR_STATUS_DECLINED' ";
	}
	else if ( $viewtype == -1 )	// завершенные
		$sql_cond = " AND m1.status=1";
	
	$query = "SELECT mp1.id as rid, mp1.status as pstatus, mp1.viewed as viewed_0, mp1.view_date, m1.*, DATE_FORMAT(m1.add_date, '%d.%m.%Y') as dt, DATE_FORMAT(m1.add_date, '%H:%i') as tm, 
			i1.title as orgname, c2.name as cultname 
		FROM $TABLE_TORG_MSNGR_P2P mp1 
		INNER JOIN $TABLE_TORG_MSNGR m1 ON mp1.item_id=m1.id $sql_cond 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON mp1.from_id=b1.id 	
		INNER JOIN $TABLE_TRADER_PR_CULTS c1 ON m1.cult_id=c1.id 
		INNER JOIN $TABLE_TRADER_PR_CULTS_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId' 
		LEFT JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id 
		WHERE mp1.to_id='$trader_id' $sql_cond0 
		ORDER BY $sort_cond ";
	//if( $trader_id == 2078 )
	//	echo $query."<br>";
	$its = Array();
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['rid'] = $row->rid;
			$it['obl_id'] = $row->obl_id;
			$it['cult_id'] = $row->cult_id;
			$it['trader_id'] = $row->to_id;
			$it['sender_id'] = $row->from_id;
			$it['pstatus'] = $row->pstatus;
			$it['status'] = $row->status;
			$it['viewed'] = $row->viewed_0;
			$it['sendercomp'] = stripslashes($row->orgname);
			$it['cult'] = stripslashes($row->cultname);
			$it['compname'] = stripslashes($row->company);
			$it['fio'] = stripslashes($row->fio);
			$it['phone'] = stripslashes($row->phone);
			$it['email'] = stripslashes($row->email);
			$it['amount'] = stripslashes($row->amount);
			$it['cost'] = stripslashes($row->cost);
			$it['comment'] = stripslashes($row->comment);
			$it['adddt'] = $row->add_date;
			$it['dt'] = $row->dt;
			$it['tm'] = $row->tm;
			
			$its[] = $it;
		}
		mysqli_free_result( $res );
	}
	else
		echo mysqli_error($upd_link_db);
	
	return $its;
}

/* moderators */
function User_GetModerNum($UserId) { global $upd_link_db;	
	global $TABLE_TORG_BUYERS_MODERATORS;
	
	$mnum = 0;
	
	$query1 = "SELECT count(*) as totnum FROM $TABLE_TORG_BUYERS_MODERATORS WHERE moder_user_id='$UserId'";
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		if( $row1 = mysqli_fetch_object($res1) )
		{
			$mnum = $row1->totnum;
		}
		mysqli_free_result($res1);
	}
	
	return $mnum;
}

function User_GetModerList($UserId, $owner_id=0) { global $upd_link_db;		
	global $TABLE_TORG_BUYERS_MODERATORS, $TABLE_TORG_BUYERS_MODERATORS_OBL, $TABLE_COMPANY_ITEMS, $TABLE_TORG_BUYERS;
	
	$mlist = Array();
	
	$sql_cond = "";
	if( $owner_id != 0 )
	{
		$sql_cond = " AND owner_id='".$owner_id."' ";
	}
	
	$query1 = "SELECT m1.*, i1.title as company 
		FROM $TABLE_TORG_BUYERS_MODERATORS m1 
		INNER JOIN $TABLE_TORG_BUYERS b1 ON m1.owner_id=b1.id 
		INNER JOIN $TABLE_COMPANY_ITEMS i1 ON b1.id=i1.author_id  
		WHERE m1.moder_user_id='$UserId' $sql_cond";
	if( $res1 = mysqli_query($upd_link_db, $query1 ) )
	{
		while( $row1 = mysqli_fetch_object($res1) )
		{
			$mi = Array();
			$mi['id'] = $row1->id;
			$mi['oid'] = $row1->owner_id;
			$mi["company"] = stripslashes($row1->company);
			$mi["pbuy"] = $row1->allow_pbuy;
			$mi["psell"] = $row1->allow_psell;
			$mi["pserv"] = $row1->allow_pserv;
			$mi["msngr"] = $row1->allow_msngr;
			$mi["elev"] = $row1->allow_elev;
			$mi["cont"] = $row1->allow_contact;
			$mi["price"] = $row1->allow_price;
			$mi["priceobls"] = Array();
			
			if( $row1->allow_price != 0 )
			{
				// Get obls
				$query2 = "SELECT * FROM $TABLE_TORG_BUYERS_MODERATORS_OBL WHERE moder_id='".$row1->id."' ";
				if( $res2 = mysqli_query($upd_link_db, $query2 ) )
				{
					while( $row2 = mysqli_fetch_object( $res2 ) )
					{
						$mi["priceobls"][] = $row2->moder_obl_id;
					}
					mysqli_free_result( $res2 );
				}
			}
			
			$mlist[] = $mi;
		}
		mysqli_free_result($res1);
	}
	
	return $mlist;
}

function Pack_List($pack_type = -1, $active = true) { global $upd_link_db;
	global $TABLE_BUYER_PACKS;
	
	$its = Array();
	
	$sql_cond = "";
	if( is_array($pack_type) && (count($pack_type)>1) )
	{
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." m1.pack_type IN (".implode(",", $pack_type).") ";
	}
	else if( $pack_type != -1 )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." m1.pack_type='$pack_type' ";
	
	if( $active )
		$sql_cond .= ($sql_cond != "" ? " AND " : " WHERE ")." m1.active=1 ";
	
	if( $res = mysqli_query($upd_link_db, "SELECT m1.* FROM $TABLE_BUYER_PACKS m1 $sql_cond ORDER BY m1.sort_num") )
	{
		while($row=mysqli_fetch_object($res))
		{				
			$it = Array();
			$it['id'] = $row->id;
			$it['active'] = $row->active;
			$it['cost'] = $row->cost;
			$it['periodt'] = $row->period_type;
			$it['period'] = $row->period;
			
			$it['title'] = stripslashes($row->title);
			$it['adv_num'] = $row->adv_num;
			$it['fish_num'] = $row->fish_num;
			$it['targ_num'] = $row->targ_num;
			$it['fish_hours'] = $row->fish_hours;
			
			$its[] = $it;
		}
		mysqli_free_result($res);
	}
	
	return $its;
}

function Pack_Info($id) { global $upd_link_db;
	global $TABLE_BUYER_PACKS;
	
	$it = Array("id" => 0);
	
	if( $res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_BUYER_PACKS m1 WHERE m1.id='".$id."' ") )
	{
		while($row=mysqli_fetch_object($res))
		{				
			//$it = Array();
			$it['id'] = $row->id;
			$it['pack_type'] = $row->pack_type;
			$it['active'] = $row->active;
			$it['cost'] = $row->cost;
			$it['periodt'] = $row->period_type;
			$it['period'] = $row->period;
			$it['title'] = stripslashes($row->title);			
			$it['adv_num'] = $row->adv_num;
			$it['fish_num'] = $row->fish_num;
			$it['targ_num'] = $row->targ_num;
			$it['fish_hours'] = $row->fish_hours;
		}
		mysqli_free_result($res);
	}
	
	return $it;
}

function Buyer_PayedPacksNum($buyerid, $pack_type=-1, $mode = "") { global $upd_link_db;
	global $TABLE_BUYER_PACKS, $TABLE_PAYED_PACK_ORDERS;
	
	$its_num = 0;
	
	$sql_cond = "";
	if( is_array($pack_type) && (count($pack_type)>1) )
	{
		$sql_cond .= " AND o1.pack_type IN (".implode(",", $pack_type).") ";
	}
	else if( $pack_type != -1 )
		$sql_cond .= " AND o1.pack_type='$pack_type' ";
	
	$query = "SELECT count(o1.id) as ordernum FROM $TABLE_PAYED_PACK_ORDERS o1
		WHERE o1.user_id='".$buyerid."'";
	if( $mode == "onlyactive" )
	{
		$query = "SELECT count(o1.id) as ordernum FROM $TABLE_PAYED_PACK_ORDERS o1
		WHERE o1.user_id='".$buyerid."' AND ( (o1.stdt <= NOW()) && (o1.endt >= NOW()) )";
	}
	
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{	
			$its_num = $row->ordernum;			
		}
		mysqli_free_result($res);
	}
	
	return $its_num;
}

function Buyer_PayedPacks($buyerid, $pack_type=-1, $mode = "", $sortby = "") { global $upd_link_db;
	global $TABLE_BUYER_PACKS, $TABLE_PAYED_PACK_ORDERS;
	
	$its = Array();
	
	$sql_cond = "";
	if( $mode == "onlyactive" ) 
		$sql_cond = " AND ( (o1.stdt <= NOW()) && (o1.endt >= NOW()) ) ";
	else if( $mode == "notended" ) 
		$sql_cond = " AND ( o1.endt >= NOW() ) ";
	
	if( is_array($pack_type) && (count($pack_type)>1) )
	{
		$sql_cond .= " AND o1.pack_type IN (".implode(",", $pack_type).") ";
	}
	else if( $pack_type != -1 )
		$sql_cond .= " AND o1.pack_type='$pack_type' ";
	
	$sort_cond = "o1.pack_type, o1.add_date DESC";
	switch($sortby)
	{
		case "enddt":
			$sort_cond = "o1.endt, o1.stdt";
			break;
	}
	
	$query = "SELECT o1.*, p1.active, p1.title, p1.cost, p1.adv_num, case when ( (o1.stdt <= NOW()) && (o1.endt >= NOW()) ) then 1 else 0 end as nowactive 
		FROM $TABLE_PAYED_PACK_ORDERS o1
		LEFT JOIN $TABLE_BUYER_PACKS p1 ON o1.pack_id=p1.id 
		WHERE o1.user_id='".$buyerid."' $sql_cond 
		ORDER BY $sort_cond";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row=mysqli_fetch_object($res))
		{				
			$it = Array();
			$it['id'] = $row->id;
			$it['pack_type'] = $row->pack_type;
			$it['pack_id'] = $row->pack_id;
			$it['nowactive'] = $row->nowactive;
			$it['post_id'] = $row->post_id;
			$it['active'] = $row->active;
			$it['cost'] = $row->cost;
			$it['stdt'] = $row->stdt;
			$it['endt'] = $row->endt;
			
			$it['dt'] = $row->add_date;
			
			$it['title'] = stripslashes($row->title);
			
			$it['adv_avail'] = $row->adv_avail;
			$it['adv_num'] = $row->adv_num;
			
			//$it['fish_num'] = $row->fish_num;
			//$it['targ_num'] = $row->targ_num;
			//$it['fish_hours'] = $row->fish_hours;
			
			$its[] = $it;
		}
		mysqli_free_result($res);
	}
	
	return $its;
}

function Buyer_LoadLimits_Def() { global $upd_link_db;
	global $BOARD_LIMITS, $BOARD_UTYPE_USER, $BOARD_UTYPE_COMP, $BOARD_UTYPE_ANONIM;
	
	$cfg = Array(
		"comp" => false,
		"comp_id" => 0,
		"comp_act" => 0,
		"max_post" => $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['maxpost'],
		"max_post_arc" => $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['maxpostarc'],
		"max_post_ups" => $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['maxups'],
		"max_post_upsfpd" => $BOARD_LIMITS[$BOARD_UTYPE_ANONIM]['upsfpd'],
		"max_post_fishka" => 0,
		"max_post_target" => 0,
		"avail_post_free" => 0,
		"avail_post_pack" => 0,
		"avail_post" => 0,
		"payed_pack" => false,
		"payed_pack_inf" => null
	);
	
	return $cfg;
}

function Buyer_LoadLimits($uid) { global $upd_link_db;
	global $TABLE_TORG_BUYERS;
	global $LangId, $BOARD_LIMITS, $BOARD_UTYPE_USER, $BOARD_UTYPE_COMP, $BILLING_PACK_POSTNUM;
	
	$binf = Torg_BuyerInfo($LangId, $uid);	
	
	$cfg = Array(
		"comp" => false,
		"comp_id" => 0,
		"comp_act" => 0,
		"max_post" => $BOARD_LIMITS[$BOARD_UTYPE_USER]['maxpost'],
		"max_post_arc" => $BOARD_LIMITS[$BOARD_UTYPE_USER]['maxpostarc'],
		"max_post_ups" => $BOARD_LIMITS[$BOARD_UTYPE_USER]['maxups'],
		"max_post_upsfpd" => $BOARD_LIMITS[$BOARD_UTYPE_USER]['upsfpd'],
		"max_post_fishka" => 5,	// $binf['maxfishka'], // Was in version 1
		"max_post_target" => 0, //5,	//0,
		"avail_post_free" => $binf['availpost'],
		"avail_post_pack" => 0,
		"avail_post" => $binf['availpost'],
		"payed_pack" => false,
		"payed_pack_inf" => null
	);
	
	$complist = Comp_Items( $LangId, 0, 0, 0, 0, -1, 20, $uid, true );	
	$compinfo = Comp_ItemInfo( $LangId, (count($complist) > 0 ? $complist[0]['id'] : 0) );
	if( isset($compinfo['id']) && ($compinfo['id'] != 0) )
	{
		$cfg['comp'] = true;
		$cfg['comp_id'] = $compinfo['id'];
		$cfg['comp_act'] = $compinfo['vis'];
		/*
		// Now the number of posts is constant by default for all
		$cfg['max_post'] 		= $BOARD_LIMITS[$BOARD_UTYPE_COMP]['maxpost'];
		$cfg['max_post_arc'] 	= $BOARD_LIMITS[$BOARD_UTYPE_COMP]['maxpostarc'];
		$cfg['max_post_ups'] 	= $BOARD_LIMITS[$BOARD_UTYPE_COMP]['maxups'];
		$cfg['max_post_upsfpd'] = $BOARD_LIMITS[$BOARD_UTYPE_COMP]['upsfpd'];
		*/
				
		//////////////////////////////////////////////////////
		// Old v1 version
		//$packinf = Pack_Info($compinfo['site_pack']);		
		//if( $packinf['id'] != 0 )
		//{
		//	$TARGET_NUM = $packinf['targ_num'];
		//	$MAX_FISHKA = $packinf['fish_num'];
		//}		
	}
	
	// New version
	$packs = Buyer_PayedPacks($uid, $BILLING_PACK_POSTNUM, "onlyactive");
	if( count($packs)>0 )
	{
		for( $i=0; $i<count($packs); $i++ )
		{
			$cfg['max_post'] += $packs[$i]['adv_num'];
			$cfg['avail_post_pack'] += $packs[$i]['adv_avail'];
			$cfg['avail_post'] += $packs[$i]['adv_avail'];
		}
		$cfg['payed_pack'] = true;
		$cfg['payed_pack_inf'] = $packs;
		/*
		$cfg['max_post'] = $packs[0]['adv_num'];
		
		$cfg['payed_pack'] = true;
		$cfg['payed_pack_inf'] = $packs[0];
		*/
	}
	
	return $cfg;
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//TITLE FOR SECTION
function Catalog_SeoGetTitles($LangId, $ptype, $sect_id=0, $csect_id=0, $obl_id=0, $type_id=0, $cult_id=0, $sort_id=0, $filt_id=0, $filt_val=0) { global $upd_link_db;
	global $TABLE_SEO_TITLES;

	$sql_cond = "";
	
	$sql_cond .= " AND csect_id='$csect_id' ";
	$sql_cond .= " AND obl_id='$obl_id' ";
	$sql_cond .= " AND type_id='$type_id' ";
	$sql_cond .= " AND cult_id='$cult_id' ";
	$sql_cond .= " AND sortmode_id='$sort_id' ";
	$sql_cond .= " AND filter_id='$filt_id' AND filter_val='$filt_val'";
	
	$seo = Array('isset' => false);

	$query = "SELECT * FROM $TABLE_SEO_TITLES WHERE pagetype='$ptype' AND sect_id=$sect_id $sql_cond";

	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$seo['isset'] = true;

			$seo['id'] = $row->id;

			$seo['title'] = stripslashes($row->page_title);
			$seo['keyw'] = str_replace("\"", "&quot;", stripslashes($row->page_keywords));
			$seo['descr'] = str_replace("\"", "&quot;", stripslashes($row->page_descr));
			$seo['h1'] = stripslashes($row->page_h1);
			$seo['txt1'] = stripslashes($row->content_text);
			$seo['txt2'] = stripslashes($row->content_words);

			$seo['tpl_title'] = stripslashes($row->tpl_items_title);
			$seo['tpl_keyw'] = str_replace("\"", "&quot;", stripslashes($row->tpl_items_keywords));
			$seo['tpl_descr'] = str_replace("\"", "&quot;", stripslashes($row->tpl_items_descr));
			$seo['tpl_txt1'] = stripslashes($row->tpl_items_text);
			$seo['tpl_txt2'] = stripslashes($row->tpl_items_words);
		}
		mysqli_free_result( $res );
	}
	else
	{
		//echo mysqli_error($upd_link_db);
		debugMysql();
	}

	return $seo;
}


function Catalog_SeoDefTitle($LangId, $sect_name, $obl_id=0, $type_id=0, $sort_id=0) { global $upd_link_db;
	global $TABLE_SEO_TITLES, $WWWNAMERU, $WWWNAMEEN;

	$result = Array();

	$orgcont = "";
	$orgwords = "";
	
	$orgtitle = "";
	$orgkeyw = "";
	$orgdescr = "";

	/*
	switch($sort_id)
	{
		case 0:
			$orgtitle = "$sect_name ".($make_name != "" ? $make_name." " : "")." - Магазин ".$WWWNAMERU.", купить $sect_name ".($make_name != "" ? $make_name." " : "")." - хорошие цены";
			$orgkeyw = "$sect_name, ".($make_name != "" ? $make_name.", " : "")."купить, продажа, магазин, цены";
			$orgdescr = "Магазин ".$WWWNAMERU." - Выбирай $sect_name ".($make_name != "" ? $make_name." " : "")." по хорошей цене. Доставим любые $sect_name".($make_name != "" ? " ".$make_name : "")." по всей Украине.";
			if( $make_name != "" )
			{
				//$orgtitle = "$sect_name $make_name – интернет магазин ".$WWWNAMERU;
				//$orgkeyw = "$sect_name, ".($make_name != "" ? $make_name.", " : "")."купить, продажа, каталог, интернет магазин, цены";
				//$orgdescr = "$sect_name ".($make_name != "" ? $make_name." " : "")."в интернет магазине ".strtoupper($_SERVER['HTTP_HOST']).". У нас самые низкие цены на $sect_name".($make_name != "" ? " ".$make_name : "").".";
				//$orgdescr = "$sect_name $make_name купить в интернет магазине ".$WWWNAMERU.". Доставка заказов в любой город Украины.";

				//$orgcont = "В интернет-магазине Autoprotect вы можете купить $sect_name $make_name по выгодным ценам. $sect_name $make_name – цены, фото, характеристики, отзывы. Продажа и доставка по всей территории Украины.";
			}
			break;

		case 1:
			$orgtitle = "Дешевые $sect_name ".($make_name != "" ? $make_name." " : "")."в интернет магазине ".strtolower($_SERVER['HTTP_HOST'])." ";
			$orgkeyw = "дешевые, $sect_name, ".($make_name != "" ? $make_name.", " : "")."интернет магазин";
			$orgdescr = "Самые дешевые $sect_name ".($make_name != "" ? $make_name." " : "")."только в магазине ".strtolower($_SERVER['HTTP_HOST']).". У нас самые низкие цены на $sect_name ".($make_name != "" ? $make_name." " : "").".";
			break;

		case 2:
			$orgtitle = "Популярные $sect_name ".($make_name != "" ? $make_name." " : "")."в интернет-магазине ".strtolower($_SERVER['HTTP_HOST']);
			$orgkeyw = "популярные, $sect_name, ".($make_name != "" ? $make_name.", " : "")."интернет-магазин";
			$orgdescr = "Самые популярные $sect_name ".($make_name != "" ? $make_name." " : "")." - ".strtolower($_SERVER['HTTP_HOST']).". Покупайте то что покупают все.";
			break;

		case 3:
			$orgtitle = "От дорогих к дешевым: $sect_name ".($make_name != "" ? $make_name." " : "")."в интернет магазине ".strtolower($_SERVER['HTTP_HOST'])." ";
			$orgkeyw = "дорогие, $sect_name, ".($make_name != "" ? $make_name.", " : "")."интернет магазин";
			$orgdescr = "Самые дорогие $sect_name ".($make_name != "" ? $make_name." " : "")."только в магазине ".strtolower($_SERVER['HTTP_HOST']).". У нас самые низкие цены на $sect_name ".($make_name != "" ? $make_name." " : "").".";
			break;
	}
	*/

	$result['title'] = $orgtitle;
	$result['descr'] = $orgdescr;
	$result['keyw'] = $orgkeyw;
	$result['h1']	= "";
	$result['txt1'] = $orgcont;
	$result['txt2'] = $orgwords;

    return $result;
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//TITLE FOR PRODUCTs
function Product_SeoDefTitle( $LangId, $get_real=false, $advtitle="", $advcont="", $sectname="" ) { global $upd_link_db;
	global $TABLE_SEO_TITLES, $WWWNAMERU, $WWWNAMEEN;

	$result = Array();

	$fullname = $advtitle;

	//$title = "_make_ _model_. Купить _make_ _model_ - интернет магазин Авторадости ".$_SERVER['HTTP_HOST'];
	//$title = "_model_ - Купить в Киеве, Харькове, Днепропетровске, доставка по Украине, отзывы, цены, магазины";
	//$title = "_make_ _model_, купить ".($sectname != "" ? $sectname." " : "")." - ".$WWWNAMEEN;
	$title = "_advtit_. Объявления на agt.weehub.io";
	//$descr = "_make_ _model_ в интернет магазине ".$_SERVER['HTTP_HOST'].". Купить ".($sectname != "" ? $sectname." " : "")."_make_ _model_.";
	//$descr = "_model_, спортивное питание в интернет магазине ".$WWWNAMERU.". Купить ".($sectname != "" ? $sectname." " : "")."_make_ _model_ с доставкой по всей Украине.";
	//$descr = "_make_ _model_ купить в магазине ".$WWWNAMERU.". Доставим _model_ в любой город Украины. Заходи и смотри.";
	//$keyw = "_make_ _model_, купить, продажа, цена";
	$descr = "_advcont_";
	$keyw = "_advtit_";
	$cont = "";
	$words = "";
	//$words = "<b>_make_ _model_</b> - где и как купить смотрите на сайте.";
	//$words = "Вы выбрали: ".($sectname != "" ? $sectname." " : "")." _make_ _model_. Вы можете купить и оформить доставку товара по Украине. В интернет-магазине автотоваров и аксессуаров Autoprotect предоставляется официальная гарантия на всю приобретенную продукцию.";

	if( $get_real )
	{
		//$trans = array("_make_" => $make , "_model_" => $model);
		$trans = array("_advtit_" => $advtitle , "_advcont_" => $advcont, "_advsect_" => $sectname);
		$title = strtr( $title, $trans );
		$descr = strtr( $descr, $trans );
		$keyw = strtr( $keyw, $trans );
		$cont = strtr( $cont, $trans );
		$words = strtr( $words, $trans );
	}

	$result['title']	= $title;
	$result['descr']	= $descr;
	$result['keyw']		= $keyw;
	$result['h1']		= "";
	$result['txt1']		= $cont;
	$result['txt2']		= $words;

    return $result;
}

?>
