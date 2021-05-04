<?php

function GetCountryList($langid){ global $upd_link_db;
	global $TABLE_COUNTRY, $TABLE_COUNTRY_LANG;

	$countrys = Array();

    $query = "SELECT c1.id, cl1.name as country
    	FROM $TABLE_COUNTRY c1
    	INNER JOIN $TABLE_COUNTRY_LANG cl1 ON c1.id=cl1.country_id AND cl1.lang_id='".$langid."'
    	ORDER BY cl1.name";

    //echo $query;

    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$item = Array();

        	$item['countryid'] = $row->id;
        	$item['country'] = stripslashes($row->country);

        	$countrys[] = $item;
        }
        mysqli_free_result($res);
    }

    return $countrys;
}

function GetCityList($langid){ global $upd_link_db;
	global $TABLE_COUNTRY, $TABLE_COUNTRY_LANG, $TABLE_CITY, $TABLE_CITY_LANG;

	$cities = Array();

    $query = "SELECT c1.id, cl1.name as country, cc1.id as cityid, ccl1.name as city
    	FROM $TABLE_COUNTRY c1
    	INNER JOIN $TABLE_COUNTRY_LANG cl1 ON c1.id=cl1.country_id AND cl1.lang_id='".$langid."'
    	INNER JOIN $TABLE_CITY cc1 ON c1.id=cc1.country_id
    	INNER JOIN $TABLE_CITY_LANG ccl1 ON cc1.id=ccl1.city_id AND ccl1.lang_id='".$langid."'
    	ORDER BY ccl1.name";

    //echo $query;

    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$item = Array();

        	$item['countryid'] = $row->id;
        	$item['cityid'] = $row->cityid;
        	$item['country'] = stripslashes($row->country);
        	$item['city'] = stripslashes($row->city);

        	$cities[] = $item;
        }
        mysqli_free_result($res);
    }

    return $cities;
}

function GetCityListByCountry($langid, $countryid){ global $upd_link_db;
	global $TABLE_COUNTRY, $TABLE_COUNTRY_LANG, $TABLE_CITY, $TABLE_CITY_LANG;

	$cities = Array();

    $query = "SELECT c1.id, cl1.name as country, cc1.id as cityid, ccl1.name as city
    	FROM $TABLE_COUNTRY c1
    	INNER JOIN $TABLE_COUNTRY_LANG cl1 ON c1.id=cl1.country_id AND cl1.lang_id='".$langid."'
    	INNER JOIN $TABLE_CITY cc1 ON c1.id=cc1.country_id
    	INNER JOIN $TABLE_CITY_LANG ccl1 ON cc1.id=ccl1.city_id AND ccl1.lang_id='".$langid."'
    	WHERE c1.id='$countryid'
    	ORDER BY ccl1.name";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$item = Array();

        	$item['countryid'] = $row->id;
        	$item['cityid'] = $row->cityid;
        	$item['country'] = stripslashes($row->country);
        	$item['city'] = stripslashes($row->city);

        	$cities[] = $item;
        }
        mysqli_free_result($res);
    }
    else
    	echo mysqli_error($upd_link_db);

    return $cities;
}

?>
