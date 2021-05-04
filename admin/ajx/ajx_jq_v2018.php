<?php
	include "../../inc/db-inc.php";
	include "../../inc/connect-inc.php";

	include "../../inc/utils-inc.php";
	//include "../inc/utils2-inc.php";
	include "../../inc/torgutils-inc.php";
	
	include "../../inc/ses-inc.php";
	include "../inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: /admin/index.php");
		exit();
    }

	$AJX_COMMAND_TOPICS	= "uh_com_topics";	
	$AJX_COMMAND_COMPTOPICS	= "uh_com_ctopics";	
	
	$cmd = GetParameter("cmd", "");
	
	//var_dump($_GET);
	
	//echo $cmd;

	$content_text = "";
	$prodarr = Array();
    switch( $cmd )
    {
		case $AJX_COMMAND_TOPICS:
			$tid = GetParameter("tid", 0);
			
			//echo "!!!";
			$json_txt = '';
			
			$subtopics = Board_TopicLevel($LangId, $tid);
			for( $j=0; $j<count($subtopics); $j++ )
			{
				$json_txt .= ($json_txt != "" ? "," : "").'{"tn":"'.$subtopics[$j]['name'].'","tid":'.$subtopics[$j]['id'].'}';
				//echo '<option value="1:'.$subtopics[$j]['id'].'"'.($topicsid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
			}
			
			$json_txt = '{"tlist":['.$json_txt.']}';
			
			$content_text = $json_txt;
			
			break;		

		case $AJX_COMMAND_COMPTOPICS:
			$tid = GetParameter("tid", 0);
			
			//echo "!!!";
			$json_txt = '';
			
			$subtopics = Array();
			
			$query = "SELECT t1.* 
				FROM $TABLE_COMPANY_TOPIC t1
				WHERE t1.parent_id='0' AND t1.menu_group_id='$tid' 
				ORDER BY t1.sort_num, t1.title";
			if( $res = mysql_query( $query ) )
			{
				while( $row = mysql_fetch_object( $res ) )
				{
					$tit = Array();
					$tit['id'] = $row->id;
					$tit['name'] = stripslashes($row->title);
					
					$subtopics[] = $tit;					
				}
				mysql_free_result( $res );
			}
			
			for( $j=0; $j<count($subtopics); $j++ )
			{
				$json_txt .= ($json_txt != "" ? "," : "").'{"tn":"'.$subtopics[$j]['name'].'","tid":'.$subtopics[$j]['id'].'}';
				//echo '<option value="1:'.$subtopics[$j]['id'].'"'.($topicsid == $subtopics[$j]['id'] ? ' selected' : '').'> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;'.$subtopics[$j]['name'].'</option>';
			}
			
			$json_txt = '{"tlist":['.$json_txt.']}';
			
			$content_text = $json_txt;
			
			break;	

   		case "getvars":
   			//phpinfo();
   			break;

   		default:
   			//RunTest();
   			break;
    }

	//echo "!!!!";
    //var_dump( $_COOKIE['pids'] );

	header("Content-Type: text/plain; charset=windows-1251");
    //header("Content-Type: text/plain; charset=utf-8");
    //header("Content-Encoding: windows-1251");
	//echo join(",", $prodarr);
	//var_dump($_COOKIE['pids']);
	echo $content_text;

function CompareAddHtml($pid, $tid)
{
	global $_COOKIE;
	//var_dump( $_COOKIE['pids'] );

	// All ids should be in array like string separated by commas (example: 12,34,5532,2243, etc)
	$prodarrstr = ( ( isset($_COOKIE['pids']) && (trim($_COOKIE['pids']) != "") ) ? trim($_COOKIE['pids']) : "" );
	$prodarrtmp = split(",", $prodarrstr);
	for($i=0; $i<count($prodarrtmp); $i++)
	{
		$prodarr[] = (int)$prodarrtmp[$i];
	}

	$prodarr[] = $pid;
	setcookie("pids", join(",", $prodarr), time()+3600);

	return $prodarrstr;
}

function GetSearchListByStart($q_str)
{
	global $TABLE_TORG_SEARCH; //$TABLE_SEARCH_WORDS,

	$list_html = "";

	$words = Array();

	$found_prod_ids = Array();

	$query = "SELECT * FROM $TABLE_TORG_SEARCH WHERE title LIKE '%".addslashes($q_str)."%' ORDER BY rating DESC, title LIMIT 0,12";
	if( $res = mysql_query( $query ) )
	{
		while( $row = mysql_fetch_object( $res ) )
		{
			//if( empty( $found_prod_ids[$row->item_id] ) )
			//{
			//	$found_prod_ids[$row->item_id] = true;
			//}
			//else
			//{
			//	continue;
			//}

			$wi = Array();
			$wi['id'] = $row->id;
			$wi['item_id'] = $row->item_id;
			//$wi['item_db_id'] = $row->item_db_id;
			//$wi['word'] = "<b>".$q_str."</b>".substr( stripslashes($row->title), strlen($q_str) );//str_replace( $q_str, "<b>".$q_str."</b>", stripslashes($row->sw));
			$wi['pic'] = '';
			$wi['pic_w'] = 0;
			$wi['pic_h'] = 0;

			if( $row->word_content == 1 )	// т.е. єто слово создано по названию раздела каталога
			{
				//$wi['word'] = str_ireplace( $q_str, "<b>".$q_str."</b>", stripslashes($row->title)).' (раздел каталога)';
				$wi['word'] = str_replace( $q_str, "<b>".$q_str."</b>", stripslashes($row->title)).' (раздел каталога)';
			}
			else
			{
				//$wi['word'] = str_ireplace( $q_str, "<b>".$q_str."</b>", stripslashes($row->title));
				$wi['word'] = str_replace( $q_str, "<b>".$q_str."</b>", stripslashes($row->title));

				/*
				$query1 = "SELECT * FROM $TABLE_CAT_ITEMS_PICS
					WHERE item_id=".$wi['item_id']."
					ORDER BY sort_num
					LIMIT 0,1";
				if( $res1 = mysql_query( $query1 ) )
				{
					if( $row1 = mysql_fetch_object( $res1 ) )
					{
						$wi['pic'] = stripslashes($row1->filename_ico);

						$pdim = Image_RecalcSize( $row1->ico_w, $row1->ico_h, 70, 50 );

						$wi['pic_w'] = $pdim["w"]; //$row1->ico_w;
						$wi['pic_h'] = $pdim["h"]; //$row1->ico_h;
					}
					mysql_free_result( $res1 );
				}
				*/
				//else
				//	$wi['pic'] = mysql_error();
			}

			$words[] = $wi;

			if( count($words) > 10 )
			{
				break;
			}
		}
		mysql_free_result( $res );
	}
	//else
	//	echo mysql_error()."<br />";

	$was_added = false;
	$list_html = "{\"words\": [ \r\n";

	for($i=0; $i<count($words); $i++)
	{
        if ($was_added)
            $list_html .= ",\r\n";

        $list_html .= "{ id: \"".$words[$i]['id']."\", itid: \"".$words[$i]['item_id']."\", word: \"".addslashes($words[$i]['word'])."\", p: \"".$words[$i]['pic']."\", pw: ".$words[$i]['pic_w'].", ph: ".$words[$i]['pic_h']." }";
        $was_added = true;
	}
	$list_html .= "\r\n] };";

	return $list_html;
}

function RunTest()
{
	$list_html = "Test";

	return $list_html;
}



?>
