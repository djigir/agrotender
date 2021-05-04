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
	
	$sql_cond = "";
	$join_cond = "";
	
	if( $oblid != 0 )
	{
		$sql_cond .= " AND c1.obl_id='".addslashes($oblid)."' ";
	}
	if( $topicid != 0 )
	{
		$join_cond .= " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC i2t ON c1.id=i2t.item_id AND i2t.topic_id='".addslashes($topicid)."' ";
	}
	else if( $topicid0 != 0 )
	{
		$join_cond .= " INNER JOIN $TABLE_COMPANY_ITEMS2TOPIC i2t ON c1.id=i2t.item_id 
		INNER JOIN $TABLE_COMPANY_TOPIC t1 ON i2t.topic_id=t1.id AND t1.menu_group_id='".addslashes($topicid0)."' ";
	}

	$outcsv = "";

	$query = "SELECT DISTINCT b1.login FROM $TABLE_TORG_BUYERS b1
		INNER JOIN $TABLE_COMPANY_ITEMS c1 ON b1.id=c1.author_id 
		$join_cond 
		WHERE b1.login<>'' $sql_cond ";
	
	//echo $query."<br>";
		
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while($row = mysqli_fetch_object($res))
		{
			$outcsv .= "\"".trim(stripslashes($row->login))."\";;\r\n";
		}
		mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db);

	header("Content-Type: text/csv; name=\"allemails_".date("dmY", time()).".csv\";");
	header("Content-Disposition: attachment; filename=\"allemails_".date("dmY", time()).".csv\";");

	echo $outcsv;

	////////////////////////////////////////////////////////////////////////////////////////

	//include("inc/footer-inc.php");
	include("../inc/close-inc.php");
?>
