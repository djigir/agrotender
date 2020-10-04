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

	$strings['tipedit']['ru'] = "Редактировать параметры товаров";
	$strings['tipdel']['ru'] = "Удалить параметр из списка";

	$PAGE_HEADER['ru'] = "Редактировать Параметры Товаров";
	$PAGE_HEADER['en'] = "Product Parameters Editing";


	$action = GetParameter("action","");
	$profile_id = GetParameter("profile_id",0);
	$make_id = GetParameter("make_id",0);
	//$v = GetParameter("v","");

	$profile_name = "";
	$query = "SELECT p1.id, p2.type_name FROM $TABLE_CAT_PROFILE p1
		INNER JOIN $TABLE_CAT_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		WHERE p1.id='$profile_id'";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		if( $row = mysqli_fetch_object( $res ) )
		{
			$profile_name = stripslashes($row->type_name);
		}
		mysqli_free_result( $res );
	}

	$mlist = Array();
	$query = "SELECT DISTINCT m1.*, m2.make_name
		FROM $TABLE_CAT_ITEMS i1
		INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
		INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
		WHERE i1.profile_id='$profile_id'
		ORDER BY m2.make_name";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$mi = Array();
			$mi['id'] = $row->id;
			$mi['name'] = stripslashes($row->make_name);
			$mlist[] = $mi;
		}
		mysqli_free_result( $res );
	}

	if( ($make_id == 0) && (count($mlist) > 0) )
	{
		$make_id = $mlist[0]['id'];
	}

	$filters = Array();
	$query = "SELECT f1.id, f1.param_display_type_id, f2.name
		FROM $TABLE_CAT_PROFILE_PARAMS p1
		INNER JOIN $TABLE_CAT_PARAMS f1 ON p1.param_id=f1.id
		INNER JOIN $TABLE_CAT_PARAMS_LANGS f2 ON f1.id=f2.param_id AND f2.lang_id='$LangId'
		WHERE p1.profile_id='$profile_id'
		ORDER BY p1.sort_ind, f2.name";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$fi = Array();
			$fi['id'] = $row->id;
			$fi['name'] = stripslashes($row->name);
			$fi['disptype'] = $row->param_display_type_id;

			//$filters[$row->param_id]=$row->name;
			$filters[] = $fi;
		}
		$colspan = mysqli_num_rows($res)+1;
		mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db);

	switch($action)
	{
		case "save":
			$pids = GetParameter("pids", null);
   			$filtvals = Array();

			for( $i=0; $i<count($filters); $i++ )
			{
				if( $filters[$i]['disptype'] != $FIELD_TYPE_OPTIONS )
				{
					$curv = GetParameter( "f".$filters[$i]['id'], null );
					$filtvals[$filters[$i]['id']] = $curv;
				}
			}

			for( $i=0; $i<count($pids); $i++ )
			{
				$prod_id = $pids[$i];

                for( $j=0; $j<count($filters); $j++ )
				{
					if( $filters[$j]['disptype'] != $FIELD_TYPE_OPTIONS )
						$valarr = $filtvals[$filters[$j]['id']];

					switch( $filters[$j]['disptype'] )
					{
						case $FIELD_TYPE_EDIT:
						case $FIELD_TYPE_TEXTAREA:
						case $FIELD_TYPE_HTML:
						case $FIELD_TYPE_RADIO:
						case $FIELD_TYPE_SELECT:
							$curfval = $valarr[$i];

							$query = "SELECT * FROM $TABLE_CAT_PARAM_VALUES WHERE item_id='$prod_id' AND param_id='".$filters[$j]['id']."'";
						    if( $res = mysqli_query($upd_link_db, $query ) )
						    {
							    if( $row = mysqli_fetch_object($res) )
							    {
							    	// The filter for product exists
							    	$query = "UPDATE $TABLE_CAT_PARAM_VALUES SET value='".addslashes($curfval)."' WHERE id='".$row->id."'";
							    	//echo $query."<br />";
							    	if( !mysqli_query($upd_link_db, $query ) )
									{
									   echo mysqli_error($upd_link_db);
									}
								}
								else
								{
									// No filter for product, add it
									if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value)
									 VALUES ('$prod_id', '".$filters[$j]['id']."', '".addslashes($curfval)."')" ) )
									{
									   echo mysqli_error($upd_link_db);
									}
								}
								mysqli_free_result( $res );
							}
							break;

						case $FIELD_TYPE_FLAG:
							$curfval = 0;
							for( $k=0; $k<count($valarr); $k++ )
							{
								if( $valarr[$k] == $prod_id )
								{
									$curfval = 1;
								}
							}

							$query = "SELECT * FROM $TABLE_CAT_PARAM_VALUES WHERE item_id='$prod_id' AND param_id='".$filters[$j]['id']."'";
						    if( $res = mysqli_query($upd_link_db, $query ) )
						    {
							    if( $row = mysqli_fetch_object($res) )
							    {
							    	// The filter for product exists
							    	if( !mysqli_query($upd_link_db, "UPDATE $TABLE_CAT_PARAM_VALUES SET value='".$curfval."' WHERE id='".$row->id."'" ) )
									{
									   echo mysqli_error($upd_link_db);
									}
								}
								else
								{
									// No filter for product, add it
									if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value)
									 VALUES ('$prod_id', '".$filters[$j]['id']."', '".$curfval."')" ) )
									{
									   echo mysqli_error($upd_link_db);
									}
								}
								mysqli_free_result( $res );
							}
							break;

						case $FIELD_TYPE_OPTIONS:
							$valfopt = GetParameter("f".$prod_id."_".$filters[$j]['id'], null);

							$filtvalid = 0;
							$query = "SELECT * FROM $TABLE_CAT_PARAM_VALUES
								WHERE item_id='$prod_id' AND param_id='".$filters[$j]['id']."'";
							if( $res = mysqli_query($upd_link_db, $query ) )
							{
								if( $row = mysqli_fetch_object($res) )
								{
								    $filtvalid = $row->id;
								}
								mysqli_free_result($res);
							}

							if( $filtvalid == 0 )
							{
								$query = "INSERT INTO $TABLE_CAT_PARAM_VALUES (item_id, param_id, value, lang_id)
									VALUES ('$prod_id', '".$filters[$j]['id']."', '', 0)";
								if( !mysqli_query($upd_link_db, $query ) )
								{
								   echo mysqli_error($upd_link_db);
								}
								else
								{
									$filtvalid = mysqli_insert_id($upd_link_db);
								}
							}
							else
							{
								if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_CAT_PARAM_VALUES_OPTS WHERE param_value_id='$filtvalid'" ) )
								{
								   echo mysqli_error($upd_link_db);
								}
							}

							if( $filtvalid != 0 )
							{
								for( $k=0; $k<count($valfopt); $k++ )
								{
									if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_CAT_PARAM_VALUES_OPTS (param_value_id, option_id)
									    VALUES ('".$filtvalid."', '".$valfopt[$k]."')" ) )
									{
									   echo mysqli_error($upd_link_db);
									}
								}
							}
							break;
					}
				}
			}

			/*
			for($i=0;$i<count($v);$i++)
			{
				$result = @split("_",$v[$i]);
				$item_id = $result[0];
				$param_id = $result[1];
				$value = $result[2];

				$query="SELECT id FROM $TABLE_CAT_FILTER_VALUES WHERE item_id='$item_id' AND param_id='$param_id'";
				if($res=mysqli_query($upd_link_db,$query))
				{
					if( $row = mysqli_fetch_object($res) )
					{
						$query2 = "UPDATE $TABLE_CAT_FILTER_VALUES SET value='".$value."' WHERE id='".$row->id."'";
						if( !mysqli_query($upd_link_db, $query2 ))
						{
						   echo mysqli_error($upd_link_db);
						}
					}
					else
					{
						$query3 = "INSERT INTO $TABLE_CAT_FILTER_VALUES (item_id,param_id,value) VALUES ('".$item_id."','".$param_id."','".$value."')";
						if( !mysqli_query($upd_link_db, $query3 ))
						{
						   echo mysqli_error($upd_link_db);
						}
					}
					mysqli_free_result($res);
				}
				else
					echo mysqli_error($upd_link_db);
			}
			*/
			break;
	}

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	echo '<h3>Редактирование параметров товаров типа &quot;'.$profile_name.'&quot;</h3>';
	echo '<div style="text-align: center; padding: 3px 40px 3px 40px;"><a href="cat_addprod.php">Вернуться к перечню типов</a></div>';

	echo '<div style="text-align: center; padding: 10px 40px 10px 40px;">';
	for( $i=0; $i<count($mlist); $i++ )
	{
		if( $i > 0 )
			echo " | ";

		if( $mlist[$i]['id'] == $make_id )
		{
			echo '<b>'.$mlist[$i]['name'].'</b>';
		}
		else
		{
			echo '<a href="'.$PHP_SELF.'?profile_id='.$profile_id.'&make_id='.$mlist[$i]['id'].'">'.$mlist[$i]['name'].'</a>';
		}
	}
	echo '</div>';

	echo '<form action="'.$PHP_SELF.'" method="POST">
	<input type="hidden" name="action" value="save" />
	<input type="hidden" name="profile_id" value="'.$profile_id.'" />
	<input type="hidden" name="make_id" value="'.$make_id.'" />
	<table align="center" cellspacing="0" cellpadding="5" border="1">
	<tr>
		<td align="center"><b>Модель</b></td>';
		for($i=0; $i<count($filters); $i++ )
		{
			echo '<td align="center"><b>'.$filters[$i]['name'].'</b></td>';
		}
	echo "</tr>";

	$val = 0;
	$query = "SELECT i.id, i.model, m.make_name FROM $TABLE_CAT_ITEMS i
		INNER JOIN $TABLE_CAT_MAKE_LANGS m ON i.make_id=m.make_id AND m.lang_id='$LangId'
		WHERE i.profile_id='$profile_id' AND i.make_id='$make_id'";
	if( $res = mysqli_query($upd_link_db,$query) )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			echo '<input type="hidden" name="pids[]" value="'.$row->id.'" />';
			echo '<tr><td>'.$row->make_name.' '.$row->model.'</td>';
			//foreach($filters as $param_id=>$val)
			for( $i=0; $i<count($filters); $i++ )
			{
				$was_in_db = false;
				$val_id = 0;
				$val = 0;

				$query_v = "SELECT id, value FROM $TABLE_CAT_PARAM_VALUES WHERE param_id='".$filters[$i]['id']."' AND item_id='".$row->id."'";
				if( $res_v = mysqli_query($upd_link_db,$query_v) )
				{
					if( $row_v = mysqli_fetch_object($res_v) )
					{
						$val_id = $row->id;
						$val = $row_v->value;
						$was_in_db = true;
					}
					mysqli_free_result( $res_v );
				}

				if( $filters[$i]['disptype'] == $FIELD_TYPE_FLAG )
				{
					echo '<td>
						<input type="checkbox" name="f'.$filters[$i]['id'].'[]" value="'.$row->id.'" '.($val == 1 ? "checked" : "").' />
					</td>';
				}
				if( $filters[$i]['disptype'] == $FIELD_TYPE_EDIT )
				{
					if( !$was_in_db && ($val == 0) )
						$val = "";
					echo '<td>
						<input type="text" name="f'.$filters[$i]['id'].'[]" value="'.$val.'" />
					</td>';
				}
				if( ($filters[$i]['disptype'] == $FIELD_TYPE_TEXTAREA) || ($filters[$i]['disptype'] == $FIELD_TYPE_HTML) )
				{
					if( !$was_in_db && ($val == 0) )
						$val = "";
					echo '<td>
						<textarea name="f'.$filters[$i]['id'].'[]" cols="50" rows="7">'.$val.'</textarea>
					</td>';
				}
				else if( $filters[$i]['disptype'] == $FIELD_TYPE_SELECT )
				{
					echo '<td>';
					$query_o = "SELECT o2.option_text, o.id FROM $TABLE_CAT_PARAM_OPTIONS o
							INNER JOIN $TABLE_CAT_PARAM_OPTIONS_LANGS o2 ON o2.option_id=o.id AND o2.lang_id='$LangId'
							WHERE o.param_id='".$filters[$i]['id']."'";
					if( $res_o = mysqli_query($upd_link_db,$query_o) )
					{
						echo '<select name="f'.$filters[$i]['id'].'[]">';
						while( $row_o = mysqli_fetch_object($res_o) )
						{
							echo '<option '.($row_o->id == $val? "selected" : "").' value="'.$row_o->id.'">'.stripslashes($row_o->option_text).'</option>';
						}
						echo '</select>';
					}
					else
						echo mysqli_error($upd_link_db);
					echo '</td>';
				}
				else if( $filters[$i]['disptype'] == $FIELD_TYPE_OPTIONS )
				{
					echo '<td>';
					$optval = Array();

					$query1 = "SELECT o.option_id FROM $TABLE_CAT_PARAM_VALUES v
								INNER JOIN $TABLE_CAT_PARAM_VALUES_OPTS o ON v.id=o.param_value_id
								WHERE v.param_id='".$filters[$i]['id']."' AND v.item_id='".$row->id."'";
					if( $res1 = mysqli_query($upd_link_db,$query1) )
					{
						$optval = Array();
						while( $row1 = mysqli_fetch_object($res1) )
						{
							$optval[] = $row1->option_id;
						}
						mysqli_free_result($res1);
					}
					else
						echo mysqli_error($upd_link_db);

					$query1 = "SELECT o1.*, o2.option_text
								FROM $TABLE_CAT_PARAM_OPTIONS o1, $TABLE_CAT_PARAM_OPTIONS_LANGS o2
								WHERE o1.param_id='".$filters[$i]['id']."' AND o1.id=o2.option_id AND o2.lang_id='$LangId'
								ORDER BY o1.sort_ind";
					if( $res1 = mysqli_query($upd_link_db, $query1 ) )
					{
					    while( $row1 = mysqli_fetch_object($res1) )
					    {
							echo '<input type="checkbox" name="f'.$row->id.'_'.$filters[$i]['id'].'[]" value="'.$row1->id.'" '.( in_array($row1->id, $optval) ? ' checked="checked" ' : '' ).' /> '.stripslashes($row1->option_text).'<br />';
					    }
					    mysqli_free_result($res1);
					}
					echo '</td>';
				}
			}
			echo '</tr>';
		}
		mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db);

	echo '<tr>
		<td align="center" colspan="'.$colspan.'"><input type="submit" value="Сохранить" /></td>
	</tr>
	</table>
	</form>';

	////////////////////////////////////////////////////////////////////////////
    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
