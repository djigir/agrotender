<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit vehicle params";
   	$strings['tipdel']['en'] = "Delete this vehicle parameter";

    $strings['tipedit']['ru'] = "Редактировать опции ";
   	$strings['tipdel']['ru'] = "Удалить опцию из списка";

	$PAGE_HEADER['ru'] = "Редактировать Опции ";
	$PAGE_HEADER['en'] = "Vehicle Parameters Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TORG_PARAMS;
	$THIS_TABLE_LANG = $TABLE_TORG_PARAMS_LANGS;
	$THIS_TABLE_DISP = $TABLE_TORG_PARAM_DISP_TYPE;
	$THIS_TABLE_OPTS = $TABLE_TORG_PARAM_OPTIONS;
	$THIS_TABLE_OPTS_LANG = $TABLE_TORG_PARAM_OPTIONS_LANGS;

	////////////////////////////////////////////////////////////////////////////
	// Extract field types from database
	$disptypes[] = Array();
	$disptypes_num = 0;
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$param_id = GetParameter("param_id", 0);
	$orgname = GetParameter("orgname", "");
	$orgsort = GetParameter("orgsort", "");

	$query = "SELECT * FROM $THIS_TABLE_DISP ORDER BY id";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
	    while( $row = mysqli_fetch_object($res) )
	    {
			$disptypes[$disptypes_num]['id'] = $row->id;
			$disptypes[$disptypes_num]['name'] = stripslashes($row->name);

			$disptypes_num++;
	    }
	    mysqli_free_result($res);
	}
	////////////////////////////////////////////////////////////////////////////
	$param_name = "Uknown";
	$param_is_filter = false;
	$query = "SELECT p1.*, p2.name, p2.izm, p2.sample
			    FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
			    WHERE p1.id='$param_id' AND p1.id=p2.param_id AND p2.lang_id='$LangId'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
	    if( $row = mysqli_fetch_object($res) )
	    {
		    $param_name = stripslashes($row->name);
		    if( $row->isbasic == 3 )
			    $param_is_filter = true;
	    }
	    mysqli_free_result($res);
	}

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$param_id = GetParameter("param_id", 0);
	$orgname = GetParameter("orgname", "");
	$orgsort = GetParameter("orgsort", "");

	switch( $action )
	{
    	case "add":
    		$query = "INSERT INTO $THIS_TABLE_OPTS ( param_id, sort_ind )
    			VALUES ('".$param_id."', '".addslashes($orgsort)."')";
			if(mysqli_query($upd_link_db,$query))
			{
                $newoptid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_OPTS_LANG ( option_id, lang_id, option_text )
	                    VALUES ('$newoptid', '".$langs[$i]."', '".addslashes($orgname)."')" ) )
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
		case "change":
			$delete_but = GetParameter("delete_but", "");
			$apply_but = GetParameter("apply_but", "");

			if( $delete_but != "" )
			{
            	// The delete button was pressed
            	$items_id = GetParameter("items_id", "");
	            for($i = 0; $i < count($items_id); $i++)
	            {
	                if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE_OPTS WHERE id=".$items_id[$i]." "))
	                {
	                    echo "<b>".mysqli_error($upd_link_db)."</b>";
	                }
	                else
	                {
	                    if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_OPTS_LANG
	                        WHERE option_id='".$items_id[$i]."'" ) )
	                    {
	                       echo mysqli_error($upd_link_db);
	                    }

	                    if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_VALUES_OPTS
	                        WHERE option_id='".$items_id[$i]."'" ) )
	                    {
	                       echo mysqli_error($upd_link_db);
	                    }
	                }

	                // Here all vehicle items should be unassigned to 0 profile id
	            }
	            break;
            }

            if( $apply_but != "" )
            {
            	// The apply button was pressed
            	$option_id = GetParameter("option_id", null);
            	$orgname = GetParameter("orgname", null);
            	$orgname2 = GetParameter("orgname2", null);
            	$orgsort = GetParameter("orgsort", null);

            	for( $i=0; $i<count($option_id); $i++ )
            	{
            		$icofile = GetParameter("myfile".$option_id[$i], "");
                    if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE_OPTS
                        SET sort_ind='".$orgsort[$i]."', icofile='".addslashes($icofile)."'
                        WHERE id='".$option_id[$i]."'"))
            	    {
	                    echo "<b>".mysqli_error($upd_link_db)."</b>";
	                }

	                if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_OPTS_LANG
	                    SET option_text='".addslashes($orgname[$i])."'
	                    WHERE option_id='".$option_id[$i]."' AND lang_id='".$LangId."'" ) )
	                {
	                    echo mysqli_error($upd_link_db);
	                }
                }
                break;
            }

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
            if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE_OPTS WHERE id=".$item_id." "))
			{
        		echo "<b>".mysqli_error($upd_link_db)."</b>";
    		}
    		else
    		{
                if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_OPTS_LANG
                	WHERE option_id='".$item_id."'" ) )
                {
                	echo mysqli_error($upd_link_db);
                }

                if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_VALUES_OPTS
                	WHERE option_id='".$item_id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
            }
			break;

		case "update":
			$item_id = GetParameter("item_id", "");

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET min_val='".addslashes($orgmin)."',
                        max_val='".addslashes($orgmax)."', isbasic='".addslashes($orgbasic)."',
                        param_display_type_id='".$orgdispid."'
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

            if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG
            	SET name='".addslashes($orgname)."', izm='".addslashes($orgizm)."',
                        sample='".addslashes($orgsample)."'
            	WHERE param_id='".$item_id."' AND lang_id='".$LangId."'" ) )
            {
            	echo mysqli_error($upd_link_db);
            }
			break;
	}

	if( is_array($orgname) )	$orgname = "";
	if( is_array($orgsort) )	$orgsort = "0";


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orgizm = "";
		$orgsample = "";
		$orgmin = "0";
		$orgmax = "";
		$orgbasic = "1";
		$orgdispid = "1";

		if($res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.izm, p2.sample
			FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
			WHERE p1.id='$item_id' AND p1.id=p2.param_id AND p2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->name);
				$orgizm = stripslashes($row->izm);
				$orgsample = stripslashes($row->sample);
				$orgmin = stripslashes($row->min_val);
				$orgmax = stripslashes($row->max_val);
				$orgbasic = stripslashes($row->isbasic);
				$orgdispid = $row->param_display_type_id;
			}
			mysqli_free_result($res);
		}
