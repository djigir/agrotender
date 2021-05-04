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

    $strings['tipedit']['ru'] = "Редактировать список моделей авто";
   	$strings['tipdel']['ru'] = "Удалить модель из списка";

	$PAGE_HEADER['ru'] = "Редактировать Модели Авто";
	$PAGE_HEADER['en'] = "Auto Models Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_CAR_MODEL;
	//$THIS_TABLE_LANG = $TABLE_CAT_MAKE_LANGS;

	// Get GET/POST environment variables
	$id = GetParameter("id", 0);
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

    		$query = "INSERT INTO $THIS_TABLE ( brand_id, url, carmodel, carphoto, descr )
    			VALUES ('".$id."','".addslashes($orgurl)."', '".addslashes($orgname)."', '".addslashes($orglogo)."', '".addslashes($orgdescr)."')";
			if(mysqli_query($upd_link_db,$query))
			{
            	$newmakeid = mysqli_insert_id($upd_link_db);
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

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET url='".addslashes($orgurl)."', carmodel='".addslashes($orgname)."', carphoto='".addslashes($orglogo)."',
                        	descr='".addslashes($orgname)."'
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "edit":
			$mode = "edit";
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orglogo = "";
		$orgdescr = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $THIS_TABLE m1 WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->carmodel);
				$orgurl = stripslashes($row->url);
				$orglogo = stripslashes($row->carphoto);
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
	<input type="hidden" name="id" value="<?=$id;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <tr><td class="ff">Название модели:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
     <tr><td class="ff">Url модели:</td><td class="fr"><input type="text" size="70" name="orgurl" value="<?=$orgurl;?>" /></td></tr>
    <?php
    /*
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea name="orgdescr" cols="60" rows="15"><?=$orgdescr;?></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
<?php
	*/
?>
	<tr><td class="ff">Фото с моделью авто:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>

	<br />
	<h3>Привязаные товары</h3>
<?php
		$its = Array();
		$query = "SELECT i2m.id as i2m_id, i1.id, i1.model, m2.make_name
			FROM $TABLE_CAR_MODELITEMS i2m
			INNER JOIN $TABLE_CAT_ITEMS i1 ON i2m.item_id=i1.id
			INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
			INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
			WHERE i2m.model_id='".$item_id."'
			ORDER BY m2.make_name, i1.model";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$it = Array();
				$it['id'] = $row->id;
				$it['model'] = stripslashes($row->model);
				$it['make'] = stripslashes($row->make_name);
				$its[] = $it;
			}
			mysqli_free_result( $res );
		}
		else
			echo mysqli_error($upd_link_db);

		echo '<table cellpadding="2" cellspacing="0" align="center">';
		for($i=0; $i<count($its); $i++)
		{
			echo '<tr><td>'.$its[$i]['make'].'</td><td>'.$its[$i]['model'].'</td></tr>';
		}
		echo '</table>';

	}
	else
	{
		//echo "LangId = $LangId<br />";
?>
	<h3>Выбрать марку</h3>

<center>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="post" name="frm">
	<tr>
		<td class="ff">Марка авто: </td>
		<td class="fr">
			<select name="id" onchange="javascript:GoTo('car_models.php?id='+this.value);">
				<option value="0">--- Выбрать марку ---</option>
<?php
			if( $res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_CAR_BRAND ORDER BY carmake") )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					echo "<option value=\"".$row->id."\"".($id == $row->id ? " selected" : "").">".stripslashes($row->carmake)."</option>";
				}
		  		mysqli_free_result($res);
			}
?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="fr" align="center"><input type="submit" value="Выбрать"></td>
	</tr>
	</form>
	</table>
	</td></tr>
	</table>
</center>

<?php
		if( $id != "" )
		{
?>
    <h3>Список моделей</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id" value="<?=$id;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Фото</th>
    	<th>Модель</th>
    	<th>Товаров</th>
    	<th>Описание</th>
    	<th>Функции</th>
    </tr>
    <?php
	    	$found_items = 0;
	    	$query = "SELECT m1.*, count(i2m.item_id) as prodsnum
	    		FROM $THIS_TABLE m1
	    		LEFT JOIN $TABLE_CAR_MODELITEMS i2m ON m1.id=i2m.model_id
	    		WHERE m1.brand_id=$id
	    		GROUP BY m1.id
	    		ORDER BY m1.carmodel";
	    	//echo $query."<br />";
			if( $res = mysqli_query($upd_link_db,$query) )
			{
				while($row=mysqli_fetch_object($res))
				{
	                $found_items++;

	            	echo "<tr>
	                               <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
	                               <td>".($row->carphoto != "" ? '<img src="../'.$FILE_DIR.stripslashes($row->carphoto).'" alt="" />' : '')."</td>
	                               <td style=\"padding: 1px 10px 1px 10px\">
	                                   <b>".stripslashes($row->carmodel)."</b>
	                               </td>
	                               <td style=\"text-align: center;\"> ".$row->prodsnum." </td>
	                               <td style=\"padding: 1px 10px 1px 10px\">".stripslashes($row->descr)."</td>
	                               <td align=\"center\">
	                               	<a href=\"$PHP_SELF?action=deleteitem&id=".$id."&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
	                               	<a href=\"$PHP_SELF?action=edit&id=".$id."&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
	                </tr>
	                <tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
				}
	            mysqli_free_result($res);
			}
			else
				echo mysqli_error($upd_link_db);

			if( $found_items == 0 )
			{
				echo "<tr><td colspan=\"6\" align=\"center\"><br />В базе нет брендов<br /><br /></td></tr>
				<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
	        }
	        else
	        {
	        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
	        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Новую Модель</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="id" value="<?=$id;?>">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название модели:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Url модели:</td><td class="fr"><input type="text" size="70" name="orgurl"></td></tr>
    <?php
    /*
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea name="orgdescr" cols="60" rows="15"></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	*/
	?>
	<tr><td class="ff">Фото с моделью авто:</td><td class="fr"><input type="text" size="30" name="orglogo" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>

    </form>
    	</table>
    	</td></tr>
    </table>

<?php
		}
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
