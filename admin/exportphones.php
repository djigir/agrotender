<?php
include "../inc/db-inc.php";
include "../inc/connect-inc.php";
//include "../inc/ses-inc.php";
//include "inc/authorize-inc.php";

$outcsv = "";

$query = "SELECT phone FROM $TABLE_TORG_BUYERS WHERE phone<>''";
if( $res = mysqli_query($upd_link_db,$query) )
{
	while($row = mysqli_fetch_object($res))
	{
		$outcsv .= "\"".stripslashes($row->phone)."\";;\r\n";
	}
	mysqli_free_result($res);
}

$query = "SELECT DISTINCT phone FROM $TABLE_ADV_POST WHERE phone<>''";
if( $res = mysqli_query($upd_link_db,$query) )
{
	while($row = mysqli_fetch_object($res))
	{
		$outcsv .= "\"".stripslashes($row->phone)."\";;\r\n";
	}
	mysqli_free_result($res);
}

header("Content-Type: text/csv; name=\"allphones_".date("dmY", time()).".csv\";");
header("Content-Disposition: attachment; filename=\"allphones_".date("dmY", time()).".csv\";");

echo $outcsv;


//include("inc/footer-inc.php");
include("../inc/close-inc.php");
?>