?>

	<h3>Редактировать</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
    <tr><td class="ff">Название опции:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>>
    <tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="10" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
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
    <h3>Список опций параметра &quot;<?=$param_name;?>&quot;</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method=POST>
    <input type="hidden" name="action" value="change" />
    <input type="hidden" name="param_id" value="<?=$param_id;?>">
    <tr>
    	<th>&nbsp;</th>
    	<th>№ Сорт</th>
    	<th>Название Опции</th>
	<?php
    	if( $param_is_filter )
    	{
    		echo '<th>Иконка</th>';
    		echo '<th>Файл иконки</th>';
    	}
    ?>
    	<th colspan="2">Функции</th>
    </tr>
<?php
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT o1.*, o2.option_text
			FROM $THIS_TABLE_OPTS o1, $THIS_TABLE_OPTS_LANG o2
			WHERE o1.param_id='$param_id' AND o1.id=o2.option_id AND o2.lang_id='$LangId' ORDER BY o1.sort_ind, o2.option_text") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
            			<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
            			<td><input type=\"hidden\" name=\"option_id[]\" value=\"".$row->id."\" />
            				<input type=\"text\" name=\"orgsort[]\" size=\"2\" value=\"".$row->sort_ind."\"></td>
                     	<td><input type=\"text\" name=\"orgname[]\" size=\"32\" value=\"".stripslashes($row->option_text)."\"></td>";
                if( $param_is_filter )
                {
                	$ico = "";
                	if( ($row->icofile != null) && ($row->icofile != "") )
                	{
						$ico = stripslashes($row->icofile);
                	}
                	echo '<td>'.($ico != "" ? '<img src="'.$WWWHOST.'files/'.$ico.'" alt="" />' : ' &nbsp; ').'</td>';
                	echo '<td><input type="text" name="myfile'.$row->id.'" id="myfile'.$row->id.'" value="'.$ico.'" style="width: 200px"><input type="button" value="Выбрать" onclick="MM_openBrWindow(\'cat_files.php?hide=1&target=self.opener.document.catfrm.myfile'.$row->id.'\',\'winfiles\',\'width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes\');"></td>';
                }
                echo "<td align=\"center\">
                            <a href=\"javascript:Delet('$PHP_SELF?action=deleteitem&param_id=$param_id&item_id=".$row->id."')\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                        </td>
                </tr>";

                // <a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;

                /*
                echo "
<form action=\"$PHP_SELF\" method=\"post\">
<input type=\"hidden\" name=\"item_id\" value=\"".$row->id."\">
<input type=\"hidden\" name=\"action\" value=\"save\">
<tr>
	<td><input type=\"text\" name=\"orgsort\" size=\"2\" value=\"".$row->sort_ind."\"></td>
	<td><input type=\"text\" name=\"orgname\" size=\"40\" value=\"".stripslashes($row->name)."\"></td>
	<td><input type=\"text\" name=\"orgizm\" size=\"8\" value=\"".stripslashes($row->izm)."\"></td>
	<td><input type=\"text\" name=\"orgsample\" size=\"30\" value=\"".stripslashes($row->sample)."\"></td>
	<td><select name=\"orgbasic\">
       <option value=\"1\" ".($row->isbasic==1?" selected":"").">Основное</option>
       <option value=\"2\" ".($row->isbasic==2?" selected":"").">Второстепен.</option>
	</select></td>
	<td><input type=\"submit\" value=\"Сохранить\"></td>
	<td><input type=\"button\" onclick=\"javascript:Delet('$PHP_SELF?action=deleteitem&item_id=".$row['param_id']."');\" value=\"Удалить\"></td>
</tr></form>";
				*/

                echo "<tr><td colspan=\"".( $param_is_filter ? 7 : 5 )."\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"".( $param_is_filter ? 7 : 5 )."\" align=\"center\"><br />В базе нет ни одной опции для параметра<br /><br /></td></tr>
			<tr><td colspan=\"".( $param_is_filter ? 7 : 5 )."\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"".( $param_is_filter ? 7 : 5 )."\">
        		<input type=\"submit\" name=\"delete_but\" value=\" Удалить \" />
        		<input type=\"submit\" name=\"apply_but\" value=\" Применить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Новую Опцию для Параметра &quot;<?=$param_name;?>&quot;</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm2" method="POST">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="param_id" value="<?=$param_id;?>">
    <tr><td class="ff">Название опции:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="3" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>

	<div style="text-align: center; padding: 20px 0px 20px 0px;"><a href="torg_params.php">Вернуться к списку параметров</a></div>
<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
