<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Assign params to profile";
   	$strings['tipdel']['en'] = "Delete this parameter from profile";
   	$strings['tipview']['en'] = "View values for this parameter";

    $strings['tipedit']['ru'] = "Привязать параметры к культуре";
   	$strings['tipdel']['ru'] = "Удалить параметр из списка";
   	$strings['tipview']['ru'] = "Посмотреть возможные значения";

	$PAGE_HEADER['ru'] = "Приязка Параметров к Культурам";
	$PAGE_HEADER['en'] = "Assign Parameter to Profile";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TORG_PARAMS;
	$THIS_TABLE_LANG = $TABLE_TORG_PARAMS_LANGS;
	$THIS_TABLE_DISP = $TABLE_TORG_PARAM_DISP_TYPE;
	$THIS_TABLE_P2P = $TABLE_TORG_PROFILE_PARAMS;
	$THIS_TABLE_PROF = $TABLE_TORG_PROFILE;
	$THIS_TABLE_PROFL = $TABLE_TORG_PROFILE_LANGS;

	////////////////////////////////////////////////////////////////////////////
	// Extract field types from database
	$disptypes[] = Array();
	$disptypes_num = 0;

    $query = "SELECT * FROM $THIS_TABLE_DISP ORDER BY id";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
			$disptypes[$row->id] = stripslashes($row->name);

			$disptypes_num++;
        }
        mysqli_free_result($res);
    }
	////////////////////////////////////////////////////////////////////////////

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$profid = GetParameter("profid", "0");

	switch( $action )
	{
		case "assign":
			$items_id = GetParameter("items_id", null);
			$param_items = GetParameter("param_items", null);
			$sort_ind = GetParameter("sort_ind", null);

            // Insert all new items and set the sorting index for them
			for($i=0; $i<count($param_items); $i++)
			{
				$query = "SELECT p1.id	FROM $THIS_TABLE_P2P p1
					WHERE p1.profile_id='".$profid."' AND p1.param_id='".$param_items[$i]."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object( $res ) )
		    		{
		    			$pr=false;
		    			for($z=0;$z<count($items_id);$z++)
		    			{
							if($items_id[$z]==$param_items[$i])
								$pr=true;
						}
						if(!$pr)
						{
							if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_P2P WHERE id='".$row->id."'" ) )
            				{
               					echo mysqli_error($upd_link_db);
            				}
						}
					}
				}
			}
			for($i=0; $i<count($items_id); $i++)
			{
				for($j=0;$j<count($param_items);$j++)
				{
					if($param_items[$j]==$items_id[$i])
						$f=$j;
				}
				$query = "SELECT p1.id	FROM $THIS_TABLE_P2P p1
					WHERE p1.profile_id='".$profid."' AND p1.param_id='".$items_id[$i]."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object( $res ) )
		    		{
		    			if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_P2P SET sort_ind='".$sort_ind[$f]."' WHERE id='".$row->id."'" ) )
                		{
                   			echo mysqli_error($upd_link_db);
                		}
					}
					else
					{
						if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_P2P (profile_id, param_id, sort_ind) VALUES
                			('".$profid."', '".$items_id[$i]."', '".$sort_ind[$f]."')" ) )
                		{
                   			echo mysqli_error($upd_link_db);
                		}
					}
					mysqli_free_result( $res );
				}
            }
			break;

			case "update":
				$ordqroup_id = GetParameter("orgroup_id", "");
				$ordsort_ind = GetParameter("orsort_ind", "");
				$p2p_id = GetParameter("p2p_id", "");
				$t=array();
				$par_st = GetParameter("par_sr", $t);
				for($i=0;$i<count($ordqroup_id);$i++)
				{
					if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_P2P SET group_id='".$ordqroup_id[$i]."',sort_ind='".$ordsort_ind[$i]."' WHERE id='".$p2p_id[$i]."'" ) )
                	{
                   		echo mysqli_error($upd_link_db);
                	}

                	/*
                	if(in_array($p2p_id[$i],$par_st))
                	{
						if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_P2P SET sravn='1' WHERE id='".$p2p_id[$i]."'" ) )
                		{
                   			echo mysqli_error($upd_link_db);
                		}
					}
					else
					{
						if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_P2P SET sravn='0' WHERE id='".$p2p_id[$i]."'" ) )
                		{
                   			echo mysqli_error($upd_link_db);
                		}
					}
					*/
				}

			break;
	}

	if( $profid == 0 )
	{
?>
		<h3>Необходимо выбрать тип товаров</h3>
    	<table align="center" cellspacing="2" cellpadding="0">
    	<form action="<?=$PHP_SELF;?>" method=POST>
    	<input type="hidden" name="action" value="typesel" />
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
	if($mode=="add_param")
	{
		$profname = "Unknown";
		$query = "SELECT p1.*, p2.type_name, p2.descr
			FROM $THIS_TABLE_PROF p1, $THIS_TABLE_PROFL p2
			WHERE p1.id='$profid' AND p1.id=p2.profile_id AND p2.lang_id='$LangId'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			if( $row = mysqli_fetch_object( $res ) )
		    {
		    	$profname = stripslashes($row->type_name);
			}
			mysqli_free_result( $res );
		}
?>
    <h3>Привязать параметры к типу &quot;<?=$profname;?>&quot;</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="assign" />
    <input type="hidden" name="profid" value="<?=$profid;?>" />
    <tr>
    	<th>&nbsp;</th>
    	<th>№ сорт.</th>
    	<th>Название параметра</th>
    	<th>Ед. изм.</th>
    	<th>Пример использвония</th>
    	<th>Важность</th>
    	<th>Вид параметра</th>
    	<th>Дополн.</th>
    </tr>
<?php
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.izm, p2.sample
			FROM $THIS_TABLE p1, $THIS_TABLE_LANG p2
			WHERE p1.id=p2.param_id AND p2.lang_id='$LangId' ORDER BY name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

                $is_assigned = false;
                $cur_sort_ind = 0;

                // Check if this parameter ius assigned to this profile (select sort num if yes
                $query1 = "SELECT p1.sort_ind FROM $THIS_TABLE_P2P p1 WHERE profile_id='$profid' AND param_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    if( $row1 = mysqli_fetch_object($res1) )
                    {
						$is_assigned = true;
						$cur_sort_ind = $row1->sort_ind;
                    }
                    mysqli_free_result($res1);
                }

            	echo "<tr>
                     	<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" ".($is_assigned ? " checked" : "")." /></td>
                     	<td><input type=\"text\" size=\"2\" name=\"sort_ind[]\" value=\"".$cur_sort_ind."\" />
                     		<input type=\"hidden\" name=\"param_items[]\" value=\"".$row->id."\" /></td>
                     	<td><b>".stripslashes($row->name)."</b></td>
                     	<td>".stripslashes($row->izm)."</td>
                     	<td>".stripslashes($row->sample)."</td>
                     	<td>".( $row->isbasic==1 ? "<b>Основное</b>" : "Второстепенное" )."</td>
                     	<td>".$disptypes[$row->param_display_type_id]."</td>
                        <td align=\"center\">";
                 	if( ($row->param_display_type_id == $FIELD_TYPE_SELECT) ||
                 		($row->param_display_type_id == $FIELD_TYPE_OPTIONS) ||
                 		($row->param_display_type_id == $FIELD_TYPE_RADIO)
                	)
                 	{
						echo "<a href=\"cat_params_opt.php?param_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipview'][$lang]."\" /></a>&nbsp;";
					}
                  echo "</td>
                </tr>";
                echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"8\" align=\"center\"><br />В базе нет ни одного параметра<br /><br /></td></tr>
			<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"8\"><input type=\"submit\" name=\"assign_but\" value=\" Привязать \" /></td></tr>";
        }
