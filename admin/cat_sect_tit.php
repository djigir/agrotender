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

	////////////////////////////////////////////////////////////////////////////
	//

	//$sortby_arrind = Array("bymodel" => 0, "bypup" => 1, "bypdown" => 2, "byrate" => 3);
	// Тут надо подкорректировать режимы, которые поддерживаются в каталоге
	$sortby_arr = Array(0 => "По названию", 1 => "По цене", 2 => "По рейтингу");

	$sortby_arr2[0]['id'] = 0;
	$sortby_arr2[0]['name'] = "По названию";
	$sortby_arr2[1]['id'] = 1;
	$sortby_arr2[1]['name'] = "По цене";
	$sortby_arr2[2]['id'] = 2;
	$sortby_arr2[2]['name'] = "По рейтингу";

	$strings['tipedit']['en'] = "Edit This Section Name";
	$strings['tipdel']['en'] = "Delete This Section";

	$strings['tipedit']['ru'] = "Редактировать тайтлы";
	$strings['tipdel']['ru'] = "Удалить раздел";

	$PAGE_HEADER['ru'] = "Редактировать тайтлы";
	$PAGE_HEADER['en'] = "Work's Catalog Sections";

	$THIS_TABLE = $TABLE_CAT_CATALOG;
	$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
	$THIS_TABLE_FILES = $TABLE_CAT_CATALOG_PICS;
	$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;

	////////////////////////////////////////////////////////////////////////////
	// Include Top Header HTML Style
	include "inc/header-inc.php";


	////////////////////////////////////////////////////////////////////////////
	//
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$item_id = GetParameter("item_id", 0);
	$make_id = GetParameter("make_id", 0);

	$sort_id = GetParameter("sort_id", 0);
	$filt_id = GetParameter("filt_id", 0);
	$filt_val = GetParameter("filt_val", 0);

	switch( $action )
	{
		case "update":
			$org_id = GetParameter("org_id", "");
			$orgtitle = GetParameter("orgtitle", "");
			$orgkeyw = GetParameter("orgkeyw", "");
			$orgdescr = GetParameter("orgdescr", "");
			$orgcont = GetParameter("orgcont", "");
			$orgwords = GetParameter("orgwords", "");
			$orgtitle_items = GetParameter("orgtitle_items", "");
			$orgkeyw_items = GetParameter("orgkeyw_items", "");
			$orgdescr_items = GetParameter("orgdescr_items", "");
			$orgcont_items = GetParameter("orgcont_items", "");
			$orgwords_items = GetParameter("orgwords_items", "");

			if( $org_id != 0 )
			{
				echo "Изменения сохранены<br>";
				if(!mysqli_query($upd_link_db,"UPDATE $TABLE_CAT_CATTITLES SET
					page_title='".addslashes($orgtitle)."',
					page_keywords='".addslashes($orgkeyw)."',
					page_descr='".addslashes($orgdescr)."',
					content_text='".addslashes($orgcont)."',
					content_words='".addslashes($orgwords)."',
					tpl_items_title='".addslashes($orgtitle_items)."',
					tpl_items_keywords='".addslashes($orgkeyw_items)."',
					tpl_items_descr='".addslashes($orgdescr_items)."',
					tpl_items_text='".addslashes($orgcont_items)."',
					tpl_items_words='".addslashes($orgwords_items)."',
					modify_date=NOW()
					WHERE id='".$org_id."'"))
				{
					echo "<b>".mysqli_error($upd_link_db)."</b>";
				}
			}
			else
			{
				echo "Запись добавлена<br>";
				if( $make_id == 0 )
				{
					if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_CAT_CATTITLES (page_title, page_keywords, page_descr, content_text, content_words,
						modify_date, sect_id, make_id, add_date, lang_id,
						tpl_items_title, tpl_items_keywords, tpl_items_descr, tpl_items_text, tpl_items_words,
						sortmode_id, filter_id, filter_val)
						VALUES ('".addslashes($orgtitle)."','".addslashes($orgkeyw)."','".addslashes($orgdescr)."',
							'".addslashes($orgcont)."', '".addslashes($orgwords)."', NOW(), '".$item_id."', 0, NOW(), '$LangId',
							'".addslashes($orgtitle_items)."','".addslashes($orgkeyw_items)."','".addslashes($orgdescr_items)."',
							'".addslashes($orgcont_items)."', '".addslashes($orgwords_items)."',
							'".addslashes($sort_id)."', '".addslashes($filt_id)."', '".addslashes($filt_val)."') ") )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				else
				{
					if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_CAT_CATTITLES (page_title, page_keywords, page_descr, content_text, content_words,
						modify_date, sect_id, make_id, add_date, lang_id,
						tpl_items_title, tpl_items_keywords, tpl_items_descr, tpl_items_text, tpl_items_words,
						sortmode_id, filter_id, filter_val)
						VALUES ('".addslashes($orgtitle)."','".addslashes($orgkeyw)."','".addslashes($orgdescr)."',
							'".addslashes($orgcont)."', '".addslashes($orgwords)."', NOW(), '".$item_id."' , '".$make_id."', NOW(), '$LangId',
							'' ,'', '', '', '',
							'".addslashes($sort_id)."', '".addslashes($filt_id)."', '".addslashes($filt_val)."') ") )
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			break;
	}


	if( $mode == "edit" )
	{
		$orgid = 0;
		$orgname = "";
		$orgtitle = "";
		$orgkeyw = "";
		$orgdescr = "";
		$orgcont = "";
		$orgwords = "";
		$orgtitle_items = "";
		$orgkeyw_items = "";
		$orgdescr_items = "";
		$orgcont_items = "";
		$orgwords_items = "";

		$sorttit_ids = Array();

		$query = "SELECT DISTINCT sortmode_id FROM $TABLE_CAT_CATTITLES WHERE sect_id='$item_id' AND make_id='$make_id' AND lang_id='$LangId'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$sorttit_ids[] = $row->sortmode_id;
			}
			mysqli_free_result( $res );
		}


		$filters = Array();
		$query = "SELECT DISTINCT filter_id FROM $TABLE_CAT_CATTITLES
			WHERE sect_id='$item_id' AND make_id='$make_id' AND lang_id='$LangId' AND filter_id<>0 AND sortmode_id=0";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$fi = Array();
				$fi['id'] = $row->filter_id;

				echo "-- ".$fi['id']." --";

				// Get name of the filter parameter
				$query1 = "SELECT p1.*, p2.name FROM $TABLE_CAT_PARAMS p1
					INNER JOIN $TABLE_CAT_PARAMS_LANGS p2 ON p1.id=p2.param_id AND p2.lang_id='$LangId'
					WHERE p1.id=".$row->filter_id;
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$fi['name'] = stripslashes($row1->name);
					}
					mysqli_free_result( $res1 );
				}

				//
				$foptions = Array();
				$query1 = "SELECT DISTINCT t1.filter_val, o1.id, o2.option_text
						FROM $TABLE_CAT_CATTITLES t1
						INNER JOIN $TABLE_CAT_PARAM_OPTIONS o1 ON o1.id=t1.filter_val
						INNER JOIN $TABLE_CAT_PARAM_OPTIONS_LANGS o2 ON o1.id=o2.option_id AND o2.lang_id='$LangId'
						WHERE t1.filter_id='".$row->filter_id."' AND t1.sect_id='$item_id' AND t1.make_id='$make_id'
							AND t1.lang_id='$LangId' AND t1.sortmode_id='0'
						ORDER BY o1.sort_ind";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$oi = Array();
						$oi['id'] = $row1->id;
						$oi['name'] = stripslashes($row1->option_text);
						$foptions[] = $oi;
					}
					mysqli_free_result( $res1 );
				}
				else
					echo mysqli_error($upd_link_db);

				$fi['opts'] = $foptions;

				$filters[] = $fi;
			}
			mysqli_free_result( $res );
		}

		$orgname = "";
		$query0 = "SELECT * FROM $TABLE_CAT_CATALOG_LANGS c1
			WHERE c1.sect_id='$item_id' AND c1.lang_id='$LangId'";
		if( $res = mysqli_query($upd_link_db, $query0 ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$orgname = stripslashes($row->name);
			}
			mysqli_free_result( $res );
		}

		if( $make_id == 0 )
		{
			$query = "SELECT ct1.*, c1.name as sect FROM $TABLE_CAT_CATTITLES ct1
			INNER JOIN $TABLE_CAT_CATALOG_LANGS c1 ON ct1.sect_id=c1.sect_id AND c1.lang_id=$LangId
			WHERE ct1.sect_id='$item_id' AND ct1.make_id=0 AND ct1.sortmode_id='$sort_id'
				AND ct1.filter_id='$filt_id' AND ct1.filter_val='$filt_val' AND ct1.lang_id='$LangId'";
		}
		else
		{
			$query = "SELECT ct1.*, c1.name as sect, m1.make_name FROM $TABLE_CAT_CATTITLES ct1
			INNER JOIN $TABLE_CAT_CATALOG_LANGS c1 ON ct1.sect_id=c1.sect_id AND c1.lang_id=$LangId
			INNER JOIN $TABLE_CAT_MAKE_LANGS m1 ON ct1.make_id=m1.make_id AND m1.lang_id=$LangId
			WHERE ct1.sect_id='$item_id' AND ct1.make_id='$make_id' AND ct1.sortmode_id='$sort_id'
				AND ct1.filter_id='$filt_id' AND ct1.filter_val='$filt_val' AND ct1.lang_id='$LangId'";
		}

		//echo $query."<br />";

		if($res = mysqli_query($upd_link_db,$query))
		{
			if($row = mysqli_fetch_object($res))
			{
				echo "!!!";

				$orgid = $row->id;
				$orgname = stripslashes($row->sect).($make_id == 0 ? "" : " ".stripslashes($row->make_name));
				$orgtitle = stripslashes($row->page_title);
				$orgkeyw = stripslashes($row->page_keywords);
				$orgdescr = stripslashes($row->page_descr);
				$orgcont = stripslashes($row->content_text);
				$orgwords = stripslashes($row->content_words);
				$orgtitle_items = stripslashes($row->tpl_items_title);
				$orgkeyw_items = stripslashes($row->tpl_items_keywords);
				$orgdescr_items = stripslashes($row->tpl_items_descr);
				$orgcont_items = stripslashes($row->tpl_items_text);
				$orgwords_items = stripslashes($row->tpl_items_words);
				$text = "Данные из базы";
			}
			mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		$make_name = "";
		$sect_name = "";

		if( $orgtitle == "" )
		{
			if( $make_id == 0 )
			{
				$query = "SELECT c1.name as sect FROM $TABLE_CAT_CATALOG_LANGS c1 WHERE c1.sect_id='$item_id' AND c1.lang_id=$LangId";
			}
			else
			{
				$query = "SELECT c1.name as sect, m1.make_name FROM $TABLE_CAT_CATALOG_LANGS c1
					INNER JOIN $TABLE_CAT_MAKE_LANGS m1 ON m1.make_id='$make_id' AND m1.lang_id=$LangId
					WHERE c1.sect_id='$item_id'";
			}
			if($res = mysqli_query($upd_link_db,$query))
			{
				if($row = mysqli_fetch_object($res))
				{
					$sect_name = stripslashes($row->sect);
					$make_name = ($make_id == 0 ? "" : stripslashes($row->make_name));
					$text = "Данные сгенерированы автоматически";
				}
				mysqli_free_result($res);
			}
			else
				echo mysqli_error($upd_link_db);
		}


		////////////////////////////////////////////////////////////////////////
		//
		// Здесь этот кусок кода надо заменить на функцию, которая должна формировать тайлы по умолчанию.Она будет вызываться
		// здесь для тех разделов, для которых нет в базе тайтлов, а так же на сайте для тех же целей.
		// Єти значения поумолчанию нужны, когда в базе нет вручную заданных тайтлов и ключевых слов для раздела. Если их нет
		// в базе, они должны формироваться налету.

		//$gen_title = GenerateTitleSect($row->sect, $make_id, $row->make_name, $sort_id, $orgkeyw, $orgdescr,$orgtitle,$orgcont,$orgwords);
		$gen_title = Catalog_SeoDefTitle($LangId, $sect_name, $make_id, $make_name, $sort_id);
		$orgtitle	= ( $orgtitle != "" ? $orgtitle : $gen_title['title'] );
		$orgkeyw	= ( $orgkeyw != "" ? $orgkeyw : $gen_title['keyw'] );
		$orgdescr	= ( $orgdescr != "" ? $orgdescr : $gen_title['descr'] );
		$orgcont	= ( $orgcont != "" ? $orgcont : $gen_title['txt1'] );
		$orgwords	= ( $orgwords != "" ? $orgwords : $gen_title['txt2'] );

		$gen_title_prod = Product_SeoDefTitle( $LangId, false, "", "", $orgname );
		//$gen_title_prod = GenerateTitleItem($row->make_name,$prod_name,$orgname,$orgkeyw_items,$orgdescr_items,$orgtitle_items,$orgcont_items,$orgwords_items);
		$orgtitle_items	= ( $orgtitle_items != "" ? $orgtitle_items : $gen_title_prod['title'] );
		$orgkeyw_items	= ( $orgkeyw_items != "" ? $orgkeyw_items : $gen_title_prod['keyw'] );
		$orgdescr_items	= ( $orgdescr_items != "" ? $orgdescr_items : $gen_title_prod['descr'] );
		$orgcont_items	= ( $orgcont_items != "" ? $orgcont_items : $gen_title_prod['txt1'] );
		$orgwords_items	= ( $orgwords_items != "" ? $orgwords_items : $gen_title_prod['txt2'] );
?>

	<h3>Редактировать</h3>
	<?=$text?>
<?php

	/*
	if( count($sorttit_ids) > 1 )
	{
		echo '<div style="text-align: center; padding: 10px 0px 10px 0px;">';
		for($i=0; $i<count($sorttit_ids); $i++ )
		{
			if( $i != 0 )
				echo ' &nbsp; | &nbsp; ';

			if( $sort_id == $sorttit_ids[$i] )
				echo '<b>'.$sortby_arr[$sorttit_ids[$i]].'</b>';
			else
				echo '<a href="'.$PHP_SELF.'?mode=edit&item_id='.$item_id.'&make_id='.$make_id.'&sort_id='.$sorttit_ids[$i].'">'.$sortby_arr[$sorttit_ids[$i]].'</a>';
		}
		echo '</div>';
	}
	*/
	if( count($sortby_arr2) > 1 )
	{
		echo '<div style="text-align: center; padding: 10px 0px 10px 0px;">';
		for($i=0; $i<count($sortby_arr2); $i++ )
		{
			if( $i != 0 )
				echo ' &nbsp; | &nbsp; ';

			if( $sort_id == $sortby_arr2[$i]['id'] )
				echo '<b>'.$sortby_arr2[$i]['name'].'</b>';
			else
				echo '<a href="'.$PHP_SELF.'?mode=edit&item_id='.$item_id.'&make_id='.$make_id.'&sort_id='.$sortby_arr2[$i]['id'].'">'.$sortby_arr2[$i]['name'].'</a>';
		}
		echo '</div>';
	}


	if( count($filters) > 0 )
	{
		echo '<div style="text-align: center; padding: 10px 0px 10px 0px;">';
		for($i=0; $i<count($filters); $i++ )
		{
			echo '<div><b>'.$filters[$i]['name'].': </b> ';

			$opts = $filters[$i]['opts'];

			for( $j=0; $j<count($opts); $j++ )
			{
				if( $j != 0 )
					echo ', ';

				if( ($filt_id == $filters[$i]['id']) && ($filt_val == $opts[$j]['id']) )
					echo '<b>'.$opts[$j]['name'].'</b>';
				else
					echo '<a href="'.$PHP_SELF.'?mode=edit&item_id='.$item_id.'&make_id='.$make_id.'&sort_id=0&filt_id='.$filters[$i]['id'].'&filt_val='.$opts[$j]['id'].'">'.$opts[$j]['name'].'</a>';
			}

			echo '</div>';
		}
		echo '</div>';
	}
?>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="org_id" value="<?=$orgid;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<input type="hidden" name="make_id" value="<?=$make_id;?>" />
	<input type="hidden" name="sort_id" value="<?=$sort_id;?>" />
	<input type="hidden" name="filt_id" value="<?=$filt_id;?>" />
	<input type="hidden" name="filt_val" value="<?=$filt_val;?>" />
    <tr><td class="ff">Раздел:</td><td class="fr"><b><?=$orgname;?></b></td></tr>
    <tr><td class="ff">Title:</td><td class="fr"><input type="text" size="64" name="orgtitle" value="<?=$orgtitle;?>" /></td></tr>
    <tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="80" name="orgkeyw"><?=$orgkeyw;?></textarea></td></tr>
    <tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="80" name="orgdescr"><?=$orgdescr;?></textarea></td></tr>
    <tr><td class="ff">Текст:</td><td class="fr"><textarea rows="12" cols="80" name="orgcont"><?=$orgcont;?></textarea></td></tr>
    <script language="javascript1.2">
    	editor_generate('orgcont'); // field, width, height
	</script>
    <tr><td class="ff">Текст 2:</td><td class="fr"><textarea rows="12" cols="80" name="orgwords"><?=$orgwords;?></textarea></td></tr>
    <script language="javascript1.2">
    	editor_generate('orgwords'); // field, width, height
	</script>
<?php
    if( $make_id == 0 )
    {
?>
	<tr><td colspan="2" class="fr" align="center">Шаблоны для товаров категории</td></tr>
	<tr><td colspan="2" class="fr" align="center">_model_ - обозначение модели товара</td></tr>
	<tr><td colspan="2" class="fr" align="center">_make_ - полное название бренда</td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="64" name="orgtitle_items" value="<?=$orgtitle_items;?>" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="80" name="orgkeyw_items"><?=$orgkeyw_items;?></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="80" name="orgdescr_items"><?=$orgdescr_items;?></textarea></td></tr>
	<tr><td class="ff">Текст:</td><td class="fr"><textarea rows="6" cols="80" name="orgcont_items"><?=$orgcont_items;?></textarea></td></tr>
	<tr><td class="ff">Релевантные фразы:</td><td class="fr"><textarea rows="4" cols="80" name="orgwords_items"><?=$orgwords_items;?></textarea></td></tr>
<?php
	}
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
		PrintWorkCatalog(0, $LangId, 0, "fortitles");
	}
?>
    </form>
    </table>
<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
