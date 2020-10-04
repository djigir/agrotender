<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    include "../inc/utils-inc.php";

	$strings['tipedit']['en'] = "Edit This Section Name";
   	$strings['tipdel']['en'] = "Delete This Section";

    $strings['tipedit']['ru'] = "Редактировать разделы каталога";
   	$strings['tipdel']['ru'] = "Удалить раздел";

	$PAGE_HEADER['ru'] = "Список Разделов Каталога";
	$PAGE_HEADER['en'] = "Work's Catalog Sections";

	$THIS_TABLE = $TABLE_CAT_CATALOG;
	$THIS_TABLE_LANG = $TABLE_CAT_CATALOG_LANGS;
	$THIS_TABLE_FILES = $TABLE_CAT_CATALOG_PICS;
	$THIS_TABLE_P2P = $TABLE_CAT_CATITEMS;

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$item_id = GetParameter("item_id", 0);

	switch( $action )
	{
		case "setprice":
      		$prids = GetParameter("prids", null);
      		$prvals = GetParameter("prvals", null);
      		$prvals2 = GetParameter("prvals2", null);
			$count_p = GetParameter("count_p", null);
      		$prodids = GetParameter("prodids", null);
			$articul = GetParameter("articul", null);

         	for($i=0; $i<count($prids); $i++)
         	{
         		// Check if the item is in price list
         		$was_in_price = false;
         		$query = "SELECT item_id FROM $TABLE_CAT_PRICES WHERE item_id='".$prids[$i]."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object( $res ) )
 					{
 						$was_in_price = true;
					}
					mysqli_free_result( $res );
				}

				if( ($prvals[$i] == "") || ($prvals[$i] == 0))
				{
					// Should be removed from price
					if( $was_in_price )
					{
						$query = "DELETE FROM $TABLE_CAT_PRICES WHERE item_id='".$prids[$i]."'";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
				else
				{
					// item is in price so update or add it
					if( $was_in_price )
					{
						$query = "UPDATE $TABLE_CAT_PRICES SET price='".$prvals[$i]."', price2='".$prvals2[$i]."' WHERE item_id='".$prids[$i]."'";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}


					}
					else
					{
						$query = "INSERT INTO $TABLE_CAT_PRICES (item_id, price, price2, update_date) VALUES
							('".$prids[$i]."', '".$prvals[$i]."', '".$prvals2[$i]."', NOW())";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}

				}


				$query = "SELECT articul FROM $TABLE_CAT_ITEMS WHERE id='".$prids[$i]."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object( $res ) )
 					{
 						if($row->articul!=$articul[$i]){
							$query = "UPDATE $TABLE_CAT_ITEMS SET articul='".$articul[$i]."' WHERE id='".$prids[$i]."'";
							if( !mysqli_query($upd_link_db, $query ) )
							{
								echo mysqli_error($upd_link_db);
							}

						}
					}
					mysqli_free_result( $res );
				}

				/*
				if( $articul[$i]!="" )
				{
					$query = "UPDATE $TABLE_CAT_ITEMS SET articul='".$articul[$i]."' WHERE id='".$prids[$i]."'";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				else
				{

				}
				*/
			}

			//FOR NUM PRODUCT
			$sql="";
			for($n=0; $n<count($count_p); $n++)
			{
				if($n==0){
					$sql.="item_id != '".$count_p[$n]."'";
				}else{
					$sql.=" AND item_id != '".$count_p[$n]."'";
				}

				$query = "SELECT id, price, availiable_now FROM $TABLE_CAT_PRICES WHERE item_id='$count_p[$n]'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					if( $row = mysqli_fetch_object( $res ) )
					{
						if($row->price!="" && $row->availiable_now==0)
						{
							$query = "UPDATE $TABLE_CAT_PRICES SET availiable_now='1' WHERE id='".$row->id."'";
							if( !mysqli_query($upd_link_db, $query ) )
							{
								echo mysqli_error($upd_link_db);
							}
						}
					}
					mysqli_free_result( $res );
				}
			}


			$query = "SELECT id,price FROM $TABLE_CAT_PRICES WHERE $sql";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$query = "UPDATE $TABLE_CAT_PRICES SET availiable_now='0' WHERE id='".$row->id."'";
					if( !mysqli_query($upd_link_db, $query ) )
					{
						echo mysqli_error($upd_link_db);
					}
				}
				mysqli_free_result( $res );
			}
			//////
			break;
	}

