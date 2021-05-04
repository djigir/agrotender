<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";
        include "../inc/catutils-inc.php";

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

    $strings['tipedit']['ru'] = "Редактировать этого консультанта";
   	$strings['tipdel']['ru'] = "Удалить этого консультанта";
   	$strings['hdrlist']['ru'] = "Список консультантов";
   	$strings['hdradd']['ru'] = "Добавить консультанта";
   	$strings['hdredit']['ru'] = "Редакировать консультанта";
   	$strings['rowtitle']['ru'] = "Город";
   	$strings['rowtext']['ru'] = "Комментарии";
   	$strings['rowsort']['ru'] = "Порядковый номер";
    $strings['btnadd']['ru'] = "Добавить";
   	$strings['btndel']['ru'] = "Удалить";
   	$strings['btnedit']['ru'] = "Редактировать";
   	$strings['btnrefresh']['ru'] = "Обновить";
   	$strings['nolist']['ru'] = "В базе нет консультантов";
    $strings['rowcont']['ru'] = "Консульнтанты";
   	$strings['rowfunc']['ru'] = "Функции";

	$PAGE_HEADER['ru'] = "Редактировать список консультантов";
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
    		$cname = GetParameter("cname", "");
    		$cicq = GetParameter("cicq", "");
    		$cprodtype = GetParameter("catsect", "");
    		$cphone = GetParameter("cphone", "");
    		$sortnum = GetParameter("sortnum", "");

    		//$newstitle = str_replace("\"","&quot;", $newstitle);

    		$query = "INSERT INTO $TABLE_OFFICES ( sort_num) VALUES ('".$sortnum."')";
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
                		name, icq, prodtype, phone)
	                    VALUES ('$newsectid', '".$langs[$i]."', '".addslashes($cname)."', '".addslashes($cicq)."',
	                    '".addslashes($cprodtype)."', '".addslashes($cphone)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }
			}
			break;

			case "update":
			$item_id = GetParameter("item_id", 0);
			$cname = GetParameter("cname", "");
			$cicq = GetParameter("cicq", "");
			$cprodtype = GetParameter("catsect", "");
			$cphone = GetParameter("cphone", "");
			$sortnum = GetParameter("sortnum", "");

				if(!mysqli_query($upd_link_db,"UPDATE $TABLE_OFFICES SET sort_num='".$sortnum."'
					WHERE id=".$item_id." "))
				{
					echo "<b>".mysqli_error($upd_link_db)."</b>";
				}

				if(!mysqli_query($upd_link_db,"UPDATE $TABLE_OFFICES_LANG SET name='".addslashes($cname)."', icq='".addslashes($cicq)."',
					prodtype='".addslashes($cprodtype)."', phone='".addslashes($cphone)."'
					WHERE office_id=".$item_id." AND lang_id='$LangId'"))
				{
					echo "<b>".mysqli_error($upd_link_db)."</b>";
				}
				break;


		case "delete":

			$news_id = GetParameter("news_id", "");
			if($news_id==""){
				echo "<b>Выберите консультанта</b>";
				break;
			}
			// Delete selected news
			for($i = 0; $i < count($news_id); $i++)
			{
    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_OFFICES WHERE id=".$news_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}

    			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_OFFICES_LANG WHERE office_id=".$news_id[$i]." "))
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
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$cname = "";
		$cicq = "";
		$cphone = "";
		$cprodtype = "";
		$sortnum = 0;


		if($res = mysqli_query($upd_link_db,"SELECT s1.*, s2.name, s2.icq, s2.prodtype, s2.phone
			FROM $TABLE_OFFICES s1
			INNER JOIN $TABLE_OFFICES_LANG s2 ON s1.id=s2.office_id AND s2.lang_id='$LangId'
			WHERE s1.id=$item_id"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$cname = stripslashes($row->name);
				$cicq = stripslashes($row->icq);
				$cprodtype = stripslashes($row->prodtype);
				$cphone = stripslashes($row->phone);
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
	<tr><td class="ff">Имя:</td><td class="fr"><input type="text" size="70" name="cname" value="<?=$cname;?>" /></td></tr>
	<tr><td class="ff">ICQ:</td><td class="fr"><input type="text" size="70" name="cicq" value="<?=$cicq;?>" /></td></tr>
	<tr><td class="ff">Телефоны:</td><td class="fr"><input type="text" size="40" name="cphone" value="<?=$cphone;?>" /></td></tr>
	<!--<tr><td class="ff">Тип продукта:</td><td class="fr"><select name="catsect">
								<option value="0">Служба доставки</option>
									<?php
									/*
											$THIS_TABLE = $TABLE_CAT_CATALOG;
											$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
											$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;
											PrintWorkCatalog(0, $LangId, 1, "select", $cprodtype);
											*/
									?>
								</select>
	</td></tr>-->
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
    	<th style="padding: 1px 10px 1px 20px;"><?=$strings['rowcont'][$lang];?></th>
    	<th style="text-align:left;">Контакты</th>
    	<th><?=$strings['rowfunc'][$lang];?></th>
    </tr>
    <?

    	$found_news = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT s1.*, s2.name, s2.phone, s2.icq, s2.prodtype
			FROM $TABLE_OFFICES s1
			INNER JOIN $TABLE_OFFICES_LANG s2 ON s1.id=s2.office_id AND s2.lang_id='$LangId'
			ORDER BY s1.sort_num") )
		{
			while( $row = mysqli_fetch_object($res) )
			{
                $found_news++;

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"news_id[]\" value=\"".$row->id."\" /></td>
                               <td style=\"padding: 2px 10px 2px 10px\"><b>".stripslashes($row->name)."</b>";
			       if($row->prodtype!=0){
					if( $res1 = mysqli_query($upd_link_db,"SELECT s2.name FROM $TABLE_CAT_CATALOG as s1, $TABLE_CAT_CATALOG_LANGS as s2 WHERE s1.id=s2.sect_id AND s1.id=".$row->prodtype) )
					 {
						 $row1 = mysqli_fetch_object($res1);
						 if($row1->name!=""){
							 $prodname=$row1->name;
						 }else{
							 $prodname="";
						 }
					 }
			       }else{
				$prodname="Служба поддержки";
			       }

				echo "</td>
                               <td>Телефоны: ".stripslashes($row->phone)."<br />
			       ICQ:".stripslashes($row->icq)."
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
        	echo "<tr><td align=\"center\" colspan=\"4\"><input type=\"submit\" name=\"delete_but\" value=\" ".$strings['btndel'][$lang]." \" /></td></tr>";
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
    <tr><td class="ff">Имя:</td><td class="fr"><input type="text" size="70" name="cname" /></td></tr>
    <tr><td class="ff">ICQ</td><td class="fr"><input type="text" size="70" name="cicq"  /></td></tr>
<tr><td class="ff">Телефоны:</td><td class="fr"><input type="text" size="40" name="cphone"  /></td></tr>
 <!--<tr><td class="ff">Тип продукта:</td><td class="fr"><select name="catsect">
				<option value="0">Служба доставки</option>
					<?php
					/*
							$THIS_TABLE = $TABLE_CAT_CATALOG;
							$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
							$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;
							PrintWorkCatalog(0, $LangId, 1, "select", $catsect);
							*/
					?>
				</select></td></tr>  -->
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
