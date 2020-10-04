<?php
    include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";
    include "inc/authorize-inc.php";

    include "../inc/utils-inc.php";
    include "../inc/catutils-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    $strings['tipedit']['en'] = "Edit This Model";
    $strings['tipeditp']['en'] = "Edit Model's Photos";
   	$strings['tipdel']['en'] = "Delete This Model";
   	$strings['tipassign']['en'] = "Assign photos to other models";

    $strings['tipedit']['ru'] = "Редактировать информацию";
    $strings['tipeditp']['ru'] = "Редактировать фотографии";
   	$strings['tipdel']['ru'] = "Удалить модель из базы";
   	$strings['tipassign']['ru'] = "Скопировать фото для других моделей";

    $PAGE_HEADER['ru'] = "Товары";
	$PAGE_HEADER['en'] = "Products";

    // Include Top Header HTML Style
	include "inc/header-inc.php";

	// Get the vehicle type first to know what parameters to display
	$catid = GetParameter("catid", 0);
	$action = GetParameter("action", "");
	$item_id = GetParameter("item_id", 0);

	switch( $action )
	{
		case "addto":
			if( $item_id != 0 )
			{
				// Check if it is already in the best list
				$isadded = false;
				$query = "SELECT * FROM $TABLE_CAT_BEST_ITEMS WHERE item_id='$item_id'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$isadded = true;
					}
					mysqli_free_result( $res );
				}

				if( !$isadded )
				{
					if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_CAT_BEST_ITEMS (item_id, date_add) VALUES ('$item_id', NOW()) ") )
					{
						echo mysqli_error($upd_link_db);
					}
				}
			}
			break;

		case "deleteitem":
			$query = "DELETE FROM $TABLE_CAT_BEST_ITEMS WHERE id='$item_id'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			break;

		case "delitems":
			$itemids = GetParameter("itemids", null);
   			for( $i=0; $i<count($itemids); $i++ )
   			{
   				$query = "DELETE FROM $TABLE_CAT_BEST_ITEMS WHERE id='".$itemids[$i]."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
   			}
			break;
	}

?>
        <h3>Товары на стартовой странице</h3>
    	<table align="center" cellspacing="2" cellpadding="0" width="800">
    	<form action="<?=$PHP_SELF;?>" method="POST">
    	<input type="hidden" name="action" value="delitems" />
	    <tr>
	    	<th> &nbsp;</th>
	    	<th>Название товара</th>
	    	<th>Раздел каталога</th>
	    	<th>Фото</th>
	    	<th>&nbsp;</th>
	    </tr>
<?php
	    $found_items = 0;
	    $query = "SELECT b1.id as bid, i1.*, m2.make_name, i2.descr
	    		FROM $TABLE_CAT_BEST_ITEMS b1
	    		INNER JOIN $TABLE_CAT_ITEMS i1 ON b1.item_id=i1.id
	    		INNER JOIN $TABLE_CAT_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
	    		INNER JOIN $TABLE_CAT_MAKE m1 ON i1.make_id=m1.id
				INNER JOIN $TABLE_CAT_MAKE_LANGS m2 ON m1.id=m2.make_id AND m2.lang_id='$LangId'
	            ORDER BY i1.model";
	    if( $res = mysqli_query($upd_link_db, $query ) )
	    {
	        while( $row = mysqli_fetch_object($res) )
	        {
	            $photocount = 0;

                $query1 = "SELECT count(*) as totitems FROM $TABLE_CAT_ITEMS_PICS WHERE item_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$photocount = $row1->totitems;
                    }
                    mysqli_free_result($res1);
                }

	            $found_items++;

              	$strcatpath = "";//GetItemSectPath($row->id, $LangId);

	            echo "<tr>
	            	 <td><input type=\"checkbox\" name=\"itemids[]\" value=\"".$row->bid."\" /></td>
	                 <td><b>".stripslashes($row->make_name)." ".stripslashes($row->model)."</b></td>
	                 <td style=\"padding: 1px 10px 1px 10px\">".$strcatpath."</td>
	                 <td align=\"center\">".$photocount." шт</td>
	                 <td align=\"center\">
	                 	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->bid."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
	                 </td>
	                </tr>
	                <tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
	        }
	        mysqli_free_result($res);
	    }
	    else
	        echo mysqli_error($upd_link_db);

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"5\" align=\"center\"><br />В лучшие предложения не вынесен ни один товар<br /><br /></td></tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
		}
		else
		{
			echo "<tr><td align=\"center\" colspan=\"5\"><input type=\"submit\" name=\"delbut\" value=\" Удалить отмеченные \" /></td></tr>";
		}
	?>
		</form>
	    </table>

<?php
    ////////////////////////////////////////////////////////////////////////////
	include "inc/footer-inc.php";
    include "../inc/close-inc.php";
?>
