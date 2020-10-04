<?php
	$MENU_HIDE=1;

	require_once "../inc/db-inc.php";
	require_once "../inc/connect-inc.php";

	include "../inc/ses-inc.php";
	include "inc/authorize-inc.php";

    if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    $lang = GetParameter( "lang", "en" );
    $uan = GetParameter( "uan", 0 );		// Use Absolute Name

    $strings['title']['ru'] = "Файловый Менеджер";
    $strings['close']['ru'] = "Закрыть Окно";
    $strings['msgupload']['ru'] = "Файл загружен на сервер";
    $strings['msgloaderr']['ru'] = "Не удалось загрузить файл на сервер";
    $strings['msgtypeerr']['ru'] = "Не удалось загрузить файл на сервер. Возможно вы пытаетесь загрузить файл с другим расширением.";
    $strings['msgdirdel']['ru'] = "Директория была удалена";
    $strings['msgdirfull']['ru'] = "Не удалось удалить директорию, возможно она не существует или в она не пустая.";
    $strings['msgfiledel']['ru'] = "Файл был удален";
    $strings['msgdelerr']['ru'] = "Не удалось удалить файл.";
    $strings['hdrload']['ru'] = "Загрузить файлы на сервер";
    $strings['typelist']['ru'] = "Список разрешенных типов файлов";
    $strings['file']['ru'] = "Файл";
    $strings['btnload']['ru'] = "Загрузить файл";
    $strings['delete']['ru'] = "Удалить";
    $strings['view']['ru'] = "Просмотреть";
    $strings['choose']['ru'] = "Выбрать";
    $strings['deleteall']['ru'] = "Удалить выбранные файлы";
    $strings['createfolder']['ru'] = "Создать папку";
    $strings['direrror']['ru'] = "Директория не существует";


    $strings['title']['en'] = "File Manager";
    $strings['close']['en'] = "Close Window";
    $strings['msgupload']['en'] = "File uploaded to server";
    $strings['msgloaderr']['en'] = "Error occure while loading file to server";
    $strings['msgtypeerr']['en'] = "Error occure while loading file to server. The extention of the file is incorrect.";
    $strings['msgdirdel']['en'] = "Folder was removed";
    $strings['msgdirfull']['en'] = "Can't remove directory, the directory is possibly not empty.";
    $strings['msgfiledel']['en'] = "File was removed.";
    $strings['msgdelerr']['en'] = "Can't remove file.";
    $strings['hdrload']['en'] = "Upload file to server";
    $strings['typelist']['en'] = "List of allowed file types";
    $strings['file']['en'] = "File";
    $strings['btnload']['en'] = "Upload file";
    $strings['delete']['en'] = "Delete";
    $strings['view']['en'] = "View";
    $strings['choose']['en'] = "Choose";
    $strings['deleteall']['en'] = "Delete selected files";
    $strings['createfolder']['en'] = "Create folder";
    $strings['direrror']['en'] = "Folder is not valid";

    $PAGE_HEADER['ru'] = $strings['title']['ru'];
    $PAGE_HEADER['en'] = $strings['title']['en'];

    $full = GetParameter("full", false);

    if( !$full )
    {
    	$lang = GetParameter( "lang", "en" );
    }

    if( $full )
    	require_once "inc/header-inc.php";
    else
		require_once "inc/popup-header-inc.php";

    $ROOT_FILE_DIR = "../files/";
	$MAX_UPLOAD_SIZE=5000000;

	$dir = GetParameter("dir", "");

	$str_array=Array("../","/..","./","/.");
	$cur_dir=str_replace($str_array,"",$dir);
	$tmp_dir=$ROOT_FILE_DIR.$cur_dir;

	echo "<center><b>".$WWWHOST.$FILE_DIR.$cur_dir."</center>";

	$ext_arr=Array("jpg","jpeg","gif","bmp","png","zip","rar","xls","csv","pdf","doc","mp3","mid","midi","jar");
	$msg="";

    $mode = GetParameter("mode", "files");
    $fname = GetParameter("fname", "");

    //echo "$mode<br />";
    $target = GetParameter("target", "");

	if(!$mode)
	{
  		$mode="files";
	}

	if($mode=="filesAdd")
	{
		if( (isset($_FILES['myfile'])) && ($_FILES['myfile']['name']!="") )
		{
			//echo "Temp filename: ".$_FILES['myfile']['tmp_name']."<br />";
			$tmp_ext_pos=strrpos($_FILES['myfile']['name'],".");
			if($tmp_ext_pos)
			{
				$tmp_ext=substr($_FILES['myfile']['name'],$tmp_ext_pos+1);
				$tmp_ext=strtolower($tmp_ext);

				if($tmp_ext && $tmp_ext!="" && in_array($tmp_ext,$ext_arr))
				{
					$namefiles = $_FILES['myfile']['name'];
					$upload_max_filesize = $MAX_UPLOAD_SIZE;
					if(file_exists($tmp_dir.$namefiles))
					{
						$i=1;
						while(file_exists($tmp_dir.$i.$namefiles))
						{
							$i++;
						}
						$namefiles = $i.$namefiles;
					}
					$uploadfile = $tmp_dir.$namefiles;

					if( move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile) )
					{
						$msg .= $strings['msgupload'][$lang];
					}
					else
					{
   						$msg .= $strings['msgloaderr'][$lang];
					}
				}
   				else
   				{
   					$msg .= $strings['msgtypeerr'][$lang];
				}
			}
  			else
  			{
				$msg .= $strings['msgtypeerr'][$lang];
			}
		}

		$mode="files";
	}
	else if($mode=="filesCreate")
	{
		//echo $fname."<br />";
		if( !empty($fname) && $fname!=".." && $fname!="." )
		{
			if( !file_exists($tmp_dir.$fname) )
			{
				mkdir($tmp_dir.$fname, 0777);
			}
		}
		$mode="files";
	}
	else if( $mode == "filesDelete" )
	{
		if( !empty($fname) && $fname!=".." && $fname!="." )
		{
			if( file_exists($tmp_dir.$fname) )
			{
				if( rmdir($tmp_dir.$fname) )
				{
					$msg .= $strings['msgdirdel'][$lang];
				}
				else
				{
					$msg .= $strings['msgdirfull'][$lang];
				}
			}
		}
		$mode="files";
	}
	else if( $mode == "filesFDelete" )
	{
		$name = GetParameter("name", "");
		if( !empty($name) && $name!=".." && $name!="." )
		{
			if(file_exists($tmp_dir.$name))
			{
				if( unlink($tmp_dir.$name) )
				{
					$msg .= $strings['msgfiledel'][$lang];
				}
				else
				{
					$msg .= $strings['msgdelerr'][$lang];
				}
			}
		}
		$mode="files";
	}
	else if( $mode == "filesFdels" )
	{
		$arr = GetParameter("arr", null);
		if( isset($arr) && is_array($arr) )
		{
			for( $i=0; $i<count($arr); $i++ )
			{
   				if( !empty($arr[$i]) && $arr[$i]!=".." && $arr[$i]!="." )
   				{
					if( file_exists($tmp_dir.$arr[$i]) )
					{
     					if( unlink($tmp_dir.$arr[$i]) )
     					{
     					}
     				}
     			}
     		}
     	}
 		$mode="files";
 	}
 	else if($mode=="del")
 	{
		if(isset($id))
		{
			if( $result = mysqli_query($upd_link_db,"SELECT a.* FROM ".$TABLE_ARTICLE_FILES." as a WHERE article_id='".$id."'") )
			{
				while( $row = mysqli_fetch_array($result) )
				{
					if( $row['filename']!="" && $row['filename']!="." && $row['filename']!=".." && file_exists($ROOT_FILE_DIR.decodeMySQL2($row['filename'])) )
					{
       					unlink($ROOT_FILE_DIR.decodeMySQL2($row['filename']));
     				}
     				mysqli_query($upd_link_db,"DELETE FROM ".$TABLE_ARTICLE_FILES." WHERE files_id='".$row['files_id']."'");
				}
			}

            if( !mysqli_query($upd_link_db,"DELETE FROM ".$TABLE_ARTICLE." WHERE article_id='".$id."'") )
            {
				//fnDisplayErrMsg("MySQL Error: ".mysqli_error($upd_link_db));
				echo mysqli_error($upd_link_db);
			}
		}

        $mode="article";
    }

	if($mode=="files")
	{
?>
<h3 style="margin: 2px 0px 2px 0px;"><?=$strings['hdrload'][$lang];?></h3>
<?php
/*
<?=$strings['typelist'][$lang];?>:
<?php
		for( $i=0; $i<count($ext_arr); $i++ )
		{
			if($i>0)
            {
				echo " ";
			}
			echo ".".$ext_arr[$i];
		}
*/
?>
<?php
	if( $msg != "" )
	{
?>
<p class="error"><?=$msg;?></p>
<br />
<?php
	}
?>
<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
<tr><td>
	<table width="100%" cellspacing="1" cellpadding="1" border="0">
<form action="<?=$PHP_SELF;?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="<?=$mode;?>Add">
<input type="hidden" name="dir" value="<?=$cur_dir;?>">
<input type="hidden" name="target" value="<?=$target;?>">
<input type="hidden" name="lang" value="<?=$lang;?>">
<input type="hidden" name="full" value="<?=$full;?>">
<input type="hidden" name="uan" value="<?=$uan;?>">
<?php
		if( $MENU_HIDE == 1 )
			echo "<input type=\"hidden\" name=\"hide\" value=\"1\">";
?>
 <tr><td class="ff"><?=$strings['file'][$lang];?>: </td><td class="fr"><input type="file" name="myfile"></td></tr>
 <tr><td class="fr" colspan="2" align="center"><input type="submit" value="<?=$strings['btnload'][$lang];?>"></td></tr>
</form>
</table>
	</td></tr>
</table><br />


<div align="center">
<?php
function cmpFN($a, $b)
{
	return strcasecmp($a,$b);
}

		if(is_dir($tmp_dir))
		{
			if($handle = opendir($tmp_dir))
			{
				/* Именно этот способ чтения элементов каталога является правильным. */
				$allfiles=Array();
				while(false !== ($file = readdir($handle)))
                {
					$allfiles[]=$file;
				}

                closedir($handle);

				usort($allfiles, "cmpFN");
                reset($allfiles);

				$path_parts = pathinfo($cur_dir);

				if(isset($path_parts["dirname"]) && $path_parts["dirname"]=="\\") $path_parts["dirname"]="";
				//echo $path_parts["dirname"]."<br>\n";
				//echo $path_parts["basename"]."<br>\n";
				//echo $path_parts["extension"]."<br><br>\n";

				echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"0\">
				<form action=\"$PHP_SELF\" method=\"post\">
				<input type=\"hidden\" name=\"dir\" value=\"".$cur_dir."\">
				<input type=\"hidden\" name=\"mode\" value=\"".$mode."Fdels\">
				<input type=\"hidden\" name=\"target\" value=\"".$target."\">
				<input type=\"hidden\" name=\"lang\" value=\"".$lang."\">
				<input type=\"hidden\" name=\"full\" value=\"".$full."\">
				<input type=\"hidden\" name=\"uan\" value=\"".$uan."\">
				".( $MENU_HIDE==1 ? "<input type=\"hidden\" name=\"hide\" value=\"1\">" : "" )."
				<tr>
					<td width=\"20\">&nbsp;</td>
					<td width=\"20\"><img src=\"img/spacer.gif\" width=\"20\" height=\"0\" alt=\"\" border=\"0\"></td>
					<td width=\"200\"><img src=\"img/spacer.gif\" width=\"250\" height=\"0\" alt=\"\" border=\"0\"></td>
					<td width=\"50\"><img src=\"img/spacer.gif\" width=\"50\" height=\"0\" alt=\"\" border=\"0\"></td>
					<td width=\"50\"><img src=\"img/spacer.gif\" width=\"50\" height=\"0\" alt=\"\" border=\"0\"></td>
					<td width=\"50\"><img src=\"img/spacer.gif\" width=\"50\" height=\"0\" alt=\"\" border=\"0\"></td>
				</tr>
				<tr>
					<th colspan=\"6\" align=\"left\">&nbsp;<b>".($cur_dir?$cur_dir:"./")."</b>&nbsp;</th>
				</tr>";

                if($dir!="" && $dir!="./")
                {
					echo "<tr>
							<td>&nbsp;</td>
							<td>
								<a href=\"$PHP_SELF?full=$full&lang=$lang&uan=$uan&dir=".$path_parts["dirname"]."/&target=".$target."".($MENU_HIDE==1?"&hide=1":"")."\"><img src=\"img/folder.gif\" width=\"18\" height=\"18\" alt=\"\" border=\"0\"></a>
							</td>
							<td>
								&nbsp;<a href=\"$PHP_SELF?full=$full&lang=$lang&uan=$uan&dir=".$path_parts["dirname"]."/&target=".$target."".($MENU_HIDE==1?"&hide=1":"")."\"><b>..</b></a>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
					     </tr>";
				}

				for($i=0;$i<count($allfiles);$i++)
				{
					if( ($allfiles[$i]!=".") && ($allfiles[$i]!="..") )
					{
						if( is_dir($tmp_dir.$allfiles[$i]) )
						{
							echo "<tr>
									<td>&nbsp;</td>
									<td>
										<a href=\"$PHP_SELF?full=$full&lang=$lang&uan=$uan&dir=".$cur_dir.$allfiles[$i]."/&target=".$target."\"><img src=\"img/folder.gif\" width=\"18\" height=\"18\" alt=\"\" border=\"0\"></a>
									</td>
									<td valign=\"middle\">
										&nbsp;<a href=\"$PHP_SELF?full=$full&lang=$lang&uan=$uan&dir=".$cur_dir.$allfiles[$i]."/&target=".$target."".($MENU_HIDE==1?"&hide=1":"")."\"><b>".$allfiles[$i]."</b></a>
									</td>
									<td>
										&nbsp;<a href=\"$PHP_SELF?full=$full&lang=$lang&mode=".$mode."Delete&uan=$uan&dir=".$cur_dir."&fname=".$allfiles[$i]."&target=".$target."".($MENU_HIDE==1?"&hide=1":"")."\">".$strings['delete'][$lang]."</a>
									</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
							     </tr>";
						}
					}
				}

   				for($i=0;$i<count($allfiles);$i++)
   				{
					if(($allfiles[$i]!=".")&&($allfiles[$i]!=".."))
					{
						if(is_file($tmp_dir.$allfiles[$i]))
						{
							echo "<tr>
									<td>
										<input type=\"checkbox\" name=\"arr[]\" value=\"".$allfiles[$i]."\">
									</td>
									<td>
										<img src=\"img/file.gif\" width=\"16\" height=\"18\" alt=\"\" border=\"0\">
									</td>
									<td valign=\"middle\">&nbsp;".$allfiles[$i]."</td>
									<td>
										&nbsp;<a href=\"$PHP_SELF?full=$full&lang=$lang&mode=".$mode."FDelete&uan=$uan&dir=".$cur_dir."&name=".$allfiles[$i]."&target=".$target."".($MENU_HIDE==1?"&hide=1":"")."\">".$strings['delete'][$lang]."</a>
									</td>
									<td>
										&nbsp;<a href=\"".$tmp_dir.$allfiles[$i]."\" target=\"_blank\">".$strings['view'][$lang]."</a>
									</td>
									<td>";
   										if(isset($target)&&$target!="") echo "&nbsp;<input type=\"button\" onclick=\"javascript:FileCh('".($uan != 0 ? $WWWHOST.$FILE_DIR : "").$cur_dir.$allfiles[$i]."',".$target.");\" value=\"".$strings['choose'][$lang]."\">";
										else echo "&nbsp;";
									echo "</td>
							     </tr>";
						}
					}
				}

      			echo "<tr><td colspan=\"6\"><input type=\"submit\" value=\"".$strings['deleteall'][$lang]."\"></td></tr>
      			</form>
	            <tr><td colspan=\"6\">&nbsp;</td></tr>
	            <form action=\"$PHP_SELF\" method=\"post\">
	            <input type=\"hidden\" name=\"target\" value=\"".$target."\">
	            <input type=\"hidden\" name=\"dir\" value=\"".$cur_dir."\">
	            <input type=\"hidden\" name=\"mode\" value=\"".$mode."Create\">
	            <input type=\"hidden\" name=\"lang\" value=\"".$lang."\">
	            <input type=\"hidden\" name=\"full\" value=\"".$full."\">
	            <input type=\"hidden\" name=\"uan\" value=\"".$uan."\">";

				if($MENU_HIDE==1)
				{
					echo "<input type=\"hidden\" name=\"hide\" value=\"1\">";
				}

				echo "<tr>
					<td colspan=\"6\"><input type=\"text\" name=\"fname\" value=\"\">&nbsp;&nbsp;<input type=\"submit\" value=\"".$strings['createfolder'][$lang]."\"></td>
				</tr>
				</form>
				</table></div><br>";
			}
		}
		else
		{
			echo $strings['direrror'][$lang]."<br>\n";
		}

        /*
		if(!empty($target))
		{
			echo "<input type=\"button\" value=\"Закрыть окно\" onclick=\"window.close()\">";
		}
		*/
?>
</div>
<?php
	}

    if( $full )
		include "inc/footer-inc.php";
	else
		include "inc/popup-footer-inc.php";

	include "../inc/close-inc.php";
?>
