<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "../inc/catutils-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit This Person";
   	$strings['tipdel']['en'] = "Delete This Person";

    $strings['tipedit']['ru'] = "Редактировать информацию о сотруднике";
   	$strings['tipdel']['ru'] = "Удалить сотрудника из списка";

	$PAGE_HEADER['ru'] = "Редактировать Список опросных листов";
	$PAGE_HEADER['en'] = "Staff List Editing";

	$grps = Array();
	$query = "SELECT g1.*, g2.type_name FROM $TABLE_QUEST_GROUP g1
		INNER JOIN $TABLE_QUEST_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		ORDER BY g1.sort_num, g2.type_name";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$gi = Array('id' => $row->id, 'name' => stripslashes($row->type_name));
			$grps[] = $gi;
		}
		mysqli_free_result( $res );
	}
	else
		mysqli_error($upd_link_db);

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$THIS_TABLE = $TABLE_QUEST_ITEMS;

?>

<?php

	switch( $action )
	{
		case "assign":
			$item_id = GetParameter("item_id", 0);
			$mode = "assign2pages";
			break;

		case "makeassign":
			$item_id = GetParameter("item_id", 0);

			$pages_id = GetParameter("pages_id", null);
			$sects_id = GetParameter("sects_id", null);

			$query = "DELETE FROM $TABLE_QUEST_ITEMS2PAGE WHERE item_id=".$item_id;
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			for( $i=0; $i<count($pages_id); $i++ )
			{
				$query = "INSERT INTO $TABLE_QUEST_ITEMS2PAGE (item_id, page_id) VALUES ('".$item_id."', '".$pages_id[$i]."')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			for( $i=0; $i<count($sects_id); $i++ )
			{
				$query = "INSERT INTO $TABLE_QUEST_ITEMS2PAGE (item_id, cat_id) VALUES ('".$item_id."', '".$sects_id[$i]."')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			break;

    	case "add":
    		$orgname = GetParameter("orgname", "");
    		$orgdolg = GetParameter("orgdolg", "");
			$orgdescr = GetParameter("orgdescr", "");
			$orgphone = GetParameter("orgphone", "");
			$orgphonesub = GetParameter("orgphonesub", "");
			$orgemail = GetParameter("orgemail", "");
			$orgicq = GetParameter("orgicq", "");
			$orgsort = GetParameter("orgsort", "0");
			$orglogo = GetParameter("orglogo", "");
			$orgsect = GetParameter("orgsect", 0);

    		$query = "INSERT INTO $THIS_TABLE ( sect_id, add_date, name, position, descr, email, phone, phone_sub, icq, photo_filename, sort_num, lang_id )
    			VALUES ('$orgsect', NOW(), '".addslashes($orgname)."', '".addslashes($orgdolg)."', '".addslashes($orgdescr)."',
    			'".addslashes($orgemail)."', '".addslashes($orgphone)."', '".addslashes($orgphonesub)."',
    			'".addslashes($orgicq)."', '".addslashes($orglogo)."',
    			'".addslashes($orgsort)."', '$LangId')";
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
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
    		$orgdolg = GetParameter("orgdolg", "");
			$orgdescr = GetParameter("orgdescr", "");
			$orgphone = GetParameter("orgphone", "");
			$orgphonesub = GetParameter("orgphonesub", "");
			$orgemail = GetParameter("orgemail", "");
			$orgicq = GetParameter("orgicq", "");
			$orgsort = GetParameter("orgsort", "0");
			$orglogo = GetParameter("orglogo", "");
			$orgsect = GetParameter("orgsect", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET sect_id='$orgsect', name='".addslashes($orgname)."', position='".addslashes($orgdolg)."',
                        descr='".addslashes($orgdescr)."', phone='".addslashes($orgphone)."',
                        email='".addslashes($orgemail)."', phone_sub='".addslashes($orgphonesub)."',
                        icq='".addslashes($orgicq)."', sort_num='".addslashes($orgsort)."',
                        photo_filename='".addslashes($orglogo)."'
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


function FillPageList($pid, $level, $selid)
{
	global $TABLE_PAGES, $TABLE_PAGES_LANGS, $LangId, $PHP_SELF, $strings, $lang;
	global $TABLE_QUEST_ITEMS2PAGE;

	$num_pages = 0;

	if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean
			FROM $TABLE_PAGES p1
			INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.parent_id=$pid
			ORDER BY p1.show_in_menu, p1.sort_num") )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$num_pages++;

			$link_file = "";
			switch( $row->page_record_type )
			{
				case 1:	$link_file = stripslashes($row->page_name).'.php';				break;
				case 2:	$link_file = stripslashes($row->page_name).'/';					break;
				case 3:	$link_file = "info.php?page=".stripslashes($row->page_name);	break;
				case 4: $link_file = stripslashes($row->page_name);						break;
			}

			$is_checked = false;

			$query1 = "SELECT * FROM $TABLE_QUEST_ITEMS2PAGE WHERE item_id='$selid' AND page_id=".$row->id;
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$is_checked = true;
				}
				mysqli_free_result( $res1 );
			}

           	echo "<tr>
                 <td class=\"fr\"><input type=\"checkbox\" name=\"pages_id[]\" value=\"".$row->id."\" ".($is_checked ? "checked" : "")." /></td>
                 <td class=\"fr\" style=\"padding: 2px 10px 2px ".(10+$level*20)."px\"><b>".stripslashes($row->page_mean)."</b> (".$link_file.")</td>
               </tr>";
            //echo "<tr><td colspan=\"2\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";


			$pres = FillPageList($row->id, $level+1, $selid);
			$num_pages += $pres;
		}
  		mysqli_free_result($res);
	}

	return $num_pages;
}

    if( $mode == "assign2pages" )
    {
    	$quest_list_name = "";

		$query = "SELECT * FROM $TABLE_QUEST_ITEMS WHERE id=".$item_id;
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$quest_list_name = stripslashes($row->name);
			}
			mysqli_free_result( $res );
		}

		$THIS_TABLE = $TABLE_CAT_CATALOG;
    	$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
    	$THIS_TABLE_P2P = $TABLE_QUEST_ITEMS2PAGE;
