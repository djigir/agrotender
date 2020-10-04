<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

	if( $UserId == 0 )
	{
		header("Location: index.php");
		exit();
	}
	
	$topicid0 = GetParameter("topicid0", 0);
	$topicid = GetParameter("topicid", 0);
	$oblid = GetParameter("oblid", 0);
	
	///////////////////////////////////////////////////////////////////////////////////////

	$outcsv = "";
	
	if( ($topicid0 == 0) && ($topicid == 0) && ($oblid == 0) )
	{
		$query = "SELECT b1.login, c1.id FROM $TABLE_TORG_BUYERS b1
			LEFT JOIN $TABLE_COMPANY_ITEMS c1 ON b1.id=c1.author_id
			WHERE b1.login<>''";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while($row = mysqli_fetch_object($res))
			{
				$outcsv .= "\"".trim(stripslashes($row->login))."\";".($row->id == null ? 1 : 2).";\r\n";
			}
			mysqli_free_result($res);
		}
	}

	$sql_cond = "";
	$join_cond = "";
	
	if( $oblid != 0 )
	{
		$join_cond .= " INNER JOIN $TABLE_ADV_POST2OBL p2o ON p1.id=p2o.post_id AND p2o.obl_id='".addslashes($oblid)."' ";
	}
	if( $topicid != 0 )
	{
		$sql_cond .= " AND p1.topic_id='".addslashes($topicid)."' ";
	}
	else if( $topicid0 != 0 )
	{
		$join_cond .= " INNER JOIN $TABLE_ADV_TOPIC t1 ON p1.topic_id=t1.id AND t1.parent_id='".addslashes($topicid0)."' ";
	}
	
	$query = "SELECT DISTINCT p1.email 
		FROM $TABLE_ADV_POST p1 
		$join_cond 
		WHERE p1.email<>'' $sql_cond ";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row = mysqli_fetch_object($res))
		{
			$outcsv .= "\"".trim(stripslashes($row->email))."\";0;\r\n";
		}
		mysqli_free_result($res);
	}

	header("Content-Type: text/csv; name=\"allemails_".date("dmY", time()).".csv\";");
	header("Content-Disposition: attachment; filename=\"allemails_".date("dmY", time()).".csv\";");

	echo $outcsv;


	//////////////////////////////////////////////////////////////////////////////////
	//include("inc/footer-inc.php");
	include("../inc/close-inc.php");
?>
