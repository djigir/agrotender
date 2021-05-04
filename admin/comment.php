<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

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

	$strings['tipedit']['en'] = "Edit This Comment";
   	$strings['tipdel']['en'] = "Delete This Comment";
   	$strings['hdrlist']['en'] = "Comment List";
   	$strings['hdradd']['en'] = "Add Comment";
   	$strings['hdredit']['en'] = "Edit Comment";
   	$strings['rowdate']['en'] = "Comment date";
   	$strings['rowtitle']['en'] = "Name";
   	$strings['rowfirst']['en'] = "Preview Page";
   	$strings['rowtext']['en'] = "Comment Text";
   	$strings['rowbrand']['en'] = "Company Source";
   	$strings['btnadd']['en'] = "Add";
   	$strings['btndel']['en'] = "Delete";
   	$strings['btnedit']['en'] = "Edit";
   	$strings['btnrefresh']['en'] = "Update";
   	$strings['nolist']['en'] = "No comments in database";
   	$strings['rowcont']['en'] = "Content";
   	$strings['rowfunc']['en'] = "Functions";
        $strings['product']['en'] ="Product";

    $strings['tipedit']['ru'] = "Р РµРґР°РєС‚РёСЂРѕРІР°С‚СЊ СЌС‚РѕС‚ РѕС‚Р·С‹РІ";
   	$strings['tipdel']['ru'] = "РЈРґР°Р»РёС‚СЊ СЌС‚РѕС‚ РѕС‚Р·С‹РІ";
   	$strings['hdrlist']['ru'] = "РЎРїРёСЃРѕРє РѕС‚Р·С‹РІРѕРІ";
   	$strings['hdradd']['ru'] = "Р”РѕР±Р°РІРёС‚СЊ РѕС‚Р·С‹РІ";
   	$strings['hdredit']['ru'] = "Р РµРґР°РєРёСЂРѕРІР°С‚СЊ РѕС‚Р·С‹РІ";
   	$strings['rowdate']['ru'] = "Р”Р°С‚Р°";
   	$strings['rowtitle']['ru'] = "РРјСЏ";
   	$strings['rowfirst']['ru'] = "РћС‚РѕР±СЂР°Р¶Р°С‚СЊ РІ Р°РЅРѕРЅСЃРµ";
   	$strings['rowtext']['ru'] = "РўРµРєСЃС‚";
   	$strings['rowbrand']['ru'] = "РљРѕРјРїР°РЅРёСЏ";
    $strings['btnadd']['ru'] = "Р”РѕР±Р°РІРёС‚СЊ";
   	$strings['btndel']['ru'] = "РЈРґР°Р»РёС‚СЊ";
   	$strings['btnedit']['ru'] = "Р РµРґР°РєС‚РёСЂРѕРІР°С‚СЊ";
   	$strings['btnrefresh']['ru'] = "РћР±РЅРѕРІРёС‚СЊ";
   	$strings['nolist']['ru'] = "Р’ Р±Р°Р·Рµ РЅРµС‚ РѕС‚Р·С‹РІРѕРІ";
    $strings['rowcont']['ru'] = "РЎРѕРґРµСЂР¶Р°РЅРёРµ Р·Р°РїРёСЃРµР№";
   	$strings['rowfunc']['ru'] = "Р¤СѓРЅРєС†РёРё";
        $strings['product']['ru']="РџСЂРѕРґСѓРєС‚";
	$strings['article']['ru']="РЎС‚Р°С‚СЊСЏ";

	$PAGE_HEADER['ru'] = "Р РµРґР°РєС‚РёСЂРѕРІР°С‚СЊ РћС‚Р·С‹РІ";
	$PAGE_HEADER['en'] = "Comment Editing";

	

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$ntype = GetParameter("ntype", 0);

	$datest = GetParameter("datest", date("d.m.Y", time()));

	$THIS_TABLE = $TABLE_COMMENT;                        
	$THIS_TABLE_LANG = $TABLE_COMMENT_LANGS;
?>

