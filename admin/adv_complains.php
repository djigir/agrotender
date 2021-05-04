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

    $strings['tipedit']['ru'] = "Редактировать эту жалобу";
   	$strings['tipdel']['ru'] = "Удалить эту жалобу";
   	$strings['hdrlist']['ru'] = "Список жалоб";
   	$strings['hdradd']['ru'] = "Добавить отзыв";
   	$strings['hdredit']['ru'] = "Редакировать жалобу";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Имя";
   	$strings['rowfirst']['ru'] = "Показывать на сайте";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет жалоб";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";
	$strings['product']['ru']="Продукт";
	$strings['article']['ru']="Статья";

	$PAGE_HEADER['ru'] = "Просмотр Жалоб на Объявления";
	$PAGE_HEADER['en'] = "Comment Editing";

	


	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$ntype = GetParameter("ntype", 0);

	$datest = GetParameter("datest", date("d.m.Y", time()));
	
	$msg = '';

	$THIS_TABLE = $TABLE_ADV_POST_COMPLAINS; //$TABLE_COMMENT;
	//$THIS_TABLE_LANG = $TABLE_COMPANY_COMMENT_LANGS; //$TABLE_COMMENT_LANGS;
?>

<?php
	switch( $action )
	{
		case "delete":
			$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_ADV_POST_COMPLAINS WHERE id=".$com_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_ADV_POST_COMPLAINS WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}    		
    		break;

		case "update":
			$item_id = GetParameter("item_id", "0");
			$newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
			$newscontp = GetParameter("newscontp", "", false);
			$newscontm = GetParameter("newscontm", "", false);
    		$newsfirst = GetParameter("newsfirst", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");
			$a=getdate();
			$time=$a['hours'].":".$a['minutes'].":".$a['seconds'];
    		$db_datest = substr($datest, 6, 4)."-".substr($datest, 3, 2)."-".substr($datest, 0, 2)." ".$time;

			//if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET show_first='$newsfirst', add_date='$db_datest', author='$newstitle' WHERE id='".$item_id."'"))
			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_ADV_POST_COMPLAINS SET visible='$newsfirst', add_date='$db_datest', author='$newstitle' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
		
		/*
		case "edit":
			$mode = "edit";
			$item_id = GetParameter("item_id", "0");
			break;
			
		case "viewcompl":
			$item_id = GetParameter("item_id", "0");
			
			$mode = "compllist";
			break;
		*/
			
		case "editcompl":
			$item_id = GetParameter("item_id", "0");
			$compl_id = GetParameter("compl_id", "0");
			
			$mode = "compledit";
			break;
			
		case "updatecompl":
			$item_id = GetParameter("item_id", "0");
			$compl_id = GetParameter("compl_id", "0");
			$cviewed = GetParameter("cviewed", "0");
			$cstatus = GetParameter("cstatus", "0");
			$ccont = GetParameter("ccont", "");
			
			$query = "UPDATE $TABLE_ADV_POST_COMPLAINS SET viewed='".$cviewed."', status='".$cstatus."', msg='".addslashes($ccont)."' 
				WHERE id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			else
			{
				$msg = "Информация по жалобе была обновлена";
			}
			//$mode = "compllist";
			break;
	}


	/*
    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newstitle = "";
		$newscont = "";
		$newscontp = "";
		$newscontm = "";
		$newsfirst = 0;
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.content, m2.content_plus, m2.content_minus, DAYOFMONTH(m1.add_date) as dd, MONTH(m1.add_date) as dm, YEAR(m1.add_date) as dy
			FROM $THIS_TABLE m1 
			INNER JOIN $THIS_TABLE_LANG m2 ON m1.id=m2.item_id AND m2.lang_id='$LangId' 
			WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle= stripslashes($row->author);
				$newscont = stripslashes($row->content);
				$newscontp = stripslashes($row->content_plus);
				$newscontm = stripslashes($row->content_minus);
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
	<tr><td class="ff">Преимущества:</td><td class="fr"><textarea rows="4" cols="80" name="newscontp"><?=$newscontp;?></textarea></td></tr>
	<tr><td class="ff">Недостатки:</td><td class="fr"><textarea rows="4" cols="80" name="newscontm"><?=$newscontm;?></textarea></td></tr>

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
	*/
		
	if( $mode == "compledit" )
	{
		//$item_id = GetParameter("item_id", "0");
		//$newstitle = "";
		$ccont = "";
		$cviewed = 0;
		$cstatus = 0;
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $TABLE_ADV_POST_COMPLAINS m1 WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				//$newstitle= stripslashes($row->author);
				$ccont = stripslashes($row->msg);
				$cviewed = $row->viewed;
				$cstatus = $row->status;
				//$newsbrand = $row->brand_id;
				//$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);
			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
	
	<div style="padding: 14px 0 14px 0; text-align: center;"><a href="<?=$PHP_SELF;?>">Вернуться к жалобам</a></div>
	
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="updatecompl" />
	<input type="hidden" name="ntype" value="<?=$ntype;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="ccont"><?=$ccont;?></textarea></td></tr>
	<tr>
		<td class="ff">Просмотрено:</td>
		<td class="fr"><select name="cviewed">
			<option value="0"<?=( $cviewed == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $cviewed == 1 ? " selected ": "" );?>>ДА</option>
		</select></td>
	</tr>   
	<tr>
		<td class="ff">Статус:</td>
		<td class="fr"><select name="cstatus">
			<option value="0"<?=( $cstatus == 0 ? " selected ": "" );?>>Новый</option>
			<option value="1"<?=( $cstatus == 1 ? " selected ": "" );?>>Обработан</option>
		</select></td>
	</tr>   
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Применить"></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	
	/*
	else if( $mode == "compllist" )
	{
		$its = Array();
		$query = "SELECT * FROM $TABLE_COMPANY_COMMENT_COMPLAINS WHERE comment_id='$item_id' ORDER BY add_date DESC";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while($row=mysqli_fetch_object($res))
			{
				$it = Array();
				$it['id'] = $row->id;
				$it['comment_id'] = $row->comment_id;
				$it['source_msgid'] = $row->sreply_to_id;
				$it['author_id'] = $row->author_id;
				$it['viewed'] = $row->viewed;
				$it['status'] = $row->status;
				$it['dt'] = $row->add_date;
				$it['ip'] = stripslashes($row->ip);
				$it['txt'] = stripslashes($row->msg);
				
				$its[] = $it;
			}
			mysqli_free_result($res);
		}
		
		echo ' <h3>Жалобы на сообщение</h3>
		
		<div style="padding: 14px 0 14px 0; text-align: center;"><a href="'.$PHP_SELF.'">Вернуться к комментариям</a></div>
		
		'.( $msg != "" ? '<div style="padding: 14px 0; text-align: center; color: red;">'.$msg.'</div>' : '').'
		
		<table align="center" width="96%" cellspacing="0" cellpadding="0">
		<tr>
			<th>&nbsp;</th>
			<th>Дата</th>
			<th>Текст жалобы</th>
			<th>IP</th>
			<th>Просмотрено</th>
			<th>Обработано</th>
			<th>'.$strings['rowfunc'][$lang].'</th>
		</tr>
		';
		
		for( $i=0; $i<count($its); $i++ )
		{
			echo '<tr>
				<td>'.$its[$i]['id'].'</td>
				<td align="center">'.$its[$i]['dt'].'</td>
				<td>'.$its[$i]['txt'].'</td>
				<td align="center">'.$its[$i]['ip'].'</td>
				<td align="center">'.( $its[$i]['viewed'] == 0 ? '<span style="color: red;">Нет</span>' : '' ).'</td>
				<td align="center">'.( $its[$i]['status'] == 1 ? 'Исправлено' : '<span style="color: red;">Обработать</span>' ).'</td>
				<td align="center">
					<a href="'.$PHP_SELF.'?action=editcompl&ntype='.$ntype.'&item_id='.$item_id.'&compl_id='.$its[$i]['id'].'"><img src="img/edit.gif" width="20" height="20" border="0" alt="'.$strings['tipedit'][$lang].'" /></a>&nbsp;
				</td>
			</tr>';
		}
		
		echo '</table>';
	}
	*/
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
		<th>Автор</th>
    	<th style="padding: 1px 10px 1px 20px" width="25%">Жалоба</th>    	
		<th width="25%">Объявление</th>
    	<th>Новое</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php
    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT c1.*, p1.author, p1.title, b1.login, b1.name 
			FROM $TABLE_ADV_POST_COMPLAINS c1 
			INNER JOIN $TABLE_ADV_POST p1 ON c1.item_id=p1.id 
			LEFT JOIN $TABLE_TORG_BUYERS b1 ON c1.author_id=b1.id 			
			ORDER BY c1.add_date DESC") )
		{
			while($row=mysqli_fetch_object($res))
			{
				/*
				$prod_name = "";
				$query = "SELECT e1.* FROM $TABLE_COMPANY_ITEMS e1 WHERE e1.id='".$row->item_id."'";
				if( $result= mysqli_query($upd_link_db,$query) )
				{
					if( $myrow = mysqli_fetch_object($result) )
					{
						$prod_name = stripslashes($myrow->title);
					}
					mysqli_free_result($result);
				}
				else
					echo mysqli_error($upd_link_db);
				*/

				$found_news++;
				
				$comment = strip_tags(stripslashes($row->msg), "");
				if( strlen($comment) > 200 )
					$comment = substr($comment, 0, 200)."...";

				echo "<tr>
					<td><input type=\"checkbox\" name='com_id[]' value=\"".$row->id."\" /></td>
					<td style=\"padding: 2px 10px 2px 10px;\"><b>".( $row->author_id == 0 ? "Аноним" : stripslashes($row->name) )."</b> - [".$row->add_date."]</td>
					<td>".$comment."</td>
					<td><a href=\"".$WWWHOST."board/post-".$row->item_id.".html\" target=\"_blank\">".stripslashes($row->title)."</a></td>
					<td align=\"center\">".($row->viewed == 0 ? " <span style=\"font-weight: bold; color: red;\">Да</span> " : "  ")."</td>
					<td align=\"center\">
						<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						<a href=\"$PHP_SELF?action=editcompl&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
					</td>
				</tr>
				<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";

			}
			mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"6\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
