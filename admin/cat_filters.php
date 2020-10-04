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

	$strings['tipedit']['ru'] = "Редактировать фильтры товаров";
	$strings['tipdel']['ru'] = "Удалить фильтр из списка";

	$PAGE_HEADER['ru'] = "Редактировать Фильтры Товаров";
	$PAGE_HEADER['en'] = "Product Parameters Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE 		= $TABLE_CAT_FILTERS;
	$THIS_TABLE_LANG	= $TABLE_CAT_FILTERS_LANGS;
	$THIS_TABLE_DISP	= $TABLE_CAT_PARAM_DISP_TYPE;
	$THIS_TABLE_PROF	= $TABLE_CAT_PROFILE;
	$THIS_TABLE_PROFL	= $TABLE_CAT_PROFILE_LANGS;
	$THIS_TABLE_P2P		= $TABLE_CAT_PROFILE_FILTERS;

function CatAdmin_FilterDel($param_id)
{
	global $TABLE_CAT_FILTERS, $TABLE_CAT_FILTERS_LANGS, $TABLE_CAT_PROFILE_FILT_OPTIONS, $TABLE_CAT_PROFILE_FILT_OPTIONS_LANGS,
			$TABLE_CAT_FILTER_VALUES, $TABLE_CAT_FILTER_VALUES_OPTS, $TABLE_CAT_PROFILE_FILTERS,
			$FIELD_TYPE_OPTIONS;

	$par_disp_type = 0;
	$query = "SELECT * FROM $TABLE_CAT_FILTERS WHERE id=".$param_id." ";
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


	$query = "SELECT o1.* FROM $TABLE_CAT_PROFILE_FILT_OPTIONS o1 WHERE o1.param_id='".$param_id."'";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			if( $par_disp_type == $FIELD_TYPE_OPTIONS )
			{
				if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_FILTER_VALUES_OPTS WHERE option_id='".$row->id."'" ) )
				{
				   echo mysqli_error($upd_link_db);
				}
			}

			if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_PROFILE_FILT_OPTIONS_LANGS WHERE option_id='".$row->id."'" ) )
			{
			   echo mysqli_error($upd_link_db);
			}
		}
		mysqli_free_result( $res );
	}

	if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_PROFILE_FILT_OPTIONS WHERE param_id='".$param_id."'" ) )
	{
	   echo mysqli_error($upd_link_db);
	}

	if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_FILTER_VALUES WHERE param_id='".$param_id."'" ) )
	{
	   echo mysqli_error($upd_link_db);
	}

	if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_PROFILE_FILTERS WHERE param_id='".$param_id."'" ) )
	{
	   echo mysqli_error($upd_link_db);
	}

	if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_CAT_FILTERS WHERE id=".$param_id." "))
	{
		echo "<b>".mysqli_error($upd_link_db)."</b>";
	}
	else
	{
		if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_FILTERS_LANGS WHERE param_id='".$param_id."'" ) )
		{
			echo mysqli_error($upd_link_db);
		}
	}

	return true;
}

	////////////////////////////////////////////////////////////////////////////
	// Extract field types from database
	$disptypes = Array();

	//$query = "SELECT * FROM $THIS_TABLE_DISP WHERE id=2 OR id=3 OR id=4 ORDER BY id";
	$query = "SELECT * FROM $THIS_TABLE_DISP WHERE id=2 OR id=3 ORDER BY id";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$di = Array();
			$di['id'] = $row->id;
			$di['name'] = stripslashes($row->name);
			$disptypes[] = $di;
		}
		mysqli_free_result($res);
	}
	////////////////////////////////////////////////////////////////////////////

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$profid = GetParameter("profid", "0");
	$orgname = GetParameter("orgname", "");
	$orgizm = GetParameter("orgizm", "");
	$orgsample = GetParameter("orgsample", "");
	$orgmin = GetParameter("orgmin", "");
	$orgmax = GetParameter("orgmax", "");
	$orgbasic = GetParameter("orgbasic", "");
	$orgdispid = GetParameter("orgdispid", 1);
	$sort_filter = GetParameter("sort_filter", 0);

	switch( $action )
	{
		case "add":
			$query = "INSERT INTO $THIS_TABLE ( isbasic, param_display_type_id, sort_filter )
				VALUES ('".addslashes($orgbasic)."', '".addslashes($orgdispid)."', '".addslashes($sort_filter)."')";
			if(mysqli_query($upd_link_db,$query))
			{
				$item_id = $newparid = mysqli_insert_id($upd_link_db);

				for( $i=0; $i<count($langs); $i++ )
				{
					if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( param_id, lang_id, name, izm, sample )
					    VALUES ('$newparid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgizm)."', '".addslashes($orgsample)."')" ) )
					{
					   echo mysqli_error($upd_link_db);
					}
				}

				if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_P2P (profile_id, param_id, sort_ind) VALUES
						('".$profid."', '".$item_id."', '".$sort_filter."')" ) )
				{
					echo mysqli_error($upd_link_db);
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
				CatAdmin_FilterDel( $items_id[$i] );
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
			CatAdmin_FilterDel( $item_id );
			break;

		case "update":
		case "save":
			$item_id = GetParameter("item_id", "");

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET isbasic='".addslashes($orgbasic)."', sort_filter='".addslashes($sort_filter)."'
				WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG SET name='".addslashes($orgname)."', izm='".addslashes($orgizm)."',
				sample='".addslashes($orgsample)."'
				WHERE param_id='".$item_id."' AND lang_id='".$LangId."'" ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "SELECT p1.id	FROM $THIS_TABLE_P2P p1	WHERE p1.profile_id='".$profid."' AND p1.param_id='".$item_id."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				if( $row = mysqli_fetch_object( $res ) )
				{
					if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_P2P SET sort_ind='".$sort_filter."' WHERE id='".$row->id."'" ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				else
				{
					if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_P2P (profile_id, param_id, sort_ind) VALUES
						('".$profid."', '".$item_id."', '".$sort_filter."')" ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				mysqli_free_result( $res );
			}
			break;
	}

	if( $profid == 0 )
	{
?>
		<h3>Необходимо выбрать тип товаров</h3>
		<table align="center" cellspacing="2" cellpadding="0">
		<form action="<?=$PHP_SELF;?>" method=POST>
		<tr>
			<td class="ff">Тип товаров:</td>
			<td class="fr">
				<select name="profid">
<?php
		$query = "SELECT p1.*, p2.type_name, p2.descr
			FROM $THIS_TABLE_PROF p1, $THIS_TABLE_PROFL p2
			WHERE p1.id=p2.profile_id AND p2.lang_id='$LangId'
			ORDER BY p2.type_name";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
		    {
		    	echo "<option value=\"".$row->id."\">".stripslashes($row->type_name)."</option>";
			}
			mysqli_free_result( $res );
		}
?>
				</select>
			</td>
		</tr>
		<tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Выбрать "></td></tr>
		</form>
		</table>
<?php
	}
	else
	{
		$prof_name = "";
		$query = "SELECT p1.*, p2.type_name, p2.descr
			FROM $THIS_TABLE_PROF p1, $THIS_TABLE_PROFL p2
			WHERE p1.id='$profid' AND p1.id=p2.profile_id AND p2.lang_id='$LangId'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
		    {
		    	$prof_name = stripslashes($row->type_name);
			}
			mysqli_free_result( $res );
		}
		/*
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
					//$orgmin = stripslashes($row->min_val);
					//$orgmax = stripslashes($row->max_val);
					$orgbasic = stripslashes($row->isbasic);
					$orgdispid = $row->param_display_type_id;
					$sort_filter = $row->sort_filter;
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
			<input type="hidden" name="profid" value="<?=$profid;?>" />
			<input type="hidden" name="action2" value="assign" />
			<input type="hidden" name="item_id" value="<?=$item_id;?>" />
			<tr><td class="ff">Название параметра:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
			<tr><td class="ff">Единица измерения:</td><td class="fr"><input type="text" size="10" name="orgizm" value="<?=$orgizm;?>" /></td></tr>
			<tr><td class="ff">Пояснение:</td><td class="fr"><input type="text" size="70" name="orgsample" value="<?=$orgsample;?>" /></td></tr>
			<tr><td class="ff">Тип:</td><td class="fr">
				<select name="orgbasic">
					<option value="2"<?=( $orgbasic == 2 ? " selected" : "");?>>Фильтр</option>
					<option value="3"<?=( $orgbasic == 3 ? " selected" : "");?>>Видимый фильтр</option>
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
			<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="10" name="sort_filter" value="<?=$sort_filter;?>" /></td></tr>
			<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
			</form>
				</table>
			</td></tr>
			</table>
<?php
		}
		else
		{
		*/
			//echo "LangId = $LangId<br />";
?>
			<h3>Список фильтров для &quot;<?=$prof_name;?>&quot;</h3>
			<table align="center" cellspacing="2" cellpadding="0">
			<tr><td colspan="8" bgcolor="#EEEEEE" align="center"><font color="red"> Фильтры </font></td></tr>
			<tr>
				<th>Сорт.</th>
				<th>Название фильтра</th>
				<th>Ед. изм.</th>
				<th>Пояснение</th>
				<th>Тип</th>
				<th>Важность</th>
				<th colspan="2">Функции</th>
				<th>Дополн.</th>
			</tr>
<?php
			$found_items = 0;
			$query = "SELECT p1.*, p2.name, p2.izm, p2.sample, d1.name as dfname, count(o1.id) as optnum
				FROM $THIS_TABLE p1
				INNER JOIN $THIS_TABLE_LANG p2 ON p1.id=p2.param_id
				INNER JOIN $THIS_TABLE_P2P p3 ON p3.param_id=p1.id
				INNER JOIN $THIS_TABLE_DISP d1 ON p1.param_display_type_id=d1.id
				LEFT JOIN $TABLE_CAT_PROFILE_FILT_OPTIONS o1 ON p1.id=o1.param_id
				WHERE p3.profile_id='$profid' AND p2.lang_id=1
				GROUP BY p1.id
				ORDER BY p1.sort_filter, p2.name";

			if( $res = mysqli_query($upd_link_db, $query ) )
			{
			  	$pr=true;

				while($row = mysqli_fetch_object($res))
				{
					$found_items++;
					if( ($row->isbasic==1) && $pr )
					{
						echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"10\" alt=\"\" /></td></tr>";
						echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><hr></td></tr>";
						echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"10\" alt=\"\" /></td></tr>";
					?>
					<tr><td colspan="8" bgcolor="#EEEEEE" align="center"><font color="red"> Параметры </font></td></tr>
					<tr>
						<th>&nbsp;</th>
						<th>Название параметра</th>
						<th>Ед. изм.</th>
						<th>Пояснение</th>
						<th>Тип</th>
						<th>Важность</th>
						<th colspan="2">Функции</th>
						<th>Дополн.</th>
					</tr>
					<?php
						$pr = false;
					}
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
				<input type=\"hidden\" name=\"profid\" value=".$profid." />
				<input type=\"hidden\" name=\"action\" value=\"save\">
				<input type=\"hidden\" name=\"action2\" value=\"assign\">
				<tr>
					<td><input type=\"text\" name=\"sort_filter\" size=\"3\" value=\"".stripslashes($row->sort_filter)."\"></td>
					<td><input type=\"text\" name=\"orgname\" size=\"32\" value=\"".stripslashes($row->name)."\"></td>
					<td><input type=\"text\" name=\"orgizm\" size=\"10\" value=\"".stripslashes($row->izm)."\"></td>
					<td><input type=\"text\" name=\"orgsample\" size=\"10\" value=\"".stripslashes($row->sample)."\"></td>
					<td style=\"padding: 0px 8px 0px 8px;\">".stripslashes($row->dfname)."</td>
					<td><select name=\"orgbasic\">
				       <option value=\"1\" ".($row->isbasic == 1 ? " selected" : "").">Фильтр</option>
				       <option value=\"2\" ".($row->isbasic == 2 ? " selected" : "").">Видимый фильтр</option>
					</select></td>
					<td><input type=\"submit\" value=\"Сохранить\"></td>
					<td><input type=\"button\" onclick=\"javascript:Delet('$PHP_SELF?action=deleteitem&item_id=".$row->id."&profid=".$profid."');\" value=\"Удалить\"></td>";
				//echo "<td><input type=\"button\" onclick=\"javascript:GoTo('$PHP_SELF?mode=edit&item_id=".$row->id."&profid=".$profid."');\" value=\"Редактировать\"></td>
				echo "<td>".( ( ($row->param_display_type_id == $FIELD_TYPE_SELECT) || ($row->param_display_type_id == $FIELD_TYPE_OPTIONS) )
					? "<a href=\"cat_filters_opt.php?param_id=".$row->id."&profid=".$profid."\">Опции</a> (".$row->optnum.")" : "" )."</td>
				</tr>
				</form>";

				echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
				}
				mysqli_free_result($res);
			}

			if( $found_items == 0 )
			{
				echo "<tr><td colspan=\"8\" align=\"center\"><br />В базе нет ни одного фильтра для товаров<br /><br /></td></tr>
				<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
			else
			{
				//echo "<tr><td align=\"center\" colspan=\"8\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
			}
?>
		</table>

		<br /><br />
		<h3>Добавить Новый Фильтр</h3>
		<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
			<table width="100%" cellspacing="1" cellpadding="1" border="0">
		<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
		<input type="hidden" name="profid" value="<?=$profid;?>" />
		<input type="hidden" name="action" value="add">
		<tr><td class="ff">Название параметра:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
		<tr><td class="ff">Единица измерения:</td><td class="fr"><input type="text" size="10" name="orgizm" value="<?=$orgizm;?>" /></td></tr>
		<tr><td class="ff">Пояснение:</td><td class="fr"><input type="text" size="70" name="orgsample" value="<?=$orgsample;?>" /></td></tr>
		<?php
		/*
		<tr><td class="ff">Min значение:</td><td class="fr"><input type="text" size="10" name="orgmin" value="<?=$orgmin;?>" /></td></tr>
		<tr><td class="ff">Max значение:</td><td class="fr"><input type="text" size="10" name="orgmax" value="<?=$orgmax;?>" /></td></tr>
		*/
		?>
		<tr><td class="ff">Важность:</td><td class="fr">
			<select name="orgbasic">
				<option value="1"<?=( $orgbasic == 1 ? " selected" : "");?>>Фильтр</option>
				<option value="2"<?=( $orgbasic == 2 ? " selected" : "");?>>Видимый Фильтр</option>
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
		<tr><td class="ff">Порядковый номер:</td></td><td class="fr"><input type="text" size="3" name="sort_filter" value="" /></td></tr>
		<tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
		</form>
			</table>
		</td></tr>
		</table>
<?php
		//}
	}

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
