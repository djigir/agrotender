<?php
	require_once '../phpexcelreader/Excel/reader.php';

	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    //include "../inc/catutils-inc.php";

    setlocale(LC_ALL, "ru_RU.CP1251");

	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");
	$PAGE_HEADER['ru'] = "Загрузка элеваторов";
	$PAGE_HEADER['en'] = "Upload price list";

	// INCLUDE YOUR HEADER FILE HERE
	include "inc/header-inc.php";

	$strings['formhdr']['ru'] = "Загрузить файл с элеваторами";
	$strings['formhdr']['en'] = "Upload elevator archive";

	$SKIP_ROWS = 0;
	$TMP_IMPORT_FILE = "../loadtmp/elevreg.xls";
	$map_xls = Array("rayon" => 1, "name" => 2, "orgname" => 3, "orgaddr" => 4,  "addr" => 5,  "phones" => 6, "director" => 7, "sposhold" => 8, "usl_podr" => 9, "usl_qual" => 10 );

switch( $action )
{
	case "update":
		$newskip = GetParameter("newskip", 0);
		$oblid = GetParameter("oblid", 0);
		$newprice = $_FILES['newprice'];
		if( $newprice['name'] == "" )
		{
			break;
		}
		$SKIP_ROWS = $newskip;
		if( file_exists($TMP_IMPORT_FILE) )
			unlink( $TMP_IMPORT_FILE );
		copy( $newprice['tmp_name'], $TMP_IMPORT_FILE );
		// ExcelFile($filename, $encoding);
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		// Read file data
		$data->read( $TMP_IMPORT_FILE );

		//echo "Total items: ".$data->sheets[0]['numRows']."<br />";
		$col=$data->sheets[0]['numRows'] - $SKIP_ROWS;
		echo "Количество строк в файле: ".$col."<br />";

		$products = Array();

		$tot_items_in_price = 0;		// Количество строк в прайсе с артикулами

		// Go through rows
		for ($i = (1+$SKIP_ROWS); $i <= $data->sheets[0]['numRows']; $i++)
		{
			if( isset( $data->sheets[0]['cells'][$i][$map_xls["rayon"]] ) && isset( $data->sheets[0]['cells'][$i][$map_xls["name"]] ) )
			{
				$tot_items_in_price++;

				$prodit = Array();
				foreach( $map_xls as $k => $v )
				{
					if( $v != -1 )
					{
						$prodit[$k] = ( isset($data->sheets[0]['cells'][$i][$v]) ? trim($data->sheets[0]['cells'][$i][$v]) : '' );
					}
				}
				$products[] = $prodit;
			}
		}


		$new_items = 0;

		$raylist = Array();

		for($i=0; $i<count($products); $i++)
		{
			if( isset($raylist[$products[$i]['rayon']]) )
			{
				// already added
			}
			else
			{
				$raylist[$products[$i]['rayon']] = $products[$i]['rayon'];
			}

			$this_prod_id = 0;
			$query = "SELECT * FROM $TABLE_TORG_ELEV e1
				INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId' AND e2.name LIKE '".addslashes($products[$i]['name'])."'
				WHERE e1.obl_id='".$oblid."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$this_prod_id = $row->id;
				}
				mysqli_free_result( $res );
			}
			else
				echo mysqli_error($upd_link_db);

			if( $this_prod_id != 0 )
			{
				//echo "Товар в базе, артикул: ".$this_prod_id."=>".$products[$i]['siteartic']."<br />";
			}
			else
			{
				echo "Элеватора нет в базе: ".$products[$i]['name'].", ".$products[$i]['rayon']." район<br />";
				$new_items++;
			}
		}

		// Check if the names of the rayon is correct
		foreach( $raylist as $rk => $rn )
		{
			$ray_id = 0;
			$query = "SELECT r1.* FROM $TABLE_RAYON r1
				INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId' AND name LIKE '".addslashes($rn)."'
				WHERE r1.obl_id='".$oblid."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$ray_id = $row->id;
				}
				mysqli_free_result( $res );
			}

			if( $ray_id == 0 )
			{
				echo 'Района нет в базе - '.$rk.'<br />';
			}

			$raylist[$rk] = $ray_id;
		}

		echo "<br />";
		echo '<br /><table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
   		<tr><td>
   		<table cellspacing="1" cellpadding="1" border="0">
		<form action="'.$PHP_SELF.'" method="POST">
		<input type="hidden" name="action" value="applyimport" />
		<input type="hidden" name="importfile" value="'.$TMP_IMPORT_FILE.'" />
		<input type="hidden" name="newskip" value="'.$SKIP_ROWS.'" />
		<input type="hidden" name="oblid" value="'.$oblid.'" />
		<tr>
			<td class="fr">Всего позиций в файле: </td>
			<td class="fr">'.$tot_items_in_price.'</td>
			<td class="fr"> &nbsp; </td>
		</tr>
		<tr>
			<td class="fr">Из них для импорта: </td>
			<td class="fr">'.count($products).'</td>
			<td class="fr"> &nbsp; </td>
		</tr>
		<tr>
			<td class="fr">Новых элеваторов не из базы: </td>
			<td class="fr">'.$new_items.'</td>
			<td class="fr"> &nbsp; </td>
		</tr>
		<tr>
			<td class="fr">Было в базе: </td>
			<td class="fr">'.(count($products) - $new_items).' элеваторов</td>
			<td class="fr"> &nbsp; </td>
		</tr>';

		echo '<tr><td class="fr" colspan="3" align="center"><input type="submit" value=" Выполнить импорт "></td></tr>
		</form></table>
		</td></tr>
		</table>';

		$mode = "check";
		break;

	case "applyimport":
		$oblid = GetParameter("oblid", 0);
		$newskip = GetParameter("newskip", 0);
	 	$SKIP_ROWS = $newskip;
	 	// ExcelFile($filename, $encoding);
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		// Read file data
		$data->read( $TMP_IMPORT_FILE );

		$products = Array();

		/// Go through rows
		for ($i = (1+$SKIP_ROWS); $i <= $data->sheets[0]['numRows']; $i++)
		{
			if( isset( $data->sheets[0]['cells'][$i][$map_xls["rayon"]] ) && isset( $data->sheets[0]['cells'][$i][$map_xls["name"]] ) )
			{
				$prodit = Array();
				foreach( $map_xls as $k => $v )
				{
					if( $v != -1 )
					{
						$prodit[$k] = ( isset($data->sheets[0]['cells'][$i][$v]) ? trim($data->sheets[0]['cells'][$i][$v]) : '' );
					}
				}
				$products[] = $prodit;
			}
		}


		//----------------------------------------------------------------------
		$new_items = 0;
		$imported_num = 0;

		$raylist = Array();
		for($i=0; $i<count($products); $i++)
		{
			if( isset($raylist[$products[$i]['rayon']]) )
			{
				// already added
			}
			else
			{
				$raylist[$products[$i]['rayon']] = $products[$i]['rayon'];
			}
		}

		// Check if the names of the rayon is correct
		foreach( $raylist as $rk => $rn )
		{
			$ray_id = 0;
			$query = "SELECT r1.* FROM $TABLE_RAYON r1
				INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId' AND name LIKE '".addslashes($rn)."'
				WHERE r1.obl_id='".$oblid."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$ray_id = $row->id;
				}
				mysqli_free_result( $res );
			}

			if( $ray_id == 0 )
			{
				echo 'Района нет в базе - '.$rk.'<br />';
			}

			$raylist[$rk] = $ray_id;
		}

		for($i=0; $i<count($products); $i++)
		{
			$this_prod_id = 0;
			$query = "SELECT * FROM $TABLE_TORG_ELEV e1
				INNER JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId' AND e2.name LIKE '".$products[$i]['name']."'
				WHERE e1.obl_id='".$oblid."'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					$this_prod_id = $row->id;
				}
				mysqli_free_result( $res );
			}
			if( $this_prod_id != 0 )
			{
				echo "Элеваторв в базе, ID: ".$this_prod_id." => ".$products[$i]['name']."<br />";
			}
			else
			{
				echo "Елеватора импортируется в базу: ".$products[$i]['name'].", ".$products[$i]['rayon']." район<br />";

				$query = "INSERT INTO $TABLE_TORG_ELEV (obl_id, ray_id, phone, elev_url) VALUES
					('".$oblid."', '".$raylist[$products[$i]['rayon']]."', '".addslashes($products[$i]['phones'])."', '')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
				else
				{
					$newelevid = mysqli_insert_id($upd_link_db);
	                for( $i1=0; $i1<count($langs); $i1++ )
	                {
	                	if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_TORG_ELEV_LANGS
	                		( item_id, lang_id, name, orgname, addr, orgaddr, holdcond, descr_podr, descr_qual,director )
		                    VALUES
		                    ('$newelevid', '".$langs[$i1]."', '".addslashes($products[$i]['name'])."', '".addslashes($products[$i]['orgname'])."',
		                    '".addslashes($products[$i]['addr'])."', '".addslashes($products[$i]['orgaddr'])."',
		                    '".addslashes($products[$i]['sposhold'])."', '".addslashes($products[$i]['usl_podr'])."',
		                    '".addslashes($products[$i]['usl_qual'])."', '".addslashes($products[$i]['director'])."')" ) )
		                {
		                   echo mysqli_error($upd_link_db);
		                }
		            }

		            $new_items++;
				}
			}
		}
		echo "<div style=\"text-align: center;\"><br /><br /><b>Импортировано $new_items позиций прайса. Для ".(count($products) - $new_items)." были найдены соответствия в ранее импортированных записях.</b><br /><br /></div>";
		break;
}
	if( $mode == "" )
	{
?>
    <br>
    <h3><?=$strings['formhdr'][$lang];?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
         <form action="<?=$PHP_SELF;?>" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="action" value="update">
         <input type="hidden" name="mode" value="<?=$mode;?>">
         <tr>
         	<td class="ff">Формат прайс-листа:</td>
         	<td class="fr">
			<?php
				foreach($map_xls as $coln => $colind)
				{
					echo 'Колонка '.$colind.' - '.$coln.'<br />';
				}
			?>
         	</td>
         </tr>
         <tr><td class="ff">Пропускать первых строк:</td><td class="fr"><input type="text" size="2" name="newskip" value="0"></td></tr>
         <tr>
         	<td class="ff">Элеваторы из области:</td>
         	<td class="fr"><select name="oblid">
         	<?php
         		for($i=1; $i<count($REGIONS); $i++)
         		{
					echo '<option value="'.$i.'">'.$REGIONS[$i].'</option>';
				}
         	?>
         	</select></td>
         </tr>
         <tr><td class="ff">Файл (.xls):</td><td class="fr"><input type="file" name="newprice"></td></tr>
         <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Загрузить прайс "></td></tr>
         </form>
         </table>
     </td></tr>
     </table>
<?php
	}


    include("inc/footer-inc.php");

    include("../inc/close-inc.php");
?>
