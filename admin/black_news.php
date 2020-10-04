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

function checkDtFormat($dt)
{
	if( !(
		is_numeric(substr($dt, 0, 1)) &&
		is_numeric(substr($dt, 1, 1)) &&
		is_numeric(substr($dt, 3, 1)) &&
		is_numeric(substr($dt, 4, 1)) &&
		is_numeric(substr($dt, 6, 1)) &&
		is_numeric(substr($dt, 7, 1)) &&
		is_numeric(substr($dt, 8, 1)) &&
		is_numeric(substr($dt, 9, 1))
		) )
		return false;

	$starr = @split("[.]", $dt);
	if( (count($starr) == 3) &&
		is_numeric($starr[1]) && is_numeric($starr[0]) && is_numeric($starr[2]) &&
	 	!checkdate( $starr[1], $starr[0], $starr[2] ) )
	{
		return false;
	}

	return true;
}

	$strings['tipedit']['en'] = "Edit This News";
   	$strings['tipdel']['en'] = "Delete This News";
   	$strings['hdrlist']['en'] = "News List";
   	$strings['hdradd']['en'] = "Add News Record";
   	$strings['hdredit']['en'] = "Edit News Record";
   	$strings['rowdate']['en'] = "News date";
   	$strings['rowtitle']['en'] = "Title";
   	$strings['rowfirst']['en'] = "Preview Page";
   	$strings['rowtext']['en'] = "News Text";
   	$strings['rowbrand']['en'] = "Company Source";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No news in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";

    $strings['tipedit']['ru'] = "Редактировать эту новость";
   	$strings['tipdel']['ru'] = "Удалить эту новость";
   	$strings['hdrlist']['ru'] = "Список Новостей";
   	$strings['hdradd']['ru'] = "Добавить Новость";
   	$strings['hdredit']['ru'] = "Редакировать Новость";
   	$strings['rowdate']['ru'] = "Дата";
   	$strings['rowtitle']['ru'] = "Заголовок";
   	$strings['rowfirst']['ru'] = "На главную";
   	$strings['rowtext']['ru'] = "Текст";
   	$strings['rowbrand']['ru'] = "Компания";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет новостей";
    $strings['rowcont']['ru'] = "Содержание записей";
   	$strings['rowfunc']['ru'] = "Функции";

	$PAGE_HEADER['ru'] = "Редактировать Новости";
	$PAGE_HEADER['en'] = "News Editing";

	$ntype_arr = $NEWS_TYPES; //Array("Новости", "Новости сайта");

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$ntype = GetParameter("ntype", 0);

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 50);

	$datest = GetParameter("datest", date("d.m.Y", time()));

	$THIS_TABLE = $TABLE_BLNEWS;
	$THIS_TABLE_LANG = $TABLE_BLNEWS_LANGS;
?>

