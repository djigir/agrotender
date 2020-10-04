<?php
	$HTMLAREA=true;

	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";
	  include "../inc/utils-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }


    $PAGE_HEADER['ru'] = "Редактировать список скриптов";
   	$PAGE_HEADER['en'] = "Page Headers Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

    $strings["hdrsel"]["ru"] = "Скрипты добавленные в базу";
    $strings["hdradd"]["ru"] = "Добавить скрипт";
    $strings["rowedit"]["ru"] = "Редактировать";
    $strings["rowsel"]["ru"] = "Выберите страницу";
    $strings["btnnext"]["ru"] = "Далее";
    $strings["rowtitle"]["ru"] = "Заголовок Страницы";
    $strings["rowheader"]["ru"] = "Верхний Контент";
    $strings["rowfooter"]["ru"] = "Нижний Контент";
    $strings["btnapply"]["ru"] = "Применить";
    $strings["btndel"]["ru"] = "Удалить выбранные";
    $strings["hdrname"]["ru"] = "Название";
    $strings["hdrcont"]["ru"] = "Контент";
    $strings["tipedit"]["ru"] = "Редактировать";
    $strings["tipdel"]["ru"] = "Удалить";
    $strings["nolist"]["ru"] = "В базе нет записей";
	$strings["deleteconfirm"]["ru"] = "При удаление вся информация связанная с выбранной страницей будет удалена.\\r\\nУдалить?";

	$strings["hdrsel"]["en"] = "Select page for editing";
	$strings["hdradd"]["en"] = "Add page";
	$strings["rowedit"]["en"] = "Edit page";
	$strings["rowsel"]["en"] = "Select page";
	$strings["btnnext"]["en"] = "Continue";
	$strings["rowtitle"]["en"] = "Page Title";
	$strings["rowheader"]["en"] = "Top text";
	$strings["rowfooter"]["en"] = "Bottom text";
	$strings["btnapply"]["en"] = "Apply";
	$strings["btndel"]["en"] = "Delete selected";
	$strings["hdrname"]["en"] = "Name";
	$strings["hdrcont"]["en"] = "Content";
	$strings["tipedit"]["en"] = "Edit item";
    $strings["tipdel"]["en"] = "Delete item";
    $strings["nolist"]["en"] = "No records in database";

    //require_once "inccat/functions.inc.php";

	$action = GetParameter( "action", "" );
	$msg = "";

	$content = GetParameter("content", "", false);
	$content=str_replace ("&gt;",">",$content);
	$content=str_replace ("&lt;","<",$content);

	$title = GetParameter("title", "");
	$header = GetParameter("header", "", false);

	$pfile = GetParameter("pfile", "");
	$ptitle = GetParameter("ptitle", "");
	$pmean = GetParameter("pmean", "");
	$pkey = GetParameter("pkey", "");
	$pdescr = GetParameter("pdescr", "");

	$psort = GetParameter("psort", "0");
	$menushow = GetParameter("menushow", 0);
	$pagetype = GetParameter("pagetype", 1);
	$parentid = GetParameter("parentid", 0);

	if( $psort == "" )
		$psort = 0;

	switch( $action )
	{
    	case "add":
			if( $pfile == "" )
			{
				$msg = "Страница не добавлена. Вы не указали имя скрипта.";
			}
			else if( $pmean == "" )
			{
				$msg = "Страница не добавлена. Вы не указали назначение скрипта.";
			}
			else
			{
				if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_PAGES (parent_id, page_name, create_date, modify_date, show_in_menu,
					page_record_type, sort_num)
					VALUES ( $parentid, '".addslashes($pfile)."', NOW(), NOW(), $menushow, $pagetype, $psort )") )
				{
		        	$msg = mysqli_error($upd_link_db);
		        }
		        else
		        {
		        	$newpageid = mysqli_insert_id($upd_link_db);
		        	for($i=0; $i<count($langs); $i++)
		        	{
		        		$query = "INSERT INTO $TABLE_PAGES_LANGS (item_id, lang_id, page_mean, page_title, page_keywords, page_descr,
		        			content, title, header) VALUES ($newpageid, ".$langs[$i].", '".addslashes($pmean)."',
		        			'".addslashes($ptitle)."', '".addslashes($pkey)."', '".addslashes($pdescr)."',
		        			'".addslashes($content)."', '".addslashes($title)."', '".addslashes($header)."' )";
			            if( !mysqli_query($upd_link_db, $query ) )
			            {
			            	echo mysqli_error($upd_link_db);
			            }
		        	}

		        	$content = "";

					$title = "";
					$header = "";

					$pfile = "";
					$ptitle = "";
					$pmean = "";
					$pkey = "";
					$pdescr = "";
		        }
			}
			break;

		case "delete":

			$items_id = GetParameter("items_id", "");

			// Delete selected pages
			for($i = 0; $i < count($items_id); $i++)
			{
				//echo $items_id[$i];
				DeletAllSub($items_id[$i], 0 ,'page');
				/*
					if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_PAGES WHERE id=".$items_id[$i]." "))
					{
						echo "<b>".mysqli_error($upd_link_db)."</b>";
					}
					else
					{
						$query = "DELETE FROM $TABLE_PAGES_LANGS WHERE item_id='".$items_id[$i]."'";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
					*/
			}
			break;

		case "deleteitem":

			$item_id = GetParameter("item_id", "0");
			DeletAllSub($item_id, 0 ,'page');
			/*
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_PAGES WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		else
    		{
    			$query = "DELETE FROM $TABLE_PAGES_LANGS WHERE item_id='".$item_id."'";
			    if( !mysqli_query($upd_link_db, $query ) )
			    {
			    	echo mysqli_error($upd_link_db);
			    }
    		}
			*/
    		break;

	}


	//---------------------------- Extract all pages ---------------------------

	if ( $msg != "" )
	{
  		echo "<center><span style=\"color: red;\">$msg</span></center><br /><br />";
	}
