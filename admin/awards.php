<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

    include "../inc/utils-inc.php";
    include "../inc/catutils-inc.php";

	include "inc/authorize-inc.php";

	if( $UserId == 0 )
	{
		header("Location: index.php");
	}

	$AWARD_DIR = "../".$AWARD_DIR;

	$strings['tipedit']['en'] = "Edit Awards List";
	$strings['tipdel']['en'] = "Delete This Award";

	$strings['tipedit']['ru'] = "Редактировать информацию о награде";
	$strings['tipdel']['ru'] = "Удалить награду из списка";

	$PAGE_HEADER['ru'] = "Редактировать Список Наград";
	$PAGE_HEADER['en'] = "Awards' Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$catsect = GetSectLevel(0, $LangId);

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	switch( $action )
	{
    	case "add":
			$awname = GetParameter("awname", "");
    		$awname = str_replace("\"","&quot;", $awname);
			$awdescr = GetParameter("awdescr", "");
			$awsort = GetParameter("awsort", "");
			$awimg = GetParameter("awimg", "");

    		$query = "INSERT INTO $TABLE_AWARDS ( sort_num, img_filename )
    			VALUES ('".addslashes($awsort)."', '".addslashes($awimg)."')";

			if(!mysql_query($query))
			{
				echo "<b>".mysql_error()."</b>";
			}
			else
			{
				$newid = mysql_insert_id();

				// Add lang texts
				for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysql_query( "INSERT INTO $TABLE_AWARDS_LANGS ( item_id, lang_id, name, descr )
	                    VALUES ('$newid', '".$langs[$i]."', '".addslashes($awname)."', '".addslashes($awdescr)."')" ) )
	                {
	                   echo mysql_error();
	                }
	            }

                $img_ext = strtolower(substr( $awimg, strrpos($awimg, ".") ));

				if( file_exists( $AWARD_DIR.$newid.$img_ext ) )
				{
					unlink( $AWARD_DIR.$newid.$img_ext );
				}

				ResizeImage( $FILE_DIR.$awimg, $AWARD_DIR.$newid.$img_ext, $img_ext, $img_ext, 180, 250 );
			}
   			break;

		case "delete":
			// Delete selected news
			$items_id = GetParameter("items_id", "");
			for($i = 0; $i < count($items_id); $i++)
			{
				if(!mysql_query("DELETE FROM $TABLE_AWARDS WHERE id='".$items_id[$i]."'"))
				{
        			echo "<b>".mysql_error()."</b>";
    			}
    			else
    			{
    				if( !mysql_query( "DELETE FROM $TABLE_AWARDS_LANGS WHERE item_id='".$items_id[$i]."'" ) )
                    {
                       echo mysql_error();
                    }
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
			if(!mysql_query("DELETE FROM $TABLE_AWARDS WHERE id=".$item_id." "))
			{
   				echo "<b>".mysql_error()."</b>";
			}
			else
			{
				if( !mysql_query( "DELETE FROM $TABLE_AWARDS_LANGS WHERE item_id='".$item_id."'" ) )
				{
					echo mysql_error();
				}
			}
   			break;

		case "update":
			$item_id = GetParameter("item_id", "");
   			$awname = GetParameter("awname", "");
			//$awname = str_replace("\"","&quot;", $awname);
   			$awdescr = GetParameter("awdescr", "");
   			$awsort = GetParameter("awsort", "");
   			$awimg = GetParameter("awimg", "");
   			$sectid = GetParameter("sectid", 0);

   			if(!mysql_query("UPDATE $TABLE_AWARDS
                        SET sect_id='".$sectid."', sort_num='".addslashes($awsort)."', img_filename='".addslashes($awimg)."'
                        WHERE id=".$item_id." "))
			{
   				echo "<b>".mysql_error()."</b>";
			}
			else
			{
       			$newid = $item_id;

       			$query = "UPDATE $TABLE_AWARDS_LANGS SET name='".addslashes($awname)."', descr='".addslashes($awdescr)."'
       				WHERE item_id='$item_id' AND lang_id='$LangId'";
				if( !mysql_query( $query ) )
				{
					echo mysql_error();
				}

       			echo "newid = $newid<br />";

         		$img_ext = substr( $awimg, strrpos($awimg, ".") );
    			$img_ext1 = strtolower($img_ext);

    			echo "File: ".$AWARD_DIR.$newid.$img_ext1."<br />";

				if( file_exists( $AWARD_DIR.$newid.$img_ext1 ) )
				{
					if( !unlink( $AWARD_DIR.$newid.$img_ext1 ) )
					{
                    	echo "Error delete the old file<br />";
                    }
				}

				if( !ResizeImage( $FILE_DIR.$awimg, $AWARD_DIR.$newid.$img_ext1, $img_ext1, $img_ext1, 180, 250 ) )
				{
    				echo "Error resizing image";
				}
			}
			break;
	}


    if( $mode == "edit" )
	{
		$item_id = GetParameter("item_id", "0");
		$awname = "";
		$awdescr = "";
		$awsort = "0";
		$awimg = "";
		$sectid = 0;

		if($res = mysql_query("SELECT a1.*, a2.name, a2.descr FROM $TABLE_AWARDS a1, $TABLE_AWARDS_LANGS a2
				WHERE a1.id='$item_id' AND a1.id=a2.item_id AND a2.lang_id='$LangId'"))
		{
			if($row = mysql_fetch_object($res))
			{
				$awname = stripslashes($row->name);
				$awdescr = stripslashes($row->descr);
         		$awsort = $row->sort_num;
				$awimg = stripslashes($row->img_filename);
				$sectid = $row->sect_id;
			}
   			mysql_free_result($res);
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
    <tr><td class="ff">Название Награды:</td><td class="fr"><input type="text" size="70" name="awname" value="<?=$awname;?>" /></td></tr>
    <tr><td class="ff">Раздел каталога:</td><td class="fr">
    	<select name="sectid">
    		<option value="0">Все разделы</option>
<?php
	for( $i=0; $i<count($catsect); $i++ )
	{
		echo '<option value="'.$catsect[$i]['id'].'" '.($sectid == $catsect[$i]['id'] ? "selected" : "").'>'.$catsect[$i]['name'].'</option>';
	}
?>
    	</select>
    </td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="awdescr"><?=$awdescr;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('awdescr'); // field, width, height
</script>
	<tr><td class="ff">Фото:</td><td class="fr"><input type="text" size="30" name="awimg" value="<?=$awimg;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.awimg','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="3" name="awsort" value="<?=$awsort;?>" /></td></tr>
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
    <h3>Список Наград</h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr><th>&nbsp;</th><th>Фото</th><th style="padding: 1px 10px 1px 20px" width="55%">Описание</th><th>Функции</th></tr>
    <?
    	$found_items = 0;
		if( $res = mysql_query("SELECT a1.*, a2.name, a2.descr FROM $TABLE_AWARDS a1, $TABLE_AWARDS_LANGS a2
				WHERE a1.id=a2.item_id AND a2.lang_id='$LangId' ORDER BY a1.sort_num, a2.name") )
		{
			while($row=mysql_fetch_object($res))
			{
                $found_items++;

            			echo "<tr>
                               <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                               <td style=\"padding: 2px 10px 2px 10px\">";
                        if( $row->img_filename != "" )
                        {
                     		//echo "<img src=\"".$FILE_DIR.stripslashes($row->img_filename)."\" alt=\"Фото\" /><br />";
                         	echo "<img src=\"".$AWARD_DIR.$row->id.strtolower(substr(stripslashes($row->img_filename), strrpos(stripslashes($row->img_filename), ".")))."\" alt=\"Фото\" /><br />";
                     	}
                     	else
                        {
                            echo "<center>Нет Фото</center>";
                        }
                     	echo "</td>
                               <td><b>".stripslashes($row->name)."</b><br /><b>Описание:</b><br />".nl2br(stripslashes($row->descr))."<br /></td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysql_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"4\" align=\"center\"><br />В базе нет наград<br /><br /></td></tr>
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
    <h3>Добавить Награду</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название Награды:</td><td class="fr"><input type="text" size="70" name="awname"></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea rows="7" cols="70" name="awdescr"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('awdescr'); // field, width, height
</script>
	<tr><td class="ff">Фото:</td><td class="fr"><input type="text" size="30" name="awimg"><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.awimg','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="3" name="awsort" value="0" /></td></tr>
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
