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
	
	include "../inc/utils-inc.php";

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

    $strings['tipedit']['ru'] = "Редактировать это предложение";
   	$strings['tipdel']['ru'] = "Удалить это предложение";
   	$strings['hdrlist']['ru'] = "Список предложений";
   	$strings['hdradd']['ru'] = "Добавить предложение";
   	$strings['hdredit']['ru'] = "Редакировать предложение";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Показывать на сайте";
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

	$PAGE_HEADER['ru'] = "Мессенджер";
	$PAGE_HEADER['en'] = "Message Editing";



	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$ntype = GetParameter("ntype", 0);
	
	$sortby = GetParameter("sortby", "bydate");
	
	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 100);

	$datest = GetParameter("datest", date("d.m.Y", time()));

	//$THIS_TABLE = $TABLE_COMPANY_COMMENT; //$TABLE_COMMENT;
	//$THIS_TABLE_LANG = $TABLE_COMPANY_COMMENT_LANGS; //$TABLE_COMMENT_LANGS;
?>

<?php
	switch( $action )
	{
		/*
		case "delete":
			$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$com_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE item_id='".$com_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
    			}
			}
			break;
		*/

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            $query = "DELETE FROM $TABLE_TORG_MSNGR WHERE id='".$item_id."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}	
			else
			{
				$query = "DELETE FROM $TABLE_TORG_MSNGR_P2P WHERE item_id='".$item_id."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
    		break;

		case "update":
			$item_id = GetParameter("item_id", "0");
			$newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$newsfirst = GetParameter("newsfirst", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");
			$a=getdate();
			$time=$a['hours'].":".$a['minutes'].":".$a['seconds'];
    		$db_datest = substr($datest, 6, 4)."-".substr($datest, 3, 2)."-".substr($datest, 0, 2)." ".$time;

			//if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET show_first='$newsfirst', add_date='$db_datest', author='$newstitle' WHERE id='".$item_id."'"))
			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET visible='$newsfirst', add_date='$db_datest', author='$newstitle' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$query = "UPDATE $THIS_TABLE_LANG SET content='".addslashes($newscont)."'
                        WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
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

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.content, DAYOFMONTH(m1.add_date) as dd, MONTH(m1.add_date) as dm, YEAR(m1.add_date) as dy
			FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.item_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle= stripslashes($row->author);
				$newscont = stripslashes($row->content);
				$newsfirst = $row->visible;
				//$newsbrand = $row->brand_id;
				$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);


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
	<input type="hidden" name="ntype" value="<?=$ntype;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff"><?=$strings['rowdate'][$lang];?>:</td><td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"datest\" name=\"datest\" size=\"10\" maxlength=\"10\" value=\"".$datest."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.advfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
</td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>

	<tr >
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
		<td class="fr"><select name="newsfirst">
			<option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>ДА</option>
		</select></td></tr>
    <script language="javascript1.2">
    	editor_generate('newscont'); // field, width, height
	</script>
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
	
	$its = Msngr_PropList($LangId, 0, $sortby, $pi, $pn);	
	
	$its_num = Msngr_PropNum($LangId, 0);
?>

    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="ntype" value="<?=$ntype;?>" />  
	<tr>
		<th>№</th>
		<th><?=( $sortby == "bydate" ? "Дата" : '<a href="'.$PHP_SELF.'?sortby=bydate">Дата</a>' );?></th>
		<th><?=( $sortby == "bycult" ? "Культура" : '<a href="'.$PHP_SELF.'?sortby=bycult">Культура</a>' );?></th>
		<th>Трейдер</th>
		<th><?=( $sortby == "byamount" ? "Объем" : '<a href="'.$PHP_SELF.'?sortby=byamount">Объем</a>' );?></th>
		<th>Цена</th>
		<th>Область</th>
		<th>Описание</th>
		<th>Отправитель (
			<?=( $sortby == "byname" ? "Имя" : '<a href="'.$PHP_SELF.'?sortby=byname">Имя</a>');?> / 
			<?=( $sortby == "bytel" ? "Тел." : '<a href="'.$PHP_SELF.'?sortby=bytel">Тел.</a>');?> / 
			<?=( $sortby == "bymail" ? "Email" : '<a href="'.$PHP_SELF.'?sortby=bymail">Email</a>');?>)</th>
		<th><?=( $sortby == "bystatus" ? "Статус" : '<a href="'.$PHP_SELF.'?sortby=bystatus">Статус</a>' );?></th>
		<th><?=$strings['rowfunc'][$lang];?></th>			
	</tr>
<?php
		$found_news = 0;
		for( $i=0; $i<count($its); $i++ )
		{		
			$found_news++;
			
			$TRADER_HTML = "";
			
			$trlist = $its[$i]['to'];
			for( $j=0; $j<count($trlist); $j++ )
			{
				$TRADER_URL = Comp_BuildUrl($LangId, "item", "", 0, 0, $trlist[$j]['trader_id']);
				$TRADER_HTML .= '<a href="'.$TRADER_URL.'" target="_blank">'.$trlist[$j]['trader'].'</a> '.($trlist[$j]['status'] == $MSNGR_STATUS_DECLINED ? 'Отклонена' : '').'<br>';
			}		

			//var_dump($its[$i]);
			//echo "!!!<br>";
					
			echo '<tr>
				<td>'.($i+1).':'.$its[$i]['id'].'</td>
				<td class="uctbl-dttm">
					<span class="uctbl-dt">'.$its[$i]['dt'].'</span><br>'.$its[$i]['tm'].'
				</td>
				<td class="ta_center">'.$its[$i]['cult'].'</td>
				<td class="uctbl-lnk">
					'.( false ? '<a href="'.$TRADER_URL.'" target="_blank">'.$its[$i]['trader'].'</a>' : $TRADER_HTML ).'						
				</td>
				<td class="ta_center">'.$its[$i]['amount'].'</td>
				<td class="ta_center">'.$its[$i]['cost'].'</td>
				<td class="ta_center">'.$REGIONS_SHORT2[$its[$i]['obl_id']].'</td>
				<td class="ta_center">'.$its[$i]['comment'].'</td>
				<td class="uctbl-lnk">
					<b>'.$its[$i]['fio'].'</b><div style="color: #808080; padding: 0">'.$its[$i]['compname'].'</div>
					'.$its[$i]['phone'].'<br>'.$its[$i]['email'].'
				</td>
				<td>'.( $its[$i]['status'] == $MSNGR_STATUS_APPROVED ? 'Продано' : '' ).'</td>
				<td class="uctbl-nav">				
					<a href="'.$PHP_SELF.'?action=deleteitem&item_id='.$its[$i]['id'].'"><img src="img/delete.gif" width="20" height="20" border="0" alt="'.$strings['tipdel'][$lang].'" /></a>					
				</td>
			</tr>';
		}		

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"10\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"10\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	//echo "<tr><td align=\"center\" colspan=\"5\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>
	
	 <?php
    	if( $its_num > $pn )
    	{
    		$PAGES_NUM = ceil( $its_num/$pn );
    		echo '<div style="padding: 20px 20px 20px 20px; text-align: center;">Страницы: ';

    		for( $i=1; $i<=$PAGES_NUM; $i++ )
    		{
    			if( $i == $pi )
    				echo ' <b>'.($i).'</b> ';
    			else
    				echo ' <a href="'.$PHP_SELF.'?sortby='.$sortby.'&pi='.$i.'&pn='.$pn.'">'.$i.'</a> ';
    		}

    		echo '</div>';
    	}
    ?>

    <br /><br />

    <table align="center" cellspacing="0" cellpadding="0" border="0" class="tableborder">
    <tr><td>   	</td></tr>
    </table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
