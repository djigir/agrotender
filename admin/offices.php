<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit This Question";
   	$strings['tipdel']['en'] = "Delete This Question";
   	$strings['hdrlist']['en'] = "Section List";
   	$strings['hdradd']['en'] = "Add Section";
   	$strings['hdredit']['en'] = "Edit Section";
   	$strings['rowtitle']['en'] = "Group section";
   	$strings['rowtext']['en'] = "Answer";
   	$strings['rowsort']['en'] = "Sort Index";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No sections in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";

    $strings['tipedit']['ru'] = "Редактировать это представительство";
   	$strings['tipdel']['ru'] = "Удалить это представительство";
   	$strings['hdrlist']['ru'] = "Список представительств";
   	$strings['hdradd']['ru'] = "Добавить представительство";
   	$strings['hdredit']['ru'] = "Редакировать представительство";
   	$strings['rowtitle']['ru'] = "Город";
   	$strings['rowtext']['ru'] = "Комментарии";
   	$strings['rowsort']['ru'] = "Порядковый номер";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет представительств";
    $strings['rowcont']['ru'] = "Содержание раздела";
   	$strings['rowfunc']['ru'] = "Функции";

	$PAGE_HEADER['ru'] = "Редактировать список представительств";
	$PAGE_HEADER['en'] = "Update group sections";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

?>

