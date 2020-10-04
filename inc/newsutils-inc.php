<?php
////////////////////////////////////////////////////////////////////////////////
// Developed By Ukrainian Hosting company, 2011                               //
// Alexandr Godunov                                                           //
//      Украинский Хостинг                                                    //
//      Годунов Александр                                                     //
//   Данный код запрещен для использования на других сайтах, которые          //
//   разрабатываются без участия компании "Украинский Хостинг"                //
////////////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////////////////
	// Functions
function News_BuildUrl_PHP($LangId, $pi=0, $pn=20, $nid=0, $mod="", $y=0, $m=0, $groupurl="")
{
	global $PHP_SELF;
	// sample link styles
	//   news.php
	//   news.php?pagei=2
	//   news.php?id=10
	//   news.php?mode=arc
	//   news.php?mode=arc&dm=01&dy=2010
	//   news.php?mode=arc&dm=01&dy=2010&id=8
	$url = "news.php";

	$group = -1;

	//$groupurl = "";
	if( $group != -1 )
	{
		//$groupurl = "ngroup=".$group."&";
	}

	if( $nid == 0 )
	{
		// The news item not specified
		if( $groupurl != "" )
			$url .= "?groupurl=".$groupurl.($pi > 0 ? "&pagei=".$pi : "");
		else if( $mod == "arc" )
			$url = $url."?".$groupurl."mode=arc".($y != 0 ? "&dy=".$y : "").($m != 0 ? "&dm=".$m : "");
		else
			$url = $url.($pi == 0 ? "?".$groupurl : "?".$groupurl."pagei=".$pi);
	}
	else
	{
		// News item is specified
		if( $mod == "arc" )
			$url = $url."?".$groupurl."mode=".$mod."&dy=".$y."&dm=".$m."&id=".$nid;
		else
			$url = $url."?".$groupurl."id=".$nid;
	}

	return $url;
}

function News_BuildUrl_HTML($LangId, $pi=0, $pn=20, $nid=0, $mod="", $y=0, $m=0, $groupurl="")
{
	// sample link styles
	//   news/index.html
	//   news/page_2_20.html
	//   news/01_2010/10.html
	//   news/archive.html
	//   news/01_2010/index.html
	//   news/01_2010/8.html

	$url = "news/";

	$group = -1;

	if( $group == 1 )
	{
		$url = "article/";
	}
	else if( $group == 2 )
	{
		$url = "obzor/";
	}

	if( ($nid == 0) || ($nid == "") )
	{
		// The news item not specified
		if( $groupurl != "" )
		{
			$url .= $groupurl."/".($pi > 0 ? "page_".$pi : "index").".html";
		}
		else if( $mod == "arc" )
		{
			$url .= ( $y == 0 ? "archive.html" : sprintf("%02d", $m)."_".sprintf("%04d", $y)."/index.html" );
		}
		else
		{
			$url .= ( $pi > 0 ? "page_".$pi."_".$pn.".html" : "index.html" );

			if( $url == "news/index.html" )
				$url = "news.html";
		}
	}
	else
	{
		// News item is specified
		$url .= sprintf("%02d", $m)."_".sprintf("%04d", $y)."/".$nid.".html";
	}

	return $url;
}

function News_BuildUrl($LangId, $pi=0, $pn=20, $nid=0, $mod="", $y=0, $m=0, $groupurl="")
{
	global $WWW_LINK_MODE, $WWWHOST;

	//if( $WWW_LINK_MODE == "php" )
	//	$wwwlink = substr( $WWWHOST, 0, strpos($WWWHOST, "/", 7) );
	$wwwlink = $WWWHOST;

	return (
		$WWW_LINK_MODE == "php" ?
			$wwwlink.News_BuildUrl_PHP($LangId, $pi, $pn, $nid, $mod, $y, $m, $groupurl) :
			$WWWHOST.News_BuildUrl_HTML($LangId, $pi, $pn, $nid, $mod, $y, $m, $groupurl)
		);
}

function News_ItemsNum($ngroup = -1)
{
	global $TABLE_NEWS;

	//$ngroup=-1;
	$totnews = 0;

	$cond = "";
	if( $ngroup != -1 )
	{
		$cond = " WHERE ngroup='".$ngroup."' ";
	}

   	$query = "SELECT count(*) as totnews FROM $TABLE_NEWS $cond";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
    	if( $row = mysqli_fetch_object( $res ) )
     	{
			$totnews = $row->totnews;
      	}
		mysqli_free_result( $res );
	}

	return $totnews;
}

