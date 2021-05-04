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

	$starr = split("[.]", $dt);
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

    $strings['tipedit']['ru'] = "Редактировать этот пакет";
   	$strings['tipdel']['ru'] = "Удалить этот пакет";
   	$strings['hdrlist']['ru'] = "Список пакетов";
   	$strings['hdradd']['ru'] = "Добавить пакет";
   	$strings['hdredit']['ru'] = "Редакировать пакет";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Показывать на сайте";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет пакетов";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";
	$strings['product']['ru']="Продукт";
	$strings['article']['ru']="Статья";

	$PAGE_HEADER['ru'] = "Редактировать Пакеты Услуг";
	$PAGE_HEADER['en'] = "Comment Editing";



	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	
	//$ntype = GetParameter("ntype", 0);
	//$datest = GetParameter("datest", date("d.m.Y", time()));
	
	$newstitle = GetParameter("newstitle", "");
	$newscont = GetParameter("newscont", "", false);
	$newsfirst = GetParameter("newsfirst", 0);
	$ptype = GetParameter("ptype", 0);
	$pcost = GetParameter("pcost", 100);
	$padvnum = GetParameter("padvnum", 1);
	$pfishnum = GetParameter("pfishnum", 1);
	$pfishtm = GetParameter("pfishtm", 2);
	$ptargnum = GetParameter("ptargnum", 1);
	$psort = GetParameter("psort", 0);
	$pperiodt = GetParameter("pperiodt", 1);
	$pperiodv = GetParameter("pperiodv", 1);

	$THIS_TABLE = $TABLE_BUYER_PACKS; //$TABLE_COMMENT;
?>

