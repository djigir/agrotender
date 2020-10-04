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

    $strings['tipedit']['ru'] = "Редактировать Группы параметров";
   	$strings['tipdel']['ru'] = "Удалить параметр из списка";

	$PAGE_HEADER['ru'] = "Редактировать Группы Параметров";
	$PAGE_HEADER['en'] = "Product Parameters Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TORG_GROUP_PARAM;
	$THIS_TABLE_LANG = $TABLE_TORG_GROUP_PARAM_LANGS;


	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

    $orgname = GetParameter("orgname", "");
    $orgsort = GetParameter("orgsort", "1");
    $prof_id = GetParameter("profile_id", "0");


	switch( $action )
	{
    	case "add":
    		$query = "INSERT INTO $THIS_TABLE ( sort_num, profile_id )
    			VALUES ('".$orgsort."', '".$prof_id."')";
			if(mysqli_query($upd_link_db,$query))
			{
				$newid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( item_id, lang_id, name )
	                    VALUES ('$newid', '".$langs[$i]."', '".addslashes($orgname)."')" ) )
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

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
			//break;
			if($item_id!=0)
            {
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

            // now try to delete options for combo box and similar params
           	//	$query = "SELECT * FROM $TABLE_CAT_PARAMS_LANGS WHERE group_id='$item_id'";
            //	if( $res = mysqli_query($upd_link_db, $query ) )
            //	{
            //    	while( $row = mysqli_fetch_object( $res ) )
            //    	{
            			$zero=0;
                		$query1 = "UPDATE $TABLE_TORG_PROFILE_PARAMS SET group_id='".$zero."' WHERE group_id='".$item_id."'";
						if( !mysqli_query($upd_link_db, $query1 ) )
						{
							echo mysqli_error($upd_link_db);
						}
              //  	}
              // 		mysqli_free_result( $res );
            //	}
			}
			break;

		case "update":
			$item_id = GetParameter("item_id", "");

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET sort_num='".$orgsort."' WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			$query = "UPDATE $THIS_TABLE_LANG SET name='".addslashes($orgname)."' WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			break;
	}


    if( $mode == "edit" )
    {
    	$prof_id = GetParameter("profile_id", "0");
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orgsort = "1";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.name
			FROM $THIS_TABLE m1
			INNER JOIN $THIS_TABLE_LANG m2 ON m1.id=m2.item_id AND m2.lang_id='$LangId'
			WHERE m1.id='$item_id'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->name);
				$orgsort = $row->sort_num;
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
	<input type="hidden" name="profile_id" value="<?=$prof_id;?>" />
    <tr><td class="ff">Название Группы:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Порядок вывода:</td><td class="fr"><input type="text" size="10" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
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
		$prof_id = GetParameter("profile_id", "0");
		$query3 = "SELECT type_name FROM $TABLE_TORG_PROFILE_LANGS WHERE profile_id=".$prof_id."";
		//echo $query3;
		if( $res3 = mysqli_query($upd_link_db, $query3 ) )
		{
			if( $row3 = mysqli_fetch_object( $res3 ) )
			{
				$type_name=$row3->type_name;
			}
			mysqli_free_result($res3);
		}
?>
    <h3>Список Групп параметров для "<?=$type_name?>"</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <tr>
    	<th>&nbsp;</th>
    	<th>Название Группы</th>
    	<th>Порядок вывода</th>
    	<th colspan="2">Функции</th>
    </tr>
    <?

    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*, m2.name FROM $TABLE_TORG_GROUP_PARAM m1
			INNER JOIN $TABLE_TORG_GROUP_PARAM_LANGS m2 ON m1.id=m2.item_id AND m2.lang_id=$LangId
			WHERE m1.profile_id='".$prof_id."' ORDER BY m1.sort_num") )
		{
			while($row = mysqli_fetch_object($res))
			{
                $found_items++;
                echo "
<form action=\"$PHP_SELF\" method=\"post\">
<input type=\"hidden\" name=\"item_id\" value=\"".$row->id."\">
<input type=\"hidden\" name=\"action\" value=\"save\">
<tr>
	<td>".stripslashes($row->id)."</td>
	<td><input type=\"text\" name=\"orgname\" size=\"40\" value=\"".stripslashes($row->name)."\"></td>
	<td><input type=\"text\" name=\"orgsort\" size=\"10\" value=".$row->sort_num."></td>
	<td><input type=\"button\" onclick=\"javascript:Delet('$PHP_SELF?profile_id=$prof_id&action=deleteitem&item_id=".$row->id."');\" value=\"Удалить\"></td>
	<td><input type=\"button\" onclick=\"javascript:GoTo('$PHP_SELF?profile_id=$prof_id&mode=edit&item_id=".$row->id."');\" value=\"Редактировать\"></td>
</tr></form>";

                echo "<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"8\" align=\"center\"><br />В базе нет ни одной группы параметра для товаров<br /><br /></td></tr>
			<tr><td colspan=\"8\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	//echo "<tr><td align=\"center\" colspan=\"8\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /> <input type=\"submit\" name=\"refresh_but\" value=\" Обновить \" /></td></tr>";
        }
?>
    </table>

    <br /><br />
    <h3>Добавить Новую Группу</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="profile_id" value="<?=$prof_id;?>" />
    <tr><td class="ff">Название Группы:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Порядок вывода:</td><td class="fr"><input type="text" size="10" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>
	<br>
	<table align="center">
    	<tr><td>
		<a href="torg_param2prof.php?profid=<?=$prof_id;?>"><h3>Вернутся к списку параметров</h3></a>
		</td></tr>
    </table>
<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
