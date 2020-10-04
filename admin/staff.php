<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit This Person";
   	$strings['tipdel']['en'] = "Delete This Person";

    $strings['tipedit']['ru'] = "Редактировать информацию о сотруднике";
   	$strings['tipdel']['ru'] = "Удалить сотрудника из списка";

	$PAGE_HEADER['ru'] = "Редактировать Список Сотрудников";
	$PAGE_HEADER['en'] = "Staff List Editing";

	$grps = Array();
	$query = "SELECT g1.*, g2.type_name FROM $TABLE_STAFF_GROUP g1
		INNER JOIN $TABLE_STAFF_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
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

?>

<?php

	switch( $action )
	{
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

    		$query = "INSERT INTO $TABLE_STAFF ( sect_id, name, position, descr, email, phone, phone_sub, icq, photo_filename, sort_num, lang_id )
    			VALUES ('$orgsect', '".addslashes($orgname)."', '".addslashes($orgdolg)."', '".addslashes($orgdescr)."',
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
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_STAFF WHERE id=".$items_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_STAFF WHERE id=".$item_id." "))
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

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_STAFF
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


    if( $mode == "edit" )
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

		if($res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_STAFF WHERE id=$item_id"))
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
    <tr><td class="ff">Ф.И.О. Сотрудника:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Должность:</td><td class="fr"><input type="text" size="50" name="orgdolg" value="<?=$orgdolg;?>" /></td></tr>
<?php
/*
    <tr><td class="ff">Веб-страница:</td><td class="fr"><input type="text" size="50" name="orgdolg" value="<?=$orgdolg;?>" /></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
*/
?>
	<tr><td class="ff">Контактный телефон:</td><td class="fr"><input type="text" size="20" name="orgphone" value="<?=$orgphone;?>" /></td></tr>
	<tr><td class="ff">Внутренный номер:</td><td class="fr"><input type="text" size="10" name="orgphonesub" value="<?=$orgphonesub;?>" /></td></tr>
	<tr><td class="ff">Контактный E-Mail:</td><td class="fr"><input type="text" size="50" name="orgemail" value="<?=$orgemail;?>" /></td></tr>
	<tr><td class="ff">Контактный ICQ:</td><td class="fr"><input type="text" size="15" name="orgicq" value="<?=$orgicq;?>" /></td></tr>
<?php
/*
	<tr><td class="ff">Фото:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
*/
?>
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
    <h3>Список Сотрудников</h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Группа</th>
    	<th>Сотрудник</th>
    	<th>Контакты</th>
    <?php
    /*
    	<th style="padding: 1px 10px 1px 20px" width="55%">Описание</th>
    */
    ?>
    	<th>Функции</th>
    </tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT s1.*, g1.sort_num, g2.type_name FROM $TABLE_STAFF s1
			INNER JOIN $TABLE_STAFF_GROUP g1 ON g1.id=s1.sect_id
			INNER JOIN $TABLE_STAFF_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
			ORDER BY g1.sort_num, g2.type_name, s1.sort_num, s1.name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
             	<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
             	<td style=\"padding: 2px 10px 2px 10px\">".stripslashes($row->type_name)."</td>
              	<td style=\"padding: 2px 10px 2px 10px\">
                                   <b>".stripslashes($row->name)."</b><br />".stripslashes($row->position)."<br />";
                     if( $row->photo_filename != "" )
                     {
                     		echo "<img src=\"".$FILE_DIR.stripslashes($row->photo_filename)."\" alt=\"logo\" /><br />";
                     }
                     		echo "</td>
                     		<td>Телефон: ".stripslashes($row->phone)."<br />
                     		Внутренний: ".stripslashes($row->phone_sub)."<br />
                       		E-Mail<a href=\"mailto:".stripslashes($row->email)."\">".stripslashes($row->email)."</a><br />
                         	ICQ: ".stripslashes($row->icq)."<br /></td>";
                            //<td><b>Описание:</b><br />".nl2br(stripslashes($row->descr))."<br /></td>
                            echo "<td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"5\" align=\"center\"><br />В базе нет сотрудников<br /><br /></td></tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"5\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Сотрудника</h3>
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
    <tr><td class="ff">Ф.И.О. Сотрудника:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Должность:</td><td class="fr"><input type="text" size="50" name="orgdolg"></td></tr>
<?
/*
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="orgdescr"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
*/
?>
	<tr><td class="ff">Контактный телефон:</td><td class="fr"><input type="text" size="30" name="orgphone"></td></tr>
	<tr><td class="ff">Внутренный номер:</td><td class="fr"><input type="text" size="10" name="orgphonesub"></td></tr>
	<tr><td class="ff">Контактный E-Mail:</td><td class="fr"><input type="text" size="50" name="orgemail"></td></tr>
	<tr><td class="ff">Контактный ICQ:</td><td class="fr"><input type="text" size="15" name="orgicq"></td></tr>
<?php
/*
	<tr><td class="ff">Фото:</td><td class="fr"><input type="text" size="30" name="orglogo"><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
*/
?>
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
