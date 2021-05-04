<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit product profiles";
   	$strings['tipdel']['en'] = "Delete this profile";
   	$strings['tipassign']['en'] = "Assign parameters to profile";

    $strings['tipedit']['ru'] = "Редактировать списки элеваторов";
   	$strings['tipdel']['ru'] = "Удалить элеватор из списка";
   	$strings['tipassign']['ru'] = "Прикрепить параметры к типу товара";

	$PAGE_HEADER['ru'] = "Редактировать списки элеваторов";
	$PAGE_HEADER['en'] = "Product Types Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TORG_ELEV;
	$THIS_TABLE_LANG = $TABLE_TORG_ELEV_LANGS;

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$obl = GetParameter("obl", 0);

	switch( $action )
	{
		case "oblsel":
			$mode = "obl";
			break;

		case "edit":
			$item_id = GetParameter("item_id", "0");

			$rayid = 0;
			$name = "";
            $orgname = "";
            $phone = "";
            $addr = "";
            $orgmail = "";
            $orgdir = "";
            $orgaddr = "";
            $holdmeth = "";
			$descr1 = "";
			$descr2 = "";
			$orglogo = "";

			if($res = mysqli_query($upd_link_db,"SELECT p1.ray_id, p1.phone, p1.email, p1.filename, p2.*
				FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
				WHERE p1.id='$item_id' AND p1.id=p2.item_id AND p2.lang_id='$LangId'"))
			{
				if($row = mysqli_fetch_object($res))
				{
					$rayid = $row->ray_id;
					$name = str_replace("\"", "&quot;", stripslashes($row->name));
		            $orgname = str_replace("\"", "&quot;", stripslashes($row->orgname));
		            $phone = stripslashes($row->phone);
		            $orgmail = stripslashes($row->email);
		            $orgdir = stripslashes($row->director);
		            $addr = str_replace("\"", "&quot;", stripslashes($row->addr));
		            $orgaddr = str_replace("\"", "&quot;", stripslashes($row->orgaddr));
		            $holdmeth = str_replace("\"", "&quot;", stripslashes($row->holdcond));
					$descr1 = stripslashes($row->descr_podr);
					$descr2 = stripslashes($row->descr_qual);
					$orglogo = stripslashes($row->filename);
				}
				mysqli_free_result($res);
			}

			$mode = "edit";
			break;

    	case "add":
    		$rayid = GetParameter("rayid", 0);
			$name = GetParameter("name", "");
            $orgname = GetParameter("orgname", "");
            $phone = GetParameter("phone", "");
            $orgmail = GetParameter("orgmail", "");
            $orgdir = GetParameter("orgdir", "");
            $addr = GetParameter("addr", "");
            $orgaddr = GetParameter("orgaddr", "");
            $holdmeth = GetParameter("holdmeth", "");
			$descr1 = GetParameter("descr1", "");
			$descr2 = GetParameter("descr2", "");
			$orglogo = GetParameter("orglogo", "");

    		$query = "INSERT INTO $THIS_TABLE ( obl_id, ray_id, phone, email, filename )
    			VALUES ( '".$obl."', '".$rayid."', '".addslashes($phone)."', '".addslashes($orgmail)."', '".addslashes($orglogo)."')";
			if(mysqli_query($upd_link_db,$query))
			{
                $newcatid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( item_id, lang_id, name, orgname, addr, orgaddr, holdcond, descr_podr, descr_qual )
	                    VALUES ('$newcatid', '".$langs[$i]."', '".addslashes($name)."', '".addslashes($orgname)."', '".addslashes($addr)."',
	                    '".addslashes($orgaddr)."', '".addslashes($holdmeth)."', '".addslashes($descr1)."', '".addslashes($descr2)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }
			}
			else
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			$mode = "obl";
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
                    if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG
                    	WHERE item_id='".$items_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
                }

    			// Here all vehicle items should be unassigned to 0 profile id
			}
			$mode = "obl";
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
            $mode = "obl";
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
			$rayid = GetParameter("rayid", 0);
			$name = GetParameter("name", "");
            $orgname = GetParameter("orgname", "");
            $phone = GetParameter("phone", "");
            $orgmail = GetParameter("orgmail", "");
            $orgdir = GetParameter("orgdir", "");
            $addr = GetParameter("addr", "");
            $orgaddr = GetParameter("orgaddr", "");
            $holdmeth = GetParameter("holdmeth", "");
			$descr1 = GetParameter("descr1", "");
			$descr2 = GetParameter("descr2", "");
			$orglogo = GetParameter("orglogo", "");

			//$orglogo = GetParameter("orglogo", "");

			$name = str_replace("&quot;", "\"", $name);
            $orgname = str_replace("&quot;", "\"", $orgname);
            $addr = str_replace("&quot;", "\"", $addr);
            $orgaddr = str_replace("&quot;", "\"", $orgaddr);
            $holdmeth = str_replace("&quot;", "\"", $holdmeth);

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET ray_id='".$rayid."', phone='".addslashes($phone)."', email='".addslashes($orgmail)."',
				filename='".addslashes($orglogo)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$query = "UPDATE $THIS_TABLE_LANG
            	SET name='".addslashes($name)."', orgname='".addslashes($orgname)."', holdcond='".addslashes($holdmeth)."',
            	addr='".addslashes($addr)."', orgaddr='".addslashes($orgaddr)."', director='".addslashes($orgdir)."',
            	descr_podr='".addslashes($descr1)."', descr_qual='".addslashes($descr2)."'
            	WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
            	echo mysqli_error($upd_link_db);
            }
            $mode = "obl";
			break;
	}


    if( $mode == "edit" )
    {
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<input type="hidden" name="obl" value="<?=$obl;?>" />
	<tr><td class="ff">Район области:</td><td class="fr">
    	<select name="rayid">
<?php
	$query = "SELECT r1.*, r2.name FROM $TABLE_RAYON r1
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE r1.obl_id='".$obl."'
		ORDER BY r2.name";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			echo '<option value="'.$row->id.'"'.($rayid == $row->id ? ' selected' : '').'>'.stripslashes($row->name).'</option>';
		}
		mysqli_free_result( $res );
	}