<?php

	switch( $action )
	{
    	case "add":
    		$ctitle = GetParameter("ctitle", "");
    		$ccity = GetParameter("ccity", "");
    		$caddr = GetParameter("caddr", "");
    		$cphone = GetParameter("cphone", "");
    		$cfax = GetParameter("cfax", "");
    		$cemail = GetParameter("cemail", "");
    		$cdescr = GetParameter("cdescr", "");
    		$sortnum = GetParameter("sortnum", "");
    		$curl = GetParameter("curl", "");
    		$myfile = GetParameter("myfile", "");

    		//$newstitle = str_replace("\"","&quot;", $newstitle);

    		$query = "INSERT INTO $TABLE_OFFICES ( sort_num, map_file, page_link ) VALUES ('".$sortnum."', '".addslashes($myfile)."', '".addslashes($curl)."' )";
			if(!mysqli_query($upd_link_db,$query))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			else
			{
				$newsectid = mysqli_insert_id($upd_link_db);

				for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_OFFICES_LANG ( office_id, lang_id,
                		title, city, address, phone, fax, email, descr )
	                    VALUES ('$newsectid', '".$langs[$i]."', '".addslashes($ctitle)."', '".addslashes($ccity)."',
	                    '".addslashes($caddr)."', '".addslashes($cphone)."', '".addslashes($cfax)."',
	                    '".addslashes($cemail)."', '".addslashes($cdescr)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }
			}
			break;

		case "delete":
			$item_id = GetParameter("item_id", "0");
			// Delete selected news
			for($i = 0; $i < count($item_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_OFFICES WHERE id=".$item_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}

    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_OFFICES_LANG WHERE office_id=".$item_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");

            if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_OFFICES WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}

    		if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_OFFICES_LANG WHERE office_id=".$item_id." "))
			{
       			echo "<b>".mysqli_error($upd_link_db)."</b>";
   			}
			break;

		case "update":
			$item_id = GetParameter("item_id", 0);
			$ctitle = GetParameter("ctitle", "");
            $ccity = GetParameter("ccity", "");
    		$caddr = GetParameter("caddr", "");
    		$cphone = GetParameter("cphone", "");
    		$cfax = GetParameter("cfax", "");
    		$cemail = GetParameter("cemail", "");
    		$cdescr = GetParameter("cdescr", "");
    		$sortnum = GetParameter("sortnum", "");
    		$curl = GetParameter("curl", "");
    		$myfile = GetParameter("myfile", "");

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_OFFICES SET sort_num='".$sortnum."', map_file='".addslashes($myfile)."', page_link='".addslashes($curl)."'
				WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_OFFICES_LANG SET title='".addslashes($ctitle)."', city='".addslashes($ccity)."',
				address='".addslashes($caddr)."', phone='".addslashes($cphone)."',
				fax='".addslashes($cfax)."', email='".addslashes($cemail)."',
				descr='".addslashes($cdescr)."'
				WHERE office_id=".$item_id." AND lang_id='$LangId'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$ccity = "";
		$caddr = "";
		$cphone = "";
		$cfax = "";
		$cemail = "";
		$cdescr = "";
		$sortnum = 0;
		$ctitle = "";
		$curl = "";
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT s1.*, s2.title, s2.city, s2.address, s2.phone, s2.fax, s2.email, s2.descr
			FROM $TABLE_OFFICES s1
			INNER JOIN $TABLE_OFFICES_LANG s2 ON s1.id=s2.office_id AND s2.lang_id='$LangId'
			WHERE s1.id=$item_id"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$ctitle = stripslashes($row->title);
				$ccity = stripslashes($row->city);
				$caddr = stripslashes($row->address);
				$cphone = stripslashes($row->phone);
				$cfax = stripslashes($row->fax);
				$cemail = stripslashes($row->email);
				$cdescr = stripslashes($row->descr);
				$curl = stripslashes($row->page_link);
				$myfile = stripslashes($row->map_file);
				$sortnum = $row->sort_num;
			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="ctitle" value="<?=$ctitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="ccity" value="<?=$ccity;?>" /></td></tr>
	<tr><td class="ff">Адрес представительства:</td><td class="fr"><input type="text" size="70" name="caddr" value="<?=$caddr;?>" /></td></tr>
	<tr><td class="ff">Телефоны:</td><td class="fr"><input type="text" size="40" name="cphone" value="<?=$cphone;?>" /></td></tr>
	<tr><td class="ff">Факс:</td><td class="fr"><input type="text" size="40" name="cfax" value="<?=$cfax;?>" /></td></tr>
	<tr><td class="ff">E-Mail:</td><td class="fr"><input type="text" size="40" name="cemail" value="<?=$cemail;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="7" cols="80" name="cdescr"><?=$cdescr;?></textarea></td></tr>
	<tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px" value="<?=$myfile;?>"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
	<tr><td class="ff">Адрес страницы:</td><td class="fr"><input type="text" size="60" name="curl" value="<?=$curl;?>" /></td></tr>
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
    	<th style="padding: 1px 10px 1px 20px"><?=$strings['rowcont'][$lang];?></th>
    	<th>Контакты</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
    <?
    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT s1.*, s2.title, s2.city, s2.address, s2.phone, s2.fax, s2.email, s2.descr
			FROM $TABLE_OFFICES s1
			INNER JOIN $TABLE_OFFICES_LANG s2 ON s1.id=s2.office_id AND s2.lang_id='$LangId'
			ORDER BY s1.sort_num, s2.city, s2.address") )
		{
			while( $row = mysqli_fetch_object($res) )
			{
                $found_news++;

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"item_id[]\" value=\"".$row->id."\" /></td>
                               <td style=\"padding: 2px 10px 2px 10px\"><b>".stripslashes($row->title)."</b>
                                   <br />".stripslashes($row->city).", ".stripslashes($row->address)."</td>
                               <td>Телефоны: ".stripslashes($row->phone)."<br />
                               Факс: ".stripslashes($row->fax)."<br />
                               E-Mail: ".stripslashes($row->email)."<br />
                               </td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"4\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"4\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3><?=$strings['hdradd'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="ctitle" /></td></tr>
    <tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="ccity"  /></td></tr>
	<tr><td class="ff">Адрес представительства:</td><td class="fr"><input type="text" size="70" name="caddr"  /></td></tr>
	<tr><td class="ff">Телефоны:</td><td class="fr"><input type="text" size="40" name="cphone"  /></td></tr>
	<tr><td class="ff">Факс:</td><td class="fr"><input type="text" size="40" name="cfax"  /></td></tr>
	<tr><td class="ff">E-Mail:</td><td class="fr"><input type="text" size="40" name="cemail"  /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="7" cols="80" name="cdescr"></textarea></td></tr>
	<tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
	<tr><td class="ff">Адрес страницы:</td><td class="fr"><input type="text" size="60" name="curl" /></td></tr>
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
