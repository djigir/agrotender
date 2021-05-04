<?php
	require_once '../phpexcelreader/Excel/reader.php';

	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";
     include "../inc/utils-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
		exit();
    }

    setlocale(LC_ALL, "ru_RU.CP1251");

	$strings['tipedit']['en'] = "Edit trader info";
   	$strings['tipdel']['en'] = "Delete this trader";

    $strings['tipedit']['ru'] = "Редактировать трейдера";
   	$strings['tipdel']['ru'] = "Удалить трейдера из списка";

	$PAGE_HEADER['ru'] = "Редактировать Трейдеров";
	$PAGE_HEADER['en'] = "Product Brands Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_TRADER;
	$THIS_TABLE_LANG = $TABLE_TRADER_LANGS;

	// Get GET/POST environment variables
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$SKIP_ROWS = 0;
	$TMP_IMPORT_FILE = "../loadtmp/traderi.xls";

	switch( $action )
	{
    	case "add":
    		$orgname = GetParameter("orgname", "");
			$orgurl = GetParameter("orgurl", "");
			if($orgurl==""){
				$orgurl=TranslitEncode($orgname);
				$orgurl=strtolower($orgurl);

			}else{
				$orgurl=TranslitEncode($orgurl);
				$orgurl=strtolower($orgurl);
			}

    		//$orgname = str_replace ("\"", "&quot;", $orgname);
    		$orgdescr = GetParameter("orgdescr", "", false);
    		$orgdescr2 = GetParameter("orgdescr2", "", false);
    		$orgtbl = GetParameter("orgtbl", "", false);
    		$orgtblvalid = GetParameter("orgtblvalid", "");
			$orglogo = GetParameter("orglogo", "");
			$orgsort = GetParameter("orgsort", 0);

			$seotitle = GetParameter("seotitle", "");
			$seokeyw = GetParameter("seokeyw", "");
			$seodescr = GetParameter("seodescr", "");

    		$query = "INSERT INTO $THIS_TABLE ( logo_filename,url,sort_num,add_date )
    			VALUES ('".addslashes($orglogo)."','".addslashes($orgurl)."','$orgsort',NOW())";
			if(mysqli_query($upd_link_db,$query))
			{
            	$newmakeid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( item_id, lang_id, name, descr, descr2, seo_title, seo_keyw, seo_descr )
	                    VALUES ('$newmakeid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgdescr)."', '".addslashes($orgdescr2)."',
	                    '".addslashes($seotitle)."', '".addslashes($seokeyw)."', '".addslashes($seodescr)."')" ) )
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
    			if(!mysqli_query($upd_link_db,"DELETE FROM $THIS_TABLE WHERE id=".$items_id[$i]." "))
				{
        			echo "<b>".mysqli_error($upd_link_db)."</b>";
    			}
    			else
    			{
                    if( !mysqli_query($upd_link_db, "DELETE FROM $THIS_TABLE_LANG WHERE item_id='".$items_id[$i]."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }

                    //if( file_exists("..".$LINK_PHOTO_DIR.$items_id[$i].".jpg") )
					//{
					//	unlink( "..".$LINK_PHOTO_DIR.$items_id[$i].".jpg" );
					//}
                }
			}
			break;

		case "deleteitem":
			$item_id = GetParameter("item_id", "0");
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

                //if( file_exists("../".$LINK_PHOTO_DIR.$item_id.".jpg") )
				//{
				//	unlink( "../".$LINK_PHOTO_DIR.$item_id.".jpg" );
				//}
            }
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
			$orgurl = GetParameter("orgurl", "");
			if($orgurl==""){
				$orgurl=TranslitEncode($orgname);
				$orgurl=strtolower($orgurl);

			}else{
				$orgurl=TranslitEncode($orgurl);
				$orgurl=strtolower($orgurl);
			}
            //$orgname = str_replace ("\"", "&quot;", $orgname);
			$orglogo = GetParameter("orglogo", "");
			$orgdescr = GetParameter("orgdescr", "", false);
			$orgdescr2 = GetParameter("orgdescr2", "", false);

			$orgtbl = GetParameter("orgtbl", "", false);
			$orgtblvalid = GetParameter("orgtblvalid", "");
			$orgtbl2 = GetParameter("orgtbl2", "", false);
			$orgtblvalid2 = GetParameter("orgtblvalid2", "");

			$orgsort = GetParameter("orgsort", 0);
			$orgvis = GetParameter("orgvis", 0);

			$orgdt = GetParameter("orgvis", "");

			$seotitle = GetParameter("seotitle", "");
			$seokeyw = GetParameter("seokeyw", "");
			$seodescr = GetParameter("seodescr", "");

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET logo_filename='".addslashes($orglogo)."',url='".addslashes($orgurl)."', sort_num='$orgsort', visible='$orgvis', till_dt='".addslashes($orgdt)."'
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

            if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG SET name='".addslashes($orgname)."', descr='".stripslashes($orgdescr)."',
            	descr2='".stripslashes($orgdescr2)."', tbl_dat='".stripslashes($orgtbl)."', tbl_valid_to='".addslashes($orgtblvalid)."',
            	tbl_dat2='".stripslashes($orgtbl2)."', tbl_valid_to2='".addslashes($orgtblvalid2)."',
            	seo_title='".addslashes($seotitle)."', seo_keyw='".addslashes($seokeyw)."', seo_descr='".addslashes($seodescr)."'
            	WHERE item_id='".$item_id."' AND lang_id='".$LangId."'" ) )
            {
            	echo mysqli_error($upd_link_db);
            }
			break;

		case "updatetbl":
		case "updatetbl2":
			$item_id = GetParameter("item_id", "0");
			$newskip = GetParameter("newskip", 0);

			$newprice = $_FILES['newprice'];
			if( $newprice['name'] == "" )
			{
				break;
			}
			if( file_exists($TMP_IMPORT_FILE) )
				unlink( $TMP_IMPORT_FILE );
			copy( $newprice['tmp_name'], $TMP_IMPORT_FILE );


		 	$SKIP_ROWS = $newskip;
		 	// ExcelFile($filename, $encoding);
			$data = new Spreadsheet_Excel_Reader();
			// Set output Encoding.
			$data->setOutputEncoding('CP1251');
			// Read file data
			$data->read( $TMP_IMPORT_FILE );

			$out_html_tbl = "";

			$COLS_TBL = 1;

			$TBL_REGIONS = Array();


			//
			$i = (1+$SKIP_ROWS);
			for( $j=2; $j<26; $j++ )
			{
				if( isset($data->sheets[0]['cells'][$i][$j]) && (trim($data->sheets[0]['cells'][$i][$j]) != "") )
				{
					$TBL_REGIONS[] = trim($data->sheets[0]['cells'][$i][$j]);
					$COLS_TBL++;
				}
				else
				{
					break;
				}
			}

			$skip_cols = Array();
			$skip_rows = Array();

			$parsed_at_least_one_real_row = 0;

			$out_html_tbl = '';

			// Show left cols with culture
			$out_html_tbl .= '<div class="trader-tblfixed">
			<table class="traderprice">
			<tr><th> &nbsp; </td></th>';

			/// Go through rows
			for ($i = (2+$SKIP_ROWS); $i <= $data->sheets[0]['numRows']; $i++)
			{
				$celldat = ( isset($data->sheets[0]['cells'][$i][1]) ? trim($data->sheets[0]['cells'][$i][1]) : "" );

				$skip_this_row = true;

				for( $j=0; $j<count($TBL_REGIONS); $j++ )
				{
					$celldat0 = ( isset($data->sheets[0]['cells'][$i][$j+2]) ? trim($data->sheets[0]['cells'][$i][$j+2]) : "" );
					$celldat0 = trim(str_replace("-", "", $celldat0));
					if( $celldat0 != "" )
					{
						$skip_this_row = false;
						break;
					}
				}

				if( $skip_this_row )
				{
					$skip_rows[$i] = true;
					continue;
				}

				$out_html_tbl .= '<tr><th>'.$celldat.'</th></tr>';
			}


			$out_html_tbl .= '</table>
			</div>';


			// Show right cols with regions
			$out_html_tbl .= '<div class="trader-tblscroll">
			<table class="traderprice">
			<tr>';
			for( $j=0; $j<count($TBL_REGIONS); $j++ )
			{
				// Check if col is not empty
				$skip_this_col = true;

				for ($i = (2+$SKIP_ROWS); $i <= $data->sheets[0]['numRows']; $i++)
				{
					$celldat = ( isset($data->sheets[0]['cells'][$i][$j+2]) ? trim($data->sheets[0]['cells'][$i][$j+2]) : "" );
					$celldat = trim(str_replace("-", "", $celldat));
					if( $celldat != "" )
					{
						$skip_this_col = false;
						break;
					}
				}

				if( $skip_this_col )
				{
					$skip_cols[$j] = true;
					continue;
				}

				$out_html_tbl .= '<th>'.$TBL_REGIONS[$j].'</th>';
				$parsed_at_least_one_real_row++;
			}
			$out_html_tbl .= '</tr>';

			/// Go through rows
			for ($i = (2+$SKIP_ROWS); $i <= $data->sheets[0]['numRows']; $i++)
			{
				if( isset($skip_rows[$i]) && $skip_rows[$i] )
				{
					continue;
				}

				//$celldat = ( isset($data->sheets[0]['cells'][$i][1]) ? trim($data->sheets[0]['cells'][$i][1]) : "" );
				$out_html_tbl .= '<tr>';
				$col_ind = 0;
				for( $j=0; $j<count($TBL_REGIONS); $j++ )
				{
					if( isset($skip_cols[$j]) && $skip_cols[$j] )
					{
						continue;
					}

					$col_ind++;

					$celldat = ( isset($data->sheets[0]['cells'][$i][$j+2]) ? trim($data->sheets[0]['cells'][$i][$j+2]) : "" );
					$out_html_tbl .= '<td'.($col_ind % 2 == 0 ? ' class="tddrk"' : '').'>'.$celldat.'</td>';

					$parsed_at_least_one_real_row++;
				}
				$out_html_tbl .= '</tr>';
			}

			$out_html_tbl .= '</table>
			</div>';


			if( $parsed_at_least_one_real_row == 0 )
			{
				$out_html_tbl = '';
			}

			/*
			$out_html_tbl = '<table class="traderprice">
<tr>
	<th> &nbsp; </th>';
			for( $j=0; $j<count($TBL_REGIONS); $j++ )
			{
				$out_html_tbl .= '<th>'.$TBL_REGIONS[$j].'</th>';
			}
			$out_html_tbl .= '</tr>';

			/// Go through rows
			for ($i = (2+$SKIP_ROWS); $i <= $data->sheets[0]['numRows']; $i++)
			{
				$celldat = ( isset($data->sheets[0]['cells'][$i][1]) ? trim($data->sheets[0]['cells'][$i][1]) : "" );

				$out_html_tbl .= '<tr><th>'.$celldat.'</th>';
				for( $j=0; $j<count($TBL_REGIONS); $j++ )
				{
					$celldat = ( isset($data->sheets[0]['cells'][$i][$j+2]) ? trim($data->sheets[0]['cells'][$i][$j+2]) : "" );
					$out_html_tbl .= '<td>'.$celldat.'</td>';
				}
				$out_html_tbl .= '</tr>';
			}

			$out_html_tbl .= '</table>';
			*/

			if( $action == "updatetbl2" )
			{
				$query = "UPDATE $THIS_TABLE_LANG SET tbl_dat2='".addslashes($out_html_tbl)."', tbl_valid_to2='".date("d.m.Y", time())."' WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			else
			{
				$query = "UPDATE $THIS_TABLE_LANG SET tbl_dat='".addslashes($out_html_tbl)."', tbl_valid_to='".date("d.m.Y", time())."' WHERE item_id='".$item_id."' AND lang_id='".$LangId."'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			//----------------------------------------------------------------------
            $mode = "edit";
			break;
	}


    if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orglogo = "";
		$orgdescr = "";
		$orgdescr2 = "";
		$orgsort = 0;
		$orgtblvalid = "";
		$orgtblvalid2 = "";
		$orgvis = 0;
		$orgdt = "";

		$seotitle = "";
		$seokeyw = "";
		$seodescr = "";
		$orgtbl = "";
		$orgtbl2 = "";

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.name, m2.descr, m2.descr2, m2.seo_title, m2.seo_descr, m2.seo_keyw, m2.tbl_dat, m2.tbl_valid_to, m2.tbl_dat2, m2.tbl_valid_to2
			FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.item_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->name);
				$orgurl = stripslashes($row->url);
				$orglogo = stripslashes($row->logo_filename);
				$orgdescr = stripslashes($row->descr);
				$orgdescr2 = stripslashes($row->descr2);

				$orgtblvalid = stripslashes($row->tbl_valid_to);
				$orgtblvalid2 = stripslashes($row->tbl_valid_to2);

				$orgdt = stripslashes($row->till_dt);

				$orgsort = $row->sort_num;
				$orgvis = $row->visible;

				$seotitle = stripslashes($row->seo_title);
				$seokeyw = stripslashes($row->seo_keyw);
				$seodescr = stripslashes($row->seo_descr);
				$orgtbl = stripslashes($row->tbl_dat);
				$orgtbl2 = stripslashes($row->tbl_dat2);
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
	<tr><td class="ff">Видимый:</td><td class="fr"><select name="orgvis">
		<option value="1"<?=($orgvis == 1 ? ' selected' : '');?>>Да</option>
		<option value="0"<?=($orgvis == 0 ? ' selected' : '');?>>Нет</option>
	</select></td></tr>
    <tr><td class="ff">Название трейдера:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr><td class="ff">Url:</td><td class="fr"><input type="text" size="70" name="orgurl" value="<?=$orgurl;?>" /></td></tr>
    <tr><td class="ff">Период размещения:</td><td class="fr"><input type="text" size="30" name="orgdt" value="<?=$orgdt;?>" /></td></tr>
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea class="ckeditor" name="orgdescr" cols="60" rows="15"><?=$orgdescr;?></textarea></td>
	</tr>
	<tr>
		<td class="ff">Описание 2:</td>
    	<td class="fr"><textarea class="ckeditor" name="orgdescr2" cols="60" rows="15"><?=$orgdescr2;?></textarea></td>
	</tr>
	<tr><td class="ff">Цены актуальны:</td><td class="fr"><input type="text" size="70" name="orgtblvalid" value="<?=$orgtblvalid;?>" /></td></tr>
	<tr>
		<td class="ff">Таблица цен:</td>
    	<td class="fr"><textarea name="orgtbl" cols="60" rows="15"><?=$orgtbl;?></textarea></td>
	</tr>
	<tr><td class="ff">Цены продаж актуальны:</td><td class="fr"><input type="text" size="70" name="orgtblvalid2" value="<?=$orgtblvalid2;?>" /></td></tr>
	<tr>
		<td class="ff">Таблица цен продаж:</td>
    	<td class="fr"><textarea name="orgtbl2" cols="60" rows="15"><?=$orgtbl2;?></textarea></td>
	</tr>

	<tr><td class="ff">Логотип:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="30" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
	<tr><td class="ff">Title:</td><td class="fr"><input type="text" size="70" name="seotitle" value="<?=$seotitle;?>" /></td></tr>
	<tr><td class="ff">Keywords:</td><td class="fr"><textarea rows="2" cols="65" name="seokeyw"><?=$seokeyw;?></textarea></td></tr>
	<tr><td class="ff">Description:</td><td class="fr"><textarea rows="4" cols="65" name="seodescr"><?=$seodescr;?></textarea></td></tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Обновить "></td></tr>
	</form>
		</table>
	</td></tr>
	</table>


	<br>
    <h3>Импортировать таблицу цен</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
         <form action="<?=$PHP_SELF;?>" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="action" value="updatetbl">
         <input type="hidden" name="item_id" value="<?=$item_id;?>" />
         <tr><td class="ff">Пропускать первых строк:</td><td class="fr"><input type="text" size="2" name="newskip" value="0"></td></tr>
         <tr><td class="ff">Файл (.xls):</td><td class="fr"><input type="file" name="newprice"></td></tr>
         <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Загрузить файл "></td></tr>
         </form>
         </table>
     </td></tr>
     </table>


    <br>
    <h3>Импортировать таблицу цен продаж</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
         <form action="<?=$PHP_SELF;?>" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="action" value="updatetbl2">
         <input type="hidden" name="item_id" value="<?=$item_id;?>" />
         <tr><td class="ff">Пропускать первых строк:</td><td class="fr"><input type="text" size="2" name="newskip" value="0"></td></tr>
         <tr><td class="ff">Файл (.xls):</td><td class="fr"><input type="file" name="newprice"></td></tr>
         <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Загрузить файл "></td></tr>
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
    <h3>Список брендов</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr>
    	<th>&nbsp;</th>
    	<th>Логотип</th>
    	<th>Название/Описание</th>
    	<th>Видимый</th>
    	<th>Функции</th>

    	<th>&nbsp;</th>
    	<th>Логотип</th>
    	<th>Название/Описание</th>
    	<th>Видимый</th>
    	<th>Функции</th>
    </tr>
    <?
    	$found_items = 0;
    	$two_rows=0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*, m2.name, m2.descr FROM $THIS_TABLE m1,
			$THIS_TABLE_LANG m2 WHERE m1.id=m2.item_id AND m2.lang_id='$LangId' ORDER BY name") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;
                $two_rows++;
        //  if (($two_rows % 2==0) || ($two_rows==1)) echo "<tr>";
          echo "<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td><td>";
                if( $row->logo_filename != "" )
	            {
	            	echo "<img src=\"".$FILE_DIR.stripslashes($row->logo_filename)."\" alt=\"".stripslashes($row->name)." logo\" / width='50px' >";
	            }
				echo "</td>
			       <td style=\"padding: 1px 10px 1px 10px\">
			           <b>".stripslashes($row->name)."</b><br />(".$row->rate." просмотров за 183 дня)
			       </td>
			       <td align=\"center\">".($row->visible == 1 ? '<span style="font-weight: bold; color: red;">Да</span>' : 'Нет' )."</td>
			       <td align=\"center\">
			       	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
			       	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;</td>";
			       	if ($two_rows % 2==0) echo "</tr>
              <tr><td colspan=\"10\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"10\" align=\"center\"><br />В базе нет трейдеров<br /><br /></td></tr>
			<tr><td colspan=\"10\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"10\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Нового Трейдера</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr><td class="ff">Url бренда:</td><td class="fr"><input type="text" size="70" name="orgurl"></td></tr>
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea class="ckeditor" name="orgdescr" cols="60" rows="15"></textarea></td>
	</tr>
    <tr>
		<td class="ff">Описание 2:</td>
    	<td class="fr"><textarea class="ckeditor" name="orgdescr2" cols="60" rows="15"></textarea></td>
	</tr>
	<tr><td class="ff">Логотип:</td><td class="fr"><input type="text" size="30" name="orglogo" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="30" name="orgsort" /></td></tr>
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