?>
		</select>
	</td></tr>
    <tr><td class="ff">Название элеватора:</td><td class="fr"><input type="text" size="70" name="name" value="<?=$name;?>" /></td></tr>
    <tr><td class="ff">Юридическое название:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Физический адрес:</td><td class="fr"><textarea cols="40" rows="3" name="addr"><?=$addr;?></textarea></td></tr>
    <tr><td class="ff">Юридический адрес:</td><td class="fr"><textarea cols="40" rows="3" name="orgaddr"><?=$orgaddr;?></textarea></td></tr>
    <tr><td class="ff">Телефон:</td><td class="fr"><input type="text" size="70" name="phone" value="<?=$phone;?>" /></td></tr>
    <tr><td class="ff">E-mail:</td><td class="fr"><input type="text" size="70" name="orgmail" value="<?=$orgmail;?>" /></td></tr>
    <tr><td class="ff">Директор:</td><td class="fr"><input type="text" size="70" name="orgdir" value="<?=$orgdir;?>" /></td></tr>
    <tr><td class="ff">Способ хранения:</td><td class="fr"><input type="text" size="70" name="holdmeth" value="<?=$holdmeth;?>" /></td></tr>
    <tr><td class="ff">Услуги по подработке:</td><td class="fr"><textarea cols="60" rows="5" name="descr1"><?=$descr1;?></textarea></td></tr>
    <tr><td class="ff">Услуги по опр. качества:</td><td class="fr"><textarea cols="60" rows="5" name="descr2"><?=$descr2;?></textarea></td></tr>
    <tr><td class="ff">Фото (240 х 240):</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else if( $mode == "obl" )
	{
		//echo "LangId = $LangId<br />";
?>
    <h3>Список элеваторов - <?=$REGIONS[$obl];?></h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="" method=POST>
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="obl" value="<?=$obl;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Иконка</th>
    	<th>Название</th>
    	<th>Район</th>
    	<th>Адрес</th>
    	<th>Функции</th>
    </tr>
    <?php
		$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.addr, p2.descr_podr, r1.name as rayon
			FROM $THIS_TABLE p1
			INNER JOIN $THIS_TABLE_LANG p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			LEFT JOIN $TABLE_RAYON_LANGS r1 ON p1.ray_id=r1.ray_id AND r1.lang_id='$LangId'
			WHERE p1.obl_id='$obl'
			ORDER BY p1.ray_id, p2.name") )
		{
			while($row=mysqli_fetch_object($res))
			{
				$found_items++;

				echo "<tr>
				<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
				<td>";
				if( isset($row->icon_filename) && ($row->icon_filename != "") )
				{
					echo "<img src=\"".$FILE_DIR.stripslashes($row->icon_filename)."\" alt=\"".stripslashes($row->type_name)." icon\" />";
				}
				echo "</td>
				<td style=\"padding: 1px 10px 1px 10px\"><b>".stripslashes($row->name)."</b></td>
				<td style=\"padding: 1px 10px 1px 10px\">".( $row->rayon != null ? stripslashes($row->rayon) : "" )."</td>
				<td style=\"padding: 1px 10px 1px 10px\">".stripslashes($row->addr)."</td>
				<td align=\"center\">
					<a onclick='return confirm(\"Вы действительно хотите удалить этот элеватор из базы?\")' href=\"$PHP_SELF?action=deleteitem&obl=".$obl."&item_id=".$row->id."\" title=\"".$strings['tipdel'][$lang]."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
					<a href=\"$PHP_SELF?action=edit&obl=".$obl."&item_id=".$row->id."\" title=\"".$strings['tipedit'][$lang]."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
				</td>
				</tr>
				<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
			mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"6\" align=\"center\"><br />В базе нет элеваторов в выбранном районе<br /><br /></td></tr>
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
    <h3>Добавить Новый Элеватор</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="obl" value="<?=$obl;?>">
    <tr><td class="ff">Район области:</td><td class="fr">
    	<select name="rayid">
<?php
	$query = "SELECT r1.*, r2.name FROM $TABLE_RAYON r1
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		WHERE r1.obl_id='".$obl."'
		ORDER BY r2.name";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			echo '<option value="'.$row->id.'">'.stripslashes($row->name).'</option>';
		}
		mysqli_free_result( $res );
	}
?>
		</select>
	</td></tr>
    <tr><td class="ff">Название элеватора:</td><td class="fr"><input type="text" size="70" name="name" /></td></tr>
    <tr><td class="ff">Юридическое название:</td><td class="fr"><input type="text" size="70" name="orgname" /></td></tr>
    <tr><td class="ff">Физический адрес:</td><td class="fr"><textarea cols="40" rows="3" name="addr"></textarea></td></tr>
    <tr><td class="ff">Юридический адрес:</td><td class="fr"><textarea cols="40" rows="3" name="orgaddr"></textarea></td></tr>
    <tr><td class="ff">Телефон:</td><td class="fr"><input type="text" size="70" name="phone" /></td></tr>
    <tr><td class="ff">E-mail:</td><td class="fr"><input type="text" size="70" name="orgmail" /></td></tr>
    <tr><td class="ff">Директор:</td><td class="fr"><input type="text" size="70" name="orgdir" /></td></tr>
    <tr><td class="ff">Способ хранения:</td><td class="fr"><input type="text" size="70" name="holdmeth" /></td></tr>
    <tr><td class="ff">Услуги по подработке:</td><td class="fr"><textarea cols="60" rows="5" name="descr1"></textarea></td></tr>
    <tr><td class="ff">Услуги по опр. качества:</td><td class="fr"><textarea cols="60" rows="5" name="descr2"></textarea></td></tr>
    <tr><td class="ff">Фото (240 х 240):</td><td class="fr"><input type="text" size="30" name="orglogo" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>

<?php
    }
    else
    {
?>
	<h3>Выбрать область</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <tr>
    
    	<th>Название типа</th>
    	<th>Элеваторов</th>
    	<th>Функции</th>
    </tr>
<?php
	for( $i=1; $i<count($REGIONS); $i++ )
	{
		$elev_num = 0;
		$query = "SELECT count(*) as totelev FROM $TABLE_TORG_ELEV WHERE obl_id='".$i."'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$elev_num = $row->totelev;
			}
			mysqli_free_result( $res );
		}
		$stl = 'style = "border-bottom: 1px dotted black;"';
		echo '<tr>
		
			<td '.$stl.'>'.$REGIONS[$i].'</td>
			<td align="center" '.$stl.'>'.$elev_num.'</td>
			<td align="center" >
				<a href="'.$PHP_SELF.'?action=oblsel&obl='.$i.'">Перейти к элеваторам</a>
			</td>
		</tr>
		';
	}
?>
	<tr>
	<td colspan ="3" align = "center">
	<a href = "/install/make_produrls.php">Активировать добавленный элеватор</a>
	</td>
	</tr>
    </table>
<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
