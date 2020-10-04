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

	$PAGE_HEADER['ru'] = "Редактировать Публикации";
	$PAGE_HEADER['en'] = "Comment Editing";

	$limit0 = 0;
	$limit1 = 500;
	$maxprice = 27000;
	$minprice = 150;
	
	$max = ( isset( $_GET['max'] ) ? ( $_GET['max'] == ''  ? 30000 :  $_GET['max'] ) : $maxprice );
	$min = ( isset( $_GET['min'] ) ? ( $_GET['min'] == ''  ? 0 :  $_GET['min'] ) : $minprice );
	$ord = "main.costval";
	$grp = "main.costval, main.curtype";
	$grp = ($_GET[glueprice] == 'no' ? "main.id" : "main.costval");
	$buySell = ( (!isset($_GET[buysell]) or $_GET[buysell] == 'all') ? '' : ($_GET[buysell] == 'yes' ? 'AND main.acttype = 0' : 'AND main.acttype = 1'));
	
	$AYesNo =(isset($_GET[actpas]) ? ($_GET[actpas] == 'activ' ? '= 1' : ($_GET[actpas] == 'pasiv' ? '=0' : '< 2')) : '=1');
	$ActiveOrPassive ="comp.trader_price_avail $AYesNo";
	
	$GYesNo =(isset($_GET[grnusd]) ? ($_GET[grnusd] == 'grn' ? '= 0' : ($_GET[grnusd] == 'usd' ? '=1' : '< 2')) : '<=1');
	if (isset($_GET[uptdate]))
		{
			switch ($_GET[uptdate])
				{
					case 1:
					$ord = "main.costval";
					break;
					case 2:
					$ord = "cult.name";
					break;
					case 3:
					$ord = "comp.title";
					break;
					case 4:
					$ord = "comp.trader_price_dtupdt";
					$grp = $ord;
					break;
				}
		}

	if (isset($_GET['group']))
		{
			if ($_GET['group'] == "Yes") $grp = "";
		}
	
	$GrnUsd = "main.curtype $GYesNo";
	// Include Top Header HTML Style 
//	$grp = "arch.costval, arch.curtype";
	include "inc/header-inc.php";