<?php		
	switch( $action )
	{
		case "delete":
$com_id = GetParameter("com_id", "0");

			// Delete selected news
			for($i = 0; $i < count($com_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$com_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
    				if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE item_id='".$com_id[$i]."'" ) )
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
    		$newsfirst = GetParameter("newsfirst", 0);
    		//$newsbrand = GetParameter("newsbrand", 0);
    		$myfile = GetParameter("myfile", "");
		$a=getdate();
		$time=$a['hours'].":".$a['minutes'].":".$a['seconds'];
    		$db_datest = substr($datest, 6, 4)."-".substr($datest, 3, 2)."-".substr($datest, 0, 2)." ".$time;

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET show_first='$newsfirst', add_date='$db_datest', author='$newstitle' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$query = "UPDATE $THIS_TABLE_LANG SET content='".addslashes($newscont)."'
                        WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
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
		//$datest = date("d.m.Y", time());
		//$newsbrand = 0;
		$myfile = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.content, DAYOFMONTH(m1.add_date) as dd, MONTH(m1.add_date) as dm, YEAR(m1.add_date) as dy
			FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.item_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$newstitle= stripslashes($row->author);
				$newscont = stripslashes($row->content);
				$newsfirst = $row->show_first;
				//$newsbrand = $row->brand_id;
				$datest = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				
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
	<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.advfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Р’С‹Р±СЂР°С‚СЊ РґР°С‚Сѓ\" /></a></td>
	</tr></table>";
?>
</td></tr>
	<tr><td class="ff"><?=$strings['rowtitle'][$lang];?>:</td><td class="fr"><input type="text" size="70" name="newstitle" value="<?=$newstitle;?>" /></td></tr>
	<tr><td class="ff"><?=$strings['rowtext'][$lang];?>:</td><td class="fr"><textarea rows="14" cols="80" name="newscont"><?=$newscont;?></textarea></td></tr>
	
	<tr >
		<td class="ff"><?=$strings['rowfirst'][$lang];?>:</td>
		<td class="fr"><select name="newsfirst">
			<option value="0"<?=( $newsfirst == 0 ? " selected ": "" );?>>РќР•Рў</option>
			<option value="1"<?=( $newsfirst == 1 ? " selected ": "" );?>>Р”Рђ</option>
		</select></td></tr>
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
?>
    <h3><?=$strings['hdrlist'][$lang];?></h3>
<?php
/*
    <div style="padding: 10px 0px 10px 10px;">Р“СЂСѓРїРїР° РЅРѕРІРѕСЃС‚РµР№: &nbsp;
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
?>
    </div>
*/
?>
  
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="ntype" value="<?=$ntype;?>" />
    <tr><th>&nbsp;</th><th style="padding: 1px 10px 1px 20px" width="25%"><?=$strings['rowcont'][$lang];?></th><th><?=$strings['product'][$lang];?></th><th><?=$strings['article'][$lang];?></th><th><?=$strings['rowfirst'][$lang];?></th><th><?=$strings['rowfunc'][$lang];?></th></tr>
<?php
    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*
			FROM $TABLE_COMMENT m1, $TABLE_COMMENT_LANGS m2
			WHERE m1.id=m2.item_id AND m2.lang_id='$LangId'
			ORDER BY m1.add_date") )
		{
			while($row=mysqli_fetch_object($res))
			{
                            
                            $result= mysqli_query($upd_link_db,"SELECT i1.model, m2.make_name, c2.name FROM $TABLE_CAT_ITEMS i1, $TABLE_CAT_ITEMS_LANGS i2, $TABLE_CAT_MAKE m1, $TABLE_CAT_MAKE_LANGS m2, $TABLE_CAT_CATITEMS c1
                                                  INNER JOIN $TABLE_CAT_CATALOG_LANGS c2 ON c1.sect_id=c2.sect_id AND c2.lang_id='$LangId'
                                                  WHERE c1.item_id='".$row->product_id."' AND i1.id='".$row->product_id."' AND i1.id=i2.item_id AND  i2.lang_id='$LangId' AND i1.make_id=m1.id AND m1.id=m2.make_id AND m2.lang_id='$LangId'");
                            $myrow=mysqli_fetch_object($result);
							
							 $result2= mysqli_query($upd_link_db,"SELECT a2.title FROM $TABLE_ARTICLES as a INNER JOIN $TABLE_ARTICLES_LANGS as a2 ON a2.news_id=a.id WHERE a.id='".$row->article_id."'");
								$myrow2=mysqli_fetch_object($result2);
								
                            
                            $found_news++;

                            echo "<tr>
                                           <td ><input  type=\"checkbox\" name='com_id[]' value=\"".$row->id."\" /></td>
                                           <td style=\"padding: 2px 10px 2px 10px;\">
                                               <b>".stripslashes($row->author)."</b> - [".$row->add_date."]";
                                            echo "</td>
                                            <td align=\"center\" >
                                                   <b>".stripslashes($myrow->make_name)." ".stripslashes($myrow->model)."</b><br /><span style=\"font-size: 7pt;\">".$myrow->name."</span>
                                           </td>
										     <td align=\"center\" style='width:300px;'><span style=\"font-size: 7pt;\">".$myrow2->title."</span>
                                           </td>
					   
                                           <td align=\"center\" >
                                                    ".($row->show_first == 1 ? " <span style=\"font-weight: bold; color: red;\">Р”Р°</span> " : " РќРµС‚ ")."
                                           </td>
                                           <td align=\"center\">
                                            <a href=\"$PHP_SELF?action=deleteitem&ntype=".$ntype."&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                                            <a href=\"$PHP_SELF?mode=edit&ntype=".$ntype."&item_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                            </tr>
                            <tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
            mysqli_free_result($result);
			 mysqli_free_result($result2);
		}

		if( $found_news == 0 )
		{
			echo "<tr><td colspan=\"7\" align=\"center\"><br />".$strings['nolist'][$lang]."<br /><br /></td></tr>
			<tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /> <input type=\"submit\" name=\"refresh_but\" value=\" ".$strings['btnrefresh'][$lang]." \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
   
    <table align="center" cellspacing="0" cellpadding="0" border="0" class="tableborder">
    <tr><td>   	</td></tr>
    </table>

<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