?>
    <h3>Установить Цены на Товары</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="setprice" />
    <tr>
    	<th colspan="3" align="left" style="text-decoration: underline; font-size: 11pt; font-weight: bold; padding: 5px 0px 4px 7px;">Раздел/Товар</th>
		<th width="80" style="text-decoration: underline; font-size: 11pt; font-weight: bold; padding: 5px 0px 4px 0px;"> Цена<br />(у.е.) </th>
		<th width="100" style="text-decoration: underline; font-size: 11pt; font-weight: bold; padding: 5px 0px 4px 0px;"> Цена старая<br />(у.е.) </th>
		<th width="100" style="text-decoration: underline; font-size: 11pt; font-weight: bold; padding: 5px 0px 4px 0px;"> Артикул товара </th>
		<th width="50" style="text-decoration: underline; font-size: 11pt; font-weight: bold; padding: 5px 0px 4px 0px;">Есть</th>
    </tr>
<?php
	//echo '<input type="hidden" name="item_id" value="'.$item_id.'" />';
  	//PrintWorkCatalog(0, $LangId, 0, "prices", $item_id);

  	// Print product catalog
	$query = "SELECT p1.*, p2.type_name FROM $TABLE_CAT_PROFILE p1
		INNER JOIN $TABLE_CAT_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		ORDER BY p2.type_name";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			echo "<tr><td colspan=\"7\" class=\"fr\" style=\" background-color: #F0F0F0; font-size: 10pt; font-weight: bold; padding: 5px 0px 4px 10px;\">".stripslashes($row->type_name)."</td></tr>";

			// Extract all products of this type
			$query1 = "SELECT i1.id, i1.model,i1.articul, m1.make_name as make, c1.name as sect, pr1.price as cost, pr1.price2, pr1.availiable_now
				FROM $TABLE_CAT_ITEMS i1
				INNER JOIN $TABLE_CAT_MAKE_LANGS m1 ON i1.make_id=m1.make_id AND m1.lang_id='$LangId'
				INNER JOIN $TABLE_CAT_CATITEMS ci1 ON i1.id=ci1.item_id
				INNER JOIN $TABLE_CAT_CATALOG_LANGS c1 ON ci1.sect_id=c1.sect_id AND c1.lang_id='$LangId'
				LEFT JOIN $TABLE_CAT_PRICES pr1 ON i1.id=pr1.item_id
				WHERE i1.profile_id='".$row->id."'
				ORDER BY c1.name, m1.make_name, i1.model";

			if( $res1 = mysqli_query($upd_link_db, $query1 ) )
			{
				$p=1;
				while( $row1 = mysqli_fetch_object( $res1 ) )
				{
					echo "<tr>";

     				echo "<td class=\"ff\">".$p."</td>";
					$p++;
     				//echo "<td class=\"fr\">".stripslashes($row1->make)." ".stripslashes($row1->model)."</td>";
     				echo "<td class=\"fr\">".stripslashes($row1->sect)."</td>";
     				echo "<td class=\"fr\">".$row1->make." ".stripslashes($row1->model)."</td>";
     				//echo "<td class=\"fr\"> &nbsp; </td>";

     				$price = ( $row1->cost != null ? $row1->cost : "0" );
     				$price2 = ( $row1->price2 != null ? $row1->price2 : "0" );
					$count_p = ( $row1->availiable_now != null ? $row1->availiable_now : "0" );

     				echo "<td class=\"fr\" align=\"center\"><input type=\"hidden\" name=\"prids[]\" value=\"".$row1->id."\" /><input type=\"text\" name=\"prvals[]\" class=\"txtprice\" value=\"".$price."\" /></td>";
     				echo "<td class=\"fr\" align=\"center\"><input type=\"text\" name=\"prvals2[]\" class=\"txtprice\" value=\"".$price2."\" /></td>";
					echo "<td class=\"fr\" align=\"center\"><input type=\"text\" name=\"articul[]\" class=\"txtprice2\" value=\"".$row1->articul."\" /></td>";
					echo "<td class=\"fr\" align=\"center\"><input type=\"checkbox\" name=\"count_p[]\" class=\"txtprice\" value=\"".$row1->id."\" ".($count_p==1?'checked=checked':'')." /></td>";
					echo "</tr>";
				}
				mysqli_free_result( $res1 );
			}
			else
				echo mysqli_error($upd_link_db);
		}
		mysqli_free_result( $res );
	}

  	echo "<tr><td colspan=\"7\" class=\"fr\" align=\"center\"><input type=\"submit\" name=\"setprodbut\" value=\" Применить \" /></td></tr>";
?>
    </form>
    </table>
    	</td></tr>
    </table>

<?php
    include "inc/footer-inc.php";

    include "../inc/close-inc.php";
?>
