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
   	$strings['tipview']['en'] = "View values for this parameter";

    $strings['tipedit']['ru'] = "Редактировать параметры транспортных средств";
   	$strings['tipdel']['ru'] = "Удалить параметр из списка";
   	$strings['tipview']['ru'] = "Посмотреть возможные значения";

	$PAGE_HEADER['ru'] = "Редактировать Параметры Транстпортных Средств";
	$PAGE_HEADER['en'] = "Vehicle Parameters Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	////////////////////////////////////////////////////////////////////////////
	// Extract field types from database
	$disptypes[] = Array();
	$disptypes_num = 0;

    $query = "SELECT * FROM $TABLE_PARAM_DISP_TYPE ORDER BY id";
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

            // Delete all previous assigns for this profile
            if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_PROFILE_PARAMS WHERE profile_id='$profid'" ) )
            {
               echo mysqli_error($upd_link_db);
            }

            // Insert all new items and set the sorting index for them
			for($i=0; $i<count($items_id); $i++)
			{
				// Find the sorting index of the checked parameter
            	for($j=0; $j<count($param_items); $j++)
            	{
					if( $param_items[$j] == $items_id[$i] )
                        break;
                }

                if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_PROFILE_PARAMS (profile_id, param_id, sort_ind) VALUES
                	('".$profid."', '".$items_id[$i]."', '".$sort_ind[$j]."')" ) )
                {
                   echo mysqli_error($upd_link_db);
                }
            }
			break;
	}
?>
    <h3>Список параметров транспортных средств</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="assign" />
    <input type="hidden" name="profid" value="<?=$profid;?>" />
    <tr><th>&nbsp;</th><th>№ сорт.</th><th>Название параметра</th><th>Ед. изм.</th><th>Пример использвония</th><th>Важность</th><th>Вид параметра</th><th>Дополн.</th></tr>
<?php
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.name, p2.izm, p2.sample
			FROM $TABLE_PARAMS p1, $TABLE_PARAMS_LANGS p2
			WHERE p1.id=p2.param_id AND p2.lang_id='$LangId' ORDER BY name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

                $is_assigned = false;
                $cur_sort_ind = 0;

                // Check if this parameter ius assigned to this profile (select sort num if yes
                $query1 = "SELECT * FROM $TABLE_PROFILE_PARAMS WHERE profile_id='$profid' AND param_id='".$row->id."'";
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
                        <td align=\"center\">
                               	<a href=\"params_opt.php?param_id=".$row->id."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipview'][$lang]."\" /></a>&nbsp;</td>
                </tr>";
                echo "<tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"7\" align=\"center\"><br />В базе нет ни одного параметра для транспортного средства<br /><br /></td></tr>
			<tr><td colspan=\"7\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"7\"><input type=\"submit\" name=\"assign_but\" value=\" Привязать \" /></td></tr>";
        }
?>
    </form>
    </table>

<?php
    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