<?php

	switch( $action )
	{
    	case "add":
    		$newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$newsfirst = GetParameter("newsfirst", 0);
    		$newstop = GetParameter("newstop", 0);
    		$myfile = GetParameter("myfile", "");

    		$query = "INSERT INTO $THIS_TABLE ( dtime, ngroup, first_page, filename_src)
    			VALUES ( NOW(), '$ntype', '$newsfirst', '".addslashes($myfile)."')";
			if( mysqli_query($upd_link_db,$query) )
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
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( news_id, lang_id, title, content )
	                    VALUES ('$newid', '".$langs[$i]."', '".addslashes($newstitle)."', '".addslashes($newscont)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }

	            // Make relinkin
	            $relnews = Array();
	            $query = "SELECT * FROM $TABLE_BLNEWS ORDER BY dtime DESC LIMIT 0,5";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$relnews[] = $row->id;
					}
					mysqli_free_result( $res );
				}

				/*
				for( $i=1; $i<count($relnews); $i++ )
				{
					$query = "INSERT INTO $TABLE_TORG_REL2REL (item_id, rel_id, type_dat, add_date)
						VALUES ('".$newid."', '".$relnews[$i]."', 1, NOW())";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				*/
			}
			else
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "delete":
			// Delete selected news
			$news_id = GetParameter("news_id", "0");
			for($i = 0; $i < count($news_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$news_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE news_id='".$news_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
    			}
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		else
    		{
    			if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE news_id='".$item_id."'" ) )
				{
					echo mysqli_error($upd_link_db);
				}
    		}
    		break;

		case "update":
			$item_id = GetParameter("item_id", "0");
            $newstitle = GetParameter("newstitle", "");
    		$newscont = GetParameter("newscont", "", false);
    		$newsfirst = GetParameter("newsfirst", 0);
    		$newstop = GetParameter("newstop", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");

    		$db_datest = substr($datest, 6, 4)."-".substr($datest, 3, 2)."-".substr($datest, 0, 2)." 01:00:00";

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET first_page='$newsfirst', filename_src='".addslashes($myfile)."', dtime='$db_datest'
				WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$query = "UPDATE $THIS_TABLE_LANG SET title='".addslashes($newstitle)."', content='".addslashes($newscont)."'
                        WHERE news_id='".$item_id."' AND lang_id='".$LangId."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$newstitle = "";
		$newscont = "";
		$newsfirst = 0;
		$newstop = 0;
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.title, m2.content,
			DAYOFMONTH(m1.dtime) as dd, MONTH(m1.dtime) as dm, YEAR(m1.dtime) as dy
			FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.news_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle = stripslashes($row->title);
				$newscont = stripslashes($row->content);
				$newsfirst = $row->first_page;
				$newstop = $row->intop;
				//$newsbrand = $row->brand_id;
				$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$myfile = stripslashes($row->filename_src);
			}
			mysqli_free_result($res);
		}

		//echo "ID: $item_id<br />";
?>

	<h3><?=$strings['hdredit'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="ntype" value="<?=$ntype;?>" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff"><?=$strings['rowdate'][$lang];?>:</td><td class="fr">
<?php
	echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
	<td><input type=\"text\" id=\"datest\" name=\"datest\" size=\"10\" maxlength=\"10\" value=\"".$datest."\" /> &nbsp;</td>
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.advfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
	</tr></table>";
?>
</td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	<tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px" value="<?=$myfile;?>"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.advfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
	<tr>
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
		<td class="fr"><select name="newsfirst">
			<option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>ДА</option>
		</select></td>
	</tr>
<?php
	/*
	<tr>
		<td class="ff">В топ:</td>
		<td class="fr"><select name="newstop">
			<option value="0"<?=( $newstop == 0 ? " selected ": "" );?>>НЕТ</option>
			<option value="1"<?=( $newstop == 1 ? " selected ": "" );?>>ДА</option>
		</select></td></tr>
	*/
?>
    <script language="javascript1.2">
    	editor_generate('newscont'); // field, width, height
	</script>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" <?=$strings['btnrefresh'][$lang];?> "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
		$news_total = 0;
		$query = "SELECT count(*) as totnews FROM $THIS_TABLE WHERE ngroup='$ntype'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			if( $row = mysqli_fetch_object( $res ) )
			{
				$news_total = $row->totnews;
			}
			mysqli_free_result( $res );
		}

		$pagesnum = ceil($news_total / $pn);
?>
    <h3><?=$strings['hdrlist'][$lang];?></h3>

    <div style="padding: 10px 20px 10px 10px;">
    	<div style="float: right; width: 40%; text-align: right;">
		<?php
			echo '<a class="a-first" href="'.$PHP_SELF.'?ntype='.$ntype.'&pi=1&pn='.$pn.'"></a>
				<a class="a-prev" href="'.$PHP_SELF.'?ntype='.$ntype.'&pi='.($pi > 1 ? ($pi-1) : 1).'&pn='.$pn.'"></a>';
			for( $i=1; $i<=$pagesnum; $i++ )
   			{
   				if( $i == $pi )
   					echo '<span>'.$i.'</span>';
   				else
        				echo '<a class="a-page" href="'.$PHP_SELF.'?ntype='.$ntype.'&pi='.$i.'&pn='.$pn.'">'.$i.'</a>';
   			}
   			echo '<a class="a-next" href="'.$PHP_SELF.'?ntype='.$ntype.'&pi='.( $pi < $pagesnum ? $pi+1 : $pagesnum ).'&pn='.$pn.'"></a>
				<a class="a-last" href="'.$PHP_SELF.'?ntype='.$ntype.'&pi='.$pagesnum.'&pn='.$pn.'"></a>';
   		?>
		</div>
