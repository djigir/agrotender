<?php
error_reporting(E_ALL);
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/utils-inc.php";
	include "../inc/torgutils-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit banner places";
   	$strings['tipdel']['en'] = "Delete this place";
   	$strings['tipassign']['en'] = "Assign banner to place";

    $strings['tipedit']['ru'] = "Редактировать";
   	$strings['tipdel']['ru'] = "Удалить";
   	$strings['tipassign']['ru'] = "Прикрепить банеры";

	$PAGE_HEADER['ru'] = "Ротация банеров на выбранной площадке";
	$PAGE_HEADER['en'] = "Banner Places Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$msg = "";

	$placeid = GetParameter("place_id", 0);

	$datest = GetParameter("datest", "");
	$dateen = GetParameter("dateen", "");

	switch( $action )
	{
    	case "add":

    		$orgname = GetParameter("orgname", "");
    		$orgmail = GetParameter("orgmail", "");
			$orglogo = GetParameter("orglogo", "");
			$orgpay = GetParameter("orgpay", 0);
			$datest = GetParameter("datest", "");
			$dateen = GetParameter("dateen", "");

			if( !checkDt($datest) )
			{
				$msg .= 'Дата начала размещения указана некорректно';
			}

			if( !checkDt($dateen) )
			{
				$msg .= 'Дата окончания размещения указана некорректно';
			}

			if( $msg != "" )
			{
				break;
			}

			$datest_sql = makeDtSql($datest);
			$dateen_sql = makeDtSql($dateen);

    		$query = "INSERT INTO $TABLE_BANNER_ROTATE ( user_id, place_id, city_id, pay_type, dt_start_req, dt_end_req, add_date, cont_name, cont_mail )
    			VALUES (0, '$placeid', 0, '$orgpay', '$datest_sql', '$dateen_sql', NOW(), '".addslashes($orgname)."', '".addslashes($orgmail)."')";
			if(!mysqli_query($upd_link_db, $query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "delete":
			// Delete selected news
			/*
			$items_id = GetParameter("items_id", "");
			for($i = 0; $i < count($items_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$items_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			*/
			break;

		case "delrot":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"UPDATE $TABLE_BANNER_ROTATE SET archive=1 WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
			break;

		case "delreq":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_BANNER_ROTATE WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
			break;

		case "edit":
			$mode = "edit";
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
			$orgfile = GetParameter("orgfile", "");
			$orgurl = GetParameter("orgurl", "");
			$orginrot = GetParameter("orginrot", 0);

			$datest = GetParameter("datest", "");
			$dateen = GetParameter("dateen", "");

			if( !checkDt($datest) )
			{
				$msg .= 'Дата начала размещения указана некорректно';
			}

			if( !checkDt($dateen) )
			{
				$msg .= 'Дата окончания размещения указана некорректно';
			}

			if( $msg != "" )
			{
				$mode = "edit";
				break;
			}

			$datest_sql = makeDtSql($datest);
			$dateen_sql = makeDtSql($dateen);

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_BANNER_ROTATE SET inrotate='$orginrot', dt_start='$datest_sql', dt_end='$dateen_sql',
				ban_file='".addslashes($orgfile)."', ban_link='".addslashes($orgurl)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


	$plinfo = Banners_PlaceInfo($LangId, $placeid);


	echo '<div style="padding: 15px 20px 20px 15px; text-align: center;"><a href="banner_places.php">вернуться к списку площадок</a></div>';


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orgmail = "";
		$orgpage = 0;
		$orgarch = 0;
		$orginrot = 0;
		$orgw = 100;
		$orgh = 100;
		$orgurl = "";
		$orgfile = "";
		$org_dtst = "";
		$org_dten = "";

		if($res = mysqli_query($upd_link_db,"SELECT p1.*, YEAR(dt_start) as sty, MONTH(dt_start) as stm, DAYOFMONTH(dt_start) as std,
			YEAR(dt_end) as eny, MONTH(dt_end) as enm, DAYOFMONTH(dt_end) as end0
			FROM $TABLE_BANNER_ROTATE p1 WHERE p1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->cont_name);
				$orgmail = stripslashes($row->cont_mail);
				//$orglogo = stripslashes($row->icon_filename);
				//$orgdescr = stripslashes($row->descr);
				$orgarch = $row->archive;
				$orginrot= $row->inrotate;
				//$orgw = $row->size_w;
				//$orgh = $row->size_h;

				$org_dtst = $row->dt_start_req;
				$org_dten = $row->dt_end_req;

				$orgfile = stripslashes($row->ban_file);
				$orgurl = stripslashes($row->ban_link);

				$datest = sprintf("%02d.%02d.%04d", $row->std, $row->stm, $row->sty);//$row->dt_start;
				$dateen = sprintf("%02d.%02d.%04d", $row->end0, $row->enm, $row->eny);//$row->dt_end;
			}
			mysqli_free_result($res);
		}

		if( $msg != "" )
		{
			echo '<div class="err">'.$msg.'</div>';
		}
?>

	<h3>Редактировать ротацию</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="" name="edtfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="place_id" value="<?=$placeid;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr>
		<th colspan="2">Параметры площадки</th>
	</tr>
	<tr>
		<td class="ff">На какой странице:</td>
		<td class="fr"><?=$ban_page[$plinfo['page']];?></td>
	</tr>
	<tr><td class="ff">Номер позиции:</td><td class="fr"><b><?=$plinfo['pos'];?></b> - <?=$plinfo['name'];?></td></tr>
	<tr>
		<td class="ff">Размеры банера:</td>
		<td class="fr"><?=$plinfo['w'];?> x <?=$plinfo['h'];?> px
		</td>
	</tr>
	<tr>
		<th colspan="2">Данные заявки</th>
	</tr>
    <tr><td class="ff">Контактное лицо:</td><td class="fr"><?=$orgname;?> (<?=$orgmail;?>)</td></tr>
    <tr>
		<td class="ff">В ротации:</td>
		<td class="fr"><select name="orginrot">
			<option value="1" <?=($orginrot == 1 ? ' selected' : '');?>>Ротируется</option>
			<option value="0" <?=($orginrot == 0 ? ' selected' : '');?>>Не ротируется</option>
		</td>
	</tr>
	<tr>
		<td class="ff">Желаемый период:</td>
		<td class="fr">c <?=$org_dtst;?> по <?=$org_dten;?></td>
	</tr>
	<tr>
		<th colspan="2">Утвержденный период</th>
	</tr>
	<tr>
		<td class="ff">С :</td>
		<td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"datest\" name=\"datest\" size=\"10\" maxlength=\"10\" value=\"".$datest."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.edtfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
		</td>
	</tr>
	<tr>
		<td class="ff">По :</td>
		<td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"dateen\" name=\"dateen\" size=\"10\" maxlength=\"10\" value=\"".$dateen."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.edtfrm.dateen', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
		</td>
	</tr>
	<tr>
		<td class="ff">Картинка: </td>
		<td class="fr">
			<input type="text" name="orgfile" style="width: 200px" value="<?=$orgfile;?>">
			<input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.edtfrm.orgfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');">
		</td>
	</tr>
	<tr>
		<td class="ff">Url Ссылки: </td>
		<td class="fr">
			<input type="text" name="orgurl" style="width: 300px" value="<?=$orgurl;?>">
		</td>
	</tr>
<?php
/*
	<tr><td class="ff">Описание группы:</td><td class="fr"><textarea cols="60" rows="4" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
	<tr><td class="ff">Иконка:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
*/
?>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
	<br /><br />
<?php
	}


	{
?>
    <h3>Список подтвержденных ротаций - <?=$ban_page[$plinfo['page']]." - позиция № ".$plinfo['pos']." (".$plinfo['name'].")";?></h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Дата заявки</th>
    	<th>Отправитель</th>
    	<th>Тип оплаты</th>
    	<th>Желаемый период</th>
    	<th>Назначенный период</th>
    	<th>Файл</th>
    	<th>Функции</th>
    </tr>
    <?php
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_BANNER_ROTATE WHERE place_id=$placeid AND archive=0 AND inrotate=1 ORDER BY dt_start") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
            		<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
            		<td>".$row->add_date."</td>
					<td style=\"padding: 1px 10px 1px 10px\">
					    ".stripslashes($row->cont_name)."<br /><a href=\"mailto:".stripslashes($row->cont_mail)."\">".stripslashes($row->cont_mail)."</a>
					</td>
					<td align=\"center\">".$ban_paytype[$row->pay_type]."</td>
					<td align=\"center\">".$row->dt_start_req." - ".$row->dt_end_req."</td>
					<td align=\"center\"><b>".$row->dt_start." - ".$row->dt_end."</b></td>
					<td>".stripslashes($row->ban_file)."</td>
					<td align=\"center\">
						<a onclick='return confirm(\"Вы действительно хотите отменить ротацию банера?\")' href=\"$PHP_SELF?action=delrot&place_id=".$placeid."&item_id=".$row->id."\" title=\"".$strings['tipdel'][$lang]."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						<a href=\"$PHP_SELF?action=edit&place_id=".$placeid."&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
					</td>
				</tr>
                <tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"8\" align=\"center\"><br />У площадки нет банеров на ротации<br /><br /></td></tr>
			<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"8\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Список заявок на ротацию - <?=$ban_page[$plinfo['page']]." - позиция № ".$plinfo['pos']." (".$plinfo['name'].")";?></h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Дата заявки</th>
    	<th>Отправитель</th>
    	<th>Желаемый период</th>
    	<th>Доступно</th>
    	<th>Тип оплаты</th>
    	<th>Функции</th>
    </tr>
    <?php
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_BANNER_ROTATE WHERE place_id=$placeid AND archive=0 AND inrotate=0 ORDER BY dt_start") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

				$is_busy = false;
                $query1 = "SELECT * FROM $TABLE_BANNER_ROTATE
                	WHERE place_id=$placeid AND archive=0 AND inrotate=1
                		AND ( (dt_start<'".$row->dt_start_req."' AND dt_end>='".$row->dt_start_req."') OR
                		(dt_start<'".$row->dt_end_req."' AND dt_end>='".$row->dt_end_req."'))
                	ORDER BY dt_start";
                if( $res1 = mysqli_query($upd_link_db,$query1) )
				{
					while($row1=mysqli_fetch_object($res1))
					{
						$is_busy = true;
					}
					mysqli_fetch_array($res1);
				}

            	echo "<tr>
            		<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
            		<td>".$row->add_date."</td>
					<td style=\"padding: 1px 10px 1px 10px\">
					    ".stripslashes($row->cont_name)."<br /><a href=\"mailto:".stripslashes($row->cont_mail)."\">".stripslashes($row->cont_mail)."</a>
					</td>
					<td align=\"center\">".$row->dt_start_req." - ".$row->dt_end_req."</td>
					<td align=\"center\">".( $is_busy ? "<b>период занят</b>" : "размещение доступно" )."</td>
					<td align=\"center\">".$ban_paytype[$row->pay_type]."</td>
					<td align=\"center\">
						<a onclick='return confirm(\"Вы действительно хотите удалить эту заявку на ротацию банера?\")' href=\"$PHP_SELF?action=delreq&place_id=".$placeid."&item_id=".$row->id."\" title=\"".$strings['tipdel'][$lang]."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						<a href=\"$PHP_SELF?action=edit&place_id=".$placeid."&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
					</td>
				</tr>
                <tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"7\" align=\"center\"><br />У площадки нет запросов на ротацию<br /><br /></td></tr>
			<tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"7\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />



    <h3>Добавить Банер в Ротацию на эту площадку</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="place_id" value="<?=$placeid;?>" />
	<tr><td class="ff">Имя заказчика:</td><td class="fr"><input type="text" name="orgname" /></td></tr>
	<tr><td class="ff">E-mail заказчика:</td><td class="fr"><input type="text" name="orgmail" /></td></tr>
    <tr>
    	<td class="ff">Способ оплаты:</td>
    	<td class="fr">
    		<input type="radio" name="orgpay" value="1" checked="checked" /> Оплата на безналичный счет<br />
			<input type="radio" name="orgpay" value="2" /> Оплата наличными<br />
			<input type="radio" name="orgpay" value="3" /> Оплата через WebMoney<br />
		</td>
	</tr>
	<tr>
		<td class="ff">Разместить с:</td>
		<td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"datest\" name=\"datest\" size=\"10\" maxlength=\"10\" value=\"".$datest."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.catfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
		</td>
	</tr>
	<tr>
		<td class="ff">Разместить по:</td>
		<td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"dateen\" name=\"dateen\" size=\"10\" maxlength=\"10\" value=\"".$dateen."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.catfrm.dateen', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
		</td>
	</tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
