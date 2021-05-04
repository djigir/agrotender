<?php
error_reporting(E_ALL);
    $db_database = 'agrotender';
    $db_host = '127.0.0.1';
    $db_user = 'whiskas';
    $db_password = '12345';
	// Установление соединения с сервером mysqli
    if(!$upd_link_db=@mysqli_connect($db_host,$db_user,$db_password)){
		die ("<center><b>Could not connect to local database.</b></center><br />");
        echo "<center>".mysqli_error($upd_link_db)."</center>";
    } 
    // Выбор базы данных, выделенной для данного сайта
    mysqli_select_db($upd_link_db, $db_database);

	$mysqli_enc = "cp1251";
	if( $DEF_ENC == "UTF-8" )
	{
		$mysqli_enc = "utf8";
	}

    mysqli_query($upd_link_db, "SET SQL_MODE=''");
    mysqli_query($upd_link_db, "SET SQL_BIG_SELECTS=1");
	mysqli_query($upd_link_db, "SET character_set_client = '$mysqli_enc'");
	mysqli_query($upd_link_db, "SET character_set_results = '$mysqli_enc'");
	mysqli_query($upd_link_db, "SET character_set_connection = '$mysqli_enc'");

	$lang_let = Array("ru" => 1, "ua" => 2, "en" => 2);
	$lang_cod = Array(1 => "ru", 2 => "ua", 2 => "en");

    // Detecte the selected language for the website
	$lang_id = GetParameter("lang_id", null);
	if( $lang_id == null )
	{
		if( isset($_COOKIE['LangId']) )
		{

			$LangId = $_COOKIE['LangId'];
			//echo "Этап 2:".$LangId."<br />";
		}
		else
		{
			$LangId = 1;
			setcookie("LangId", $LangId);
			//echo "Этап 3:".$LangId."<br />";

		}
	}
	else
	{
		$LangId = $lang_let[$lang_id];
		setcookie("LangId", $LangId);
		//echo "Этап 1:".$LangId."<br />";
	}

	$lang = $lang_cod[$LangId];

    //City
    /*
    $city_id = GetParameter("city_id", "");

	if( $city_id == "" )
	{
    	if( isset($_COOKIE['CityId']) )
	    {
	        $CityId = $_COOKIE['CityId'];
	        //echo $LangId;
	    }
	    else
	    {
	        $CityId = 1;
	        setcookie("CityId", $CityId);
	    }
	}
	else
	{
    	$CityId = $city_id;
		setcookie("CityId", $CityId);
    }
    */

    ///////////////////////////////////////////////////////////////////////////////
	// Load language list
    $langs = Array();
    $query = "SELECT * FROM $TABLE_LANGS ORDER BY id";
    if( $res = mysqli_query($upd_link_db,  $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$langs[] = $row->id;
        }
        mysqli_free_result($res);
    }

	// Load website engine config values
    $PREFS = Array();
    $query = "SELECT * FROM $TABLE_PREFERENCES ORDER BY id";
    if( $res = mysqli_query($upd_link_db,  $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	switch( $row->id )
        	{
        		case 1:	$PREFS['DOLLAR_KURS'] = stripslashes($row->value);	break;
        		case 2:	$PREFS['EVRO_KURS'] = stripslashes($row->value);	break;
        		case 3:	$PREFS['LENTA_UP'] = stripslashes($row->value);	break;
        		case 4:	$PREFS['LENTA_LIVE'] = stripslashes($row->value);	break;
				
				case 5:	$PREFS['CK_PM'] = stripslashes($row->value);	break;
				case 6:	$PREFS['CK_TZU'] = stripslashes($row->value);	break;
				case 7:	$PREFS['CK_VAC'] = stripslashes($row->value);	break;
				case 8:	$PREFS['CK_NEWS'] = stripslashes($row->value);	break;
				case 9:	$PREFS['CK_PR'] = stripslashes($row->value);	break;
				case 10:$PREFS['CK_LOGO'] = stripslashes($row->value);	break;
				case 11:$PREFS['CK_DESCR'] = stripslashes($row->value);	break;
				case 12:$PREFS['CK_CONT'] = stripslashes($row->value);	break;
				
				case 13:$PREFS['MSNGR_MAX'] = stripslashes($row->value);	break;
				case 14:$PREFS['USER_BOARD_MAX_POST'] = stripslashes($row->value);	break;
				case 15:$PREFS['USER_BOARD_MODERON'] = stripslashes($row->value);	break;
				
				case 16:$PREFS['ADDFUND_MIN'] = stripslashes($row->value);	break;
				
				case 17:$PREFS['BOARD_UPPERIOD'] = stripslashes($row->value);	break;
				case 18:$PREFS['BOARD_DEACTPERIOD'] = stripslashes($row->value);	break;
        	}
        }
        mysqli_free_result($res);
    }
	
	$upperiodint = intval($PREFS['BOARD_UPPERIOD']);
	if( $upperiodint > 0 )
		$BOARD_UP_PERIOD = $upperiodint;
	
	$BOARD_LIMITS[$BOARD_UTYPE_USER]["maxpost"] = $PREFS['USER_BOARD_MAX_POST'];
	
	//$BOARD_LIMITS[$BOARD_UTYPE_USER]["upsfpd"] = $BOARD_UP_PERIOD;

	////////////////////////////////////////////////////////////////////////////
	// Filter Cookies
	//$sid_pr = 0;
	$max_val = GetParameter("maxcost_value", 0);
	$min_val = GetParameter("mincost_value", 0);
	$sid_tmp = GetParameter("sid", 0);
	$surl_tmp = GetParameter("surl", "");

	$COOKIE_LIFE = 1*24*60*60;

	// This is for HTML urls version
	if( $surl_tmp != "" )
	{
		$query = "SELECT m1.id FROM $TABLE_CAT_CATALOG m1 WHERE m1.url='$surl_tmp'";
		if( $res = mysqli_query($upd_link_db,  $query ) )
		{
			if( $row = mysqli_fetch_object( $res ) )
			{
				$sid_tmp = $row->id;
			}
			mysqli_free_result( $res );
		}
	}
	// This is for PHP dynamic urls
	else if($sid_tmp != 0)
	{
		//
		//echo $sid_tmp." sid<br />";
	}
	else
	{
		//$SIDS = 0;
		$MAXCOST = 0;
		$MINCOST = 0;
		SetCookie("MAXCOST", "0", time()+$COOKIE_LIFE);
		SetCookie("MINCOST", "0", time()+$COOKIE_LIFE);
		SetCookie("SIDS", "0", time()+$COOKIE_LIFE);
	}

	if( $sid_tmp != 0 )
	{
		if( isset($_COOKIE['SIDS']) && ($_COOKIE['SIDS'] == $sid_tmp) )
		{
			//$SIDS = $_COOKIE['SIDS'];
			$MAXCOST = $_COOKIE['MAXCOST'];
			$MINCOST = $_COOKIE['MINCOST'];
			if($max_val!=0 || $min_val!=0)
			{
				$MAXCOST = $max_val;
				$MINCOST = $min_val;
				SetCookie("MAXCOST", $max_val, time()+$COOKIE_LIFE);
				SetCookie("MINCOST", $min_val, time()+$COOKIE_LIFE);

				//echo "One more";
			}
		}
		else
		{
			//$SIDS = 0;
			$MAXCOST = 0;
			$MINCOST = 0;
			SetCookie("MAXCOST", "0", time()+$COOKIE_LIFE);
			SetCookie("MINCOST", "0", time()+$COOKIE_LIFE);
			SetCookie("SIDS", "$sid_tmp", time()+$COOKIE_LIFE);

			//echo "Reset cookie $sid_tmp";

			//var_dump($_COOKIE);
		}
		//if($FILTER_ZERO==0)
		//{
		//	SetCookie("MAXCOST","0",time()+3333600,'/');
		//	SetCookie("MINCOST","0",time()+3333600,'/');
		//}
	}

	////////////////////////////////////////////////////////////////////////////
    // Multi language support: Extract texts and title from database for page
    if( $PHP_SELF == "/index.php")
    {
		$pname = "index";
    }
    else
    {
   		$start_pos = ( ( strrpos($PHP_SELF, "/") === false ) ? 0 : (strrpos($PHP_SELF, "/") + 1) );
   		$pname = substr($PHP_SELF, $start_pos, strrpos($PHP_SELF, ".php") - $start_pos);
	}

	if( isset($txt) )
	{
		$atxt = $txt["allpages"];
		if($pname != "info")
			$ptxt = $txt[$pname];
	}

	////////////////////////////////////////////////////////////////////////////
	//$DOLLAR_KURS = 1;
	////////////////////////////////////////////////////////////////////////////
?>