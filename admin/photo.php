<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    include "../inc/utils-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

	$strings['tipedit']['en'] = "Edit информацию о галерее";
   	$strings['tipdel']['en'] = "Delete this galery";
   	$strings['tipphoto']['en'] = "Edit photos list";

    $strings['tipedit']['ru'] = "Редактировать список фотогалерей";
   	$strings['tipdel']['ru'] = "Удалить фотогалерею со всеми фотографиями";
   	$strings['tipphoto']['ru'] = "Редактировать фотографии галереи";

	$PAGE_HEADER['ru'] = "Редактировать фотогалереи";
	$PAGE_HEADER['en'] = "Photo Galery Administration";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$THIS_TABLE = $TABLE_GALERY;
	$THIS_TABLE_LANG = $TABLE_GALERY_LANGS;

	// Get GET/POST environment variables
	$mode = GetParameter("mode", "");
	$action = GetParameter("action", "");

	$pagei = GetParameter("pagei", 0);
	$pagen = GetParameter("pagen", 21);

	switch( $action )
	{
		case "photo":
			$item_id = GetParameter("item_id", 0);
			$mode = "photos";
			break;

		case "photodel":
   			$item_id = GetParameter("item_id", 0);
   			$photoid = GetParameter("photoid", 0);

   			$query = "SELECT * FROM $TABLE_GALERY_PHOTO WHERE id='$photoid'";
			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object( $res ) )
				{
					// Check if files exists and remove them
					if( file_exists("../".stripslashes($row->filename)) )
                		unlink("../".stripslashes($row->filename));

                    if( file_exists("../".stripslashes($row->filename_thumb)) )
                		unlink("../".stripslashes($row->filename_thumb));

                    if( file_exists("../".stripslashes($row->filename_ico)) )
                		unlink("../".stripslashes($row->filename_ico));
				}
				mysqli_free_result( $res );
			}

			// Delete record from database about file
			$query = "DELETE FROM $TABLE_GALERY_PHOTO WHERE id='$photoid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			else
			{
				$query1 = "DELETE FROM $TABLE_GALERY_PHOTO_LANGS WHERE item_id='$photoid'";
			    if( !mysqli_query($upd_link_db, $query1 ) )
			    {
			    	echo mysqli_error($upd_link_db);
			    }
			}

			$mode = "photos";
			break;

		case "photoed":
			$item_id = GetParameter("item_id", 0);
   			$photoid = GetParameter("photoid", 0);

   			$mode = "editphotoinfo";
			break;

		case "photoupd":
			$item_id = GetParameter("item_id", 0);
   			$photoid = GetParameter("photoid", 0);

   			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");

			$query = "UPDATE $TABLE_GALERY_PHOTO SET sort_num='$photoind' WHERE id=$photoid";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "UPDATE $TABLE_GALERY_PHOTO_LANGS SET title='".addslashes($phototitle)."', descr='".addslashes($photodescr)."'
				WHERE item_id=$photoid AND lang_id='$LangId'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

   			$mode = "photos";
			break;

		case "addphoto":
			$item_id = GetParameter("item_id", 0);

			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");
            $photofile = $_FILES['photofile'];

            if( empty($photofile['name']) || ($photofile['name'] == "") )
            	break;

			$point_pos = strrpos($photofile['name'], ".");
			if( $point_pos == -1 )
				break;
            $newfileext = substr($photofile['name'], $point_pos );

            if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_GALERY_PHOTO (item_id, sort_num, add_date) VALUES
            	('$item_id', '".$photoind."', NOW())" ) )
            {
               echo mysqli_error($upd_link_db);
            }
            {
            	$picid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_GALERY_PHOTO_LANGS ( item_id, lang_id, title, descr )
	                    VALUES ('$picid', '".$langs[$i]."', '".addslashes($phototitle)."', '".addslashes($photodescr)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }

            	// Now we should make resized copies for all images
            	$finalname = $picid.".jpg";

            	$srcname = $GALERY_DIR.$item_id."/".$GALERY_PHOTO.$finalname;
            	$thumbname = $GALERY_DIR.$item_id."/".$GALERY_THUMB.$finalname;
            	$iconame = $GALERY_DIR.$item_id."/".$GALERY_ICO.$finalname;

            	// Make big photo
            	//$res = ResizeImage( $photofile['tmp_name'], "../".$srcname, strtolower($newfileext), ".jpg", $GALERY_P_W, $GALERY_P_H, false, $JPEG_COMPRESS_RATIO);
            	$res = copy( $photofile['tmp_name'], "../".$srcname);
				if( !$res )
				{
					echo "Произошла ошибка при создании большого пережатого изображения.<br />";
				}
				else
				{
					$imgsz = GetImageSizeAll( "../".$srcname, ".jpg" );

			  		$thw = 0;
					$thh = 0;
					if( $imgsz != null )
					{
						$thw = $imgsz['w'];
						$thh = $imgsz['h'];
					}

	   				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_GALERY_PHOTO SET
	                    	filename='".addslashes($srcname)."',
	                    	src_w=$thw, src_h=$thh WHERE id='$picid'" ) )
	    			{
	   					echo mysqli_error($upd_link_db);
	    			}
	   			}

	   			// Make thumb photo
            	$res = ResizeImage( $photofile['tmp_name'], "../".$thumbname, strtolower($newfileext), ".jpg", $GALERY_T_W, $GALERY_T_H, false, $JPEG_COMPRESS_RATIO);
				if( !$res )
				{
					echo "Произошла ошибка при создании среднего пережатого изображения.<br />";
				}
				else
				{
					$imgsz = GetImageSizeAll( "../".$thumbname, ".jpg" );

			  		$thw = 0;
					$thh = 0;
					if( $imgsz != null )
					{
						$thw = $imgsz['w'];
						$thh = $imgsz['h'];
					}

	   				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_GALERY_PHOTO SET
	                    	filename_thumb='".addslashes($thumbname)."',
	                    	thumb_w=$thw, thumb_h=$thh WHERE id='$picid'" ) )
	    			{
	   					echo mysqli_error($upd_link_db);
	    			}
	   			}

	   			// Make ico photo
            	$res = ResizeImage( $photofile['tmp_name'], "../".$iconame, strtolower($newfileext), ".jpg", $GALERY_I_W, $GALERY_I_H, true, $JPEG_COMPRESS_RATIO);
				if( !$res )
				{
					echo "Произошла ошибка при создании малого пережатого изображения.<br />";
				}
				else
				{
					$imgsz = GetImageSizeAll( "../".$iconame, ".jpg" );

			  		$thw = 0;
					$thh = 0;
					if( $imgsz != null )
					{
						$thw = $imgsz['w'];
						$thh = $imgsz['h'];
					}

	   				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_GALERY_PHOTO SET
	                    	filename_ico='".addslashes($iconame)."',
	                    	ico_w=$thw, ico_h=$thh WHERE id='$picid'" ) )
	    			{
	   					echo mysqli_error($upd_link_db);
	    			}
	   			}
	   		}

			$mode = "photos";
			break;

    	case "add":
    		$orgname = GetParameter("orgname", "");
    		$orgdescr = GetParameter("orgdescr", "", false);
			$orglogo = GetParameter("orglogo", "");
			$orgsort = GetParameter("orgsort", 0);
			$orgfirst = GetParameter("orgfirst", 0);

    		$query = "INSERT INTO $THIS_TABLE ( first_page, logo_filename, add_date, modify_date, sort_num )
    			VALUES ($orgfirst, '".addslashes($orglogo)."', NOW(), NOW(), $orgsort)";
			if(mysqli_query($upd_link_db,$query))
			{
            	$newid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $THIS_TABLE_LANG ( item_id, lang_id, title, content )
	                    VALUES ('$newid', '".$langs[$i]."', '".addslashes($orgname)."', '".addslashes($orgdescr)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }

	            // Now we should make folder for this galery
             	mkdir( "../".$GALERY_DIR.$newid, 0777 );
             	chmod( "../".$GALERY_DIR.$newid, 0777 );

             	mkdir( "../".$GALERY_DIR.$newid."/".$GALERY_PHOTO, 0777 );
             	chmod( "../".$GALERY_DIR.$newid."/".$GALERY_PHOTO, 0777 );

             	mkdir( "../".$GALERY_DIR.$newid."/".$GALERY_THUMB, 0777 );
             	chmod( "../".$GALERY_DIR.$newid."/".$GALERY_THUMB, 0777 );

             	mkdir( "../".$GALERY_DIR.$newid."/".$GALERY_ICO, 0777 );
             	chmod( "../".$GALERY_DIR.$newid."/".$GALERY_ICO, 0777 );
			}
			else
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "delete":
			// Delete whole galery
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

					// Now we should delete all photos in galery and folders
     				$query = "SELECT * FROM $TABLE_GALERY_PHOTO WHERE item_id='".$items_id[$i]."'";
					if( $res = mysqli_query($upd_link_db, $query ) )
					{
						while( $row = mysqli_fetch_object( $res ) )
						{
							// Check if files exists and remove them
							if( file_exists("../".stripslashes($row->filename)) )
		                		unlink("../".stripslashes($row->filename));

		                    if( file_exists("../".stripslashes($row->filename_thumb)) )
		                		unlink("../".stripslashes($row->filename_thumb));

		                    if( file_exists("../".stripslashes($row->filename_ico)) )
		                		unlink("../".stripslashes($row->filename_ico));

		     				$query1 = "DELETE FROM $TABLE_GALERY_PHOTO_LANGS WHERE item_id='".$row->id."'";
						    if( !mysqli_query($upd_link_db, $query1 ) )
						    {
						    	echo mysqli_error($upd_link_db);
						    }
						}
						mysqli_free_result( $res );
					}

					// Now we should make folder for this galery
	             	rmdir( "../".$GALERY_DIR.$items_id[$i]."/".$GALERY_PHOTO );
	             	rmdir( "../".$GALERY_DIR.$items_id[$i]."/".$GALERY_THUMB );
	             	rmdir( "../".$GALERY_DIR.$items_id[$i]."/".$GALERY_ICO );
	             	rmdir( "../".$GALERY_DIR.$items_id[$i] );
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

				// Now we should delete all photos in galery and folders
    			$query = "SELECT * FROM $TABLE_GALERY_PHOTO WHERE item_id='$item_id'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						// Check if files exists and remove them
						if( file_exists("../".stripslashes($row->filename)) )
	                		unlink("../".stripslashes($row->filename));

	                    if( file_exists("../".stripslashes($row->filename_thumb)) )
	                		unlink("../".stripslashes($row->filename_thumb));

	                    if( file_exists("../".stripslashes($row->filename_ico)) )
	                		unlink("../".stripslashes($row->filename_ico));

	     				$query1 = "DELETE FROM $TABLE_GALERY_PHOTO_LANGS WHERE item_id='".$row->id."'";
					    if( !mysqli_query($upd_link_db, $query1 ) )
					    {
					    	echo mysqli_error($upd_link_db);
					    }
					}
					mysqli_free_result( $res );
				}

				// Now we should make folder for this galery
             	rmdir( "../".$GALERY_DIR.$item_id."/".$GALERY_PHOTO );
             	rmdir( "../".$GALERY_DIR.$item_id."/".$GALERY_THUMB );
             	rmdir( "../".$GALERY_DIR.$item_id."/".$GALERY_ICO );
             	rmdir( "../".$GALERY_DIR.$item_id );
            }
			break;

		case "update":
			$item_id = GetParameter("item_id", "");
            $orgname = GetParameter("orgname", "");
			$orglogo = GetParameter("orglogo", "");
			$orgdescr = GetParameter("orgdescr", "", false);
			$orgsort = GetParameter("orgsort", 0);
			$orgfirst = GetParameter("orgfirst", 0);

			/*
			if( file_exists("../".$LINK_PHOTO_DIR.$item_id.".jpg") )
			{
				unlink( "../".$LINK_PHOTO_DIR.$item_id.".jpg" );
			}
			*/

			if(!mysqli_query($upd_link_db,"UPDATE $THIS_TABLE
                        SET sort_num=$orgsort, first_page=$orgfirst, logo_filename='".addslashes($orglogo)."', modify_date=NOW()
                        WHERE id=".$item_id." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

            if( !mysqli_query($upd_link_db, "UPDATE $THIS_TABLE_LANG SET title='".addslashes($orgname)."', content='".stripslashes($orgdescr)."'
            	WHERE item_id='".$item_id."' AND lang_id='".$LangId."'" ) )
            {
            	echo mysqli_error($upd_link_db);
            }
			break;
	}


	if( $mode == "editphotoinfo" )
	{
		$photo = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_GALERY_PHOTO p1
			INNER JOIN $TABLE_GALERY_PHOTO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.id=$photoid";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$pi = Array();

				$pi['id'] = $row->id;
				$pi['alt'] = stripslashes($row->title);
				$pi['descr'] = stripslashes($row->descr);
				$pi['snum'] = $row->sort_num;

				$pi['pic'] = "../".stripslashes($row->filename);
				$pi['pic_w'] = $row->src_w;
				$pi['pic_h'] = $row->src_h;

				$pi['thumb'] = "../".stripslashes($row->filename_thumb);
				$pi['thumb_w'] = $row->thumb_w;
				$pi['thumb_h'] = $row->thumb_h;

				$pi['ico'] = "../".stripslashes($row->filename_ico);
				$pi['ico_w'] = $row->ico_w;
				$pi['ico_h'] = $row->ico_h;

				$pi['date'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$photo = $pi;
			}
			mysqli_free_result( $res );
		}
?>
		<br />
		<center><a href="<?=$PHP_SELF;?>?item_id=<?=$item_id;?>&action=photo">Вернуться к списку фотографий</a></center>

		<h3>Редактировать информацию о фотографии</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm" enctype="multipart/form-data">
		<input type="hidden" name="item_id" value="<?=$item_id;?>" />
		<input type="hidden" name="photoid" value="<?=$photoid;?>" />
		<input type="hidden" name="action" value="photoupd" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
		        <table width="100%" cellspacing="1" cellpadding="1" border="0">
		        <tr>
					<td colspan="2" class="fh">Информация о фото</td>
				</tr>
		        <tr>
					<td class="ff">Заголовок для фото:</td>
					<td class="fr">
		                <input type="text" name="phototitle" size="40" value="<?=$photo['alt'];?>" />
					</td>
				</tr>
				<tr>
					<td class="ff">Описание фото:</td>
					<td class="fr">
		                <textarea name="photodescr" cols="50" rows="5"><?=$photo['descr'];?></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Фото файл:</td>
					<td class="fr">
		                <img src="<?=$photo['thumb'];?>" width="<?=$photo['thumb_w'];?>" height="<?=$photo['thumb_h'];?>" alt="" />
					</td>
				</tr>
				<tr>
					<td class="ff">Порядковый номер:</td>
					<td class="fr">
		                <input type="text" name="photoind" size="2" value="<?=$photo['snum'];?>" />
					</td>
				</tr>
				<tr>
				<td colspan="2" class="fr" align="center"><input type="submit" name="applybut" value="Сохранить" /></td>
				</tr>
				</table>
			</td></tr>
			</table>
		</form>
<?php
	}
	else if( $mode == "photos" )
	{
		$photos = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_GALERY_PHOTO p1
			INNER JOIN $TABLE_GALERY_PHOTO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.item_id=$item_id
			ORDER BY p1.sort_num,p1.add_date";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$pi = Array();

				$pi['id'] = $row->id;
				$pi['alt'] = stripslashes($row->title);
				$pi['snum'] = $row->sort_num;

				$pi['pic'] = "../".stripslashes($row->filename);
				$pi['pic_w'] = $row->src_w;
				$pi['pic_h'] = $row->src_h;

				$pi['thumb'] = "../".stripslashes($row->filename_thumb);
				$pi['thumb_w'] = $row->thumb_w;
				$pi['thumb_h'] = $row->thumb_h;

				$pi['ico'] = "../".stripslashes($row->filename_ico);
				$pi['ico_w'] = $row->ico_w;
				$pi['ico_h'] = $row->ico_h;

				$pi['date'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$photos[] = $pi;
			}
			mysqli_free_result( $res );
		}
?>
		<h3>Фотографии галереи</h3>
		<table cellspacing="10" cellpadding="0" width="100%" border="0">
<?php
		if( count($photos) > 0 )
		{
			$COLS = 4;
			for($i=0; $i<count($photos); $i++)
			{
				if( ($i+1) % $COLS == 1 )
					echo "<tr>";

				echo "<td align=\"center\"><div style=\"border: 1px solid #b0b0b0; height: 160px;\">";
				echo "<div style=\"padding: 3px 0px 5px 0px;\">
					<a href=\"$PHP_SELF?item_id=$item_id&action=photodel&photoid=".$photos[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить фотографию из галереи\" /></a>&nbsp;
     				<a href=\"$PHP_SELF?item_id=$item_id&action=photoed&photoid=".$photos[$i]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать описание фотографии\" /></a>&nbsp;
     			</div>";
				//echo "<a href=\"$PHP_SELF?item_id=$item_id&action=photodel&photoid=".$photos[$i]['id']."\">Удалить</a><br />";
				echo "<img src=\"".$photos[$i]['ico']."\" width=\"".$photos[$i]['ico_w']."\" height=\"".$photos[$i]['ico_h']."\" style=\"border: 1px solid #b0b0b0;\" alt=\"".$photos[$i]['alt']."\" />";
				echo "<div style=\"padding: 3px 0px 5px 0px\">№ сорт. ".$photos[$i]['snum']."</div>";
				echo "</div></td>";

				if( ($i+1) % $COLS == 0 )
					echo "</tr>";
			}

			if( ($i+1) % $COLS != 0 )
			{
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr><td align=\"center\">Нет фотографий в данной галерее</td></tr>";
		}
?>
		</table>
		<br />
		<center><a href="<?=$PHP_SELF;?>">Вернуться к списку фотогалерей</a></center>

		<h3>Добавить фотографию</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm" enctype="multipart/form-data">
		<input type="hidden" name="item_id" value="<?=$item_id;?>" />
		<input type="hidden" name="action" value="addphoto" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
		        <table width="100%" cellspacing="1" cellpadding="1" border="0">
		        <tr>
					<td colspan="2" class="fh">Добавить фото в галерею</td>
				</tr>
		        <tr>
					<td class="ff">Заголовок для фото:</td>
					<td class="fr">
		                <input type="text" name="phototitle" size="40" />
					</td>
				</tr>
				<tr>
					<td class="ff">Описание фото:</td>
					<td class="fr">
		                <textarea name="photodescr" cols="50" rows="5"></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Фото файл (*.jpg, *.png, *.gif):</td>
					<td class="fr">
		                <input type="file" name="photofile" />
					</td>
				</tr>
				<tr>
					<td class="ff">Порядковый номер:</td>
					<td class="fr">
		                <input type="text" name="photoind" size="2" />
					</td>
				</tr>
				<tr>
				<td colspan="2" class="fr" align="center"><input type="submit" name="addnewbut" value="Добавить" /></td>
				</tr>
				</table>
			</td></tr>
			</table>
		</form>
<?php
	}
    else if( $mode == "edit" )
    {
		$item_id = GetParameter("item_id", "0");
		$orgname = "";
		$orglogo = "";
		$orgdescr = "";
		$orgsort = 0;
		$orgfirst = 0;

		if($res = mysqli_query($upd_link_db,"SELECT m1.*, m2.title, m2.content FROM $THIS_TABLE m1, $THIS_TABLE_LANG m2
			WHERE m1.id='$item_id' AND m1.id=m2.item_id AND m2.lang_id='$LangId'"))
		{
			if($row = mysqli_fetch_object($res))
			{
				$orgname = stripslashes($row->title);
				$orglogo = stripslashes($row->logo_filename);
				$orgdescr = stripslashes($row->content);
				$orgsort = $row->sort_num;
				$orgfirst = $row->first_page;
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
    <tr><td class="ff">Название галереи:</td><td class="fr"><input type="text" size="70" name="orgname" value="<?=$orgname;?>" /></td></tr>
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea name="orgdescr" cols="60" rows="10"><?=$orgdescr;?></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	<tr><td class="ff">Картинка:</td><td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
	<tr><td class="ff">Показывать на главной:</td>
		<td class="fr">
			<select name="orgfirst">
			<option value="0" <?=($orgfirst == 0 ? "selected" : "");?>>Нет</option>
			<option value="1" <?=($orgfirst == 1 ? "selected" : "");?>>Да</option>
			</select>
		</td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="2" name="orgsort" value="<?=$orgsort;?>" /></td></tr>
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
?>
    <h3>Список галерей</h3>
    <table align="center" cellspacing="2" cellpadding="0">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="delete" />
    <tr><th>&nbsp;</th><th>Картинка</th><th>Название галереи</th><th>Фото</th><th>Функции</th></tr>
    <?
    	$found_items = 0;
		if( $res = mysqli_query($upd_link_db,"SELECT m1.*, m2.title, m2.content, count(p1.id) as photosnum
			FROM $THIS_TABLE m1
			INNER JOIN $THIS_TABLE_LANG m2 ON m1.id=m2.item_id AND m2.lang_id='$LangId'
			LEFT JOIN $TABLE_GALERY_PHOTO p1 ON m1.id=p1.item_id
			GROUP BY m1.id
			ORDER BY sort_num, add_date DESC") )
		{
			while($row=mysqli_fetch_object($res))
			{
                $found_items++;

            	echo "<tr>
                               <td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                               <td>";
                if( $row->logo_filename != "" )
	            {
	            	echo "<img src=\"".$FILE_DIR.stripslashes($row->logo_filename)."\" width=\"".$THUMB_W."\" height=\"".$THUMB_H."\"  alt=\"".stripslashes($row->title)." logo\" />";
	            }
                     	  echo "</td>
                               <td style=\"padding: 1px 10px 1px 10px\">
                                   <b>".stripslashes($row->title)."</b><br />
                                   ".stripslashes($row->content)."
                               </td>
                               <td align=\"center\">".$row->photosnum."</td>
                               <td align=\"center\">
                               	<a href=\"$PHP_SELF?action=deleteitem&item_id=".$row->id."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&mode=edit\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp;
                               	<a href=\"$PHP_SELF?item_id=".$row->id."&action=photo\"><img src=\"img/photo.gif\" width=\"24\" height=\"20\" border=\"0\" alt=\"".$strings['tipphoto'][$lang]."\" /></a>&nbsp;</td>
                </tr>
                <tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
			}
            mysqli_free_result($res);
		}

		if( $found_items == 0 )
		{
			echo "<tr><td colspan=\"5\" align=\"center\"><br />В базе нет фотогалерей<br /><br /></td></tr>
			<tr><td colspan=\"5\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
        }
        else
        {
        	echo "<tr><td align=\"center\" colspan=\"5\"><input type=\"submit\" name=\"delete_but\" value=\" Удалить \" /></td></tr>";
        }
    ?>
    </form>
    </table>

    <br /><br />
    <h3>Добавить Новую Галерею</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" name="catfrm" method="POST">
    <input type="hidden" name="action" value="add">
    <tr><td class="ff">Название галереи:</td><td class="fr"><input type="text" size="70" name="orgname"></td></tr>
    <tr>
		<td class="ff">Описание:</td>
    	<td class="fr"><textarea name="orgdescr" cols="60" rows="10"></textarea></td>
	</tr>
<script language="javascript1.2">
    editor_generate('orgdescr'); // field, width, height
</script>
	<tr><td class="ff">Показывать на главной:</td>
		<td class="fr">
			<select name="orgfirst">
			<option value="0">Нет</option>
			<option value="1">Да</option>
			</select>
		</td></tr>
	<tr><td class="ff">Порядковый номер:</td><td class="fr"><input type="text" size="2" name="orgsort" /></td></tr>
	<tr><td class="ff">Картинка:</td><td class="fr"><input type="text" size="30" name="orglogo" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td></tr>
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
