<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";
     include "../inc/utils-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit brand info";
   	$strings['tipdel']['en'] = "Delete this brand";

    $strings['tipedit']['ru'] = "Редактировать производителя";
   	$strings['tipdel']['ru'] = "Удалить марку из списка";

	$PAGE_HEADER['ru'] = "Редактировать Доступные Бренды";
	$PAGE_HEADER['en'] = "Product Brands Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_CAT_MAKE;
	$THIS_TABLE_LANG = $TABLE_CAT_MAKE_LANGS;

	// Get GET/POST environment variables
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	switch( $action )
	{
    	case "add":
    		$orgname = GetParameter("orgname", "");
		$orgurl = GetParameter("orgurl", "");
		if($orgurl==""){
			$orgurl=TranslitEncode($orgname);
			$orgurl=strtolower($orgurl);

		}else{
			$orgurl=TranslitEncode($orgurl);
			$orgurl=strtolower($orgurl);
		}

    		//$orgname = str_replace ("\"", "&quot;", $orgname);
    		$orgdescr = GetParameter("orgdescr", "", false);
			$orglogo = GetParameter("orglogo", "");

    		$query = "INSERT INTO $THIS_TABLE ( logo_filename,url )
    			VALUES ('".addslashes($orglogo)."','".addslashes($orgurl)."')";
			if(mysqli_query($upd_link_db,$query))
			{
            	$newmakeid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( make_id, lang_id, make_name, descr )
	                    VALUES ('$newmakeid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgdescr)."')" ) )
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
                    if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE make_id='".$items_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }

                    if( file_exists("..".$LINK_PHOTO_DIR.$items_id[$i].".jpg") )
					{
						unlink( "..".$LINK_PHOTO_DIR.$items_id[$i].".jpg" );
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
            	if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE make_id='".$item_id."'" ) )
                {
                	echo mysqli_error($upd_link_db);
                }

                if( file_exists("../".$LINK_PHOTO_DIR.$item_id.".jpg") )
				{
					unlink( "../".$LINK_PHOTO_DIR.$item_id.".jpg" );
				}
            }
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
	    $orgurl = GetParameter("orgurl", "");
		if($orgurl==""){
			$orgurl=TranslitEncode($orgname);
			$orgurl=strtolower($orgurl);

		}else{
			$orgurl=TranslitEncode($orgurl);
			$orgurl=strtolower($orgurl);
		}
            //$orgname = str_replace ("\"", "&quot;", $orgname);
			$orglogo = GetParameter("orglogo", "");
			$orgdescr = GetParameter("orgdescr", "", false);

			if( file_exists("../".$LINK_PHOTO_DIR.$item_id.".jpg") )
			{
				unlink( "../".$LINK_PHOTO_DIR.$item_id.".jpg" );
			}

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET logo_filename='".addslashes($orglogo)."',url='".addslashes($orgurl)."'
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

            if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG SET make_name='".addslashes($orgname)."', descr='".stripslashes($orgdescr)."'
            	WHERE make_id='".$item_id."' AND lang_id='".$LangId."'" ) )
            {
            	echo mysqli_error($upd_link_db);
            }
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orglogo = "";
		$orgdescr = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.make_name, m2.descr FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.make_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->make_name);
				$orgurl = stripslashes($row->url);
				$orglogo = stripslashes($row->logo_filename);
				$orgdescr = stripslashes($row->descr);
			}
			mysqli_free_result($res);
		}
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <tr><td class="ff">Название бренда:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
     <tr><td class="ff">Url бренда:</td><td class="fr"><input type="text" size="70" name="orgurl" value="<?=$orgurl;?>" /></td></tr>
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea name="orgdescr" cols="60" rows="15"><?=$orgdescr;?></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	<tr><td class="ff">Логотип:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
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
    <h3>Список брендов</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr><th>&nbsp;</th><th>Логотип</th><th>Название бренда/Описание</th><th>Функции</th></tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*, m2.make_name, m2.descr FROM $THIS_TABLE m1,
			$THIS_TABLE_LANG m2 WHERE m1.id=m2.make_id AND m2.lang_id='$LangId' ORDER BY make_name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                               <td>";
                if( $row->logo_filename != "" )
	            {
	            	echo "<img src=\"".$FILE_DIR.stripslashes($row->logo_filename)."\" alt=\"".stripslashes($row->make_name)." logo\" />";
	            }
                     	  echo "</td>
                               <td style=\"padding: 1px 10px 1px 10px\">
                                   <b>".stripslashes($row->make_name)."</b><br />
                                   ".stripslashes($row->descr)."
                               </td>
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
			echo "<tr><td colspan=\"4\" align=\"center\"><br />В базе нет брендов<br /><br /></td></tr>
			<tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Новый Бренд</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название бренда:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Url бренда:</td><td class="fr"><input type="text" size="70" name="orgurl"></td></tr>
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea name="orgdescr" cols="60" rows="15"></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>

	<tr><td class="ff">Логотип:</td><td class="fr"><input type="text" size="30" name="orglogo" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
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