?>
    </form>
    </table>
<?php
    }
		else
		{
			$profname = "Unknown";
			$query = "SELECT p1.*, p2.type_name, p2.descr
				FROM $THIS_TABLE_PROF p1, $THIS_TABLE_PROFL p2
				WHERE p1.id='$profid' AND p1.id=p2.profile_id AND p2.lang_id='$LangId'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				if( $row = mysqli_fetch_object( $res ) )
		    	{
		    		$profname = stripslashes($row->type_name);
				}
				mysqli_free_result( $res );
			}
?>
			<h3>Существующие характеристик для &quot;<?=$profname;?>&quot; </h3>
        	<table align="center"  cellspacing="0" cellpadding="0" width="760">
        	<tr>
    			<th>&nbsp;</th>
    			<th> Название параметра </th>
    			<th> Группа параметра </th>
    			<th> Сортировка </th>
				<th> Для сравнения </th>
    		</tr>
			<form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="profid" value="<?=$profid;?>" />
<?php
			// Extract list of all parameter groups, assigned to profile
    		$found_groups = 0;
    		$groups=Array();
    		$query = "SELECT m1.*, m2.name
    			FROM $TABLE_TORG_GROUP_PARAM m1
    			INNER JOIN $TABLE_TORG_GROUP_PARAM_LANGS m2 ON m1.id=m2.item_id AND m2.lang_id=$LangId
    			WHERE m1.profile_id='".$profid."' OR m1.id='0' OR m1.id='-1'
    			ORDER BY m1.sort_num";
			if( $res = mysqli_query($upd_link_db,$query) )
			{
				while($row = mysqli_fetch_object($res))
				{
					//echo stripslashes($row->name)."<br />";
           	     	$groups[$found_groups]['id']=$row->id;
           	     	$groups[$found_groups]['name']=stripslashes($row->name);
					$found_groups++;
	            }
	            mysqli_free_result( $res );
       		}
       		else
       			echo mysqli_error($upd_link_db);

       		// Show new params which are no assigned to group
			$found_params = 0;
 			$p2p_id=Array();
   			$params=Array();
   			$query="SELECT m1.name, m2.id, m2.sort_ind, m1.param_id
   				FROM $TABLE_TORG_PROFILE_PARAMS m2
   				INNER JOIN $TABLE_TORG_PARAMS_LANGS m1 ON m2.param_id=m1.param_id AND m1.lang_id='$LangId'
   				WHERE m2.group_id=0 AND m2.profile_id='".$profid."'
   				ORDER BY m2.sort_ind";

			if( $res = mysqli_query($upd_link_db,$query) )
			{
				while($row=mysqli_fetch_object($res))
				{
					$p2p_id[$found_params]=$row->id;
					$params[$found_params]['id'] = $row->param_id;
					$params[$found_params]['name']=stripslashes($row->name);
					$params[$found_params]['sort']=$row->sort_ind;
					$params[$found_params]['sravn']=false;
					$found_params++;
            	}
            	mysqli_free_result( $res );
			}
			else
				echo mysqli_error($upd_link_db);

			// Print unassigned parameters
			for($j=0;$j<$found_params;$j++)
			{
 ?>
 				<tr>
 					<td><input type="hidden" name="p2p_id[]" value="<?=$p2p_id[$j];?>"/></td>
 					<td><?=$params[$j]['name']." (".$params[$j]['id'].")";?></td>
 					<td class="fr">
 						<select name="orgroup_id[]">
<?php
						echo "<option value=\"0\">-- нет группы --</option>";
						for($z=0; $z<$found_groups; $z++)
						{
							echo "<option value=\"".$groups[$z]['id']."\"".($groups[$z]['id'] == $groups[$i]['id'] ? " selected" : "").">".$groups[$z]['name']."</option>";
						}
?>
						</select>
					</td>
					<td><input type="text" name="orsort_ind[]" size="6" value="<?=$params[$j]['sort'];?>"/></td>
<?php
					echo "<td><input type=\"checkbox\" name=\"par_sr[]\" value=\"".$p2p_id[$j]."\"".($params[$j]['sravn'] ? "checked" : "0")."></td>";
?>
				</tr>
<?php
			}


			// Print all parameters with groups
       		for($i=0;$i<$found_groups;$i++)
       		{
       			//echo $groups[$i]['name']."<br />";

  				$found_params = 0;
  				$p2p_id=Array();
    			$params=Array();
    			$query="SELECT m1.name, m2.id, m2.sort_ind, m1.param_id
    				FROM $TABLE_TORG_PROFILE_PARAMS m2
    				INNER JOIN $TABLE_TORG_PARAMS_LANGS m1 ON m2.param_id=m1.param_id AND m1.lang_id='$LangId'
    				WHERE m2.group_id=".$groups[$i]['id']." AND m2.profile_id='".$profid."'
    				ORDER BY m2.sort_ind";
				/*$query="SELECT m1.name	FROM $TABLE_CAT_PARAMS_LANGS m1,
									INNER JOIN $TABLE_CAT_PROFILE_PARAMS m2 ON m1.param_id=m2.param_id
									WHERE m2.group_id=".$groups[$i]['id']." ORDER BY m2.sort_ind";*/
				if( $res = mysqli_query($upd_link_db,$query) )
				{
					while($row=mysqli_fetch_object($res))
					{
						$p2p_id[$found_params]=$row->id;
						$params[$found_params]['id'] = $row->param_id;
           	     		$params[$found_params]['name']=stripslashes($row->name);
           	     		$params[$found_params]['sort']=$row->sort_ind;
           	     		//if($row->sravn==0)
							$params[$found_params]['sravn']=false;
						//else
						//	$params[$found_params]['sravn']=true;
						$found_params++;
	            	}
	            	mysqli_free_result( $res );
       			}
       			else
       				echo mysqli_error($upd_link_db);
?>
				<tr><td colspan="5" style="padding: 8px 0px 4px 0px; text-align: center; font-size: 20px;"><?=$groups[$i]['name'];?></td></tr>
<?php
       			if($found_params==0)
       			{
?>
  				<tr><td colspan="5" style="padding: 2px 0px 10px 0px; text-align: center;"> нет параметров в группе </td></tr>
<?
				}
       			for($j=0;$j<$found_params;$j++)
       			{
?>
  					<tr>
					  <td><input type="hidden" name="p2p_id[]" value="<?=$p2p_id[$j];?>"/></td>
					  <td><?=$params[$j]['name']." (".$params[$j]['id'].")";?></td>
					  <td class="fr">
    						<select name="orgroup_id[]">
<?php
							echo "<option value=\"0\">-- нет группы --</option>";
							for($z=0; $z<$found_groups; $z++)
							{
        						echo "<option value=\"".$groups[$z]['id']."\"".($groups[$z]['id'] == $groups[$i]['id'] ? " selected" : "").">".$groups[$z]['name']."</option>";
        					}
?>
    						</select>
    				  </td>
    				  <td><input type="text" name="orsort_ind[]" size="6" value="<?=$params[$j]['sort'];?>"/></td>
    				  <?php
    				  echo "<td>
								<input type=\"checkbox\" name=\"par_sr[]\" value=\"".$p2p_id[$j]."\"".($params[$j]['sravn'] ? "checked" : "0")."></td>";
    				  ?>
					</tr>
<?php
  				}
  			}
?>
  			<tr><td colspan="5" class="fr" align="center"><input type="submit" value=" Сохранить "></td></tr>
			<tr><td colspan="5"><a href="torg_param2prof.php?profid=<?=$profid;?>&mode=add_param"><br><h3>Добавить/Удалить параметры </h3></a></tr></td>
			<tr><td colspan="5"><a href="torg_paramgroup.php?profile_id=<?=$profid;?>"><br><h3>Редактировать Группы параметров</h3></a></td></tr>
			</form>
			</table>

<?php
		}
	}

    include "inc/footer-inc.php";
    include "../inc/close-inc.php";
?>
