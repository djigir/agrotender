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

	$strings['tipedit']['en'] = "Edit splash slides";
   	$strings['tipdel']['en'] = "Delete This Slide";
	$strings['nolist']['en'] = "In the database there is no slide";
	$strings['rowfunc']['en'] = "";

	$strings['tipedit']['ru'] = "Редактировать слайд";
   	$strings['tipdel']['ru'] = "Удалить слайд";
	$strings['nolist']['ru'] = "В базе нет ни одного слайда";
	$strings['rowfunc']['ru'] = "";

	$PAGE_HEADER['ru'] = "Список Слайдов";
	$PAGE_HEADER['en'] = "Slide list";

	$THIS_TABLE = $TABLE_SLIDES;

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	switch( $action )
	{
    	case "add":
    		$orgname = GetParameter("orgname", "");
			$orgsort = GetParameter("orgsort", 0);
			$orgurl = GetParameter("orgurl", "");
			$orgdescr = GetParameter("orgdescr", "");
			$myfile = GetParameter("myfile", "");

    		$query = "INSERT INTO $THIS_TABLE ( sort_num, filename, title, url, comment )
    			VALUES ('".$orgsort."', '".addslashes($myfile)."', '".addslashes($orgname)."', '".addslashes($orgurl)."', '".addslashes($orgdescr)."')";
			if( mysqli_query($upd_link_db,$query) )
			{
				$newsectid = mysqli_insert_id($upd_link_db);
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
			$orgsort = GetParameter("orgsort", 0);
			$orgurl = GetParameter("orgurl", "");
			$orgdescr = GetParameter("orgdescr", "");
			$myfile = GetParameter("myfile", "");

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET sort_num='$orgsort', filename='".addslashes($myfile)."', title='".addslashes($orgname)."',
                        comment='".addslashes($orgdescr)."', url='".addslashes($orgurl)."'
                        WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}
    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", 0);
		$orgname = "";
		$orgsort = 0;
		$myfile = "";
		$orgurl = "";
		$orgdescr = "";

		if($res = mysqli_query($upd_link_db,"SELECT * FROM $THIS_TABLE WHERE id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgsect = $row->parent_id;
				$orgname = stripslashes($row->title);
				$orgsort = $row->sort_num;
				$myfile = stripslashes($row->filename);
				$orgurl = stripslashes($row->url);
				$orgdescr = stripslashes($row->comment);
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
    <tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Комментарий:</td><td class="fr"><input type="text" size="70" name="orgdescr" value="<?=$orgdescr;?>" /></td></tr>
    <tr><td class="ff">Ссылка (URL):</td><td class="fr"><input type="text" size="70" name="orgurl" value="<?=$orgurl;?>" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="30" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
	<tr><td class="ff">Картинка (760 x 251): </td><td class="fr"><input type="text" name="myfile" style="width: 200px" value="<?=$myfile;?>"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
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
    <h3>Список слайдов</h3>
    <table align="center" width="60%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
	<input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th style="padding: 1px 10px 1px 20px">Слайд</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php
    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT * FROM $THIS_TABLE ORDER BY sort_num") )
		{
			while( $row = mysqli_fetch_object($res) )
			{
                $found_news++;

            	echo "<tr>
             		<td><input type=\"checkbox\" name=\"news_id[]\" value=\"".$row->id."\" /></td>
               		<td style=\"padding: 2px 10px 2px 10px\">
               			<img src=\"".$FILE_DIR.stripslashes($row->filename)."\" alt=\"\" >
               			<b>".stripslashes($row->title)."</b> (".stripslashes($row->comment).")
                  		<br />".stripslashes($row->url)."</td>
                    <td align=\"center\">
                    	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                     	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
                    </td>
                </tr>
                <tr><td colspan=\"3\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"3\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"3\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"3\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить выбранные \" /></td></tr>";
        }
?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить слайд</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Комментарий:</td><td class="fr"><input type="text" size="70" name="orgdescr" /></td></tr>
    <tr><td class="ff">Ссылка (URL):</td><td class="fr"><input type="text" size="70" name="orgurl" /></td></tr>
    <tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="30" name="orgsort"></td></tr>
    <tr><td class="ff">Картинка (760 x 251): </td><td class="fr"><input type="text" name="myfile" style="width: 200px"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
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
