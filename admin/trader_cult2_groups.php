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

	$strings['tipedit']['en'] = "Edit product profiles";
   	$strings['tipdel']['en'] = "Delete this profile";
   	$strings['tipassign']['en'] = "Assign parameters to profile";

    $strings['tipedit']['ru'] = "Редактировать группу товаров";
   	$strings['tipdel']['ru'] = "Удалить группу из списка";
   	$strings['tipassign']['ru'] = "Прикрепить параметры к типу товара";

	$PAGE_HEADER['ru'] = "Редактировать перечень групп товаров";
	$PAGE_HEADER['en'] = "Product Types Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TRADER_PR_CULT_GROUPS;
	$THIS_TABLE_LANG = $TABLE_TRADER_PR_CULT_GROUPS_LANGS;

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	
	$acttype = GetParameter("acttype", 1);

	switch( $action )
	{
		case "edit":
			$item_id = GetParameter("item_id", "0");

			$orgname = "";
			$orglogo = "";
			$orgdescr = "";
			$orgurl = "";
			$orgsort = 0;

			if($res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.descr
				FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
				WHERE p1.id='$item_id' AND p1.id=p2.item_id AND p2.lang_id='$LangId'"))
			{
				if($row = mysqli_fetch_object($res))
				{
					$orgname = stripslashes($row->name);
					$orglogo = stripslashes($row->icon_filename);
					$orgdescr = stripslashes($row->descr);
					$orgurl = stripslashes($row->url);
					$orgsort = $row->sort_num;
				}
				mysqli_free_result($res);
			}

			$mode = "edit";
			break;

    	case "add":
    		$orgname = GetParameter("orgname", "");
    		$orgdescr = GetParameter("orgdescr", "");
			$orglogo = GetParameter("orglogo", "");
			$orgurl = GetParameter("orgurl", "");
			$orgsort = GetParameter("orgsort", 0);

    		$query = "INSERT INTO $THIS_TABLE ( icon_filename, url, sort_num, acttype )
    			VALUES ('".addslashes($orglogo)."', '".addslashes($orgurl)."', '".$orgsort."', '$acttype')";
			if(mysqli_query($upd_link_db,$query))
			{
                $newcatid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( item_id, lang_id, name, descr )
	                    VALUES ('$newcatid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgdescr)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }
			}
			else
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
                    if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE item_id='".$items_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
                }

    			// Here all vehicle items should be unassigned to 0 profile id
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
                if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE item_id='".$item_id."'" ) )
                {
                       echo mysqli_error($upd_link_db);
                }
            }
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
			$orglogo = GetParameter("orglogo", "");
			$orgdescr = GetParameter("orgdescr", "");
			$orgurl = GetParameter("orgurl", "");
			$orgsort = GetParameter("orgsort", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET sort_num='".$orgsort."', url='".addslashes($orgurl)."', icon_filename='".addslashes($orglogo)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

            if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG
            	SET name='".addslashes($orgname)."', descr='".addslashes($orgdescr)."'
            	WHERE item_id='".$item_id."' AND lang_id='".$LangId."'" ) )
            {
            	echo mysqli_error($upd_link_db);
            }
			break;
	}


    if( $mode == "edit" )
    {
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <tr><td class="ff">Название группы:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">URL:</td><td class="fr"><input type="text" size="50" name="orgurl" value="<?=$orgurl;?>" /></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea cols="60" rows="4" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
	<tr><td class="ff">Иконка:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="2" name="orgsort" value="<?=$orgsort;?>" ></td></tr>
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
    <h3>Перечень групп товаров в базе</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>№ сорт</th>
    	<th>&nbsp;</th>
    	<th>Иконка</th>
    	<th>Название</th>
    	<th>Функции</th>
    </tr>
    <?
		$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.descr
			FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
			WHERE p1.acttype='$acttype' AND p1.id=p2.item_id AND p2.lang_id='$LangId' ORDER BY p1.sort_num, p2.name") )
		{
			while($row=mysqli_fetch_object($res))
			{
				$found_items++;

				echo "<tr>
				<td>".$row->sort_num."</td>
				<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
				<td>";
				if( $row->icon_filename != "" )
				{
					echo "<img src=\"".$FILE_DIR.stripslashes($row->icon_filename)."\" alt=\"".stripslashes($row->name)." icon\" />";
				}
				echo "</td>
				<td style=\"padding: 1px 10px 1px 10px\">
					<b>".stripslashes($row->name)."</b><br />".nl2br(stripslashes($row->descr))."<br />
				</td>
				<td align=\"center\">
					<a onclick='return confirm(\"При удаление вся информация связанная с &lt;".stripslashes($row->name)."&gt; будет удалена.\\r\\nУдалить ".stripslashes($row->name)."?\")' href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\" title=\"".$strings['tipdel'][$lang]."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
					<a href=\"$PHP_SELF?action=edit&item_id=".$row->id."\" title=\"".$strings['tipedit'][$lang]."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>
				</td>
				</tr>
				<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
			mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"5\" align=\"center\"><br />В базе нет культур<br /><br /></td></tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"5\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить новую группу товаров</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название группы:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">URL:</td><td class="fr"><input type="text" size="50" name="orgurl" /></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea cols="60" rows="4" name="orgdescr"></textarea></td></tr>
	<tr><td class="ff">Иконка:</td><td class="fr"><input type="text" size="30" name="orglogo" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="2" name="orgsort"></td></tr>
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