?>

<h3><?php echo $strings["hdrsel"][$lang];?></h3>

	<table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="" method=POST>
    <input type="hidden" name="action" value="delete" />
	<input type="hidden" name="items_id" value="<?php echo $items_id;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th style="padding: 1px 10px 1px 10px" align="left">Страница</th>
    	<th align="left">Скрипт (без расшир.)</th>
    	<th align="left">Ссылка</th>
    	<th>Дата создание</th>
    	<th>Дата модификации</th>
    	<th>&nbsp;</th>
    </tr>
<?php
function FillPageList($pid, $level)
{
	global $TABLE_PAGES, $TABLE_PAGES_LANGS, $LangId, $PHP_SELF, $strings, $lang, $upd_link_db;

	$num_pages = 0;

	if( $res = mysqli_query($upd_link_db, "SELECT p1.*, p2.page_mean
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

           	echo "<tr>
                 <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                 <td style=\"padding: 2px 10px 2px ".(10+$level*20)."px\"><b>".stripslashes($row->page_mean)."</b> (".$row->sort_num.")</td>
                 <td>".stripslashes($row->page_name)."</td>
                 <td>".$link_file."</td>
                 <td align=\"center\">".$row->create_date."</td>
                 <td align=\"center\">".$row->modify_date."</td>
                 <td align=\"center\">
                 	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\" onclick='return confirm(\"".$strings['deleteconfirm'][$lang]."\")'><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                 	<a href=\"page_basic.php?id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
               </tr>
               <tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";


			$pres = FillPageList($row->id, $level+1);
			$num_pages += $pres;
		}
  		mysqli_free_result($res);
	}

	return $num_pages;
}
/*
		$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean
			FROM $TABLE_PAGES p1
			INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.parent_id=0
			ORDER BY p1.show_in_menu, p1.sort_num") )
		{
			while( $row = mysqli_fetch_object($res) )
			{
				$found_items++;

                $link_file = "";
				switch( $row->page_record_type )
				{
					case 1:	$link_file = stripslashes($row->page_name).'.php';				break;
					case 2:	$link_file = stripslashes($row->page_name).'/';					break;
					case 3:	$link_file = "info.php?page=".stripslashes($row->page_name);	break;
				}

            	echo "<tr>
                  <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                  <td style=\"padding: 2px 10px 2px 10px\"><b>".stripslashes($row->page_mean)."</b> (".$row->sort_num.")</td>
                  <td>".stripslashes($row->page_name)."</td>
                  <td>".$link_file."</td>
                  <td align=\"center\">".$row->create_date."</td>
                  <td align=\"center\">".$row->modify_date."</td>
                  <td align=\"center\">
                  	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                  	<a href=\"page_basic.php?id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";

                $query1 = "SELECT p1.*, p2.page_mean
					FROM $TABLE_PAGES p1
					INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
					WHERE p1.parent_id=".$row->id."
					ORDER BY p1.show_in_menu, p1.sort_num";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                	while( $row1 = mysqli_fetch_object( $res1 ) )
                	{
                		$found_items++;

                		$link_file = "";
						switch( $row1->page_record_type )
						{
							case 1:	$link_file = stripslashes($row1->page_name).'.php';				break;
							case 2:	$link_file = stripslashes($row1->page_name).'/';				break;
							case 3:	$link_file = "info.php?page=".stripslashes($row1->page_name);	break;
						}

		            	echo "<tr>
		                  <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row1->id."\" /></td>
		                  <td style=\"padding: 2px 10px 2px 30px\"><b>".stripslashes($row1->page_mean)."</b> (".$row1->sort_num.")</td>
		                  <td>".stripslashes($row1->page_name)."</td>
		                  <td>".$link_file."</td>
		                  <td align=\"center\">".$row1->create_date."</td>
		                  <td align=\"center\">".$row1->modify_date."</td>
		                  <td align=\"center\">
		                  	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row1->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
		                  	<a href=\"page_basic.php?id=".$row1->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
		                </tr>
		                <tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
                	}
                	mysqli_free_result( $res1 );
                }
			}
            mysqli_free_result($res);
		}
*/
	$found_items = FillPageList(0, 0);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"7\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"7\"><input type=\"submit\"  onclick='return confirm(\"".$strings['deleteconfirm'][$lang]."\")' name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>