/*	$query = "SELECT 
	main.buyer_id, 
	comp.id, 
	comp.title,
	comp.trader_price_avail, 
	comp.trader_price_dtupdt, 	
	cult.name,
	main.costval, 
	main.curtype, 	
	places.obl_id, 
	places.place 
	FROM `agt_traders_prices_arc` AS main 
	JOIN `agt_comp_items` AS comp ON (main.buyer_id = comp.author_id) 
	JOIN `agt_traders_products_lang` AS cult ON (cult.id = main.cult_id) 
	JOIN `agt_traders_places` AS places ON (main.buyer_id = places.buyer_id) WHERE (comp.id <> '' AND $ActiveOrPassive AND $GrnUsd AND (main.costval > $max OR main.costval < $min))  GROUP BY $grp
	ORDER BY $ord DESC LIMIT 1000";*/
	
	
	$query = "SELECT 
			main.buyer_id, 
			comp.id, 
			comp.title, 
			comp.trader_price_avail, 
			comp.trader_price_dtupdt, 
			cult.name, 
			main.costval, 
			main.curtype,
			main.acttype,			
			places.obl_id,  
			places.place 
	FROM 
	".($_GET[arch] != "archive" ? $TABLE_TRADER_PR_PRICES : "`agt_traders_prices_arc`")." AS main LEFT JOIN `agt_traders_products_lang` AS cult ON main.cult_id = cult.item_id 
	LEFT JOIN `agt_comp_items`  AS comp ON main.buyer_id = comp.author_id 
	LEFT JOIN `agt_traders_places` AS places ON main.buyer_id = places.buyer_id
	WHERE ($ActiveOrPassive AND $GrnUsd AND ( main.costval > $max OR main.costval < $min )  
	". $buySell .") GROUP BY $grp
	ORDER BY $ord DESC ".($_GET[arch] == "archive" ? "LIMIT 1000" : "");
	

	$res = mysqli_query($upd_link_db,$query);
	$selected = 'selected ="selected"';
	?>
	<form method = "GET">

	<div style ="float:left">
	<b>Таблица: Актуальная/Архив</b><br>
	<select style ="float:left; width:150px;" name = "arch">
		<option value ="current"<?=((isset($_GET[arch])&& $_GET[arch]== "current") ? $selected : $selected)?>>Актуальная</option>
		<option value ="archive"<?=($_GET[arch] == "archive" ? $selected :'')?>>Архив</option>

	</select>	
	
	</div>	



	<div style ="float:left">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </div>	
	<div style ="float:left">
	<b>Отображение цен:</b><br>
	<select name = "buysell">
		<option value ="all" <?=( isset($_GET[buysell]) ? ($_GET[buysell] == 'all' ? $selected : '') : '')?>>Все</option>
		<option value ="yes" <?=( $_GET[buysell] == 'yes'? $selected : '' )?>>Закупки</option>
		<option value ="no"  <?=( $_GET[buysell] == 'no' ? $selected : '' )?>>Продажи</option>

	</select>
	</div> 
		
	
	<div style ="float:left">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </div>	
	<div style ="float:left">
	Отображение цен:<br>
	<select name = "glueprice">
		<option value ="yes" <?= (isset($_GET[glueprice]) ? ($_GET[glueprice] == 'yes' ? $selected : '') : '')?>>Только разные</option>
		<option value ="no" <?=($_GET[glueprice] == 'no' ? $selected : '')?>>Все цены</option>
	</select>
	</div> 


	
	<div style ="float:left"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
 	</div>
	<div style ="float:left">
	Отображать трейдеров: <br>
	<select name = "actpas">
		<option value ="activ" <?= (isset($_GET[actpas]) ? ($_GET[sctpas] == 'activ' ? $selected : '') : '')?>>Активных</option>
		<option value ="pasiv") <?=($_GET[actpas] == 'pasiv' ? $selected : '')?>>Отключенных</option>
		<option value ="all" <?=($_GET[actpas] == 'all' ? $selected : '')?>>Всех</option>
	</select>
	</div>
	<div style ="float:left"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
 	</div>
	<div style ="float:left">
	Таблицы:<br>
	<select style ="float:left" name = "grnusd">
		<option value ="all" <?= (isset($_GET[grnusd]) ? ($_GET[grnusd] == 'all' ? $selected : '') : '')?>>ВСЕ</option>
		<option value ="usd" <?=($_GET[grnusd] == 'usd' ? $selected : '')?>>$</option>
		<option value ="grn" <?=($_GET[grnusd] == 'grn' ? $selected : '')?>>ГРН</option>
	</select>
	</div> 
	<div style ="float:left">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </div>
	<div style ="float:left">
	Сортировать по:<br>
	<select style ="float:left" name = "uptdate">
		<option value ="1"<?=((isset($_GET[uptdate])&& $_GET[uptdate]==1) ? $selected : $selected)?>>Ценам</option>
		<option value ="2"<?=($_GET[uptdate]==2 ? $selected :'')?>>Культуре</option>
		<option value ="3"<?=($_GET[uptdate]==3 ? $selected :'')?>>Названию</option>
		<option value ="4"<?=($_GET[uptdate]==4 ? $selected :'')?>>Дате обновления</option>
	</select>	
	
	</div>

	
	
	
	<div style ="float:left">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<br><br></div>
	<div>
	Менее <input type="text" style = "width:35px;" name = "min" Value ="<?=(isset($_GET['min']) ? $_GET['min'] : $minprice)?>"><br>
	Более <input type="text" style = "width:35px;" name = "max" Value ="<?=(isset($_GET['max']) ? $_GET['max'] : $maxprice)?>">
	</div>
	<div style ="float:left">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </div>
	<div>
	<input type="submit" name = "sort" Value ="Подтвердить">
	</div>
	</form>
	
	
	<table style ="border: 1px solid black; text-align:center; margin-top: 30px;">
	<tr>
	<th>ID Польз.</th><th>ID Комп.</th><th>Название</th><th>Цена</th><th>Закуп/Продажа</th><th>ГРН/USD</th><th>Активен</th><th>Последнее обновление</th><th>Культура</th><th>Область</th><th>Место</th>
	</tr>
	<?php

		$stle = '"border-bottom: 1px black solid"';
		while ($row = mysqli_fetch_object($res))
		{
			$id_user = $row->buyer_id;
			$id_comp = $row->id;
			$comp_name = $row->title;
			$cultame = $row->name;
			$obl_id = $row->obl_id;
			$place = $row->place;
			$trader = $row->trader_price_avail;
			$cost = $row->costval;
			$type = $row->curtype;
			$acttype = $row->acttype;
			$dateupdt = $row->trader_price_dtupdt;
			//echo date_format($dateupdt, 'd/m/Y H:i:s');
			echo "<tr>
					<td style = $stle>$id_user</td> 
					<td style = $stle>".'<a target="_blank"'." href=".$WWWHOST."kompanii/comp-".$id_comp."-pricetbl.html>".$id_comp."</td> 
					<td style = $stle>$comp_name</td>
					<td style = $stle>$cost</td>
					<td style = $stle>".($acttype ? "Продажи" : "Закупки")."</td>
					<td style = $stle>".(!$type ? '<a style ="color: red">ГРН</a>' : '<a style ="color: green">$</a>')."</td>
					<td style = $stle>".(!$trader ? '<a style ="color: red">НЕТ</a>' : '<a style ="color: green">ДА</a>')."</td>
					<td style = $stle>".$dateupdt."</td>
					<td style = $stle>$cultame</td>
					<td style = $stle title = $REGIONS[$obl_id]>".substr($REGIONS[$obl_id], 0, 5)."...</td>
					<td style = $stle title = ".'"'.$place.'"'.">".(strlen($place) > 20 ? substr($place, 0 ,20).'...' : $place)."</td>

					
				 </tr>";
		}
	?>
	</table>
	<?php
	echo $buySell;
//	echo "<pre>";
//	print_r ($_GET[arch]);
//	print_r ($_GET['max']);
//	echo $query;
//	echo "</pre>";	
	
	
    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
