<?php
error_reporting(E_ALL);
	//$arrMonths =  Array("January","February","March","April","May","June","July","August","September","October","November","December");
	//$arrWeekDays = Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");


	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	//include "inc/authorize-inc.php";

	// Include Top Header HTML Style
	//include "inc/header-inc.php";

/*
	if(isset($_POST['action']))			$action = $_POST['action'];
	else if(isset($_GET['action']))		$action = $_GET['action'];
	else									$action = "";

	if(isset( $_POST['mode'] ))			$mode = $_POST['mode'];
	else if(isset( $_GET['mode'] ))		$mode = $_GET['mode'];
	else									$mode = "today";

	if( isset( $_GET['daytime'] ) )		$daytime = $_GET['daytime'];
	else									$daytime = time();

	$year = date("Y", $daytime);
	$month = date("n", $daytime);
	$day = date("j", $daytime);
*/
	// Already retrieved in inc file
  //$real_time = time();
  //$real_year = date("Y", $real_time);
  //$real_month = date("n", $real_time);
  //$real_day = date("j", $real_time);
?>
<html>
<head>
	<title>Календарь</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
 	<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<script language="javascript" src="js/utils.js"></script>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
<style type="text/css">
.calth{
	font-weight: bold;
	background-color: #c20001;
	color: #FFFFFF;
	text-align: center;
}

.caltd{
	background-color: #f1ce63;
	padding: 0px 2px 1px 2px;
	text-align: center;
}

.caltdo{
	font-weight: normal;
	background-color: #f7efe3;
	padding: 0px 2px 1px 2px;
	text-align: center;
}

a.callink { font-size: 8pt; font-family: Verdana, Arial, Tahoma, Helvetica; color: #1864a4; font-weight:normal; text-decoration: underline }
a.callink:hover { font-size: 8pt; font-family: Verdana, Arial, Tahoma, Helvetica; color: #004484; font-weight:normal; text-decoration: underline }

a.callink1 { font-size: 8pt; font-family: Verdana, Arial, Tahoma, Helvetica; color: #FFFFFF; font-weight:bold; text-decoration: underline }
a.callink1:hover { font-size: 8pt; font-family: Verdana, Arial, Tahoma, Helvetica; color: #D0D0D0; font-weight:bold; text-decoration: underline }
</style>
<?php
	$arrMonths =  Array("", "Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
	$arrWeekDays = Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");

	$target = GetParameter("target", "");

	$cur_time = time();

	$real_year = date("Y", $cur_time);
	$real_month = date("n", $cur_time);
	$real_day = date("j", $cur_time);

	if(empty($_GET['cur_year']))		$cur_year = date("Y", $cur_time);
	else								$cur_year = $_GET['cur_year'];

	if(empty($_GET['cur_month']))		$cur_month = date("n", $cur_time);
	else								$cur_month = $_GET['cur_month'];

	if(empty($_GET['cur_day']))			$cur_day = date("j", $cur_time);
	else								$cur_day = $_GET['cur_day'];

	$timeval = mktime(1, 0, 0, $cur_month, $cur_day, $cur_year);

	$datestr = getdate($timeval);
?>
	<div class="panel">
	<table cellspacing="2" cellpadding="0" border="0" width="190">
	<tr>
		<th class="calth" colspan="7">
			<a class="callink1" href=<?=($PHP_SELF."?target=$target&cur_year=".( ($cur_month==1) ? ($cur_year-1) : $cur_year )."&cur_month=".( ($cur_month == 1) ? 12 : ($cur_month-1))."&cur_day=$cur_day");?>>&lt;&lt;</a>
			<?=($arrMonths[$datestr['mon']]." ".$datestr['year']);?>
			<a class="callink1" href=<?=($PHP_SELF."?target=$target&cur_year=".( ($cur_month==12) ? ($cur_year+1) : $cur_year )."&cur_month=".( ($cur_month == 12) ? 1 : ($cur_month+1))."&cur_day=$cur_day");?>>&gt;&gt;</a>
		</th>
	</tr>
	<tr>
		<th width="15%" class="calth">Пн</th>
		<th width="14%" class="calth">Вт</th>
		<th width="14%" class="calth">Ср</th>
		<th width="14%" class="calth">Чт</th>
		<th width="14%" class="calth">Пт</th>
		<th width="14%" class="calth">Сб</th>
		<th width="15%" class="calth">Вс</th>
	</th>
<?php
	$tmp_time = mktime(1, 0, 0, $datestr['mon'], 1, $datestr['year']);

	//while( date("w", $tmp_time) != 0 )
	while( date("w", $tmp_time) != 1 )
	{
		//echo "->".date("w", $tmp_time)."<br />";
		$tmp_time = strtotime("-1 day", $tmp_time);
	}

	$first_day = 0;

	while(true)
    {
        echo "<tr>";
        for($i=0; $i<7; $i++)
		{
            if(date("j", $tmp_time) == 1)
            	$first_day++;

            if( ($real_year == date("Y",$tmp_time)) && ($real_month == date("m",$tmp_time)) && ($real_day == date("d",$tmp_time)) )
            {
            	$is_today = true;
            }
            else
            {
            	$is_today = false;
            }

            if($first_day == 1)
            {
				echo "<td class=\"caltd\" ".($is_today ? "style=\"background-color:#f29192\"" : "")."><a class=\"callink\" title=\"No Events\" href=\"javascript:DateChoose('".date("d.m.Y", $tmp_time)."','$target');\">".date("j",$tmp_time)."</a></td>";
			}
			else
				echo "<td class=\"caltdo\">".date("j",$tmp_time)."</td>";

			$tmp_time = strtotime("+1 day", $tmp_time);
        }
        echo "</tr>";
        if(date("j", $tmp_time) == 1)
        	$first_day++;
        if($first_day == 2)
        	break;
    }
?>
	</table>
	</div>

</body>
</html>
<?php
	//include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
