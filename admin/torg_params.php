<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit product params";
   	$strings['tipdel']['en'] = "Delete this parameter";

    $strings['tipedit']['ru'] = "Редактировать параметры культуры";
   	$strings['tipdel']['ru'] = "Удалить параметр из списка";

	$PAGE_HEADER['ru'] = "Редактировать Параметры Культур";
	$PAGE_HEADER['en'] = "Product Parameters Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TORG_PARAMS;
	$THIS_TABLE_LANG = $TABLE_TORG_PARAMS_LANGS;
	$THIS_TABLE_DISP = $TABLE_TORG_PARAM_DISP_TYPE;

function CatAdmin_ParamDel($param_id)
{
	global $TABLE_TORG_PARAMS, $TABLE_TORG_PARAMS_LANGS, $TABLE_TORG_PARAM_DISP_TYPE, $TABLE_TORG_PARAM_OPTIONS, $TABLE_TORG_PARAM_OPTIONS_LANGS,
			$TABLE_TORG_PARAM_VALUES, $TABLE_TORG_PARAM_VALUES_OPTS, $TABLE_TORG_PROFILE_PARAMS,
			$FIELD_TYPE_OPTIONS;

	$par_disp_type = 0;
	$query = "SELECT * FROM $TABLE_TORG_PARAMS WHERE id=".$param_id." ";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$par_disp_type = $row->param_display_type_id;
		}
		mysqli_free_result( $res );
	}

	if( $par_disp_type == 0 )
		return false;


	$query = "SELECT o1.* FROM $TABLE_TORG_PARAM_OPTIONS o1 WHERE o1.param_id='".$param_id."'";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			if( $par_disp_type == $FIELD_TYPE_OPTIONS )
			{
				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_VALUES_OPTS WHERE option_id='".$row->id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
			}

			if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_OPTIONS_LANGS WHERE option_id='".$row->id."'" ) )
			{
			   echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}

	if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_OPTIONS WHERE param_id='".$param_id."'" ) )
	{
	   echo mysqli_error($upd_link_db);
	}

	if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_VALUES WHERE param_id='".$param_id."'" ) )
	{
	   echo mysqli_error($upd_link_db);
	}

	if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PROFILE_PARAMS WHERE param_id='".$param_id."'" ) )
	{
	   echo mysqli_error($upd_link_db);
	}

	if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_TORG_PARAMS WHERE id=".$param_id." "))
	{
		echo "<b>".mysqli_error($upd_link_db)."</b>";
	}
	else
	{
		if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAMS_LANGS WHERE param_id='".$param_id."'" ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}

	return true;
}

	////////////////////////////////////////////////////////////////////////////
	// Extract field types from database
	$disptypes[] = Array();
	$disptypes_num = 0;

    $query = "SELECT * FROM $THIS_TABLE_DISP ORDER BY id";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$disptypes[$disptypes_num]['id'] = $row->id;
			$disptypes[$disptypes_num]['name'] = stripslashes($row->name);

			//echo $row->name." | ".stripslashes($row->name)."<br />";

			$disptypes_num++;
        }
        mysqli_free_result($res);
    }

    //var_dump( $disptypes );
	////////////////////////////////////////////////////////////////////////////

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

    $orgname = GetParameter("orgname", "");
    $orgizm = GetParameter("orgizm", "");
    $orgsample = GetParameter("orgsample", "");
    $orgmin = GetParameter("orgmin", "");
    $orgmax = GetParameter("orgmax", "");
	$orgbasic = GetParameter("orgbasic", "");
	$orgdispid = GetParameter("orgdispid", 1);

	switch( $action )
	{
    	case "add":
    		$query = "INSERT INTO $THIS_TABLE ( min_val, max_val, isbasic, param_display_type_id )
    			VALUES ('".addslashes($orgmin)."', '".addslashes($orgmax)."', '".addslashes($orgbasic)."',
    			'".addslashes($orgdispid)."')";
			if(mysqli_query($upd_link_db,$query))
			{
                $newparid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( param_id, lang_id, name, izm, sample )
	                    VALUES ('$newparid', '".$langs[$i]."', '".addslashes($orgname)."',
	                    '".addslashes($orgizm)."', '".addslashes($orgsample)."')" ) )
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
				CatAdmin_ParamDel($items_id[$i]);
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", 0);
			CatAdmin_ParamDel($item_id);
			break;

		case "save":
			$item_id = GetParameter("item_id", "");

            if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET isbasic='".addslashes($orgbasic)."'
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
    <tr><td class="ff">Название параметра:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Единица измерения:</td><td class="fr"><input type="text" size="10" name="orgizm" value="<?=$orgizm;?>" /></td></tr>
    <tr><td class="ff">Пример ввода:</td><td class="fr"><input type="text" size="70" name="orgsample" value="<?=$orgsample;?>" /></td></tr>
    <tr><td class="ff">Min значение:</td><td class="fr"><input type="text" size="10" name="orgmin" value="<?=$orgmin;?>" /></td></tr>
    <tr><td class="ff">Max значение:</td><td class="fr"><input type="text" size="10" name="orgmax" value="<?=$orgmax;?>" /></td></tr>
    <tr><td class="ff">Важность:</td><td class="fr">
    	<select name="orgbasic">
    		<option value="1"<?=( $orgbasic == 1 ? " selected" : "");?>>Основное</option>
    		<option value="2"<?=( $orgbasic == 2 ? " selected" : "");?>>Второстепенное</option>
		<option value="3"<?=( $orgbasic == 3 ? " selected" : "");?>>Иконка для опций</option>
    	</select>
    </td></tr>
    <tr><td class="ff">Вид отображения:</td><td class="fr">
    	<select name="orgdispid">
<?php
		for($i=0; $i<count($disptypes); $i++)
		{
        	echo "<option value=\"".$disptypes[$i]['id']."\"".($disptypes[$i]['id'] == $orgdispid ? " selected" : "").">".$disptypes[$i]['name']."</option>";
        }
?>
    	</select>
    </td></tr>
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
    <h3>Список параметров для всех культур</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>ID</th>
    	<th>Название параметра</th>
    	<th>Ед. изм.</th>
    	<th>Пример использвония</th>
    	<th>Тип</th>
    	<th>Важность</th>
    	<th colspan="2">Функции</th>
    	<th>Дополн.</th>
    </tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.izm, p2.sample, d1.name as ptname, count(o1.id) as totopts
			FROM $THIS_TABLE p1
			INNER JOIN $THIS_TABLE_LANG p2 ON p1.id=p2.param_id AND p2.lang_id='$LangId'
			INNER JOIN $TABLE_TORG_PARAM_DISP_TYPE d1 ON p1.param_display_type_id=d1.id
			LEFT JOIN $TABLE_TORG_PARAM_OPTIONS o1 ON p1.id=o1.param_id
			GROUP BY p1.id
			ORDER BY p2.name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

                /*
            	echo "<tr>
                     	<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                     	<td>";
                     	  echo "</td>
                               <td style=\"padding: 1px 10px 1px 10px\">
                                   <b>".stripslashes($row->type_name)."</b><br />
                                   ".nl2br(stripslashes($row->descr))."<br />
                               </td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>
                </tr>";
                */

                echo "
<form action=\"$PHP_SELF\" method=\"post\">
<input type=\"hidden\" name=\"item_id\" value=\"".$row->id."\">
<input type=\"hidden\" name=\"action\" value=\"save\">
<tr>
	<td>".stripslashes($row->id)."</td>
	<td><input type=\"text\" name=\"orgname\" size=\"37\" value=\"".stripslashes($row->name)."\"></td>
	<td><input type=\"text\" name=\"orgizm\" size=\"8\" value=\"".stripslashes($row->izm)."\"></td>
	<td><input type=\"text\" name=\"orgsample\" size=\"26\" value=\"".stripslashes($row->sample)."\"></td>
	<td style=\"padding: 0px 8px 0px 8px;\">".stripslashes($row->ptname)."</td>
	<td><select name=\"orgbasic\">
       <option value=\"1\" ".($row->isbasic==1?" selected":"").">Основное</option>
       <option value=\"2\" ".($row->isbasic==2?" selected":"").">Второстепен.</option>
       <option value=\"3\" ".($row->isbasic==3?" selected":"").">Иконка для опций</option>
	</select></td>
	<td><input type=\"submit\" value=\"Сохранить\"></td>
	<td><input type=\"button\" onclick=\"javascript:Delet('$PHP_SELF?action=deleteitem&item_id=".$row->id."');\" value=\"Удалить\"></td>
	<td align=\"center\">".( (
		($row->param_display_type_id == $FIELD_TYPE_SELECT) ||
		($row->param_display_type_id == $FIELD_TYPE_OPTIONS) ||
		($row->param_display_type_id == $FIELD_TYPE_RADIO)
		) ? "<a href=\"torg_params_opt.php?param_id=".$row->id."\">Опции</a> (".$row->totopts.")" : "" )."</td>
</tr></form>";

                echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"8\" align=\"center\"><br />В базе нет ни одного параметра для товаров<br /><br /></td></tr>
			<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"8\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Новый Параметр</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название параметра:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Единица измерения:</td><td class="fr"><input type="text" size="10" name="orgizm" value="<?=$orgizm;?>" /></td></tr>
    <tr><td class="ff">Пример ввода:</td><td class="fr"><input type="text" size="70" name="orgsample" value="<?=$orgsample;?>" /></td></tr>
    <tr><td class="ff">Min значение:</td><td class="fr"><input type="text" size="10" name="orgmin" value="<?=$orgmin;?>" /></td></tr>
    <tr><td class="ff">Max значение:</td><td class="fr"><input type="text" size="10" name="orgmax" value="<?=$orgmax;?>" /></td></tr>
    <tr><td class="ff">Важность:</td><td class="fr">
    	<select name="orgbasic">
    		<option value="1"<?=( $orgbasic == 1 ? " selected" : "");?>>Основное</option>
    		<option value="2"<?=( $orgbasic == 2 ? " selected" : "");?>>Второстепенное</option>
		<option value="3"<?=( $orgbasic == 3 ? " selected" : "");?>>Иконка для опций</option>
    	</select>
    </td></tr>
    <tr><td class="ff">Вид отображения:</td><td class="fr">
    	<select name="orgdispid">
<?php
		for($i=0; $i<count($disptypes); $i++)
		{
        	echo "<option value=\"".$disptypes[$i]['id']."\"".($disptypes[$i]['id'] == $orgdispid ? " selected" : "").">".$disptypes[$i]['name']."</option>";
        }
?>
    	</select>
    </td></tr>
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
