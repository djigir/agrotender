<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/ses-inc.php";

	include "inc/authorize-inc.php";

	if( $UserId == 0 )
    {
    	header("Location: index.php");
    }

    $strings['tipedit']['en'] = "Edit Banner";
   	$strings['tipdel']['en'] = "Delete Banner";

    $strings['tipedit']['ru'] = "Редактировать банер";
   	$strings['tipdel']['ru'] = "Удалить банер";

	$PAGE_HEADER['ru'] = "Редактировать Банеры на Стартовой Странице";
	$PAGE_HEADER['en'] = "Edit Page Banners";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$action = GetParameter("action", "");
	$bid = GetParameter("bid", 0);
	$mode = "";

	$orgurl = GetParameter("orgurl", "");
	$orgtitle = GetParameter("orgtitle", "");
	$orglogo = GetParameter("orglogo", "");
	$orgw = GetParameter("orgw", 0);
	$orgh = GetParameter("orgh", 0);
	$orgtype = GetParameter("orgtype", 0);
	$orgsort = GetParameter("orgsort", 0);

	if( strncmp($orgurl, "http://", 7) != 0 )
		$orgurl = "http://".$orgurl;

	switch($action)
	{
		case "addbanner":
			$query = "INSERT INTO $TABLE_BANNERS (linkurl, filename, disptype, addtime, width, height, sort_num) VALUES
				('".addslashes($orgurl)."', '".addslashes($orglogo)."', $orgtype, NOW(), '$orgw', '$orgh', '$orgsort')";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			else
			{
				$newbanid = mysqli_insert_id($upd_link_db);
				for($i=0; $i<count($langs); $i++)
				{
					$query = "INSERT INTO $TABLE_BANNERS_LANGS (banner_id, lang_id, alttext) VALUES
						($newbanid, '".$langs[$i]."', '".addslashes($orgtitle)."')";
				    if( !mysqli_query($upd_link_db, $query ) )
				    {
				    	echo mysqli_error($upd_link_db);
				    }
				}

				$orgurl = "";
				$orgtitle = "";
				$orglogo = "";
				$orgw = 0;
				$orgh = 0;
				$orgtype = 0;
				$orgsort = 0;
			}
			break;

		case "applybanner":
            $query = "UPDATE $TABLE_BANNERS SET linkurl='".addslashes($orgurl)."', filename='".addslashes($orglogo)."',
            	width='".$orgw."', height='".$orgh."', disptype='".$orgtype."', sort_num='$orgsort' WHERE id='$bid'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }
            else
            {
                if( !mysqli_query($upd_link_db, "UPDATE $TABLE_BANNERS_LANGS SET alttext='".addslashes($orgtitle)."' WHERE banner_id='$bid'" ) )
                {
                   echo mysqli_error($upd_link_db);
                }
            }
			break;

		case "edit":
			$mode = "editbanner";
			break;

		case "delete":
            if( !mysqli_query($upd_link_db, "UPDATE $TABLE_BANNERS
            	SET linkurl='', filename='', width='0', height='0', disptype='0'
            	WHERE id='$bid'" ) )
            {
               echo mysqli_error($upd_link_db);
            }

            if( !mysqli_query($upd_link_db, "UPDATE $TABLE_BANNERS_LANGS
            	SET alttext='' WHERE banner_id='$bid' AND lang_id='$LangId'" ) )
            {
               echo mysqli_error($upd_link_db);
            }
			break;

		case "delbase":
            if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_BANNERS WHERE id='$bid'" ) )
            {
               echo mysqli_error($upd_link_db);
            }
            if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_BANNERS_LANGS WHERE banner_id='$bid'" ) )
            {
               echo mysqli_error($upd_link_db);
            }
			break;
	}

	$banners = Array();
	$query = "SELECT b1.*, bl1.alttext FROM $TABLE_BANNERS b1, $TABLE_BANNERS_LANGS bl1
		WHERE b1.id=bl1.banner_id AND bl1.lang_id='$LangId'
		ORDER BY b1.id LIMIT 0,2";
	if($res = mysqli_query($upd_link_db, $query ))
	{
		while($row=mysqli_fetch_object($res))
		{
			$banner = Array();

			$banner['id'] = $row->id;
			$banner['alt'] = stripslashes($row->alttext);
			$banner['url'] = stripslashes($row->linkurl);
			$banner['filename'] = stripslashes($row->filename);
			$banner['type'] = $row->disptype;
			$banner['w'] = $row->width;
			$banner['h'] = $row->height;

            $banners[] = $banner;
	    }
	    mysqli_free_result($res);
	}
	else
		echo mysqli_error($upd_link_db);


	$ban_base = Array();
	$query = "SELECT b1.*, bl1.alttext FROM $TABLE_BANNERS b1, $TABLE_BANNERS_LANGS bl1
		WHERE b1.managetype=0 AND b1.id=bl1.banner_id AND bl1.lang_id='$LangId'
		ORDER BY b1.sort_num";
	if($res = mysqli_query($upd_link_db, $query ))
	{
		while($row=mysqli_fetch_object($res))
		{
			$banner = Array();

			$banner['id'] = $row->id;
			$banner['alt'] = stripslashes($row->alttext);
			$banner['url'] = stripslashes($row->linkurl);
			$banner['filename'] = stripslashes($row->filename);
			$banner['type'] = $row->disptype;
			$banner['w'] = $row->width;
			$banner['h'] = $row->height;

            $ban_base[] = $banner;
	    }
	    mysqli_free_result($res);
	}

    if( $mode == "" )
    {
?>

	<h3>Фиксированные банеры</h3>

    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<tr>
		<th width="30%">Название</th>
		<th width="60%">Значение</th>
      	<th width="10%">Функции</th>
	</tr>
	<tr>
		<td class="ff">Банер верхний (728 х 90):</td>
		<td class="fr">
<?php
	if( ( $banners[0]['filename'] != "" ) && ( $banners[0]['type'] == 0 ) )
	{
		echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="'.$banners[0]['w'].'" HEIGHT="'.$banners[0]['h'].'" id="BANNER0" ALIGN="">
 <PARAM NAME=movie VALUE="'.$FILE_DIR.$banners[0]['filename'].'"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="'.$FILE_DIR.$banners[0]['filename'].'" quality=high bgcolor=#FFFFFF  WIDTH="'.$banners[0]['w'].'" HEIGHT="'.$banners[0]['h'].'" NAME="BANNER0" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>';
	}
	else if( $banners[0]['filename'] != "" )
	{
  		echo "<a href=\"".$banners[0]['url']."\"><img src=\"".$FILE_DIR.$banners[0]['filename']."\" alt=\"".$banners[0]['alt']."\" width=\"".$banners[0]['w']."\" height=\"".$banners[0]['h']."\" border=\"0\" /></a>";
    }
    else
    {
		echo "<a href=\"".$banners[0]['url']."\">".$banners[0]['alt']."</a>";
    }
?>
		</td>
		<td class="fr">
<?php
		echo "<a href=\"$PHP_SELF?action=delete&bid=".$banners[0]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
             <a href=\"$PHP_SELF?action=edit&bid=".$banners[0]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp";
?>
		</td>
	</tr>
    <tr>
		<td class="ff">Банер правый (240 х 320):</td>
		<td class="fr">
<?php
	if( ( $banners[1]['filename'] != "" ) && ( $banners[1]['type'] == 0 ) )
	{
		echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="'.$banners[1]['w'].'" HEIGHT="'.$banners[1]['h'].'" id="BANNER1" ALIGN="">
 <PARAM NAME=movie VALUE="'.$FILE_DIR.$banners[1]['filename'].'"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="'.$FILE_DIR.$banners[1]['filename'].'" quality=high bgcolor=#FFFFFF  WIDTH="'.$banners[1]['w'].'" HEIGHT="'.$banners[1]['h'].'" NAME="BANNER1" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>';
	}
	else if( $banners[1]['filename'] != "" )
	{
  		echo "<a href=\"".$banners[1]['url']."\"><img src=\"".$FILE_DIR.$banners[1]['filename']."\" width=\"".$banners[1]['w']."\" height=\"".$banners[1]['h']."\" alt=\"".$banners[1]['alt']."\" border=\"0\" /></a>";
    }
    else
    {
		echo "<a href=\"".$banners[1]['url']."\">".$banners[1]['alt']."</a>";
    }
?>
		</td>
		<td class="fr">
<?php
		echo "<a href=\"$PHP_SELF?action=delete&bid=".$banners[1]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
             <a href=\"$PHP_SELF?action=edit&bid=".$banners[1]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp";
?>
		</td>
	</tr>
	</table>
		</td>
	</tr>
	</table>

	<h3>Центральные банеры</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="contact" />
	<tr>
		<th width="30%">Название</th>
		<th width="60%">Значение</th>
      	<th width="10%">Функции</th>
	</tr>
<?php
	for( $i=0; $i<count($ban_base); $i++ )
	{
?>
	<tr>
		<td class="ff"><?=$ban_base[$i]['url'];?>:</td>
		<td class="fr">
<?php
	if( ( $ban_base[$i]['filename'] != "" ) && ( $ban_base[$i]['type'] == 0 ) )
	{
		echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="'.$ban_base[$i]['w'].'" HEIGHT="'.$ban_base[$i]['h'].'" id="BANNER2" ALIGN="">
 <PARAM NAME=movie VALUE="'.$FILE_DIR.$ban_base[$i]['filename'].'"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#FFFFFF> <EMBED src="'.$FILE_DIR.$ban_base[$i]['filename'].'" quality=high bgcolor=#FFFFFF  WIDTH="'.$ban_base[$i]['w'].'" HEIGHT="'.$ban_base[$i]['h'].'" NAME="BANNER2" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>';
	}
	else if( $ban_base[$i]['filename'] != "" )
	{
  		echo "<a href=\"".$ban_base[$i]['url']."\"><img src=\"".$FILE_DIR.$ban_base[$i]['filename']."\" width=\"".$ban_base[$i]['w']."\" height=\"".$ban_base[$i]['h']."\" alt=\"".$ban_base[$i]['alt']."\" border=\"0\" /></a>";
    }
    else
    {
		echo "<a href=\"".$ban_base[$i]['url']."\">".$ban_base[$i]['alt']."</a>";
    }
?>
		</td>
		<td class="fr">
<?php
		echo "<a href=\"$PHP_SELF?action=delbase&bid=".$ban_base[$i]['id']."\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdel'][$lang]."\" /></a>&nbsp;
             <a href=\"$PHP_SELF?action=edit&bid=".$ban_base[$i]['id']."\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedit'][$lang]."\" /></a>&nbsp";
?>
		</td>
	</tr>
<?php
	}
?>
	<tr><td class="fr" colspan="3" align="center"><br /><input type="submit" name="update" value=" Применить " /><br /><br /></td></tr>
	</form>
		</table>
		</td></tr>
	</table>

	<br /><br />

	<h3>Добавить центральный банер</h3>

    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form name="catfrm" id="catfrm" action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="addbanner" />
	<tr>
		<td class="ff">URL:</td>
		<td class="fr"><input type="text" size="50" name="orgurl" value="<?=$orgurl;?>" /></td>
	</tr>
    <tr>
		<td class="ff">Заголовок:</td>
		<td class="fr"><input type="text" size="50" name="orgtitle" value="<?=$orgtitle;?>" /></td>
	</tr>
	<tr>
		<td class="ff">Ширина (px):</td>
		<td class="fr"><input type="text" size="3" name="orgw" value="<?=$orgw;?>" /></td>
	</tr>
	<tr>
		<td class="ff">Высота (px):</td>
		<td class="fr"><input type="text" size="3" name="orgh" value="<?=$orgh;?>" /></td>
	</tr>
    <tr>
		<td class="ff">Картинка:</td>
		<td class="fr"><input type="text" size="30" name="orglogo" value="<?=$orglogo;?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td>
	</tr>
	<tr>
		<td class="ff">Тип:</td>
		<td class="fr">
			<select name="orgtype">
				<option value="0"<?=($orgtype == 0 ? " selected" : "");?>> Флеш </option>
				<option value="1"<?=($orgtype == 1 ? " selected" : "");?>> Картинка </option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="ff">Порядковый номер:</td>
		<td class="fr"><input type="text" size="2" name="orgsort" value="<?=$orgsort;?>" /></td>
	</tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" name="applybut" value="Применить" /></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
	}
	else
	{
		$query = "SELECT b1.*, bl1.alttext FROM $TABLE_BANNERS b1, $TABLE_BANNERS_LANGS bl1
		WHERE b1.id=$bid AND b1.id=bl1.banner_id AND bl1.lang_id='$LangId'";

		if($res = mysqli_query($upd_link_db, $query ))
		{
			while($row=mysqli_fetch_object($res))
			{
				$banner = Array();

				$banner['id'] = $row->id;
				$banner['alt'] = stripslashes($row->alttext);
				$banner['url'] = stripslashes($row->linkurl);
				$banner['filename'] = stripslashes($row->filename);
				$banner['type'] = $row->disptype;
				$banner['w'] = $row->width;
				$banner['h'] = $row->height;
				$banner['sort'] = $row->sort_num;

	            $banners[] = $banner;
		    }
		    mysqli_free_result($res);
		}
		else
			echo mysqli_error($upd_link_db);
?>
    <h3>Редактировать параметры банера</h3>

    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
    <form name="catfrm" id="catfrm" action="<?=$PHP_SELF;?>" method="POST">
    <input type="hidden" name="action" value="applybanner" />
    <input type="hidden" name="bid" value="<?=$bid;?>" />
	<tr>
		<td class="ff">URL:</td>
		<td class="fr"><input type="text" size="50" name="orgurl" value="<?=$banner['url'];?>" /></td>
	</tr>
    <tr>
		<td class="ff">Заголовок:</td>
		<td class="fr"><input type="text" size="50" name="orgtitle" value="<?=$banner['alt'];?>" /></td>
	</tr>
	<tr>
		<td class="ff">Ширина (px):</td>
		<td class="fr"><input type="text" size="3" name="orgw" value="<?=$banner['w'];?>" /></td>
	</tr>
	<tr>
		<td class="ff">Высота (px):</td>
		<td class="fr"><input type="text" size="3" name="orgh" value="<?=$banner['h'];?>" /></td>
	</tr>
    <tr>
		<td class="ff">Картинка:</td>
		<td class="fr"><input type="text" size="30" name="orglogo" value="<?=$banner['filename'];?>" /><input type="button" value=" Выбрать файл " onclick="javascript:MM_openBrWindow('cat_files.php?hide=1&lang=<?=$lang;?>&target=self.opener.document.catfrm.orglogo','winfiles','width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes');" /></td>
	</tr>
	<tr>
		<td class="ff">Тип:</td>
		<td class="fr">
			<select name="orgtype">
				<option value="0"<?=($banner['type'] == 0 ? " selected" : "");?>> Флеш </option>
				<option value="1"<?=($banner['type'] == 1 ? " selected" : "");?>> Картинка </option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="ff">Порядковый номер:</td>
		<td class="fr"><input type="text" size="2" name="orgsort" value="<?=$banner['sort'];?>" /></td>
	</tr>
	<tr><td colspan="2" class="fr" align="center"><input type="submit" name="applybut" value="Применить" /></td></tr>
	</form>
		</table>
	</td></tr>
	</table>
<?php
    }

	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
