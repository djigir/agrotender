<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

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

	$PAGE_HEADER['ru'] = "Редактировать банерные места";
	$PAGE_HEADER['en'] = "Banner Places Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_BANNER_PLACES;

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	switch( $action )
	{
    	case "add":
    		$orgname = GetParameter("orgname", "");
    		$orgdescr = GetParameter("orgdescr", "");
    		$orgpage = GetParameter("orgpage", 0);
			$orglogo = GetParameter("orglogo", "");
			$orgsort = GetParameter("orgsort", 0);
			$orgw = GetParameter("orgw", 100);
			$orgh = GetParameter("orgh", 100);
			$orgcost = GetParameter("orgcost", 0);

    		$query = "INSERT INTO $THIS_TABLE ( page_type, position, active, size_w, size_h, cost_grn, name )
    			VALUES ('$orgpage', '$orgsort', 1, '$orgw', '$orgh', '$orgcost', '".addslashes($orgname)."')";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "delete":
			// Delete selected news
			$items_id = GetParameter("items_id", "");
			for($i = 0; $i < count($items_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$items_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				$query = "DELETE FROM $TABLE_BANNER_ROTATE WHERE place_id='".$items_id[$i]."'";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		else
    		{
    			$query = "DELETE FROM $TABLE_BANNER_ROTATE WHERE place_id='".$item_id."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
    		}
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
            $orgpage = GetParameter("orgpage", 0);
			$orglogo = GetParameter("orglogo", "");
			$orgdescr = GetParameter("orgdescr", "");
			$orgsort = GetParameter("orgsort", 0);
			$orgact = GetParameter("orgact", 1);
			$orgw = GetParameter("orgw", 100);
			$orgh = GetParameter("orgh", 100);
			$orgcost = GetParameter("orgcost", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET page_type='$orgpage', position='$orgsort', active='$orgact', cost_grn='$orgcost',
				size_w='$orgw', size_h='$orgh', name='".addslashes($orgname)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orglogo = "";
		$orgdescr = "";
		$orgsort = 0;
		$orgpage = 0;
		$orgact = 1;
		$orgw = 100;
		$orgh = 100;
		$orgcost = 0;

		if($res = mysqli_query($upd_link_db,"SELECT p1.* FROM $THIS_TABLE p1 WHERE p1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->name);
				//$orglogo = stripslashes($row->icon_filename);
				//$orgdescr = stripslashes($row->descr);
				$orgsort = $row->position;
				$orgpage = $row->page_type;
				$orgact = $row->active;
				$orgw = $row->size_w;
				$orgh = $row->size_h;
				$orgcost = $row->cost_grn;
			}
			mysqli_free_result($res);
		}
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr>
		<td class="ff">На какой странице:</td>
		<td class="fr"><select name="orgpage">
<?php
		for( $i=0; $i<count($ban_page); $i++ )
		{
			echo '<option value="'.$i.'"'.($i == $orgpage ? ' selected' : '').'>'.$ban_page[$i].'</option>';
		}
?>
		</td>
	</tr>
	<tr><td class="ff">Номер позиции:</td><td class="fr"><input type="text" size="2" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
	<tr>
		<td class="ff">Размеры банера:</td>
		<td class="fr"><input type="text" size="3" name="orgw" value="<?=$orgw;?>" /> x <input type="text" size="3" name="orgh" value="<?=$orgh;?>" /> px
		</td>
	</tr>
    <tr><td class="ff">Название места:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr>
		<td class="ff">Активная позиция:</td>
		<td class="fr"><select name="orgact">
			<option value="1" <?=($orgact == 1 ? ' selected' : '');?>>Активно</option>
			<option value="0" <?=($orgact == 0 ? ' selected' : '');?>>Отключено</option>
		</td>
	</tr>
	<tr><td class="ff">Стоимость:</td><td class="fr"><input type="text" size="2" name="orgcost" value="<?=$orgcost;?>" /></td></tr>
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
<?php
	}
	else
	{
		//echo "LangId = $LangId<br />";
?>
    <h3>Список банерных позиций</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Название типа</th>
    	<th>Размеры</th>
    	<th>Заявки/ротация</th>
    	<th>Функции</th>
    </tr>
    <?php
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.* FROM ".$THIS_TABLE." p1 ORDER BY p1.name ASC") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

                $tot_req = 0;
                $tot_rot = 0;

                $query1 = "SELECT count(*) as totreq FROM ".$TABLE_BANNER_ROTATE." WHERE place_id='".$row->id."' AND inrotate=0 AND archive=0";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                	while( $row1 = mysqli_fetch_object( $res1 ) )
                	{
                		$tot_req = $row1->totreq;
                	}
                	mysqli_free_result( $res1 );
                }

                $query1 = "SELECT count(*) as totreq FROM ".$TABLE_BANNER_ROTATE." WHERE place_id='".$row->id."' AND inrotate=1 AND archive=0";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                	while( $row1 = mysqli_fetch_object( $res1 ) )
                	{
                		$tot_rot = $row1->totreq;
                	}
                	mysqli_free_result( $res1 );
                }

            	print "<tr>
            		<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>

					<td style=\"padding: 1px 10px 1px 10px\">".stripslashes($row->name)."</td>
					<td align=\"center\">".$row->size_w." x ".$row->size_h."</td>
					<td align=\"center\"><a href=\"banner_places_rot.php?place_id=".$row->id."\">".$tot_req." / ".$tot_rot."</a></td>
					<td align=\"center\">
						<a onclick='return confirm(\"Действительно удалить банерное место &lt;".stripslashes($row->name)."&gt; вместе с банерами?\")' href=\"?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
						<a href=\"?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
					</td>
				</tr>
                <tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"7\" align=\"center\"><br />В базе нет банерных мест<br /><br /></td></tr>
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
    <h3>Добавить Новое Место</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr>
		<td class="ff">На какой странице:</td>
		<td class="fr"><select name="orgpage">
<?php
		for( $i=0; $i<count($ban_page); $i++ )
		{
			echo '<option value="'.$i.'">'.$ban_page[$i].'</option>';
		}
?>
		</td>
	</tr>
	<tr><td class="ff">Номер позиции:</td><td class="fr"><input type="text" size="2" name="orgsort" /></td></tr>
	<tr>
		<td class="ff">Размеры банера:</td>
		<td class="fr"><input type="text" size="3" name="orgw" /> x <input type="text" size="3" name="orgh" /> px
		</td>
	</tr>
    <tr><td class="ff">Название места:</td><td class="fr"><input type="text" size="70" name="orgname" /></td></tr>
    <tr>
		<td class="ff">Активная позиция:</td>
		<td class="fr"><select name="orgact">
			<option value="1">Активно</option>
			<option value="0">Отключено</option>
		</td>
	</tr>
	<tr><td class="ff">Стоимость:</td><td class="fr"><input type="text" size="2" name="orgcost" /></td></tr>
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
