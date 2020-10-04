<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$PAGE_HEADER['ru'] = "Тематические группы в доске объявлений";
	$PAGE_HEADER['en'] = "Catalog Groups";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$THIS_TABLE = $TABLE_ADV_TGROUPS;

	switch( $action )
	{
    	case "add":
    		$name = GetParameter("name", "");
    		$url = GetParameter("url", "");
    		$active = GetParameter("active", 0);
    		$sort = GetParameter("sort", 1);

    		$query = "INSERT INTO $THIS_TABLE (sect0lev_id, title, url, add_date, mod_date, sort_num) VALUES (
    			'0', '".addslashes($name)."', '".addslashes($url)."', NOW(), NOW(), '".addslashes($sort)."')";
    		if( !mysqli_query($upd_link_db,$query) )
			{
			  	echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "delete":
			// Delete selected news
			$delete = GetParameter("delete", "");
			if($delete != "")
			{
				$sel_id = GetParameter("sel_id", "");
				for($i = 0; $i < count($sel_id); $i++)
				{
					if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id='".$sel_id[$i]."'"))
					{
        				echo "<b>".mysqli_error($upd_link_db)."</b>";
    				}
				}
			}
			$update = GetParameter("update", "");
			if($update != "")
			{
				$all_id = GetParameter("all_id", "");
				$sort = GetParameter("sort", "");
				for($i = 0; $i < count($all_id); $i++)
				{
					if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET
							sort_num='".addslashes($sort[$i])."'
							WHERE id='".$all_id[$i]."'"))
					{
						echo "<b>".mysqli_error($upd_link_db)."</b>";
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
    		break;

		case "update":
			$item_id = GetParameter("item_id", 0);
    		$name = GetParameter("name", "");
    		$url = GetParameter("url", "");
    		$active = GetParameter("active", 0);
    		$sort = GetParameter("sort", 1);

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE SET
							title='".addslashes($name)."',
							url='".addslashes($url)."',
							mod_date=NOW(),
							sort_num='".addslashes($sort)."'
							WHERE id='".$item_id."'"))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
    	$name = "";
    	$url = "";
    	$active = 0;
    	$sort = 0;

		if($res = mysqli_query($upd_link_db,"SELECT m1.* FROM $THIS_TABLE m1 WHERE m1.id='$item_id' "))
		{
			if($row = mysqli_fetch_object($res))
			{
		    	$name = stripslashes($row->title);
		    	$url = stripslashes($row->url);
		    	//$active = stripslashes($row->active);
		    	$sort = stripslashes($row->sort_num);
			}
			mysqli_free_result($res);
		}
?>

	<h3>Редактировать группу доски</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="item_id" value="<?=$item_id;?>" />
	<tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="name" value="<?=$name;?>" /></td></tr>
	<?php
	/*
	<tr><td class="ff">URL:</td><td class="fr"><input type="text" size="70" name="url" value="<?=$url;?>" /></td></tr>
	*/
	?>
	<tr><td class="ff">Сортировка:</td><td class="fr"><input type="text" size="2" name="sort" value="<?=$sort;?>" /></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Сохранить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
?>
	<h3>Добавить группу доски</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="name" value="" /></td></tr>
    <?php
    /*
    <tr><td class="ff">URL:</td><td class="fr"><input type="text" size="70" name="url" value="" /></td></tr>
    */
    ?>
	<tr><td class="ff">Сортировка:</td><td class="fr"><input type="text" size="2" name="sort" value="1" /></td></tr>
    <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Добавить "></td></tr>
    </form>
    	</table>
    	</td></tr>
    </table>

    <br /><br />

    <h3>Список групп</h3>
    <table align="center" width="96%" cellspacing="0" cellpadding="0">
	<form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
		<th width="25">&nbsp;</th>
		<th width="50">Сортировка</th>
		<th>Название</th>
		<th> <!--url--> </th>
		<th width="100">Функции</th>
	</tr>
<?php

    	$pr_found = true;
   		if( $res = mysqli_query($upd_link_db,"SELECT * FROM $THIS_TABLE ORDER BY sect0lev_id,sort_num") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $pr_found = false;

	           	echo "<tr>";
	           	echo "<td><input type=\"checkbox\" name=\"sel_id[]\" value=\"".$row->id."\" /><input type=\"hidden\" name=\"all_id[]\" value=\"".$row->id."\" /></td>";
	           	echo "<td align=\"center\"><input type='text' name='sort[]' value='".$row->sort_num."' size='3'></td>";
                echo "<td>".stripslashes($row->title)."</td>";
                echo "<td>".( false ? stripslashes($row->url) : "" )."</td>";
                echo "<td align=\"center\">
                        <a href=\"javascript:Delet('$PHP_SELF?action=deleteitem&item_id=".$row->id."')\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить\" /></a>&nbsp;
                        <a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать\" /></a>&nbsp;</td>";
                echo "</tr>";
                echo "<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $pr_found )
		{
			echo "<tr><td colspan=\"5\" align=\"center\"><br />Нет тематических групп в базе<br /><br /></td></tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
			?>
			<tr><td colspan="5">
			<input type="submit" name="update" value=" Сохранить ">
			</td></tr>
			<?php
		}
?>
    </form>
    </table>
	<br /><br />
<?php
    }

    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
