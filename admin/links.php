<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit This Partner Information";
   	$strings['tipdel']['en'] = "Delete This Partner";

    $strings['tipedit']['ru'] = "Редактировать информацию о партнере";
   	$strings['tipdel']['ru'] = "Удалить партнера из списка";

	$PAGE_HEADER['ru'] = "Редактировать Список Партнеров";
	$PAGE_HEADER['en'] = "Partner's Links Editing";

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
			$orgdescr = GetParameter("orgdescr", "");
			$orgphone = GetParameter("orgphone", "");
			$orgemail = GetParameter("orgemail", "");
			$orgwww = GetParameter("orgwww", "");
			$orglogo = GetParameter("orglogo", "");
			$orgsort = GetParameter("orgsort", 0);

    		$query = "INSERT INTO $TABLE_LINKS ( weburl, email, phone, sort_num, logo_filename)
    			VALUES ('".addslashes($orgwww)."', '".addslashes($orgemail)."',
    			'".addslashes($orgphone)."', $orgsort, '".addslashes($orglogo)."')";

			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b><br />".$query."<br />";
			}
			else
			{
				$newid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_LINKS_LANGS ( item_id, lang_id, orgname, descr )
	                    VALUES ('$newid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgdescr)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }
			}
			break;

		case "delete":
			// Delete selected news
			$items_id = GetParameter("items_id", "");
			for($i = 0; $i < count($items_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_LINKS WHERE id=".$items_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_LINKS_LANGS WHERE item_id=".$items_id[$i]." "))
					{
	        			echo "<b>".mysqli_error($upd_link_db)."</b>";
	    			}
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_LINKS WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		else
    		{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_LINKS_LANGS WHERE item_id=".$item_id." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    		}
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
			$orgdescr = GetParameter("orgdescr", "");
			$orgphone = GetParameter("orgphone", "");
			$orgemail = GetParameter("orgemail", "");
			$orgwww = GetParameter("orgwww", "");
			$orglogo = GetParameter("orglogo", "");
			$orgsort = GetParameter("orgsort", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_LINKS SET phone='".addslashes($orgphone)."', email='".addslashes($orgemail)."',
					weburl='".addslashes($orgwww)."', sort_num=$orgsort, logo_filename='".addslashes($orglogo)."'
					WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_LINKS_LANGS SET orgname='".addslashes($orgname)."',
					descr='".addslashes($orgdescr)."' WHERE item_id=".$item_id." AND lang_id='$LangId'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orgdescr = "";
		$orgphone = "";
		$orgemail = "";
		$orgwww = "";
		$orglogo = "";
		$orgsort = 0;

		if($res = mysqli_query($upd_link_db,"SELECT l1.*, l2.orgname, l2.descr FROM $TABLE_LINKS l1
			INNER JOIN $TABLE_LINKS_LANGS l2 ON l1.id=l2.item_id AND l2.lang_id='$LangId'
			WHERE l1.id=$item_id"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->orgname);
				$orgdescr = stripslashes($row->descr);
                $orgphone = stripslashes($row->phone);
				$orgemail = stripslashes($row->email);
                $orgwww = stripslashes($row->weburl);
				$orglogo = stripslashes($row->logo_filename);
				$orgsort = $row->sort_num;
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
    <tr><td class="ff">Название Организации:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
	<tr><td class="ff">Контактный телефон:</td><td class="fr"><input type="text" size="20" name="orgphone" value="<?=$orgphone;?>"></td></tr>
	<tr><td class="ff">Веб-страница:</td><td class="fr"><input type="text" size="50" name="orgwww" value="<?=$orgwww;?>" /></td></tr>
	<tr><td class="ff">Контактный E-Mail:</td><td class="fr"><input type="text" size="50" name="orgemail" value="<?=$orgemail;?>" /></td></tr>
	<tr><td class="ff">Логотип:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
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
    <h3>Список Партнеров</h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr><th>&nbsp;</th><th>Организация</th><th style="padding: 1px 10px 1px 20px" width="55%">Описание</th><th>Функции</th></tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT l1.*, l2.orgname, l2.descr FROM $TABLE_LINKS l1
			INNER JOIN $TABLE_LINKS_LANGS l2 ON l1.id=l2.item_id AND l2.lang_id='$LangId'
			ORDER BY l1.sort_num, l2.orgname") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
            	<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
            	<td style=\"padding: 2px 10px 2px 10px\"><b>".stripslashes($row->orgname)."</b><br />";
            	if( $row->logo_filename != "" )
            	{
            		echo "<img src=\"".$FILE_DIR.stripslashes($row->logo_filename)."\" alt=\"logo\" /><br />";
            	}
            	else
            	{
            		echo "<br /><br />";
            	}
            	echo "Телефон: ".stripslashes($row->phone)."<br />
            	<a href=\"http://".stripslashes($row->weburl)."\">".stripslashes($row->weburl)."</a><br />
            	<a href=\"mailto:".stripslashes($row->email)."\">".stripslashes($row->email)."</a><br /></td>
            	<td><b>Описание:</b><br />".nl2br(stripslashes($row->descr))."<br /></td>
            	<td align=\"center\">
            	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
            	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"4\" align=\"center\"><br />В базе нет партнеров<br /><br /></td></tr>
			<tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Партнера</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название Организации:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="orgdescr"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
	<tr><td class="ff">Контактный телефон:</td><td class="fr"><input type="text" size="20" name="orgphone"></td></tr>
	<tr><td class="ff">Веб-страница:</td><td class="fr"><input type="text" size="50" name="orgwww"></td></tr>
	<tr><td class="ff">Контактный E-Mail:</td><td class="fr"><input type="text" size="50" name="orgemail"></td></tr>
	<tr><td class="ff">Логотип:</td><td class="fr"><input type="text" size="30" name="orglogo"><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="2" name="orgsort" /></td></tr>
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