<h3><?php echo $strings["hdradd"][$lang];?></h3>
<table align="center" cellspacing="0" cellpadding="1" border="0" bgcolor="#9CB7C7">
	<tr><td>
	<table width="100%" cellspacing="1" cellpadding="1" border="0">
<form name="catfrm" id="catfrm" action="" method="post">
<input type="hidden" name="action" value="add" />
<tr>
    <th><?php echo $strings["hdrname"][$lang];?></th>
    <th><?php echo $strings["hdrcont"][$lang];?></th>
</tr>
<tr>
	<td class="ff">Куда вставлять:</td>
    <td class="fr">
    	<select name="parentid">
    		<option value="0">--- Корневой раздел ---</option>
<?php
function FillPageTree($pid, $level, $selid)
{
	global $TABLE_PAGES, $TABLE_PAGES_LANGS, $LangId;
	if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean
			FROM $TABLE_PAGES p1
			INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.parent_id=$pid
			ORDER BY p1.show_in_menu, p1.sort_num") )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$str_space = "";
    		for($i=0; $i<$level; $i++)
    			$str_space .= "&nbsp;&nbsp;&nbsp;";
			echo "<option value=\"".$row->id."\"".($selid == $row->id ? " selected" : "").">".$str_space.stripslashes($row->page_mean)."</option>";
			FillPageTree($row->id, $level+1, $selid);
		}
  		mysqli_free_result($res);
	}
}

FillPageTree(0, 0, $page1['pid']);
?>
<?php
/*
	$query = "SELECT p1.*, p2.page_mean FROM $TABLE_PAGES p1
		INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.parent_id='0'
		ORDER BY p1.sort_num";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
    	while( $row = mysqli_fetch_object( $res ) )
    	{
    		$str_space = "";
    		$for($i=0; $i<$level; $i++)
    			$str_space .= "&nbsp;&nbsp;&nbsp;";
    		echo "<option value=\"".$row->id."\"".($page1['pid'] == $row->id ? " selected" : "").">".$str_space.stripslashes($row->page_mean)."</option>";
    	}
    	mysqli_free_result( $res );
    }
  */
?>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Имя файла (без расшир.):</td>
    <td class="fr"><input type="text" name="pfile" size="20" value="<?php echo $pfile;?>" /></td>
</tr>
<tr>
	<td class="ff">Назначение:</td>
    <td class="fr"><input type="text" name="pmean" size="60" value="<?php echo $pmean;?>" /></td>
</tr>
<tr>
	<td class="ff">Title:</td>
    <td class="fr"><input type="text" name="ptitle" size="70" value="<?php echo $ptitle;?>" /></td>
</tr>
<tr>
	<td class="ff">Keywords:</td>
    <td class="fr"><input type="text" name="pkey" size="70" value="<?php echo $pkey;?>" /></td>
</tr>
<tr>
	<td class="ff">Description:</td>
    <td class="fr"><textarea name="pdescr" cols="70" rows="3"><?php echo $pdescr;?></textarea></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff"><?php echo $strings["rowtitle"][$lang];?>:</td>
    <td class="fr"><input type="text" name="title" size="70" value="<?php echo $title;?>" /></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff"><?php echo $strings["rowheader"][$lang];?>:</td>
    <td class="fr"><textarea class="ckeditor" name="header" cols="70" rows="10"><?php echo $header;?></textarea></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff"><?php echo $strings["rowfooter"][$lang];?>:</td>
    <td class="fr"><textarea class="ckeditor" name="content" cols="70" rows="10"><?php echo $content;?></textarea></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff">Показывать в меню:</td>
    <td class="fr">
    	<select name="menushow">
    		<option value="0">Нет</option>
    		<option value="1">Верхнее меню</option>
    		<option value="2">Меню слева</option>
    		<option value="3">Только для зарегистрированных</option>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Тип записи страницы:</td>
    <td class="fr">
    	<select name="pagetype">
    		<option value="0">Не ссылка (заглавие подгруппы)</option>
    		<option value="1" selected>Обычная страница</option>
    		<option value="2">Ссылка на подкаталог</option>
    		<option value="3">Страница из базы</option>
    		<option value="4">Прямая ссылка</option>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Порядковый номер:</td>
    <td class="fr"><input type="text" name="psort" size="2" value="0" /></td>
</tr>
<tr>
	<td class="fr" colspan="2" align="center"><input type="submit" name="addbut" value=" <?php echo $strings["btnapply"][$lang];?> " /></td>
</tr>
</form>
	</table>
	</td></tr>
</table>
<br />
<?php

	include ("inc/footer-inc.php");

	include ("../inc/close-inc.php");
?>
