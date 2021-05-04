<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    include "../inc/utils-inc.php";
    //include "../inc/catutils-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }

function checkDtFormat($dt)
{
	if( !(
		is_numeric(substr($dt, 0, 1)) &&
		is_numeric(substr($dt, 1, 1)) &&
		is_numeric(substr($dt, 3, 1)) &&
		is_numeric(substr($dt, 4, 1)) &&
		is_numeric(substr($dt, 6, 1)) &&
		is_numeric(substr($dt, 7, 1)) &&
		is_numeric(substr($dt, 8, 1)) &&
		is_numeric(substr($dt, 9, 1))
		) )
		return false;

	$starr = @split("[.]", $dt);
	if( (count($starr) == 3) &&
		is_numeric($starr[1]) && is_numeric($starr[0]) && is_numeric($starr[2]) &&
	 	!checkdate( $starr[1], $starr[0], $starr[2] ) )
	{
		return false;
	}

	return true;
}

	$strings['tipedit']['en'] = "Edit This Comment";
   	$strings['tipdel']['en'] = "Delete This Comment";
   	$strings['hdrlist']['en'] = "Comment List";
   	$strings['hdradd']['en'] = "Add Comment";
   	$strings['hdredit']['en'] = "Edit Comment";
   	$strings['rowdate']['en'] = "Comment date";
   	$strings['rowtitle']['en'] = "Name";
   	$strings['rowfirst']['en'] = "Preview Page";
   	$strings['rowtext']['en'] = "Comment Text";
   	$strings['rowbrand']['en'] = "Company Source";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No comments in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";
	$strings['product']['en'] ="Product";

    $strings['tipedit']['ru'] = "Редактировать этот отзыв";
   	$strings['tipdel']['ru'] = "Удалить этот отзыв";
   	$strings['hdrlist']['ru'] = "Список отзывов";
   	$strings['hdradd']['ru'] = "Добавить отзыв";
   	$strings['hdredit']['ru'] = "Редакировать отзыв";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Отображать в анонсе";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет отзывов";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";
	$strings['product']['ru']="Продукт";
	$strings['article']['ru']="Статья";

	$PAGE_HEADER['ru'] = "Обзор активных трейдеров";
	$PAGE_HEADER['en'] = "Comment Editing";

	include "inc/header-inc.php";
	
	
	function get_array_for_table ( $comp_id )
	{
		global $upd_link_db;
		$get_table = array();
		global  $sum;
		$sum = array();
		$query = "SELECT *, cult.name name FROM `agt_traders_prices` price JOIN `agt_comp_items` comp ON (price.buyer_id = comp.author_id) JOIN `agt_traders_places` place ON (place.id = price.place_id) JOIN `agt_traders_products_lang` cult ON (cult.id = price.cult_id) WHERE comp.id  = $comp_id GROUP BY name";
		$res = mysqli_query($upd_link_db,$query);
		$i = 1;
		while ( $row = mysqli_fetch_object ( $res ) )
		{
			$cultid = $row->name;
			$get_table[0][$i] = $cultid;
		$i++;
		}

		$query = "SELECT *, price.place_id placeid, place.obl_id obl, place.place place FROM `agt_traders_prices` price JOIN `agt_comp_items` comp ON (price.buyer_id = comp.author_id) JOIN `agt_traders_places` place ON (place.id = price.place_id) WHERE comp.id  = $comp_id GROUP BY price.place_id ORDER BY obl";
		$res = mysqli_query($upd_link_db,$query);
		$i = 1;
		while ( $row = mysqli_fetch_object ( $res ) )
		{
			$placeid = $row->placeid;
			$oblid = $row->obl;
			$get_table[$i][] = $placeid;
			$sum [$i][0] = $row->place;
			$sum [$i][1] = $row->obl;

			//$sum [$i] = $row -> obl;
			$i++;
		}
		
		
		echo '<pre>';
		//print_r($place_cult_array);
		echo '</pre>';
		return $get_table;
		
	}

	
	function getTable ( $comp_id, $pr_type, $pr_cur_type )
	{

      global $upd_link_db;
	$query = "SELECT cult.id cultid, cult.name name, price.costval cost, price.comment comment, place.obl_id obl, place.place place, place.id placeid FROM `agt_traders_prices` price JOIN `agt_torg_buyer` buy ON (price.buyer_id = buy.id) JOIN `agt_comp_items` comp ON (comp.author_id = buy.id) JOIN `agt_traders_products_lang` cult ON (cult.id = price.cult_id) JOIN `agt_traders_places` place ON (place.id = price.place_id) WHERE comp.id = $comp_id AND price.acttype = $pr_type AND price.curtype = $pr_cur_type ORDER BY cultid, place";
	$res = mysqli_query($upd_link_db, $query);
	$get_table = [];
	while ( $row = mysqli_fetch_object ( $res ) )
		{
		
			$placeid = $row->placeid;
			$cultid = $row->name;
			$oblid = $row->obl;

		
		//	if ($place == '') $place = 'empty';
		//	$get_table[$plceobl][$cultid] = $row -> obl;
		//	$get_table[$i][$placeid][$cultid] = $row -> place;
		//	$get_table[$plceobl][$cultid] = $row -> place;				
		//	$get_table[$i][$placeid][$cultid] = $row -> name;
		//	$get_table[$plceobl][$cultid] = $row -> name;	
			$get_table[$placeid][$cultid] = $row->cost.'<br>'. $row->comment;
		//	$get_table[$plceobl][$cultid] = $row -> comment;
		//	$get_table[$plceobl][$cultid] = $row -> cultid;
		//	echo $name;

		}

		return $get_table;
	}
	
	$query = "SELECT *, TO_DAYS(NOW()) - TO_DAYS(trader_price_dtupdt) as term FROM `agt_comp_items` WHERE trader_price_avail = 1 ORDER BY trader_price_dtupdt";
	
	$res = mysqli_query($upd_link_db, $query);
	?>
	<table style ="border: 5px solid black; text-align:center; margin-top: 30px; font-size : 12px; width : 100%; border-spacing : 0px;">
	<tr>
	<th>№</th><th>ID Комп.</th><th>Лого</th><th>Название</th><th>Закупки ГРН</th><th>Закупки $</th><th>Тбл.Скрыта</th><th>Последнее обновление</th><th>Дн. назад</th>
	</tr>
	<?php
		$number = 1;
		$stle = '"border: 1px black solid;"';
		$stle1 = '"border: 1px black solid;"';
		$stle2 = '"border-bottom: 1px black solid;"';
		$stle5 = '"border: 1px black solid; background: green; color: white;"';
		$freecomp = array (2728, 792, 803, 3457);
		while ($row = mysqli_fetch_object($res))
		{   

			$id_user = $row->author_id;
			$id_comp = $row->id;
			$comp_name = $row->title;
			$obl_id = $row->obl_id;
			$trader = $row->trader_price_avail;
			$visible = $row->trader_price_visible;
			$dateupdt = date( "d.m Y", strtotime(mysqli_fetch_array(mysqli_query($upd_link_db, "select date_format(dt, '%d.%m.%Y') as updateDate from agt_traders_prices where buyer_id = {$row->author_id} order by dt desc"))['updateDate']) );
			$term = $row->term;
			$logo = $row->logo_file;
			$arr_trdr_Table = get_array_for_table ( $id_comp );
			$trdr_Table  = getTable ( $id_comp, 0, 0);
			$trdr_Table1  = getTable ( $id_comp, 0, 1);
			if (in_array( $id_comp, $freecomp )) continue;
			echo "<tr>
					<td style = $stle>$number</td> 
					<td style = $stle>".'<a target="_blank"'." href=".$WWWHOST."kompanii/comp-".$id_comp."-pricetbl.html>".$id_comp."</td>
					<td style = $stle><img src = ".'"'.$WWWHOST.$logo.'"'." width = ".'30px'." height = ".'30px'."></td>
					<td style = $stle>$comp_name</td>
					<td style = $stle5 id = ".'"button'.$id_comp.'"'.">Закуп ГРН</td>
					<td style = $stle5 id = ".'"baksbutton'.$id_comp.'"'.">Закуп $</td>
					<td style = $stle>".($visible ? '<x  style = "color:green">НЕТ</x>' : '<b style = "color:red">ДА</b>')."</td>
					<td style = $stle>".$dateupdt."</td>
					<td style = $stle>".$term."</td>					
				 </tr>";
				 echo '<tr><td colspan ="9" style = '.$stle2.'>';
				 echo '<table style = "border-spacing : 0px; text-align : center; display : none; float: left; margin: 10px;" id = "comp-'.$id_comp.'">';
				
			if (count($arr_trdr_Table) == 0) 
			{
				echo'<tr><td>НЕТ ГРИВНЕВОЙ ТАБЛИЦЫ</td></tr>';
			}
			else
				for ($i = 0; $i < count($arr_trdr_Table); $i++)
					{
					echo'<tr>';
					if (($trdr_Table == '') || ($arr_trdr_Table == '')) 
					{
						echo '<td>НЕТ ГРИВНЕВОЙ ТАБЛИЦЫ</td>';
						break;
					} 
					for ($j = 0 ;$j <= count($arr_trdr_Table[0]); $j++)
					   {
						   //if ( (array_key_exists( $arr_trdr_Table[0], ) ) break;
						   if ( $i == 0 ) echo "<td  style = $stle1>".(($j == 0 && $i == 0) ? '<i><b>ГРИВНА</b></i>' :$arr_trdr_Table[$i][$j])."<br>"."</td>";
						   else if (!isset($trdr_Table[$arr_trdr_Table[$i][0]]) or count($trdr_Table[$arr_trdr_Table[$i][0]]) == 0) break;
						   else if ( $j == 0 ) echo "<td  style = $stle1>".$REGIONS[$sum[$i][1]]."<br>".$sum[$i][0]."</td>";
						   else 
						   {
						   	if (isset($trdr_Table[$arr_trdr_Table[$i][0]][$arr_trdr_Table[0][$j]])) {
						   	  $var1 = $trdr_Table[$arr_trdr_Table[$i][0]][$arr_trdr_Table[0][$j]];
						   	} else {
						   	  $var1 = '';
						   	 }
								echo "<td  style = $stle1>".$var1."<br>"."</td>";
								
							//	echo $arr_trdr_Table[0][$j];
							
						   }

						  // echo 'Ключ ='.$arr_trdr_Table[0][$j].'<br>';
						 //  echo'<br>========<br><br>';
						//		print_r ($trdr_Table);

					   }
					//echo '<pre> Массив';
					//print_r ( $trdr_Table[$arr_trdr_Table[$i][0]]);
					//echo '</pre>';
					 echo'</tr>';
					}

				 echo'</table>';
				 
				 
				 
				 

				 
				 echo '<table style = "border-spacing : 0px; text-align : center; display : none; float :left;  margin: 10px;" id = "bakscomp-'.$id_comp.'">';
				
			if (count($arr_trdr_Table) == 0) 
			{
				echo'<tr><td>НЕТ ДОЛЛАРОВОЙ ТАБЛИЦЫ</td></tr>';
			}
			else
				for ($i = 0; $i < count($arr_trdr_Table); $i++)
					{
					echo'<tr>';
					if (($trdr_Table1 == '') || ($arr_trdr_Table == '')) 
					{
						echo '<td>НЕТ ДОЛЛАРОВОЙ ТАБЛИЦЫ</td>';
						break;
					} 
					for ($j = 0 ;$j <= count($arr_trdr_Table[0]); $j++)
					   {
						   //if ( (array_key_exists( $arr_trdr_Table[0], ) ) break;
						   if ( $i == 0 ) echo "<td  style = $stle1>".(($j == 0 && $i == 0) ? '<i><b>ДОЛЛАР</b></i>' :$arr_trdr_Table[$i][$j])."<br>"."</td>";
						   else if (!isset($trdr_Table1[$arr_trdr_Table[$i][0]]) or count($trdr_Table1[$arr_trdr_Table[$i][0]]) == 0) break;
						   else if ( $j == 0 ) echo "<td  style = $stle1>".$REGIONS[$sum[$i][1]]."<br>".$sum[$i][0]."</td>";
						   else 
						   {
						   	  if (isset($trdr_Table1[$arr_trdr_Table[$i][0]][$arr_trdr_Table[0][$j]])) {
						   	  	$var1 = $trdr_Table1[$arr_trdr_Table[$i][0]][$arr_trdr_Table[0][$j]];
						   	  } else {
						   	  	$var1 = '';
						   	  }
								echo "<td  style = $stle1>".$var1."<br>"."</td>";
								
							//	echo $arr_trdr_Table[0][$j];
							
						   }

						  // echo 'Ключ ='.$arr_trdr_Table[0][$j].'<br>';
						 //  echo'<br>========<br><br>';
						//		print_r ($trdr_Table);

					   }
					//echo '<pre> Массив';
					//print_r ( $trdr_Table[$arr_trdr_Table[$i][0]]);
					//echo '</pre>';
					 echo'</tr>';
					}

				 echo'</table>';				 
				 
				//echo ('<pre>');
				// print_r($trdr_Table);
				// echo ('</pre>---------------------------');
				 
				//echo ('<pre>');
				// print_r($arr_trdr_Table);
				//echo ('</pre>');
				 
				 $number++;
				 
				// if ($number == 10) break;
				 echo '</td></tr>';
				 
				?>

				<script>
				var speed = 500;
				$("#button<?=$id_comp?>").mousedown(function() {
				//$(".headnohover").css("display", "none");
				if ( $("#comp-<?=$id_comp?>").is(":visible") == false ){
					$("#comp-<?=$id_comp?>").show(speed);
					$("#comp-<?=$id_comp?>").css("display", "block");
					$(this).css("background", "red");
				}
				else {
					$("#comp-<?=$id_comp?>").hide(speed);
				//	$("#comp-<?=$id_comp?>").css("display", "none");
				//	$("#button<?=$id_comp?>").html('ПОКАЗАТЬ');
					$(this).css("background", "green");
				}
				});
				
				$("#baksbutton<?=$id_comp?>").mousedown(function() {
				//$(".headnohover").css("display", "none");
				if ( $("#bakscomp-<?=$id_comp?>").is(":visible") == false ){
					$("#bakscomp-<?=$id_comp?>").show(speed);
					$("#bakscomp-<?=$id_comp?>").css("display", "block");
					$(this).css("background", "red");
				}
				else {
					$("#bakscomp-<?=$id_comp?>").hide(speed);
				//	$("#bakscomp-<?=$id_comp?>").css("display", "none");
				//	$("#baksbutton<?=$id_comp?>").html('ПОКАЗАТЬ');
					$(this).css("background", "green");
				}
				});

				</script>	
	<?php
				 
				 
				 
		}
	
	echo "</table>";

			
    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