<?php
	/*
    	Тип публикации: &nbsp;
<?php
	for( $i=0; $i<count($ntype_arr); $i++ )
	{
		if( $i > 0 )
			echo ' &nbsp;::&nbsp; ';

		if( $ntype == $i )
			echo '<b>'.$ntype_arr[$i].'</b>';
		else
			echo '<a href="news.php?ntype='.$i.'">'.$ntype_arr[$i].'</a>';
	}
	*/
?>
    </div>
    <div style="clear: both"></div>


    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="ntype" value="<?=$ntype;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th style="padding: 1px 10px 1px 20px" width="65%"><?=$strings['rowcont'][$lang];?></th>
    	<th><?=$strings['rowfirst'][$lang];?></th>
    	<th>Коммент.</th>
    	<!--<th>В топ</th>-->
    	<th>Просм.</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
<?php
    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*, m2.title, m2.content
			FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.ngroup='$ntype' AND m1.id=m2.news_id AND m2.lang_id='$LangId'
			ORDER BY m1.dtime DESC
			LIMIT ".(($pi-1)*$pn).",$pn") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_news++;

                $str_text = strip_tags(stripslashes($row->content));
            	if( strlen($str_text) > 2000 )
	            {
	                $pos = strpos( $str_text, " ", 2000 );
	                if( $pos )
	                {
	                    $str_text = substr($str_text, 0, $pos)."...";
	                    //$str_text .= "<div class=\"linkpar\"><a href=\"$PHP_SELF?id=".$news[$i]['id']."\" class=\"greenlink\">Подробнее...</a></div>";
	                }
	            }

				$comment_num = 0;
	            $query1 = "SELECT count(*) as commentnum FROM $TABLE_BLNEWS_COMMENT WHERE item_id='".$row->id."'";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					while( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$comment_num = $row1->commentnum;
					}
					mysqli_free_result( $res1 );
				}

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"news_id[]\" value=\"".$row->id."\" /></td>
                               <td style=\"padding: 2px 10px 2px 10px\">
                                   <b>".stripslashes($row->title)."</b> - [".$row->dtime."]";
				//echo "<br><br>".$str_text;
							echo "</td>
                               <td align=\"center\">
                               		".($row->first_page == 1 ? " <span style=\"font-weight: bold; color: red;\">Да</span> " : " Нет ")."
                               </td>
                               <td align=\"center\">".($comment_num == 0 ? "0" : '<a href="black_news_comment.php?newsid='.$row->id.'">'.$comment_num.'</a>')."</td>
                               ".( false ? "<td align=\"center\">
                               		".($row->intop == 1 ? " <span style=\"font-weight: bold; color: red;\">Да</span> " : " Нет ")."
                               </td>" : "" )."
                               <td align=\"center\">".$row->view_num."</td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&ntype=".$ntype."&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?mode=edit&ntype=".$ntype."&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"6\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
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
    <input type="hidden" name="ntype" value="<?=$ntype;?>" />
    <tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="newstitle"></td></tr>
    <tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="70" name="newscont"></textarea></td></tr>
    <tr><td class="ff">Картинка: </td><td class="fr"><input type="text" name="myfile" style="width: 200px"><input type="button" value="Выбрать" onclick="MM_openBrWindow('cat_files.php?hide=1&target=self.opener.document.catfrm.myfile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');"></td></tr>
    <tr>
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
    	<td class="fr"><select name="newsfirst">
			<option value="0">НЕТ</option>
			<option value="1">ДА</option>
		</select></td>
	</tr>
<?php
	/*
	<tr>
		<td class="ff">В топ:</td>
    	<td class="fr"><select name="newstop">
			<option value="0">НЕТ</option>
			<option value="1">ДА</option>
		</select></td>
	</tr>
	*/
?>
<script language="javascript1.2">
    editor_generate('newscont'); // field, width, height
</script>
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
