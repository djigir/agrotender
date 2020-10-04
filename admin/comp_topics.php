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

    include "../inc/utils-inc.php";
    include "../inc/torgutils-inc.php";
    //include "inc/admin_catutils-inc.php";

	$strings['tipedit']['en'] = "Edit This Section Name";
   	$strings['tipdel']['en'] = "Delete This Section";

	$strings['tipedit']['ru'] = "Редактировать разделы рубрикатора компаний";
   	$strings['tipdel']['ru'] = "Удалить раздел";

	$PAGE_HEADER['ru'] = "Список тем для Рубрикатора компаний";
	$PAGE_HEADER['en'] = "Work's Catalog Sections";

	$THIS_TABLE = $TABLE_COMPANY_TOPIC;
	//$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$gmlist = Array();
	$query = "SELECT * FROM $TABLE_COMPANY_TGROUPS ORDER BY sort_num";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$gli = Array();
			$gli['id'] = $row->id;
			$gli['name'] = stripslashes($row->title);

			$gmlist[] = $gli;
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
			//$orgdescr0 = GetParameter("orgdescr0", "", false);
			$orgsort = GetParameter("orgsort", 0);
			//$myfile = GetParameter("myfile", "");
			//$orgvis = GetParameter("orgvis", 0);
			$orggroup = GetParameter("orggroup", 0);
			//$orglayout = GetParameter("orglayout", 0);
			//$orgslayout = GetParameter("orgslayout", 0);
			//$page_url = GetParameter("page_url", "");
			//$orgfirst = GetParameter("orgfirst", 0);

			$query = "INSERT INTO $THIS_TABLE ( parent_id, menu_group_id, sort_num, add_date, title, descr )
				VALUES ('$orgsect', '$orggroup', '".$orgsort."',  NOW(), '".addslashes($orgname)."','".addslashes($orgdescr)."')";
			if( mysqli_query($upd_link_db,$query) )
			{
				$newsectid = mysqli_insert_id();
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

			//DeletAllSub($item_id, 0 ,'section');

			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
			$orgsect = GetParameter("orgsect", 0);
			$orgname = GetParameter("orgname", "");
			$orgdescr = GetParameter("orgdescr", "", false);
			//$orgdescr0 = GetParameter("orgdescr0", "", false);
			$orgsort = GetParameter("orgsort", 0);
			//$myfile = GetParameter("myfile", "");
			//$orgvis = GetParameter("orgvis", 0);
			$orggroup = GetParameter("orggroup", 0);
			//$orglayout = GetParameter("orglayout", 0);
			//$orgslayout = GetParameter("orgslayout", 0);
			//$page_url = GetParameter("page_url","");
			//$orgfirst = GetParameter("orgfirst", 0);
			$page_title = GetParameter("page_title", "");
			$page_key = GetParameter("page_key", "");
			$page_descr = GetParameter("page_descr", "");
			$page_h1 = GetParameter("page_h1", "");

			//$page_title_b = GetParameter("page_title_b", "");
			//$page_key_b = GetParameter("page_key_b", "");
			//$page_descr_b = GetParameter("page_descr_b", "");
			//$page_h1_b = GetParameter("page_h1_b", "");
			//$orgdescr_b = GetParameter("orgdescr_b", "", false);

			//$page_title_s = GetParameter("page_title_s", "");
			//$page_key_s = GetParameter("page_key_s", "");
			//$page_descr_s = GetParameter("page_descr_s", "");
			//$page_h1_s = GetParameter("page_h1_s", "");
			//$orgdescr_s = GetParameter("orgdescr_s", "", false);

			//$orgmakefilt = GetParameter("orgmakefilt", 0);
			/*
			$query = "UPDATE $THIS_TABLE
                        SET parent_id='$orgsect', menu_group_id='$orggroup', sort_num='$orgsort', title='".addslashes($orgname)."', descr='".addslashes($orgdescr)."',
                        page_h1='".addslashes($page_h1)."',
                        page_title='".addslashes($page_title)."', page_keywords='".addslashes($page_key)."', page_descr='".addslashes($page_descr)."',
                        seo_h1_buy='".addslashes($page_h1_b)."', seo_title_buy='".addslashes($page_title_b)."', seo_keyw_buy='".addslashes($page_key_b)."',
                        seo_descr_buy='".addslashes($page_descr_b)."', seo_text_buy='".addslashes($orgdescr_b)."',
                        seo_h1_sell='".addslashes($page_h1_s)."', seo_title_sell='".addslashes($page_title_s)."', seo_keyw_sell='".addslashes($page_key_s)."',
                        seo_descr_sell='".addslashes($page_descr_s)."', seo_text_sell='".addslashes($orgdescr_s)."'
                        WHERE id='".$item_id."'";
   			*/
   			$query = "UPDATE $THIS_TABLE
                        SET parent_id='$orgsect', menu_group_id='$orggroup', sort_num='$orgsort', title='".addslashes($orgname)."', descr='".addslashes($orgdescr)."',
                        page_h1='".addslashes($page_h1)."',
                        page_title='".addslashes($page_title)."', page_keywords='".addslashes($page_key)."', page_descr='".addslashes($page_descr)."'
                        WHERE id='".$item_id."'";
   			//echo $query;
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "list":
			$item_id = GetParameter("item_id", 0);
			$mode = "showproducts";
			break;
	}

	$glist0 = Array();
	$query = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id=0 ORDER BY sort_num";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$gli = Array();
			$gli['id'] = $row->id;
			$gli['name'] = stripslashes($row->title);

			$tits = Array();
			$query1 = "SELECT * FROM $TABLE_COMPANY_TOPIC WHERE parent_id='".$row->id."' ORDER BY sort_num";
			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					$ti = Array();
					$ti['id'] = $row1->id;
					$ti['name'] = stripslashes($row1->title);

					$tits[] = $ti;
				}
				mysqli_free_result( $res1 );
			}

			$gli['sub'] = $tits;

			$glist0[] = $gli;
		}
		mysqli_free_result( $res );
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

		//$orgmakefilt = 0;
		$page_h1 = "";
		$page_title = "";
		$page_key = "";
		$page_descr = "";

		$page_h1_b = "";
		$page_title_b = "";
		$page_key_b = "";
		$page_descr_b = "";
		$orgdescr_b = "";

		$page_h1_s = "";
		$page_title_s = "";
		$page_key_s = "";
		$page_descr_s = "";
		$orgdescr_s = "";

		if($res = mysqli_query($upd_link_db,"SELECT s1.* FROM $THIS_TABLE s1 WHERE s1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgsect = $row->parent_id;
				$orgname = stripslashes($row->title);
				$orgdescr = stripslashes($row->descr);
				//$orgdescr0 = stripslashes($row->descr0);
				//$page_url = stripslashes($row->url);

				$page_h1 = stripslashes($row->page_h1);
				$page_title = stripslashes($row->page_title);
				$page_key = stripslashes($row->page_keywords);
				$page_descr = stripslashes($row->page_descr);

				/*
				$page_h1_b = stripslashes($row->seo_h1_buy);
				$page_title_b = stripslashes($row->seo_title_buy);
				$page_key_b = stripslashes($row->seo_keyw_buy);
				$page_descr_b = stripslashes($row->seo_descr_buy);
				$orgdescr_b = stripslashes($row->seo_text_buy);

				$defseo = Comp_DefTitles( $LangId, 1, $orgname );
				$page_h1_b = ( trim($page_h1_b) == "" ? $defseo['h1'] : $page_h1_b );
				$page_title_b = ( trim($page_title_b) == "" ? $defseo['title'] : $page_title_b );
				$page_key_b = ( trim($page_key_b) == "" ? $defseo['keyw'] : $page_key_b );
				$page_descr_b = ( trim($page_descr_b) == "" ? $defseo['descr'] : $page_descr_b );
				$orgdescr_b = ( trim($orgdescr_b) == "" ? $defseo['txt'] : $orgdescr_b );

				$page_h1_s = stripslashes($row->seo_h1_sell);
				$page_title_s = stripslashes($row->seo_title_sell);
				$page_key_s = stripslashes($row->seo_keyw_sell);
				$page_descr_s = stripslashes($row->seo_descr_sell);
				$orgdescr_s = stripslashes($row->seo_text_sell);

				$defseo = Comp_DefTitles( $LangId, 2, $orgname );
				$page_h1_s = ( trim($page_h1_s) == "" ? $defseo['h1'] : $page_h1_s );
				$page_title_s = ( trim($page_title_s) == "" ? $defseo['title'] : $page_title_s );
				$page_key_s = ( trim($page_key_s) == "" ? $defseo['keyw'] : $page_key_s );
				$page_descr_s = ( trim($page_descr_s) == "" ? $defseo['descr'] : $page_descr_s );
				$orgdescr_s = ( trim($orgdescr_s) == "" ? $defseo['txt'] : $orgdescr_s );
				*/

				$orgsort = $row->sort_num;
				$orggroup = $row->menu_group_id;
				//$myfile = stripslashes($row->filename);
				//$orglayout = $row->product_layout;
				//$orgslayout = $row->section_layout;
				//$orgvis = $row->visible;
				//$orgfirst = $row->show_first;
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
	for( $i=0; $i<count($glist0); $i++ )
	{
		echo '<option value="'.$glist0[$i]['id'].'"'.($orgsect == $glist0[$i]['id'] ? " selected" : "").'>'.$glist0[$i]['name'].'</option>';

		$sub = $glist0[$i]['sub'];
		for( $j=0; $j<count($sub); $j++ )
		{
			echo '<option value="'.$sub[$j]['id'].'"'.($orgsect == $sub[$j]['id'] ? " selected" : "").'>&nbsp;&nbsp;&nbsp;&nbsp;'.$sub[$j]['name'].'</option>';
		}
	}
?>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">В группе (только для 1го уровня):</td>
    	<td class="fr">
    		<select name="orggroup">
    			<option value="0">----- Без группы -----</option>
<?php
	for( $i=0; $i<count($gmlist); $i++ )
	{
		echo '<option value="'.$gmlist[$i]['id'].'"'.($orggroup == $gmlist[$i]['id'] ? " selected" : "").'>'.$gmlist[$i]['name'].'</option>';
	}
?>
    		<select>
    	</td>
    </tr>
	<tr><td class="ff">Название рубрики:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
<?php
/*
	<tr><td class="ff">Url:</td><td class="fr"><input type="text" size="70" name="page_url" value="<?=$page_url;?>" /></td></tr>
*/
?>
	<tr><td colspan="2" style="font-weight: bold; padding: 8px 10px 3px 10px;">Seo данные</td></tr>
	<tr><td class="ff">H1 заголовок:</td><td class="fr"><input type="text" size="70" name="page_h1" value="<?=$page_h1;?>" /></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title" value="<?=$page_title;?>" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="page_key"><?=$page_key;?></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="page_descr"><?=$page_descr;?></textarea></td></tr>
	<tr><td class="ff">Описание:</td><td class="fr"><textarea class="ckeditor" rows="15" cols="65" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
<?php
/*
	<tr><td class="ff">Доп. текст:</td><td class="fr"><textarea rows="7" cols="65" name="orgdescr0"><?=$orgdescr0;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr0'); // field, width, height
</script>
*/

	/*
?>
	<tr><td colspan="2" style="font-weight: bold; padding: 8px 10px 3px 10px;">Seo данные - Покупка</td></tr>
	<tr><td class="ff">H1 заголовок:</td><td class="fr"><input type="text" size="70" name="page_h1_b" value="<?=$page_h1_b;?>" /></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title_b" value="<?=$page_title_b;?>" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="page_key_b"><?=$page_key_b;?></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="page_descr_b"><?=$page_descr_b;?></textarea></td></tr>
	<tr><td class="ff">Описание:</td><td class="fr"><textarea rows="15" cols="65" name="orgdescr_b"><?=$orgdescr_b;?></textarea></td></tr>
	<tr><td colspan="2" style="font-weight: bold; padding: 8px 10px 3px 10px;">Seo данные - Продажа</td></tr>
	<tr><td class="ff">H1 заголовок:</td><td class="fr"><input type="text" size="70" name="page_h1_s" value="<?=$page_h1_s;?>" /></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title_s" value="<?=$page_title_s;?>" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="page_key_s"><?=$page_key_s;?></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="page_descr_s"><?=$page_descr_s;?></textarea></td></tr>
	<tr><td class="ff">Описание:</td><td class="fr"><textarea rows="15" cols="65" name="orgdescr_s"><?=$orgdescr_s;?></textarea></td></tr>
	*/
?>
	<tr><td colspan="2" style="font-weight: bold; padding: 8px 10px 3px 10px;">Другие параметры</td></tr>
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
<?php
/*
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
    <tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px" value="<?=$myfile;?>"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
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
?>
    <h3>Каталог рубрик</h3>
    <table align="center" width="60%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="deleteprods" />
<?php
	//if( $mode == "showproducts" )
	//{
	//	echo '<input type="hidden" name="item_id" value="'.$item_id.'" />';
  	//	PrintWorkCatalog(0, $LangId, 0, "products", $item_id);
    //
  	//	echo "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"delprodbut\" value=\" Удалить отмеченные из раздела \" /></td></tr>";
	//}
	//else
	//{
	//	PrintWorkCatalog(0, $LangId, 0);
	//}

	$topgr = Comp_TopicGroups( $LangId, 0 );
	for( $gi=0; $gi<count($topgr); $gi++ )
	{
		echo '<tr>
			<td colspan="2" style="font-size: 16px; font-weight: bold; background: #f0f0f0;">'.$topgr[$gi]['name'].'</td>
		</td>';
		$glist = Comp_TopicLevel( $LangId, 0, "", $topgr[$gi]['id'] );

		for( $i=0; $i<count($glist); $i++ )
		{
			echo "<tr>
				<td style=\"padding: 1px 10px 1px 30px\">".$glist[$i]['name']." (0)</td>
				<td>
					<a onclick='return confirm(\"При удаление вся информация связанная с разделом &lt;".$glist[$i]['name']."&gt; будет удалена.\\r\\nУдалить ".$glist[$i]['name']."?\")' href=\"$PHP_SELF?action=deleteitem&item_id=".$glist[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a>&nbsp;
					<a href=\"$PHP_SELF?item_id=".$glist[$i]['id']."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a>&nbsp;
				</td></tr>";

			//$sub = $glist[$i]['sub'];
			$sub = Comp_TopicLevel( $LangId, $glist[$i]['id'], "", 0 );
			for( $j=0; $j<count($sub); $j++ )
			{
				//echo '<option value="'.$sub[$j]['id'].'"'.($orggroup == $sub[$j]['id'] ? " selected" : "").'>&nbsp;&nbsp;&nbsp;&nbsp;'.$sub[$j]['name'].'</option>';

				echo "<tr>
				<td style=\"padding: 1px 10px 1px 60px\">".$sub[$j]['name']." (0)</td>
				<td>
					<a onclick='return confirm(\"При удаление вся информация связанная с разделом &lt;".$sub[$j]['name']."&gt; будет удалена.\\r\\nУдалить ".$sub[$j]['name']."?\")' href=\"$PHP_SELF?action=deleteitem&item_id=".$sub[$j]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a>&nbsp;
					<a href=\"$PHP_SELF?item_id=".$sub[$j]['id']."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a>&nbsp;
				</td></tr>";
			}
		}
	}
?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить рубрику</h3>
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
	for( $i=0; $i<count($glist0); $i++ )
	{
		echo '<option value="'.$glist0[$i]['id'].'"'.($orgsect == $glist0[$i]['id'] ? " selected" : "").'>'.$glist0[$i]['name'].'</option>';

		$sub = $glist0[$i]['sub'];
		for( $j=0; $j<count($sub); $j++ )
		{
			echo '<option value="'.$sub[$j]['id'].'"'.($orgsect == $sub[$j]['id'] ? " selected" : "").'>&nbsp;&nbsp;&nbsp;&nbsp;'.$sub[$j]['name'].'</option>';
		}
	}
?>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td class="ff">В группе (только для 1го уровня):</td>
    	<td class="fr">
    		<select name="orggroup">
    			<option value="0">----- Без группы -----</option>
<?php
	for( $i=0; $i<count($gmlist); $i++ )
	{
		echo '<option value="'.$gmlist[$i]['id'].'"'.($orggroup == $gmlist[$i]['id'] ? " selected" : "").'>'.$gmlist[$i]['name'].'</option>';
	}
?>
    		<select>
    	</td>
    </tr>
	<tr><td class="ff">Название новой рубрики:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
<?php
/*
	<tr><td class="ff">Url:</td><td class="fr"><input type="text" size="70" name="page_url" value="" /></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="page_title" value="" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="page_key"></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="page_descr"></textarea></td></tr>
*/
?>
	<tr><td class="ff">Описание:</td><td class="fr"><textarea class="ckeditor" rows="15" cols="65" name="orgdescr"></textarea></td></tr>
<?php
/*
	<tr><td class="ff">Доп. текст:</td><td class="fr"><textarea rows="7" cols="65" name="orgdescr0"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('orgdescr0'); // field, width, height
</script>
*/
?>
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
<?php
/*
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
    <tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
*/
?>
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