function News_Items($LangId, $ngroup=-1, $sortby="add", $anons_len=300, $pi=-1, $pn=20, $year=0, $month=0)
{
	global $TABLE_NEWS, $TABLE_NEWS_LANGS, $WWWHOST, $FILE_DIR, $DEF_ENC;

	//$ngroup=-1;

	$sel_cond = "";
	$sort_cond = "m1.dtime DESC";
	switch( $sortby )
	{
		case "addtop":
			$sort_cond = "m1.intop DESC, m1.dtime DESC";
			break;

		case "add":
			$sort_cond = "m1.dtime DESC";
			break;

		case "add_asc":
			$sort_cond = "m1.dtime";
			break;

		case "anons":
			$sort_cond = "m1.dtime DESC";
			$sel_cond .= " AND first_page=1 ";
			break;
	}

	if( ($month != 0) && ($year != 0) )
	{
		if( $year != 0 )
			$sel_cond .= " AND YEAR(dtime)='".$year."' ";

		if( $month != 0 )
			$sel_cond .= " AND MONTH(dtime)='".$month."' ";
	}

	$limit_cond = "";
	if( $pi != -1 )
	{
		$limit_cond = " LIMIT ".($pi*$pn).",$pn";
	}

	$typecond = "";
	if( $ngroup != -1 )
	{
		$typecond = " m1.ngroup='".$ngroup."' AND ";
	}

	$news = Array();
	$query = "SELECT m1.*, m2.title, m2.content, DAYOFMONTH(dtime) as day, MONTH(dtime) as month, YEAR(dtime) as year
   			FROM $TABLE_NEWS m1, $TABLE_NEWS_LANGS m2
			WHERE $typecond m1.id=m2.news_id AND m2.lang_id='$LangId' $sel_cond
			ORDER BY $sort_cond
			$limit_cond";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$ni = Array();
        	$ni['id'] = $row->id;
        	$ni['group'] = $row->ngroup;
			$ni['title'] = stripslashes($row->title);
			$ni['url'] = stripslashes($row->url);
			$ni['text'] = stripslashes($row->content);
			$ni['date'] = sprintf("%02d.%02d.%04d",$row->day, $row->month, $row->year);
			$ni['date_d'] = $row->day;
			$ni['date_m'] = $row->month;
			$ni['date_y'] = $row->year;
			$ni['view_num'] = $row->view_num;
			$ni['img_src'] = ( stripslashes($row->filename_src) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->filename_src) : "" );

			$shorttxt = strip_tags($ni['text']);
	       	if( strlen( $shorttxt ) > $anons_len )
       			$shorttxt = substr($shorttxt, 0, $anons_len)."...";
       		//if( mb_strlen( $shorttxt, $DEF_ENC ) > $anons_len )
       		//	$shorttxt = mb_substr($shorttxt, 0, $anons_len, $DEF_ENC)."...";

       		$ni['short'] = $shorttxt;

        	$news[] = $ni;
        }
        mysqli_free_result($res);
    }

    return $news;
}

function News_ItemInfo($LangId, $id)
{
	global $TABLE_NEWS, $TABLE_NEWS_LANGS, $WWWHOST, $FILE_DIR;

	$ninfo = Array();

	$query = "SELECT m1.*, m2.title, m2.content, DAYOFMONTH(dtime) as day, MONTH(dtime) as month, YEAR(dtime) as year
		FROM $TABLE_NEWS m1, $TABLE_NEWS_LANGS m2
		WHERE m1.id='$id' AND m1.id=m2.news_id AND m2.lang_id='$LangId'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
	    while( $row = mysqli_fetch_object($res) )
	    {
	        $ninfo['id'] = $row->id;
	        $ninfo['group'] = $row->ngroup;
	        $ninfo['title'] = stripslashes($row->title);
	        $ninfo['url'] = stripslashes($row->url);
	        $ninfo['text'] = stripslashes($row->content);
	        $ninfo['date'] = sprintf("%02d.%02d.%04d", $row->day, $row->month, $row->year);
	        $ninfo['date_d'] = $row->day;
			$ninfo['date_m'] = $row->month;
			$ninfo['date_y'] = $row->year;
			$ninfo['view_num'] = $row->view_num;
			$ninfo['img_src'] = $WWWHOST.$FILE_DIR.stripslashes($row->filename_src);
	    }
	    mysqli_free_result($res);
	}

	return $ninfo;
}

function News_GetFirstItemDate($ngroup=-1)
{
	global $TABLE_NEWS;

	$dt_info = Array();
	$dt_info['d'] = 1;
	$dt_info['m'] = 1;
	$dt_info['y'] = date("Y", time());

	$cond = "";
	if( $ngroup != -1 )
	{
		$cond = " WHERE m1.ngroup='".$ngroup."' ";
	}

	$query = "SELECT DAYOFMONTH(dtime) as day, MONTH(dtime) as month, YEAR(dtime) as year
		FROM $TABLE_NEWS m1
		$cond
		ORDER BY m1.dtime LIMIT 0,1";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
	    if( $row = mysqli_fetch_object($res) )
	    {
			$dt_info['m'] = $row->month;
			$dt_info['y'] = $row->year;
	    }
	    mysqli_free_result($res);
	}

	return $dt_info;
}


function News_CommentNum($comp_id)
{
	global $TABLE_NEWS_COMMENT;

	$comments_num = 0;

	$query = "SELECT count(*) as totcomments FROM $TABLE_NEWS_COMMENT WHERE item_id='$comp_id' AND visible=1 ";
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

function News_CommentAvgRate($comp_id)
{
	global $TABLE_NEWS_COMMENT;

	$resp_avg = 0;

	$query = "SELECT avg(rate) as avgrate FROM $TABLE_NEWS_COMMENT WHERE item_id='$comp_id' AND visible=1 ";
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

function News_Comments($LangId, $comp_id, $pi=-1, $pn=20, $dtsqltpl="")
{
	global $TABLE_NEWS_COMMENT, $TABLE_NEWS_COMMENT_LANGS;

	$coms = Array();

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".($pn*$pi).",$pn ";
	}

	$dtsqlfmt = '%H:%i:%s %d.%m.%Y';
	if( $dtsqltpl != "" )
		$dtsqlfmt = $dtsqltpl;

	$query = "SELECT c1.*, DATE_FORMAT(c1.add_date, '$dtsqlfmt') as dtstr, c2.content FROM $TABLE_NEWS_COMMENT c1
		INNER JOIN $TABLE_NEWS_COMMENT_LANGS c2 ON c1.id=c2.item_id AND c2.lang_id='$LangId'
		WHERE c1.item_id='$comp_id' AND c1.visible=1
		ORDER BY add_date DESC
		$limit_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
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
	//	echo mysqli_error();

	return $coms;
}
?>