?>
		<h3>Привязать вопрос к товару в каталоге<br />&quot;<?=$quest_list_name;?>&quot;</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm">
    	<table align="center" width="600" cellspacing="0" cellpadding="1" border="0" class="tableborder">
	    <tr><td><table width="100%" cellspacing="1" cellpadding="0" border="0">
		<input type="hidden" name="action" value="makeassign" />
		<input type="hidden" name="item_id" value="<?=$item_id;?>" />
<?php
		$found_items = FillPageList(0, 0, $item_id);

  		PrintWorkCatalog(0, $LangId, 0, "checklistall", $item_id);
?>
		<tr>
			<td class="fr" colspan="2" align="center">
				<input type="submit" name="doplacebut" value=" Применить " />
			</td>
		</tr>
		</table>
		</td></tr>
		</table>
<?php
    }
    else if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orgdolg = "";
		$orgdescr = "";
		$orgphone = "";
		$orgphonesub = "";
		$orgemail = "";
		$orgicq = "";
		$orgsort = "0";
		$orgsect = 0;
		$orglogo = "";

		if($res = mysqli_query($upd_link_db,"SELECT * FROM $THIS_TABLE WHERE id=$item_id"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->name);
				$orgdolg = stripslashes($row->position);
				$orgdescr = stripslashes($row->descr);
                $orgphone = stripslashes($row->phone);
				$orgemail = stripslashes($row->email);
	            $orgphonesub = stripslashes($row->phone_sub);
	            $orgicq = stripslashes($row->icq);
                $orgsort = $row->sort_num;
				$orglogo = stripslashes($row->photo_filename);
                $orgsect = $row->sect_id;
			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr>
		<td class="ff">Группа:</td>
		<td class="fr">
			<select name="orgsect">
		<?php
			for($i=0; $i<count($grps); $i++)
			{
				echo "<option value=\"".$grps[$i]['id']."\" ".($grps[$i]['id'] == $orgsect ? "selected" : "").">".$grps[$i]['name']."</option>";
			}
		?>
			</select></td></tr>
    <tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Короткое название:</td><td class="fr"><input type="text" size="30" name="orgdolg" value="<?=$orgdolg;?>" /></td></tr>
<?php
/*
    <tr><td class="ff">Должность:</td><td class="fr"><input type="text" size="50" name="orgdolg" value="<?=$orgdolg;?>" /></td></tr>
    <tr><td class="ff">Веб-страница:</td><td class="fr"><input type="text" size="50" name="orgdolg" value="<?=$orgdolg;?>" /></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
<tr><td class="ff">Контактный телефон:</td><td class="fr"><input type="text" size="20" name="orgphone" value="<?=$orgphone;?>" /></td></tr>
	<tr><td class="ff">Внутренный номер:</td><td class="fr"><input type="text" size="10" name="orgphonesub" value="<?=$orgphonesub;?>" /></td></tr>
	<tr><td class="ff">Контактный E-Mail:</td><td class="fr"><input type="text" size="50" name="orgemail" value="<?=$orgemail;?>" /></td></tr>
	<tr><td class="ff">Контактный ICQ:</td><td class="fr"><input type="text" size="15" name="orgicq" value="<?=$orgicq;?>" /></td></tr>
*/
?>
	<tr><td class="ff">Фото:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="2" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
?>
    <h3>Список Опросных листов</h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Группа</th>
    	<th>Добавлен</th>
    	<th>Страниц</th>
    	<th>Название</th>
    	<th>Файл</th>
    <?php
    /*
    	<th style="padding: 1px 10px 1px 20px" width="55%">Описание</th>
    */
    ?>
    	<th>Функции</th>
    </tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT s1.*, g1.sort_num, g2.type_name FROM $THIS_TABLE s1
			INNER JOIN $TABLE_QUEST_GROUP g1 ON g1.id=s1.sect_id
			INNER JOIN $TABLE_QUEST_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
			ORDER BY g1.sort_num, g2.type_name, s1.sort_num, s1.name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

                $assign_num = 0;
                $query1 = "SELECT count(*) as totit FROM $TABLE_QUEST_ITEMS2PAGE WHERE item_id=".$row->id;
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                	while( $row1 = mysqli_fetch_object( $res1 ) )
                	{
                		$assign_num = $row1->totit;
                	}
                	mysqli_free_result( $res1 );
                }
                else
                	echo mysqli_error($upd_link_db);

            	echo "<tr>
             	<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
             	<td style=\"padding: 2px 10px 2px 10px;\">".stripslashes($row->type_name)."</td>
             	<td style=\"padding: 2px 10px 2px 10px;\">".$row->add_date."</a></td>
				<td align=\"center\">".$assign_num."</td>
              	<td style=\"padding: 2px 10px 2px 10px;\"><b>".stripslashes($row->name)."</b><br />".stripslashes($row->position)."</td>
               	<td>";

               	if( $row->photo_filename != "" )
                {
                		echo "<a href=\"".$FILE_DIR.stripslashes($row->photo_filename)."\">".stripslashes($row->photo_filename)."</a>";
                }
                echo "</td>";
                            //<td><b>Описание:</b><br />".nl2br(stripslashes($row->descr))."<br /></td>
                            echo "<td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&action=assign\"><img src=\"img/assign.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Привязать к страницам\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"6\" align=\"center\"><br />В базе нет опросных листов<br /><br /></td></tr>
			<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Опросный Лист</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr>
		<td class="ff">Группа:</td>
		<td class="fr">
			<select name="orgsect">
		<?php
			for($i=0; $i<count($grps); $i++)
			{
				echo "<option value=\"".$grps[$i]['id']."\">".$grps[$i]['name']."</option>";
			}
		?>
			</select></td></tr>
    <tr><td class="ff">Название листа:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Короткое название:</td><td class="fr"><input type="text" size="30" name="orgdolg"></td></tr>
<?
/*
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="orgdescr"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	<tr><td class="ff">Контактный телефон:</td><td class="fr"><input type="text" size="30" name="orgphone"></td></tr>
	<tr><td class="ff">Внутренный номер:</td><td class="fr"><input type="text" size="10" name="orgphonesub"></td></tr>
	<tr><td class="ff">Контактный E-Mail:</td><td class="fr"><input type="text" size="50" name="orgemail"></td></tr>
	<tr><td class="ff">Контактный ICQ:</td><td class="fr"><input type="text" size="15" name="orgicq"></td></tr>
*/
?>
	<tr><td class="ff">Файл:</td><td class="fr"><input type="text" size="30" name="orglogo"><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
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