<?php
	switch( $action )
	{
		case "delete":
			$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_BUYER_PACKS WHERE id=".$com_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_BUYER_PACKS WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		break;

		case "update":
			$item_id = GetParameter("item_id", "0");
			$newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$newsfirst = GetParameter("newsfirst", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");
			
			//if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET show_first='$newsfirst', add_date='$db_datest', author='$newstitle' WHERE id='".$item_id."'"))
			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_BUYER_PACKS SET active='".addslashes($newsfirst)."', pack_type='$ptype', cost='$pcost', adv_num='$padvnum', fish_num='$pfishnum', targ_num='$ptargnum', fish_hours='$pfishtm',  
				sort_num='$psort', period_type='".addslashes($pperiodt)."', period='".addslashes($pperiodv)."', 
				title='$newstitle', content='".addslashes($newscont)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
			
		case "add":
			$newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$newsfirst = GetParameter("newsfirst", 0);
			$pcost = GetParameter("pcost", 100);
			$padvnum = GetParameter("padvnum", 1);
			$pfishnum = GetParameter("pfishnum", 1);
			$pfishtm = GetParameter("pfishtm", 2);
			$ptargnum = GetParameter("ptargnum", 1);
			$psort = GetParameter("psort", 0);
			$pperiodt = GetParameter("pperiodt", 1);
			$pperiodv = GetParameter("pperiodv", 1);
			
			$query = "INSERT INTO $TABLE_BUYER_PACKS (add_date, pack_type, title, content, active, cost, adv_num, fish_num, targ_num, fish_hours, sort_num, period_type, period) 
				VALUES (NOW(), '$ptype', '".addslashes($newstitle)."', '".addslashes($newscont)."', '$newsfirst', '$pcost', '$padvnum', '$pfishnum', '$ptargnum', '$pfishtm', 
				'$psort', '".addslashes($pperiodt)."', '".addslashes($pperiodv)."')";
			if( !mysqli_query($upd_link_db,$query) )
			{
				echo mysqli_error($upd_link_db)."<br>";
			}
			
			break;
			
		case "edititem":
			$mode = "edit";
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newstitle = "";
		$newscont = "";
		$newsfirst = 0;
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";
		
		$ptype = 0;
		$pcost = 100;
		$padvnum = 1;
		$pfishnum = 1;
		$pfishtm = 2;
		$ptargnum = 1;
		$psort = 0;
		
		$pperiodt = 1;
		$pperiodv = 1;

		if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_BUYER_PACKS m1 WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle= stripslashes($row->title);
				$newscont = stripslashes($row->content);
				$newsfirst = $row->active;
				
				$ptype = $row->pack_type;
				$pcost = $row->cost;
				$padvnum = $row->adv_num;
				$pfishnum = $row->fish_num;
				$pfishtm = $row->fish_hours;
				$ptargnum = $row->targ_num;
				$psort = $row->sort_num;
						
				$pperiodt = $row->period_type;
				$pperiodv = $row->period;
			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff">Тип услуги:</td><td class="fr"><select name="ptype">
		<?php
		for( $i=0; $i<=count($BILLING_PACK_STR); $i++ )
		{
			echo '<option value="'.$i.'" '.($i == $ptype ? ' selected' : '').'>'.$BILLING_PACK_STR[$i].'</option>';
		}
		?>
	</select></td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="60" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea class="ckeditor" rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	<tr >
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
		<td class="fr"><select name="newsfirst">
			<option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>ДА</option>
		</select></td>
	</tr>
	<tr><td class="ff">Стоимость (грн.):</td><td class="fr"><input type="text" size="10" name="pcost" value="<?=$pcost;?>" /></td></tr>
	<tr><td class="ff">Период:</td><td class="fr"><select name="pperiodt">
		<?php
		for( $i=0; $i<count($PAYED_PERIOD_TYPE); $i++ )
		{
			echo '<option value="'.$i.'" '.($i == $pperiodt ? ' selected' : '').'>'.$PAYED_PERIOD_TYPE[$i].'</option>';
		}
		?>
	</select></td></tr>
	<tr><td class="ff">Длительность периода:</td><td class="fr"><input type="text" size="3" name="pperiodv" value="<?=$pperiodv;?>" /></td></tr>
	<tr><td class="ff">Кол-во объявлений:</td><td class="fr"><input type="text" size="3" name="padvnum" value="<?=$padvnum;?>" /></td></tr>
	<?php
	/*
	<tr><td class="ff">Кол-во фишек:</td><td class="fr"><input type="text" size="3" name="pfishnum" value="<?=$pfishnum;?>" /></td></tr>
	<tr><td class="ff">Время фишки:</td><td class="fr"><input type="text" size="3" name="pfishtm" value="<?=$pfishtm;?>" /></td></tr>
	<tr><td class="ff">Кол-во тарг. объяв:</td><td class="fr"><input type="text" size="3" name="ptargnum" value="<?=$ptargnum;?>" /></td></tr>
	*/
	?>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="3" name="psort" value="<?=$psort;?>" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnrefresh'][$lang];?> "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
?>
    <h3><?=$strings['hdrlist'][$lang];?></h3>
<?php
/*
    <div style="padding: 10px 0px 10px 10px;">Группа новостей: &nbsp;
<?php
	for( $i=0; $i<count($ntype_arr); $i++ )
	{
		if( $i > 0 )
			echo ' &nbsp;::&nbsp; ';

		if( $ntype == $i )
			echo '<b>'.$ntype_arr[$i].'</b>';
		else
			echo '<a href="news.php?ntype='.$i.'">'.$ntype_arr[$i].'</a>';
	}
?>
    </div>
*/
?>

    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="ntype" value="<?=$ntype;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th style="padding: 1px 10px 1px 20px" width="35%"><?=$strings['rowcont'][$lang];?></th>
		<th><?=$strings['rowfirst'][$lang];?></th>
		<th>Цена</th>
		<th>Период</th>
		<th>Кол-во объяв.</th>
		<?php
		/*
		<th>Кол-во фишек</th>
		<th>Кол-во таргетинг.</th>
		<th>Длит. фишек</th>
		*/
		?>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php
    	$found_news = 0;
		$pack_group = -1;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_BUYER_PACKS m1 ORDER BY m1.pack_type, m1.sort_num") )
		{
			while($row=mysqli_fetch_object($res))
			{				
				$found_news++;
				
				if( $pack_group != $row->pack_type )
				{
					$pack_group = $row->pack_type;
					
					echo '<tr><th colspan="7" style="text-align: center; padding: 14px 0 14px 0; background: #d0e5f1;">'.$BILLING_PACK_STR[$pack_group].'</th></tr>';
				}

				echo "<tr>
					<td><input type=\"checkbox\" name='com_id[]' value=\"".$row->id."\" /></td>
					<td style=\"padding: 2px 10px 2px 10px;\"><b>".stripslashes($row->title)."</b> - [".$row->add_date."]</td>
					<td align=\"center\">".($row->active == 1 ? " <span style=\"font-weight: bold; color: red;\">Да</span> " : " Нет ")."</td>
					<td align=\"center\"><b>".$row->cost."</b></td>
					<td align=\"center\"><b>".$row->period."</b> (".$PAYED_PERIOD_TYPE[$row->period_type].")</td>
					<td align=\"center\"><b>".$row->adv_num."</b></td>
					".( false ? "<td align=\"center\"><b>".$row->fish_num."</b></td>
					<td align=\"center\"><b>".$row->targ_num."</b></td>
					<td align=\"center\"><b>".$row->fish_hours."</b></td>" : "" )."
					<td align=\"center\">
						<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						<a href=\"$PHP_SELF?action=edititem&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
					</td>
				</tr>
				<tr><td colspan=\"10\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";

			}
			mysqli_free_result($res);
		}

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"10\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"10\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"10\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />

	<h3>Добавить пакет</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="add" />
	<tr><td class="ff">Тип услуги:</td><td class="fr"><select name="ptype">
		<?php
		for( $i=0; $i<=count($BILLING_PACK_STR); $i++ )
		{
			echo '<option value="'.$i.'" '.($i == $ptype ? ' selected' : '').'>'.$BILLING_PACK_STR[$i].'</option>';
		}
		?>
	</select></td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="60" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea class="ckeditor" rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	<tr>
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
		<td class="fr"><select name="newsfirst">
			<option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>ДА</option>
		</select>
		</td>
	</tr>
	<tr><td class="ff">Стоимость (грн.):</td><td class="fr"><input type="text" size="10" name="pcost" value="<?=$pcost;?>" /></td></tr>
	<tr><td class="ff">Период:</td><td class="fr"><select name="pperiodt">
		<?php
		for( $i=0; $i<count($PAYED_PERIOD_TYPE); $i++ )
		{
			echo '<option value="'.$i.'" '.($i == $pperiodt ? ' selected' : '').'>'.$PAYED_PERIOD_TYPE[$i].'</option>';
		}
		?>
	</select></td></tr>
	<tr><td class="ff">Длительность периода:</td><td class="fr"><input type="text" size="3" name="pperiodv" value="<?=$pperiodv;?>" /></td></tr>
	<tr><td class="ff">Кол-во объявлений:</td><td class="fr"><input type="text" size="3" name="padvnum" value="<?=$padvnum;?>" /></td></tr>
	<?php
	/*
	<tr><td class="ff">Кол-во фишек:</td><td class="fr"><input type="text" size="3" name="pfishnum" value="<?=$pfishnum;?>" /></td></tr>
	<tr><td class="ff">Время фишки:</td><td class="fr"><input type="text" size="3" name="pfishtm" value="<?=$pfishtm;?>" /></td></tr>
	<tr><td class="ff">Кол-во тарг. объяв:</td><td class="fr"><input type="text" size="3" name="ptargnum" value="<?=$ptargnum;?>" /></td></tr>
	*/
	?>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="3" name="psort" value="<?=$psort;?>" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Создать "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
