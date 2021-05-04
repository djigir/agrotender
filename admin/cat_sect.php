<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";
    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    include "../inc/utils-inc.php";
    include "../inc/catutils-inc.php";
    include "inc/admin_catutils-inc.php";

	$strings['tipedit']['en'] = "Edit This Section Name";
   	$strings['tipdel']['en'] = "Delete This Section";

	$strings['tipedit']['ru'] = "Редактировать разделы каталога";
   	$strings['tipdel']['ru'] = "Удалить раздел";

	$PAGE_HEADER['ru'] = "Список Разделов Каталога";
	$PAGE_HEADER['en'] = "Work's Catalog Sections";

	$THIS_TABLE = $TABLE_CAT_CATALOG;
	$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
	$THIS_TABLE_FILES = $TABLE_CAT_CATALOG_PICS;
	$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;

	// Include Top Header HTML Style
	include "inc/header-inc.php";


	$glist = Array();
	$query = "SELECT * FROM $TABLE_CAT_SECTGROUPS ORDER BY sort_num";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$gli = Array();
			$gli['id'] = $row->id;
			$gli['name'] = stripslashes($row->title);

			$glist[] = $gli;
		}
		mysqli_free_result( $res );
	}


	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	switch( $action )
	{
    	case "add":
			$orgsect = GetParameter("orgsect", 0);
			$orgname = GetParameter("orgname", "");
			$orgdescr = GetParameter("orgdescr", "", false);
			$orgdescr0 = GetParameter("orgdescr0", "", false);
			$orgsort = GetParameter("orgsort", 0);
			$myfile = GetParameter("myfile", "");
			$orgvis = GetParameter("orgvis", 0);
			$orggroup = GetParameter("orggroup", 0);
			$orglayout = GetParameter("orglayout", 0);
			$orgslayout = GetParameter("orgslayout", 0);
			$page_url = GetParameter("page_url", "");
			$orgfirst = GetParameter("orgfirst", 0);

			$orgmakefilt = GetParameter("orgmakefilt", 0);
			//$page_title = GetParameter("page_title", "");
			//$page_key = GetParameter("page_key", "");
			//$page_descr = GetParameter("page_descr", "");

			//if($page_url==""){
			//	$page_url=trim($orgname);
			//	$page_url=TranslitEncode($page_url);
			//	$page_url=strtolower($page_url);
			//}else{
			//	$page_url=trim($page_url);
			//	$page_url=TranslitEncode($page_url);
			//	$page_url=strtolower($page_url);
			//}

			$query = "INSERT INTO $THIS_TABLE ( parent_id, sort_num, visible, filename, product_layout, section_layout, url, menu_group_id,
				make_filter, show_first )
				VALUES ('$orgsect', '".$orgsort."', '$orgvis', '".addslashes($myfile)."', '".$orglayout."', '".$orgslayout."',
				'".$page_url."', '".$orggroup."', '$orgmakefilt', '$orgfirst')";
			if( mysqli_query($upd_link_db,$query) )
			{
				$newsectid = mysqli_insert_id($upd_link_db);

				for( $i=0; $i<count($langs); $i++ )
				{
					if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( sect_id, lang_id, name, descr, descr0 ) VALUES
						('$newsectid', '".$langs[$i]."', '".addslashes($orgname)."','".addslashes($orgdescr)."', '".addslashes($orgdescr0)."')" ) )
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
					if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE sect_id='".$items_id[$i]."'" ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");

			DeletAllSub($item_id, 0 ,'section');

			/*
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		else
    		{
    			if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE sect_id='".$item_id."'" ) )
                {
                	echo mysqli_error($upd_link_db);
                }
    		}
			*/
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
			$orgsect = GetParameter("orgsect", 0);
			$orgname = GetParameter("orgname", "");
			$orgdescr = GetParameter("orgdescr", "", false);
			$orgdescr0 = GetParameter("orgdescr0", "", false);
			$orgsort = GetParameter("orgsort", 0);
			$myfile = GetParameter("myfile", "");
			$orgvis = GetParameter("orgvis", 0);
			$orggroup = GetParameter("orggroup", 0);
			$orglayout = GetParameter("orglayout", 0);
			$orgslayout = GetParameter("orgslayout", 0);
			$page_url = GetParameter("page_url","");
			$orgfirst = GetParameter("orgfirst", 0);

			$orgmakefilt = GetParameter("orgmakefilt", 0);
			//$page_title = GetParameter("page_title","");
			//$page_key = GetParameter("page_key","");
			//$page_descr = GetParameter("page_descr","");
			//if($page_url==""){
			//	$page_url=trim($orgname);
			//	$page_url=TranslitEncode($page_url);
			//	$page_url=strtolower($page_url);
			//}else{
			//	$page_url=trim($page_url);
			//	$page_url=TranslitEncode($page_url);
			//	$page_url=strtolower($page_url);
			//}
			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET parent_id='$orgsect', sort_num='$orgsort', filename='".addslashes($myfile)."', product_layout='".$orglayout."',
                        section_layout='".$orgslayout."', visible='".$orgvis."', url='".addslashes($page_url)."', menu_group_id='".$orggroup."',
                        make_filter='$orgmakefilt', show_first='$orgfirst'
                        WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			else
			{
    			if( !mysqli_query($upd_link_db,"UPDATE $THIS_TABLE_LANG SET name='".addslashes($orgname)."',
    				descr='".addslashes($orgdescr)."', descr0='".addslashes($orgdescr0)."'
            		WHERE sect_id='".$item_id."' AND lang_id='".$LangId."'" ) )
	            {
	            	echo mysqli_error($upd_link_db);
	            }
			}
			break;

		case "list":
			$item_id = GetParameter("item_id", 0);
			$mode = "showproducts";
			break;

		case "deleteprods":
   			$prodids = GetParameter("prodids", null);
			$item_id = GetParameter("item_id", 0);
			$mode = "showproducts";
			for($i=0; $i<count($prodids); $i++)
			{
    			if( !mysqli_query($upd_link_db,"DELETE FROM $TABLE_CAT_CATITEMS WHERE id='".$prodids[$i]."'") )
    			{
    				echo mysqli_error($upd_link_db);
    			}
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", 0);
		$orgsect = 0;
		$orgname = "";
		$orgdescr = "";
		$orgdescr0 = "";
		$orgsort = 0;
		$myfile = "";
		$orgvis = 0;
		$orggroup = 0;
		$orglayout = 0;
		$orgslayout = 0;
		$page_url = "";
		$orgfirst = 0;

		$orgmakefilt = 0;
		//$page_title = "";
		//$page_key = "";
		//$page_descr = "";

		if($res = mysqli_query($upd_link_db,"SELECT s1.*, s2.*
				FROM $THIS_TABLE s1, $THIS_TABLE_LANG s2
				WHERE s1.id='$item_id' AND s1.id=s2.sect_id AND s2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgsect = $row->parent_id;
				$orgname = stripslashes($row->name);
				$orgdescr = stripslashes($row->descr);
				$orgdescr0 = stripslashes($row->descr0);
				$page_url = stripslashes($row->url);
				//$page_title = stripslashes($row->page_title);
				//$page_key = stripslashes($row->page_keywords);
				//$page_descr = stripslashes($row->page_descr);
				$orgsort = $row->sort_num;
				$orggroup = $row->menu_group_id;
				$myfile = stripslashes($row->filename);
				$orglayout = $row->product_layout;
				$orgslayout = $row->section_layout;
				$orgvis = $row->visible;
				$orgfirst = $row->show_first;

				$orgmakefilt = $row->make_filter;
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
    	<td class="ff">Родительский раздел:</td>
    	<td class="fr">
    		<select name="orgsect">
    			<option value="0" selected>--- Корневой раздел ---</option>
<?php
			PrintWorkCatalog(0, $LangId, 1, "select", $orgsect);
?>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">В группе (только для 2го уровня):</td>
    	<td class="fr">
    		<select name="orggroup">
    			<option value="0">----- Без группы -----</option>
<?php
	for( $i=0; $i<count($glist); $i++ )
	{
		echo '<option value="'.$glist[$i]['id'].'"'.($orggroup == $glist[$i]['id'] ? " selected" : "").'>'.$glist[$i]['name'].'</option>';
	}
?>
    		<select>
    	</td>
    </tr>
	<tr><td class="ff">Название раздела:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
	<tr><td class="ff">Url:</td><td class="fr"><input type="text" size="70" name="page_url" value="<?=$page_url;?>" /></td></tr>
<?php
/*
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title" value="<?=$page_title;?>" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="page_key"><?=$page_key;?></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="page_descr"><?=$page_descr;?></textarea></td></tr>
*/
?>
	<tr><td class="ff">Описание:</td><td class="fr"><textarea rows="15" cols="65" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	<tr><td class="ff">Доп. текст:</td><td class="fr"><textarea rows="7" cols="65" name="orgdescr0"><?=$orgdescr0;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr0'); // field, width, height
</script>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="30" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
	<tr>
    	<td class="ff">Показывать на сайте:</td>
    	<td class="fr">
    		<select name="orgvis">
    			<option value="0"<?=($orgvis == 0 ? ' selected="selected"' : '');?>>НЕТ</option>
    			<option value="1"<?=($orgvis == 1 ? ' selected="selected"' : '');?>>ДА</option>
    		<select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">Показывать на главной:</td>
    	<td class="fr">
    		<select name="orgfirst">
    			<option value="0"<?=($orgfirst == 0 ? ' selected="selected"' : '');?>>НЕТ</option>
    			<option value="1"<?=($orgfirst == 1 ? ' selected="selected"' : '');?>>ДА</option>
    		<select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">Показывать бренд в фильтре:</td>
    	<td class="fr">
    		<select name="orgmakefilt">
    			<option value="0"<?=($orgmakefilt == 0 ? ' selected="selected"' : '');?>>НЕТ</option>
    			<option value="1"<?=($orgmakefilt == 1 ? ' selected="selected"' : '');?>>ДА</option>
    		<select>
    	</td>
    </tr>
<?php
/*
	<tr>
    	<td class="ff">Тип вывода подсекций:</td>
    	<td class="fr">
    		<select name="orgslayout">
    			<option value="0" <?=($orgslayout == 0 ? " selected" : "");?>>Картинка слева</option>
    			<option value="1" <?=($orgslayout == 1 ? " selected" : "");?>>Картинка сверху</option>
    		<select>
    	</td>
    </tr>
	<tr>
    	<td class="ff">Тип вывода товаров:</td>
    	<td class="fr">
    		<select name="orglayout">
    			<option value="0" <?=($orglayout == 0 ? " selected" : "");?>>Иконками</option>
    			<option value="1" <?=($orglayout == 1 ? " selected" : "");?>>Таблицeй</option>
    			<option value="2" <?=($orglayout == 2 ? " selected" : "");?>>Иконки с описанием</option>
    		<select>
    	</td>
    </tr>
*/
?>
	<tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px" value="<?=$myfile;?>"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
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
    <h3>Каталог разделов</h3>
    <table align="center" width="60%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="deleteprods" />
<?php
	if( $mode == "showproducts" )
	{
		echo '<input type="hidden" name="item_id" value="'.$item_id.'" />';
  		PrintWorkCatalog(0, $LangId, 0, "products", $item_id);

  		echo "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"delprodbut\" value=\" Удалить отмеченные из раздела \" /></td></tr>";
	}
	else
	{
		PrintWorkCatalog(0, $LangId, 0);
	}
?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить секцию</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST" >
    <input type="hidden" name="action" value="add">
    <tr>
    	<td class="ff">Раздел в который добавлять:</td>
    	<td class="fr">
    		<select name="orgsect">
    			<option value="0" selected>--- Корневой раздел ---</option>
<?php
			PrintWorkCatalog(0, $LangId, 1, "select");
?>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">В группе (только для 2го уровня):</td>
    	<td class="fr">
    		<select name="orggroup">
    			<option value="0">----- Без группы -----</option>
<?php
	for( $i=0; $i<count($glist); $i++ )
	{
		echo '<option value="'.$glist[$i]['id'].'"'.($orggroup == $glist[$i]['id'] ? " selected" : "").'>'.$glist[$i]['name'].'</option>';
	}
?>
    		<select>
    	</td>
    </tr>
	<tr><td class="ff">Название нового раздела:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
	<tr><td class="ff">Url:</td><td class="fr"><input type="text" size="70" name="page_url" value="" /></td></tr>
<?php
/*
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title" value="" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="page_key"></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="page_descr"></textarea></td></tr>
*/
?>
	<tr><td class="ff">Описание:</td><td class="fr"><textarea rows="15" cols="65" name="orgdescr"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	<tr><td class="ff">Доп. текст:</td><td class="fr"><textarea rows="7" cols="65" name="orgdescr0"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr0'); // field, width, height
</script>
    <tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="30" name="orgsort"></td></tr>
    <tr>
    	<td class="ff">Показывать на сайте:</td>
    	<td class="fr">
    		<select name="orgvis">
    			<option value="0">НЕТ</option>
    			<option value="1" selected="selected">ДА</option>
    		<select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">Показывать на главной:</td>
    	<td class="fr">
    		<select name="orgfirst">
    			<option value="0">НЕТ</option>
    			<option value="1">ДА</option>
    		<select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">Показывать бренд в фильтре:</td>
    	<td class="fr">
    		<select name="orgmakefilt">
    			<option value="0" selected="selected">НЕТ</option>
    			<option value="1">ДА</option>
    		<select>
    	</td>
    </tr>
<?php
/*
    <tr>
    	<td class="ff">Тип вывода подсекций:</td>
    	<td class="fr">
    		<select name="orgslayout">
    			<option value="0">Картинка слева</option>
    			<option value="1">Картинка сверху</option>
    		<select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">Тип вывода товаров:</td>
    	<td class="fr">
    		<select name="orglayout">
    			<option value="0">Иконками</option>
    			<option value="1">Таблицeй</option>
    			<option value="2">Иконки с описанием</option>
    		<select>
    	</td>
    </tr>
*/
?>
    <tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
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
