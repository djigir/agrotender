<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

	include "../inc/utils-inc.php";
    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }

	$strings['tipedit']['en'] = "Edit trader port place";
   	$strings['tipdel']['en'] = "Delete this port";
   	$strings['tipassign']['en'] = "Assign parameters to profile";

    $strings['tipedit']['ru'] = "Редактировать порты отгрузки";
   	$strings['tipdel']['ru'] = "Удалить порт из списка";
   	$strings['tipassign']['ru'] = "Прикрепить параметры к типу товара";

	$PAGE_HEADER['ru'] = "Редактировать порты для трейдеров";
	$PAGE_HEADER['en'] = "Port List Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TRADER_PR_PORTS;
	$THIS_TABLE_LANG = $TABLE_TRADER_PR_PORTS_LANGS;

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$acttype = GetParameter("acttype", 0);

	switch( $action )
	{
		case "edit":
			$item_id = GetParameter("item_id", "0");

			$orgname = "";
			$orgurl = "";
			$orgstitle = "";
			$orgsh1 = "";
			$orgsdescr = "";
			$orgurl = "";
			$orgobl = 0;
			$orgact = 0;

			$query = "SELECT p1.*, p2.portname, p2.p_content, p2.p_title, p2.p_h1, p2.p_descr 
				FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
				WHERE p1.id='$item_id' AND p1.id=p2.port_id AND p2.lang_id='$LangId'";
			if($res = mysqli_query($upd_link_db,$query))
			{
				if($row = mysqli_fetch_object($res))
				{
					$orgobl = $row->obl_id;
					$orgact = $row->active;
					$orgname = stripslashes($row->portname);										
					$orgurl = stripslashes($row->url);
					$orgstitle = stripslashes($row->p_title); 
					$orgsh1 = stripslashes($row->p_h1); 
					$orgsdescr = stripslashes($row->p_content);
					$p_descr = stripslashes($row->p_descr);
				}
				mysqli_free_result($res);
			}
			else
				echo mysqli_error($upd_link_db);

			$mode = "edit";
			break;

    	case "add":
    		$orgobl = GetParameter("orgobl", 0);
			$orgact = GetParameter("orgact", 0);
    		$orgname = GetParameter("orgname", "");
    		$orgstitle = GetParameter("orgstitle", "");
			$orgsh1 = GetParameter("orgsh1", "");
			$orgsdescr = GetParameter("orgsdescr", "", false);
			$orgurl = GetParameter("orgurl", "");
			$p_descr = GetParameter("p_descr", "");	

    		$query = "INSERT INTO $THIS_TABLE ( active, url, obl_id, add_date )
    			VALUES ('".addslashes($orgact)."', '".addslashes(trim($orgurl))."', '".addslashes($orgobl)."', NOW())";
			if(mysqli_query($upd_link_db,$query))
			{
                $newcatid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( port_id, lang_id, portname, p_title, p_h1, p_content, p_descr )
	                    VALUES ('$newcatid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgstitle)."', '".addslashes($orgsh1)."', '".addslashes($orgsdescr)."', '".addslashes($p_descr)."')" ) )
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
                    if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE port_id='".$items_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
					
					$query = "DELETE FROM $TABLE_TRADER_PR_PORTS2BUYER WHERE port_id='".$items_id[$i]."'";
					if( !mysqli_query($upd_link_db,$query) )
					{
						echo mysqli_error($upd_link_db);
					}
					
					$placeids = Array();
					$query = "SELECT DISTINCT id FROM $TABLE_TRADER_PR_PLACES WHERE port_id='".$items_id[$i]."'";
					if( $res = mysqli_query($upd_link_db,$query) )
					{
						while( $row = mysqli_fetch_object($res) )
						{
							$placeids[] = $row->id;
						}
						mysqli_free_result($res);
					}
					
					$query = "DELETE FROM $TABLE_TRADER_PR_PLACES WHERE port_id='".$items_id[$i]."'";
					if( !mysqli_query($upd_link_db,$query) )
					{
						echo mysqli_error($upd_link_db);
					}
					
					if( count($placeids) > 0 )
					{
						$query = "DELETE FROM $TABLE_TRADER_PR_PRICES WHERE place_id IN ('".implode(",", $placeids)."')";
						if( !mysqli_query($upd_link_db,$query) )
						{
							echo mysqli_error($upd_link_db);
						}
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
                if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE port_id='".$item_id."'" ) )
                {
                       echo mysqli_error($upd_link_db);
                }
				
				$query = "DELETE FROM $TABLE_TRADER_PR_PORTS2BUYER WHERE port_id='".$item_id."'";
				if( !mysqli_query($upd_link_db,$query) )
				{
					echo mysqli_error($upd_link_db);
				}
				
				$placeids = Array();
				$query = "SELECT DISTINCT id FROM $TABLE_TRADER_PR_PLACES WHERE port_id='".$item_id."'";
				if( $res = mysqli_query($upd_link_db,$query) )
				{
					while( $row = mysqli_fetch_object($res) )
					{
						$placeids[] = $row->id;
					}
					mysqli_free_result($res);
				}
				
				$query = "DELETE FROM $TABLE_TRADER_PR_PLACES WHERE port_id='".$item_id."'";
				if( !mysqli_query($upd_link_db,$query) )
				{
					echo mysqli_error($upd_link_db);
				}
				
				if( count($placeids) > 0 )
				{
					$query = "DELETE FROM $TABLE_TRADER_PR_PRICES WHERE place_id IN ('".implode(",", $placeids)."')";
					if( !mysqli_query($upd_link_db,$query) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
            }
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
			$orgobl = GetParameter("orgobl", 0);
			$orgact = GetParameter("orgact", 0);
			$orgurl = GetParameter("orgurl", "");			
			$orgstitle = GetParameter("orgstitle", "");
			$orgsh1 = GetParameter("orgsh1", "");
			$orgsdescr = GetParameter("orgsdescr", "", false);
			$p_descr = GetParameter("p_descr", "");	

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET obl_id='".$orgobl."', active='".$orgact."', url='".addslashes($orgurl)."' WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

            if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG
            	SET portname='".addslashes($orgname)."', p_title='".addslashes($orgstitle)."', p_descr='".addslashes($p_descr)."', p_h1='".addslashes($orgsh1)."', p_content='".addslashes($orgsdescr)."'
            	WHERE port_id='".$item_id."' AND lang_id='".$LangId."'" ) )
            {
            	echo mysqli_error($upd_link_db);
            }
			break;
	}

	//$cultgroups = Trader_GetCultGroups($LangId, "", $acttype);

    if( $mode == "edit" )
    {
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff">Область:</td><td class="fr"><select name="orgobl">
	<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($orgobl == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}		
	?>
	</select></td></tr>
    <tr><td class="ff">Название порта:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">URL:</td><td class="fr"><input type="text" size="50" name="orgurl" value="<?=$orgurl;?>" /></td></tr>
	<tr><td class="ff">Показывать:</td><td class="fr"><select name="orgact">
		<option value="0">Нет</option>
		<option value="1"<?=( $orgact == 1 ? ' selected' : '');?>>Да</option>
	</select></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="80" name="orgstitle" value="<?=$orgstitle;?>" /></td></tr>
	<tr><td class="ff">H1:</td><td class="fr"><input type="text" size="60" name="orgsh1" value="<?=$orgsh1;?>" /></td></tr>
    <tr><td class="ff">Текстовка:</td><td class="fr"><textarea cols="60" rows="4" name="orgsdescr"><?=$orgsdescr;?></textarea></td></tr>	
    <tr><td class="ff">Описание:</td><td class="fr"><textarea cols="60" rows="4" name="p_descr"><?=$p_descr;?></textarea></td></tr>	
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
		//echo "LangId = $LangId<br />";
?>
    <h3>Перечень портов в базе</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Область</th>    	
    	<th>Название</th>
		<th>URL</th>
		<th>Активн.</th>
    	<th>Функции</th>
    </tr>
    <?
		$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.portname 
			FROM $THIS_TABLE p1
			INNER JOIN $THIS_TABLE_LANG p2 ON p1.id=p2.port_id AND p2.lang_id='$LangId'
			ORDER BY p1.obl_id, p2.portname") )
		{
			while($row=mysqli_fetch_object($res))
			{
				$found_items++;

				echo "<tr>
				<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>				
				<td>".$REGIONS[$row->obl_id]."</td>
				<td style=\"padding: 1px 10px 1px 10px\">
					<b>".stripslashes($row->portname)."</b>
				</td>
				<td align=\"center\">".stripslashes($row->url)."</td>
				<td align=\"center\">".( $row->active == 1 ? "Да" : '<span style="color: red;">Нет</span>' )."</td>
				<td align=\"center\">
					<a onclick='return confirm(\"При удаление вся информация связанная с &lt;".stripslashes($row->portname)."&gt; будет удалена.\\r\\nУдалить ".stripslashes($row->portname)."?\")' href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\" title=\"".$strings['tipdel'][$lang]."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
					<a href=\"$PHP_SELF?action=edit&item_id=".$row->id."\" title=\"".$strings['tipedit'][$lang]."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>
				</td>
				</tr>
				<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
			mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"6\" align=\"center\"><br />В базе нет портов<br /><br /></td></tr>
			<tr><td colspan=\"6\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"6\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить новый порт</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
	<tr><td class="ff">Область:</td><td class="fr"><select name="orgobl">
	<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($orgobl == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}		
	?>
	</select></td></tr>
    <tr><td class="ff">Название порта:</td><td class="fr"><input type="text" size="70" name="orgname" value="" /></td></tr>
    <tr><td class="ff">URL:</td><td class="fr"><input type="text" size="50" name="orgurl" value="" /></td></tr>
	<tr><td class="ff">Показывать:</td><td class="fr"><select name="orgact">
		<option value="0">Нет</option>
		<option value="1"<?=( $orgact == 1 ? ' selected' : '');?>>Да</option>
	</select></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="80" name="orgstitle" value="" /></td></tr>
	<tr><td class="ff">H1:</td><td class="fr"><input type="text" size="60" name="orgsh1" value="" /></td></tr>
    <tr><td class="ff">Описание:</td><td class="fr"><textarea cols="60" rows="4" name="orgsdescr"></textarea></td></tr>		
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
