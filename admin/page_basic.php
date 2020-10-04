<?
	$HTMLAREA=true;

	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/utils-inc.php";

    include "../inc/ses-inc.php";

    include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    $PAGE_HEADER['ru'] = "Редактировать Заголовки Страниц";
   	$PAGE_HEADER['en'] = "Page Headers Editing";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

    $strings["hdrsel"]["ru"] = "Выберете старницу для редактирования";
    $strings["hdredit"]["ru"] = "Редактировать страницу";
    $strings["rowedit"]["ru"] = "Редактировать";
    $strings["rowsel"]["ru"] = "Выберите страницу";
    $strings["btnnext"]["ru"] = "Далее";
    $strings["rowtitle"]["ru"] = "Заголовок Страницы";
    $strings["rowheader"]["ru"] = "Верхний Контент";
    $strings["rowfooter"]["ru"] = "Нижний Контент";
    $strings["btnapply"]["ru"] = "Применить";
    $strings["hdrname"]["ru"] = "Название";
    $strings["hdrcont"]["ru"] = "Контент";

	$strings["hdrsel"]["en"] = "Select page for editing";
	$strings["hdredit"]["en"] = "Editing page";
	$strings["rowedit"]["en"] = "Edit page";
	$strings["rowsel"]["en"] = "Select page";
	$strings["btnnext"]["en"] = "Continue";
	$strings["rowtitle"]["en"] = "Page Title";
	$strings["rowheader"]["en"] = "Top text";
	$strings["rowfooter"]["en"] = "Bottom text";
	$strings["btnapply"]["en"] = "Apply";
	$strings["hdrname"]["en"] = "Name";
	$strings["hdrcont"]["en"] = "Content";

    //require_once "inccat/functions.inc.php";

	$action = GetParameter( "action" , "" );
	$mode = GetParameter( "mode", "content" );
	$id = GetParameter( "id", "" );

	//---------------------------- categoriesUpd --------------------------------
	switch($action)
	{
		case "resdel":
			$id = GetParameter("id", 0);
   			$resid = GetParameter("resid", 0);

   			$query = "DELETE FROM $TABLE_PAGE_RESOURCES WHERE id='$resid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

   			$mode = "photos";
			break;

		case "addres":
			$id = GetParameter("id", 0);

			$resdisp = GetParameter("resdisp", 1);
			$resind = GetParameter("resind", 0);
			$resblock = GetParameter("resblock", 0);

			if($resblock != 0 )
			{
				$query = "INSERT INTO $TABLE_PAGE_RESOURCES (page_id, item_id, display_type, sort_num, add_date) VALUES
					('$id', '$resblock', '$resdisp', '$resind', NOW())";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			break;

		case "photodel":
   			$id = GetParameter("id", 0);
   			$photoid = GetParameter("photoid", 0);

   			$query = "SELECT * FROM $TABLE_PAGE_PHOTO WHERE id='$photoid'";
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
			$query = "DELETE FROM $TABLE_PAGE_PHOTO WHERE id='$photoid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			else
			{
				$query1 = "DELETE FROM $TABLE_PAGE_PHOTO_LANGS WHERE item_id='$photoid'";
			    if( !mysqli_query($upd_link_db, $query1 ) )
			    {
			    	echo mysqli_error($upd_link_db);
			    }
			}

			$mode = "photos";
			break;

		case "photoed":
			$id = GetParameter("id", 0);
   			$photoid = GetParameter("photoid", 0);

   			$mode = "editphotoinfo";
			break;

		case "photoupd":
			$id = GetParameter("id", 0);
   			$photoid = GetParameter("photoid", 0);

   			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");

			$query = "UPDATE $TABLE_PAGE_PHOTO SET sort_num='$photoind' WHERE id=$photoid";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "UPDATE $TABLE_PAGE_PHOTO_LANGS SET title='".addslashes($phototitle)."', descr='".addslashes($photodescr)."'
				WHERE item_id=$photoid AND lang_id='$LangId'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

   			$mode = "photos";
			break;

		case "addphoto":
			$id = GetParameter("id", 0);

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

            if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_PAGE_PHOTO (item_id, sort_num, add_date) VALUES
            	('$id', '".$photoind."', NOW())" ) )
            {
               echo mysqli_error($upd_link_db);
            }
            {
            	$picid = mysqli_insert_id($upd_link_db);

                for( $i=0; $i<count($langs); $i++ )
                {
                	if( !mysqli_query($upd_link_db, "INSERT INTO $TABLE_PAGE_PHOTO_LANGS ( item_id, lang_id, title, descr )
	                    VALUES ('$picid', '".$langs[$i]."', '".addslashes($phototitle)."', '".addslashes($photodescr)."')" ) )
	                {
	                   echo mysqli_error($upd_link_db);
	                }
	            }

            	// Now we should make resized copies for all images
            	$finalname = $picid.".jpg";

            	$srcname = $PAGEPIC_DIR.$PAGEPIC_PHOTO.$id."_".$finalname;
            	$thumbname = $PAGEPIC_DIR.$PAGEPIC_THUMB.$id."_".$finalname;
            	$iconame = $PAGEPIC_DIR.$PAGEPIC_ICO.$id."_".$finalname;

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

	   				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_PAGE_PHOTO SET
	                    	filename='".addslashes($srcname)."',
	                    	src_w=$thw, src_h=$thh WHERE id='$picid'" ) )
	    			{
	   					echo mysqli_error($upd_link_db);
	    			}
	   			}

	   			// Make thumb photo
	   			if( ($imgsz['w'] < $PAGEPIC_T_W) || ($imgsz['w'] < $PAGEPIC_T_H) )
	   			{
	   				$res = copy($photofile['tmp_name'], "../".$thumbname);
	   			}
	   			else
	   			{
            		$res = ResizeImage( $photofile['tmp_name'], "../".$thumbname, strtolower($newfileext), ".jpg", $PAGEPIC_T_W, $PAGEPIC_T_H, false, $JPEG_COMPRESS_RATIO);
       			}

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

	   				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_PAGE_PHOTO SET
	                    	filename_thumb='".addslashes($thumbname)."',
	                    	thumb_w=$thw, thumb_h=$thh WHERE id='$picid'" ) )
	    			{
	   					echo mysqli_error($upd_link_db);
	    			}
	   			}

	   			// Make ico photo
	   			if( ($imgsz['w'] < $PAGEPIC_I_W) || ($imgsz['w'] < $PAGEPIC_I_H) )
	   			{
	   				$res = copy($photofile['tmp_name'], "../".$iconame);
	   			}
	   			else
	   			{
            		$res = ResizeImage( $photofile['tmp_name'], "../".$iconame, strtolower($newfileext), ".jpg", $PAGEPIC_I_W, $PAGEPIC_I_H, true, $JPEG_COMPRESS_RATIO);
       			}
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

	   				if( !mysqli_query($upd_link_db, "UPDATE $TABLE_PAGE_PHOTO SET
	                    	filename_ico='".addslashes($iconame)."',
	                    	ico_w=$thw, ico_h=$thh WHERE id='$picid'" ) )
	    			{
	   					echo mysqli_error($upd_link_db);
	    			}
	   			}
	   		}

			$mode = "photos";
			break;

		case "addvideo":
			$id = GetParameter("id", 0);

			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");
			$photofile = GetParameter("photofile", "");
			$photoyoutube = GetParameter("photoyoutube", "");

			if( (trim($photofile) != "") || (trim($photoyoutube) != "") )
			{
				$query = "INSERT INTO $TABLE_PAGE_VIDEO (item_id, add_date, filename, tube_code, filename_ico, src_w, src_h, ico_w, ico_h, sort_num)
					VALUES ('$id', NOW(), '".addslashes($photofile)."', '".addslashes($photoyoutube)."', '', 0, 0, 0, 0, '$photoind')";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
				else
				{
					$videoid = mysqli_insert_id($upd_link_db);

     				for( $i=0; $i<count($langs); $i++ )
                	{
						$query = "INSERT INTO $TABLE_PAGE_VIDEO_LANGS (item_id, lang_id, title, descr) VALUES ('$videoid', '".$langs[$i]."',
							'".addslashes($phototitle)."', '".addslashes($photodescr)."')";
						if( !mysqli_query($upd_link_db, $query ) )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
			}
			$mode = "photos";
			break;

		case "videodel":
			$id = GetParameter("id", 0);
			$videoid = GetParameter("videoid", 0);

			$query = "DELETE FROM $TABLE_PAGE_VIDEO WHERE id='$videoid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			else
			{
				$query = "DELETE FROM $TABLE_PAGE_VIDEO_LANGS WHERE item_id='$videoid'";
				if( !mysqli_query($upd_link_db, $query ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}
			$mode = "photos";
			break;

		case "videoed":
			$id = $item_id = GetParameter("id", 0);
   			$videoid = GetParameter("videoid", 0);

   			$mode = "editvideoinfo";
			break;

		case "videoupdt":
			$id = $item_id = GetParameter("id", 0);
   			$videoid = GetParameter("videoid", 0);

   			$phototitle = GetParameter("phototitle", "");
			$photoind = GetParameter("photoind", 0);
			$photodescr = GetParameter("photodescr", "");
			$photofile = GetParameter("photofile", "");
			$photoyoutube = GetParameter("photoyoutube", "");

			$query = "UPDATE $TABLE_PAGE_VIDEO SET sort_num='$photoind', filename='".addslashes($photofile)."',
				tube_code='".addslashes($photoyoutube)."' WHERE id=$videoid";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "UPDATE $TABLE_PAGE_VIDEO_LANGS SET title='".addslashes($phototitle)."', descr='".addslashes($photodescr)."'
				WHERE item_id=$videoid AND lang_id='$LangId'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

   			$mode = "photos";
			break;
	}
?>
<script type='text/javascript' src='../swfobject.js'></script>
<?php
if( $mode == "editvideoinfo" )
{
	$video = Array();

	$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
		FROM $TABLE_PAGE_VIDEO p1
		INNER JOIN $TABLE_PAGE_VIDEO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.id=$videoid";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$pi = Array();

			$pi['id'] = $row->id;
			$pi['alt'] = stripslashes($row->title);
			$pi['descr'] = stripslashes($row->descr);
			$pi['snum'] = $row->sort_num;

			$pi['clip'] = stripslashes($row->filename);
			$pi['clip_w'] = $row->src_w;
			$pi['clip_h'] = $row->src_h;

			$pi['ico'] = stripslashes($row->filename_ico);
			$pi['ico_w'] = $row->ico_w;
			$pi['ico_h'] = $row->ico_h;

			$pi['tubecode'] = stripslashes($row->tube_code);

			$pi['date'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

			$video = $pi;
		}
		mysqli_free_result( $res );
	}
?>
		<br />
		<center><a href="<?=$PHP_SELF;?>?id=<?=$id;?>&action=photo">Вернуться к списку фото и видео</a></center>

		<h3>Редактировать информацию о видеоклипе</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm2" id="addfrm2" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id;?>" />
		<input type="hidden" name="videoid" value="<?=$videoid;?>" />
		<input type="hidden" name="action" value="videoupdt" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
		        <table width="100%" cellspacing="1" cellpadding="1" border="0">
		        <tr>
					<td colspan="2" class="fh">Информация о видео</td>
				</tr>
		        <tr>
					<td class="ff">Заголовок для видео:</td>
					<td class="fr">
		                <input type="text" name="phototitle" size="40" value="<?=$video['alt'];?>" />
					</td>
				</tr>
				<tr>
					<td class="ff">Описание видиео:</td>
					<td class="fr">
		                <textarea name="photodescr" cols="50" rows="5"><?=$video['descr'];?></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Видео файл:</td>
					<td class="fr">
		                <input type="text" size="30" name="photofile" value="<?=$video['clip'];?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.addfrm2.photofile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
					</td>
				</tr>
				<tr>
					<td class="ff">Или youtube код:</td>
					<td class="fr">
						<textarea cols="60" rows="6" name="photoyoutube"><?=$video['tubecode'];?></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Порядковый номер:</td>
					<td class="fr">
		                <input type="text" name="photoind" size="2" value="<?=$video['snum'];?>" />
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
else if( $mode == "editphotoinfo" )
{
		$photo = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_PAGE_PHOTO p1
			INNER JOIN $TABLE_PAGE_PHOTO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
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
		<center><a href="<?=$PHP_SELF;?>?id=<?=$id;?>&action=photo">Вернуться к списку фотографий</a></center>

		<h3>Редактировать информацию о фотографии</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id;?>" />
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
else
{
	if($mode=="update")
	{
		$content=str_replace ("&gt;",">",$_POST['content']);
		$content=str_replace ("&lt;","<",$content);

		$parentid = GetParameter("parentid", 0);
		$menushow = GetParameter("menushow", 0);
		$pagetype = GetParameter("pagetype", 1);
		$withedit = GetParameter("withedit", 1);

		$title = GetParameter("title", "");
		$header = GetParameter("header", "", false);

		$icofile = GetParameter("icofile", "");

		$pfile = GetParameter("pfile", "");
		$ptitle = GetParameter("ptitle", "");
		$pmean = GetParameter("pmean", "");
		$pkey = GetParameter("pkey", "");
		$pdescr = GetParameter("pdescr", "");
		$psort = GetParameter("psort", 0);

		if( !mysqli_query($upd_link_db,"UPDATE $TABLE_PAGES SET
				".( $parentid != $id ? " parent_id='$parentid', " : "" )."
				show_in_menu='$menushow',
				with_editor='$withedit',
				page_record_type='$pagetype',
				page_name='".addslashes($pfile)."',
				page_ico='".addslashes($icofile)."',
				modify_date=NOW(),
				sort_num='".$psort."'
				WHERE id='".$id."'") )
		{
        	echo mysqli_error($upd_link_db);
        }

        $query = "UPDATE $TABLE_PAGES_LANGS SET
        	page_mean='".addslashes($pmean)."',
        	page_title='".addslashes($ptitle)."',
			page_keywords='".addslashes($pkey)."',
			page_descr='".addslashes($pdescr)."',
			content='".addslashes($content)."',
			title='".addslashes($title)."',
			header='".addslashes($header)."'
        	WHERE item_id='$id' AND lang_id='$LangId'";
        if( !mysqli_query($upd_link_db, $query ) )
        {
        	echo mysqli_error($upd_link_db);
        }

		$mode="content";
	}

	//---------------------------- Categories --------------------------------
?>

<h3><?=$strings["hdrsel"][$lang];?></h3>

<center>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="post" name="frm">
	<tr>
		<td class="ff"><?=$strings["rowedit"][$lang];?>: </td>
		<td class="fr">
			<select name="id" onchange="javascript:GoTo('page_basic.php?id='+this.value);">
				<option value="0">--- <?=$strings["rowsel"][$lang];?> ---</option>
<?php
function FillPageTree($pid, $level, $selid)
{
	global $TABLE_PAGES, $TABLE_PAGES_LANGS, $LangId;
	if( $res = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean
			FROM $TABLE_PAGES p1
			INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.parent_id=$pid
			ORDER BY p1.show_in_menu, p1.sort_num") )
	{
		while( $row = mysqli_fetch_object($res) )
		{
			$str_space = "";
    		for($i=0; $i<$level; $i++)
    			$str_space .= "&nbsp;&nbsp;&nbsp;";
			echo "<option value=\"".$row->id."\"".($selid == $row->id ? " selected" : "").">".$str_space.stripslashes($row->page_mean)."</option>";
			FillPageTree($row->id, $level+1, $selid);
		}
  		mysqli_free_result($res);
	}
}

FillPageTree(0, 0, $id);
/*
				if( $result = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean FROM $TABLE_PAGES p1
					INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
					ORDER BY p2.page_mean, p1.id") )
				{
					while( $row = mysqli_fetch_array($result) )
					{
						echo "<option value=\"".$row['id']."\"".(($row['id']==$id)?" selected":"").">".stripslashes($row['page_mean'])."</option>\r\n";
					}
				}
				else
					echo mysqli_error($upd_link_db);
*/
?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="fr" align="center"><input type="submit" value="<?=$strings["btnnext"][$lang];?>"></td>
	</tr>
	</form>
	</table>
	</td></tr>
	</table>
</center>

<?php
	if( $id != "" )
	{
        echo "<br />";

		if( $result = mysqli_query($upd_link_db,"SELECT p1.*, p2.page_mean, p2.page_title, p2.page_keywords, p2.page_descr,
			p2.title, p2.header, p2.content
			FROM $TABLE_PAGES p1
			INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.id='".$id."'") )
		{
			if( $row = mysqli_fetch_object($result) )
			{
				$page1['pid'] = $row->parent_id;
				$page1['pfile'] = stripslashes($row->page_name);
				$page1['pmean'] = stripslashes($row->page_mean);
				$page1['ptitle'] = stripslashes($row->page_title);
				$page1['pkeywords'] = stripslashes($row->page_keywords);
				$page1['pdescr'] = stripslashes($row->page_descr);
				$page1['pcreated'] = $row->create_date;
				$page1['pmodified'] = $row->modify_date;

				$page1['ico'] = stripslashes($row->page_ico);

				$page1['pagename'] = stripslashes($row->page_name);
                $page1['title'] = stripslashes($row->title);
                $page1['header'] = stripslashes($row->header);
				$page1['content'] = stripslashes($row->content);

				$page1['show'] = $row->show_in_menu;
				$page1['type'] = $row->page_record_type;
				$page1['edit'] = $row->with_editor;
				$page1['sort'] = $row->sort_num;
			}
			mysqli_free_result( $result );
		}
?>
<h3><?=$strings["hdredit"][$lang];?> &quot;<?=$page1['pmean'];?>&quot;</h3>
<table align="center" cellspacing="0" cellpadding="1" border="0" bgcolor="#9CB7C7">
	<tr><td>
	<table width="100%" cellspacing="1" cellpadding="1" border="0">
<form name="catfrm" id="catfrm" action="<?=$PHP_SELF;?>" method="post">
<input type="hidden" name="mode" value="update" />
<input type="hidden" name="id" value="<?=$id;?>" />
<tr>
    <th><?=$strings["hdrname"][$lang];?></th>
    <th><?=$strings["hdrcont"][$lang];?></th>
</tr>
<tr>
	<td class="ff">Куда вставлять:</td>
    <td class="fr">
    	<select name="parentid">
    		<option value="0">--- Корневой раздел ---</option>
<?php
/*
	$query = "SELECT p1.*, p2.page_mean FROM $TABLE_PAGES p1
		INNER JOIN $TABLE_PAGES_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
		WHERE p1.parent_id='0'
		ORDER BY p1.sort_num";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
    	while( $row = mysqli_fetch_object( $res ) )
    	{
    		echo "<option value=\"".$row->id."\"".($page1['pid'] == $row->id ? " selected" : "").">".stripslashes($row->page_mean)."</option>";
    	}
    	mysqli_free_result( $res );
    }
    else
    	echo mysqli_error($upd_link_db);
*/

FillPageTree(0, 0, $page1['pid']);
?>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Имя файла (без расшир.):</td>
    <td class="fr"><input type="text" name="pfile" size="20" value="<?=$page1['pfile'];?>" /></td>
</tr>
<tr>
	<td class="ff">Назначение:</td>
    <td class="fr"><input type="text" name="pmean" size="60" value="<?=$page1['pmean'];?>" /></td>
</tr>
<tr>
	<td class="ff">Title:</td>
    <td class="fr"><input type="text" name="ptitle" size="70" value="<?=$page1['ptitle'];?>" /></td>
</tr>
<tr>
	<td class="ff">Keywords:</td>
    <td class="fr"><input type="text" name="pkey" size="70" value="<?=$page1['pkeywords'];?>" /></td>
</tr>
<tr>
	<td class="ff">Description:</td>
    <td class="fr"><textarea name="pdescr" cols="70" rows="3"><?=$page1['pdescr'];?></textarea></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff"><?=$strings["rowtitle"][$lang];?>:</td>
    <td class="fr"><input type="text" name="title" size="70" value="<?=$page1['title'];?>" /></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff"><?=$strings["rowheader"][$lang];?>:</td>
    <td class="fr"><textarea name="header" cols="70" rows="10"><?=$page1['header'];?></textarea></td>
</tr>
<?php
if( $page1['edit'] == 1 )
{
?>
<script language="javascript1.2">
    editor_generate('header'); // field, width, height
</script>
<?php
}
?>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<tr>
	<td class="ff"><?=$strings["rowfooter"][$lang];?>:</td>
    <td class="fr"><textarea name="content" cols="70" rows="10"><?=$page1['content'];?></textarea></td>
</tr>
<tr><td class="fr">&nbsp;</td><td class="fr">&nbsp;</td></tr>
<?php
if( $page1['edit'] == 1 )
{
?>
<script language="javascript1.2">
    editor_generate('content'); // field, width, height
</script>
<?php
}

if( trim($page1['ico']) != "" )
{
?>
	<tr>
	<td class="ff">Текущая иконка:</td>
	<td class="fr"><img src="<?=$FILE_DIR.$page1['ico'];?>" alt="" /></td>
	</tr>
<?php
}
?>
<tr>
	<td class="ff">Иконка (*.jpg или *.gif, ширина 90px):</td>
	<td class="fr"><input type="text" size="30" name="icofile" value="<?=$page1['ico'];?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.icofile','winfiles','width=600,height=400,toolbar=no,status=yes,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td>
</tr>
<tr>
	<td class="ff">Показывать в меню:</td>
    <td class="fr">
    	<select name="menushow">
    		<option value="0"<?=($page1['show'] == 0 ? " selected" : "");?>>Нет</option>
    		<option value="1"<?=($page1['show'] == 1 ? " selected" : "");?>>Верхнее меню</option>
    		<option value="2"<?=($page1['show'] == 2 ? " selected" : "");?>>Левое меню</option>
    		<option value="3"<?=($page1['show'] == 3 ? " selected" : "");?>>Только для зарегистрированных</option>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Тип записи страницы:</td>
    <td class="fr">
    	<select name="pagetype">
    		<option value="0"<?=($page1['type'] == 0 ? " selected" : "");?>>Не ссылка (заглавие подгруппы)</option>
    		<option value="1"<?=($page1['type'] == 1 ? " selected" : "");?>>Обычная страница</option>
    		<option value="2"<?=($page1['type'] == 2 ? " selected" : "");?>>Ссылка на подкаталог</option>
    		<option value="3"<?=($page1['type'] == 3 ? " selected" : "");?>>Страница из базы</option>
    		<option value="4"<?=($page1['type'] == 4 ? " selected" : "");?>>Прямая ссылка</option>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Показывать HTML редактор:</td>
    <td class="fr">
    	<select name="withedit">
    		<option value="0"<?=($page1['edit'] == 0 ? " selected" : "");?>>Нет</option>
    		<option value="1"<?=($page1['edit'] == 1 ? " selected" : "");?>>Да</option>
    	</select>
    </td>
</tr>
<tr>
	<td class="ff">Порядковый номер:</td>
    <td class="fr"><input type="text" name="psort" size="2" value="<?=$page1['sort'];?>" /></td>
</tr>
<tr>
	<td class="ff">Дата создания:</td>
    <td class="fr"><?=$page1['pcreated'];?></td>
</tr>
<tr>
	<td class="ff">Дата модификации:</td>
    <td class="fr"><?=$page1['pmodified'];?></td>
</tr>
<tr>
	<td class="fr" colspan="2" align="center"><input type="submit" name="updatebut" value=" <?=$strings["btnapply"][$lang];?> " /></td>
</tr>
</form>
	</table>
	</td></tr>
</table>
<br />

<?php
		//$allres = GetResources($LangId);
		$allres = Resources_Get($LangId);

		$pageres = Array();
		$query = "SELECT pr1.id as assid, pr1.display_type, pr1.sort_num, r1.*, r2.content
			FROM $TABLE_PAGE_RESOURCES pr1
			INNER JOIN $TABLE_RESOURCE r1 ON pr1.item_id=r1.id
			INNER JOIN $TABLE_RESOURCE_LANGS r2 ON r1.id=r2.item_id AND r2.lang_id='$LangId'
			WHERE pr1.page_id='$id'
			ORDER BY pr1.display_type,pr1.sort_num";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$ri = Array();
				$ri['id'] = $row->id;
				$ri['assignid'] = $row->assid;
				$ri['disp'] = $row->display_type;
				$ri['sort'] = $row->sort_num;
				$ri['name'] = stripslashes($row->name);
				$ri['title'] = stripslashes($row->title);
				$ri['text'] = stripslashes($row->content);
				$pageres[] = $ri;
			}
			mysqli_free_result( $res );
		}
?>
		<h3>Текстовые блоки на странице</h3>
		<table align="center" cellspacing="2" cellpadding="0" width="600" border="0">
		<tr>
			<th>Где показывать</th>
			<th>№ сорт.</th>
			<th>Название блока</th>
			<th> &nbsp; </th>
		</tr>
<?php
		if( count($pageres) > 0 )
		{
			for($i=0; $i<count($pageres); $i++)
			{
				$disp_str = "";
				switch( $pageres[$i]['disp'] )
				{
					case 1:
						$disp_str = "Левая колонка";
						break;
					case 2:
						$disp_str = "Правая колонка";
						break;
				}

				echo '<tr>
				<td>'.$disp_str.'</td>
				<td>'.$pageres[$i]['sort'].'</td>
				<td>'.$pageres[$i]['title'].'</td>';
				echo "<td align=\"center\">
					<a href=\"$PHP_SELF?id=$id&action=resdel&resid=".$pageres[$i]['assignid']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить блок с этой страницы\" /></a>
				</td>";

				echo '</tr>';
			}
		}
		else
		{
			echo "<tr><td colspan=\"4\" align=\"center\">Нет прикрепленных текстовых блоков</td></tr>";
		}
?>
		</table>

		<h3>Добавить блок</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm">
		<input type="hidden" name="id" value="<?=$id;?>" />
		<input type="hidden" name="action" value="addres" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
		        <table width="100%" cellspacing="1" cellpadding="1" border="0">
		        <tr>
					<td colspan="2" class="fh">Привязать текстовый блок к странице</td>
				</tr>
		        <tr>
					<td class="ff">Где показывать:</td>
					<td class="fr">
						<select name="resdisp">
							<option value="1">Левая колонка</option>
							<option value="2">Правая колонка</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="ff">Текстовый блок:</td>
					<td class="fr">
						<select name="resblock">
				<?php
					foreach($allres as $kres=>$vres)
					{
						echo '<option value="'.$vres['id'].'">'.$vres['title'].'</option>';
					}
				?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="ff">Порядковый номер:</td>
					<td class="fr">
		                <input type="text" name="resind" size="2" />
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
		$photos = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_PAGE_PHOTO p1
			INNER JOIN $TABLE_PAGE_PHOTO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.item_id=$id
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
		<h3>Фотографии на странице</h3>
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
					<a href=\"$PHP_SELF?id=$id&action=photodel&photoid=".$photos[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить фотографию из галереи\" /></a>&nbsp;
     				<a href=\"$PHP_SELF?id=$id&action=photoed&photoid=".$photos[$i]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать описание фотографии\" /></a>&nbsp;
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
			echo "<tr><td align=\"center\">Нет фотографий у данной страницы</td></tr>";
		}
?>
		</table>
		<br />

		<h3>Добавить фотографию</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm" id="addfrm" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id;?>" />
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
		$video = Array();

		$query = "SELECT p1.*, p2.title, p2.descr, YEAR(p1.add_date) as dy, MONTH (p1.add_date) as dm, DAYOFMONTH(p1.add_date) as dd
			FROM $TABLE_PAGE_VIDEO p1
			INNER JOIN $TABLE_PAGE_VIDEO_LANGS p2 ON p1.id=p2.item_id AND p2.lang_id='$LangId'
			WHERE p1.item_id=$id
			ORDER BY p1.sort_num,p1.add_date";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$pi = Array();

				$pi['id'] = $row->id;
				$pi['alt'] = stripslashes($row->title);
				$pi['snum'] = $row->sort_num;

				$pi['clip'] = stripslashes($row->filename);
				$pi['clip_w'] = $row->src_w;
				$pi['clip_h'] = $row->src_h;

				$pi['ico'] = stripslashes($row->filename_ico);
				$pi['ico_w'] = $row->ico_w;
				$pi['ico_h'] = $row->ico_h;

				$pi['tubecode'] = stripslashes($row->tube_code);

				$pi['date'] = sprintf("%02d.%02d.%04d", $row->dd, $row->dm, $row->dy);

				$video[] = $pi;
			}
			mysqli_free_result( $res );
		}
?>
		<h3>Видео на странице</h3>
		<table cellspacing="10" cellpadding="0" width="100%" border="0">
<?php
		if( count($video) > 0 )
		{
			for($i=0; $i<count($video); $i++)
			{
				echo "<tr>";
				echo "<td align=\"center\">";

     			if( trim($video[$i]['tubecode']) != "" )
				{
					echo '<div style="padding: 0px 0px 0px 0px;  text-align: center;">'.html_entity_decode(trim($video[$i]['tubecode']), ENT_COMPAT).'</div>';
				}
				else
				{
					//echo '<embed src="'.$FILE_DIR.$orglogo.'" style="width: 300px;" loop="false" autostart="false" volume="25" hidden="false"></embed>';
?>
		<div id='mediaspace<?=$i;?>'>This text will be replaced</div>

		<script type='text/javascript'>
		  var so<?=$i;?> = new SWFObject('../player.swf','ply','310','270','9','#ffffff');
		  so<?=$i;?>.addParam('allowfullscreen','true');
		  so<?=$i;?>.addParam('allowscriptaccess','always');
		  so<?=$i;?>.addParam('wmode','opaque');
		  so<?=$i;?>.addVariable('file','<?=($WWWHOST.'files/'.$video[$i]['clip']);?>');
		  so<?=$i;?>.write('mediaspace<?=$i;?>');
		</script>
		<br />
<?php
				}

				//echo "<a href=\"$PHP_SELF?item_id=$item_id&action=photodel&photoid=".$photos[$i]['id']."\">Удалить</a><br />";
				echo "</td>
				<td><img src=\"".$video[$i]['ico']."\" width=\"".$video[$i]['ico_w']."\" height=\"".$video[$i]['ico_h']."\" style=\"border: 1px solid #b0b0b0;\" alt=\"".$video[$i]['alt']."\" /></td>
				<td style=\"padding: 3px 0px 5px 0px\">№ сорт. ".$video[$i]['snum']."</td>
				<td>
					<a href=\"$PHP_SELF?id=$id&action=videodel&videoid=".$video[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Удалить видео\" /></a>&nbsp;
     				<a href=\"$PHP_SELF?id=$id&action=videoed&videoid=".$video[$i]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Редактировать видео\" /></a>&nbsp;
     			</td>";

				echo "</tr>";
			}
		}
		else
		{
			echo "<tr><td colspan=\"4\" align=\"center\">Нет видеоклипов у данной страницы</td></tr>";
		}
?>
		</table>
		<br />

		<h3>Добавить видеоклип</h3>
		<form action="<?=$PHP_SELF;?>" method="POST" name="addfrm2" id="addfrm2" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id;?>" />
		<input type="hidden" name="action" value="addvideo" />
		<table align="center" width="550" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
		        <table width="100%" cellspacing="1" cellpadding="1" border="0">
		        <tr>
					<td colspan="2" class="fh">Добавить фото в галерею</td>
				</tr>
		        <tr>
					<td class="ff">Заголовок видео:</td>
					<td class="fr">
		                <input type="text" name="phototitle" size="40" />
					</td>
				</tr>
				<tr>
					<td class="ff">Описание видео:</td>
					<td class="fr">
		                <textarea name="photodescr" cols="50" rows="8"></textarea>
					</td>
				</tr>
				<tr>
					<td class="ff">Видео файл (*.flv):</td>
					<td class="fr">
		                <input type="text" size="30" name="photofile" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.addfrm2.photofile','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" />
					</td>
				</tr>
				<tr>
					<td class="ff">Или youtube код:</td>
					<td class="fr">
						<textarea cols="60" rows="6" name="photoyoutube"></textarea>
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
}

	include ("inc/footer-inc.php");

	include ("../inc/close-inc.php");
?>
