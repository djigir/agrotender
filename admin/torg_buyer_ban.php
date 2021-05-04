<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/utils-inc.php";
	include "../inc/torgutils-inc.php";
	include "../inc/countryutils-inc.php";

	include "../inc/ses-inc.php";

	include "inc/authorize-inc.php";

	$fields['name']['ru'] = 'Ф.И.О.';
	$fields['login']['ru'] = 'Логин';
	$fields['passwd']['ru'] = 'Пароль';
	$fields['address']['ru'] = 'Адрес';
	$fields['city']['ru'] = 'Город';
	$fields['country']['ru'] = 'Страна';
	$fields['zip_code']['ru'] = 'Почтовый Индекс';
	$fields['telephone']['ru'] = 'Телефон';
	$fields['office_phone']['ru'] = 'Рабочий тел.';
	$fields['cell_phone']['ru'] = 'Мобильный тел.';
	$fields['email1']['ru'] = 'E-Mail 1';
	$fields['email2']['ru'] = 'E-Mail 2';
	$fields['email3']['ru'] = 'E-Mail 3';
	$fields['ip']['ru'] = 'IP-адрес';
	$fields['web_url']['ru'] = 'Веб-страница';
	$fields['groupid']['ru'] = 'Группа пользователей';
	$fields['trader']['ru'] = 'Привязка к трейдеру';

	$fields['name']['en'] = 'Full Name';
	$fields['login']['en'] = 'Login';
	$fields['passwd']['en'] = 'Password';
	$fields['address']['en'] = 'Address';
	$fields['city']['en'] = 'City';
	$fields['country']['en'] = 'Country';
	$fields['zip_code']['en'] = 'Zip';
	$fields['telephone']['en'] = 'Telephone';
	$fields['office_phone']['en'] = 'Office Phone';
	$fields['cell_phone']['en'] = 'Cell Phone';
	$fields['email1']['en'] = 'E-Mail 1';
	$fields['email2']['en'] = 'E-Mail 2';
	$fields['email3']['en'] = 'E-Mail 3';
	$fields['ip']['en'] = 'IP-address';
	$fields['web_url']['en'] = 'Web-url';
	$fields['groupid']['en'] = 'User Group';
	$fields['trader']['en'] = 'Trader Assign';

	$strings['editprof']['en'] = "Edit user profile";
	$strings['newprof']['en'] = "Add user profile";
	$strings['userlist']['en'] = "User List";
	$strings['addbtn']['en'] = " Add New ";
	$strings['applybtn']['en'] = " Apply ";
	$strings['rowlogin']['en'] = "Login";
	$strings['rowname']['en'] = "Name";
	$strings['rowaddr']['en'] = "Address";
	$strings['rowcontact']['en'] = "Contacts";
	$strings['tipchangepwd']['en'] = "Change Password";
	$strings['tipedituser']['en'] = "Edit User Profile";
	$strings['tipdeluser']['en'] = "Delete User";
	$strings['tipstatus']['en'] = "Change Status";

	$strings['editprof']['ru'] = "Редактирование бан санкций пользователя";
	$strings['newprof']['ru'] = "Добавление Нового Пользователя";
	$strings['userlist']['ru'] = "Список Пользователей";
	$strings['addbtn']['ru'] = " Добавить ";
	$strings['applybtn']['ru'] = " Применить ";
	$strings['rowlogin']['ru'] = "Логин";
	$strings['rowname']['ru'] = "Ф.И.О.";
	$strings['rowaddr']['ru'] = "Адрес";
	$strings['rowcontact']['ru'] = "Контакты";
	$strings['tipchangepwd']['ru'] = "Изменить Пароль";
	$strings['tipedituser']['ru'] = "Редактировать Профиль";
	$strings['tipdeluser']['ru'] = "Удалить Пользователя";
	$strings['tipstatus']['ru'] = "Изменить Статус";

	$citylist = GetCityList($LangId);

	if( $UserId == 0 )
	{
		header("Location: index.php");
		exit;
	}

	$PAGE_HEADER['ru'] = "Управление Трейдерами";
	$PAGE_HEADER['en'] = "User Management";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = "";
	$action = GetParameter("action", "");
	$uid = GetParameter("uid", "");

	$oblid = GetParameter("oblid", 0);

	$fltmail = trim(strip_tags(GetParameter("fltmail", ""), ""));
	$flttel = trim(strip_tags(GetParameter("flttel", ""), ""));
	$fltname = trim(strip_tags(GetParameter("fltname", ""), ""));
	$fltid = trim(strip_tags(GetParameter("fltid", 0), ""));
	$fltip = trim(strip_tags(GetParameter("fltip", ""), ""));
	$fltses = trim(strip_tags(GetParameter("fltses", ""), ""));

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 100);

	$uprof = Array();

	$uprof['name'] = GetParameter("fullname", "");
	$uprof['passwd'] = GetParameter("passwd", "");
	$uprof['login'] = GetParameter("login", "");
	$uprof['address'] = GetParameter("address", "");
	$uprof['city'] = GetParameter("city", "");
	$uprof['country'] = GetParameter("country", "");
	$uprof['phone'] = GetParameter("phone", "");
	$uprof['email'] = GetParameter("email", "");
	$uprof['web_url'] = GetParameter("weburl", "");
	$uprof['comments'] = GetParameter("comments", "");
	//$uprof['groupid'] = GetParameter("userlevel", "0");
	//$uprof['usertrader'] = GetParameter("usertrader", 0);

	$banphone = GetParameter("banphone", "");
	$banemail = GetParameter("banemail", "");
	$banip = GetParameter("banip", "");
	$banses = GetParameter("banses", "");
	$banperiod = GetParameter("banperiod", 1);
	$bancomment = GetParameter("bancomment", "");

	$msg = "";

	switch( $action )
	{
		case "addbanuser":
			$mode = "edit";
			$baninf = Torg_BuyerIsBan( $LangId, $uid );
			if( $baninf['id'] != 0 )
			{
				$msg = "На этого пользователя уже есть один наложенный бан на ".$baninf['period']." дней до ".$baninf['end'];
				break;
			}
			// add ban
			$dtsqlen = date("Y-m-d 23:59:59", time()+($banperiod*24*60*60));
			$query = "INSERT INTO $TABLE_TORG_BUYER_BAN (user_id, item_id, add_date, end_date, period_days, 
				ban_ip, ban_phone, ban_email, ban_name, ban_ses, comment)
				VALUES ('$uid', 0, NOW(), '$dtsqlen', '$banperiod', '".addslashes($banip)."', '".addslashes($banphone)."', '".addslashes($banemail)."', '', '".addslashes($banses)."', '".addslashes($bancomment)."')";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			break;

		case "addban":
			$now_ban = false;
			if( $banphone != "" )
			{
				$baninf = Torg_BuyerIsBan( $LangId, 0, $banphone );
				if( $baninf['id'] != 0 )
				{
					$now_ban = true;
					$msg = "На пользователя с таким телефонным номером уже есть один наложенный бан на ".$baninf['period']." дней до ".$baninf['end'];
					break;
				}

				$banemail = "";
				$banip = "";
				/*
				$query = "SELECT *, case when (add_date<NOW() AND end_date>NOW()) then 1 else 0 end as isnow
					FROM $TABLE_TORG_BUYER_BAN WHERE user_id=0 AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(ban_phone,' ',''), '-', ''), '+', ''),'(', ''),')','')='".addslashes($banphone)."'
					ORDER BY isnow DESC, end_date DESC";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						if( $row->isnow && !$row->is_disabled )
						{
							$now_phone_ban = true;
						}
					}
					mysqli_free_result( $res );
				}
				*/
			}
			else if( $banemail != "" )
			{
				$baninf = Torg_BuyerIsBan( $LangId, 0, "", $banemail );
				if( $baninf['id'] != 0 )
				{
					$now_ban = true;
					$msg = "На пользователя с таким Email адресом уже есть один наложенный бан на ".$baninf['period']." дней до ".$baninf['end'];
					break;
				}
				$banip = "";
			}
			else if( $banip != "" )
			{
				$baninf = Torg_BuyerIsBan( $LangId, 0, "", "", $banip );
				if( $baninf['id'] != 0 )
				{
					$now_ban = true;
					$msg = "На пользователя с таким IP-адресом уже есть один наложенный бан на ".$baninf['period']." дней до ".$baninf['end'];
					break;
				}
			}
			else if( $banses != "" )
			{
				$baninf = Torg_BuyerIsBan( $LangId, 0, "", "", "", $banses );
				if( $baninf['id'] != 0 )
				{
					$now_ban = true;
					$msg = "На пользователя с такой сессией уже есть один наложенный бан на ".$baninf['period']." дней до ".$baninf['end'];
					break;
				}
			}

			// add ban
			$dtsqlen = date("Y-m-d 23:59:59", time()+($banperiod*24*60*60));
			$query = "INSERT INTO $TABLE_TORG_BUYER_BAN (user_id, item_id, add_date, end_date, period_days, 
				ban_ip, ban_ses, ban_phone, ban_email, ban_name, comment)
				VALUES (0, 0, NOW(), '$dtsqlen', '$banperiod', '".addslashes($banip)."', '".addslashes($banses)."', 
				'".addslashes($banphone)."', '".addslashes($banemail)."', '', '".addslashes($bancomment)."')";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
			break;

		case "status":
  			$active = GetParameter("active", 0);
  			$bid = GetParameter("bid", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_TORG_BUYER_BAN SET is_disabled=".($active == 1 ? 1 : 0)." WHERE id=$bid"))
			{
				echo mysqli_error($upd_link_db);
			}
			
			if( $uid != 0 )
				$mode = "edit";
  			break;

		case "delete":
			$bid = GetParameter("bid", 0);
			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_TORG_BUYER_BAN WHERE id='$bid'"))
			{
				echo mysqli_error($upd_link_db);
			}
			if( $uid != 0 )
				$mode = "edit";
  			break;

		case "applynew":
			/*
			if( !mysqli_query($upd_link_db,"UPDATE $TABLE_TORG_BUYERS SET
						name='".addslashes($uprof['name'])."', orgname='".addslashes($uprof['orgname'])."', address='".addslashes($uprof['address'])."',
						city='".addslashes($uprof['city'])."',
        				phone='".addslashes($uprof['phone'])."', email='".addslashes($uprof['email'])."', comments='".addslashes($uprof['comments'])."'
        				WHERE id=".$uid." "))
			{
				echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			*/

			$mode = "edit";
			//$uid = $_POST['uid'];
			break;

		case "editprofile":
			$mode = "edit";
			break;
	}


    if( $mode == "edit" )
	{
		$query = "SELECT u.* FROM $TABLE_TORG_BUYERS u WHERE u.id='".$uid."' ";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			if( $row = mysqli_fetch_object($res) )
			{
				$uprof['name'] = stripslashes($row->name);
				$uprof['orgname'] = stripslashes($row->name);
				$uprof['login'] = stripslashes($row->login);
				$uprof['city'] = stripslashes($row->city);
				//$uprof['country'] = stripslashes($row->country);
				$uprof['address'] = stripslashes($row->address);
				$uprof['phone'] = stripslashes($row->phone);
				$uprof['email'] = stripslashes($row->email);
				//$uprof['web_url'] = stripslashes($row->web_url);
				$uprof['comments'] = stripslashes($row->comments);
			}
			mysqli_free_result($res);
		}

		$banphone = $uprof['phone'];
		$banemail = $uprof['email'];
	}

	if( $msg != "" )
	{
		echo '<div style="text-align: center; padding: 14px 0; color: red;">'.$msg.'</div>';
	}
?>

	<h3>Добавить в бан</h3>
	<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="<?=($mode == "edit" ? "addbanuser" : "addban");?>" />
	<?=($mode == "edit" ? '<input type="hidden" name="uid" value="'.$uid.'" />' : '');?>
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
    <tr>
	    <td class="ff">Период бана:</td>
	    <td class="fr"><select name="banperiod">
	    	<option value="1">1 день</option>
	    	<option value="3">3 дня</option>
	    	<option value="7">7 дней</option>
	    	<option value="30">30 дней</option>
	    </select></td>
	</tr>
	<?php
	if( $mode == "edit" )
	{
		echo '<tr>
		    <td class="ff">Пользователь:</td>
		    <td class="fr"><b>'.$uprof['name'].' ('.$uprof['orgname'].')</td>
		</tr>';
	}
	?>
    <tr>
	    <td class="ff"><?=$fields['telephone'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="banphone" type="text" value="<?=$banphone;?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['email1'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="banemail" type="text" value="<?=$banemail;?>" /></td>
	</tr>
	<tr>
	    <td class="ff"><?=$fields['ip'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="banip" type="text" value="<?=$banip;?>" /></td>
	</tr>
	<tr>
	    <td class="ff">Сессия:</td>
	    <td class="fr"><input class="field" name="banses" type="text" value="<?=$banses;?>" /></td>
	</tr>
	<tr>
	    <td class="ff">Комментарии:</td>
	    <td class="fr"><textarea name="bancomment" rows="3" cols="50"><?=$bancomment;?></textarea></td>
	</tr>
	<tr>
	      <td class="fr" colspan="2" align="center"><br /><input type="submit" value=" Добавить в бан " /><br /></td>
	</tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br /><br />
<?php
	if( $mode == "edit" )
	{
?>
	<a href="<?=$PHP_SELF;?>">Вернуться к списку пользователей</a>
	<br />

	<h3><?=($action == "editprofile" ? $strings['editprof'][$lang] : $strings['newprof'][$lang]);?><br />
	<?=$uprof['name'];?> (<?=$uprof['orgname'];?>)</h3>
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="applynew" />
	<input type="hidden" name="uid" value="<?=$uid;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<table cellspacing="0" cellpadding="0" border="0" align="center" width="60%">
    <tr>
    	<th width="30">&nbsp;</th>
    	<th>Добавлен</th>
    	<th>Конец</th>
    	<th>Период</th>
		<th>Тип бана</th>
    	<th>Комментарий</th>
    	<th>Статус по дате</th>
		<th>Статус</th>
    	<th width="100">&nbsp;</th>
    </tr>
    <tr>
    	<td colspan="8" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>
	<?php
	$blist = Array();
	$query = "SELECT *, DATE_FORMAT(add_date,'%d.%m.%Y') as dtst, DATE_FORMAT(end_date,'%d.%m.%Y') as dten,
		case when (add_date<=NOW() AND end_date>NOW()) then 1 else 0 end as isnow
		FROM $TABLE_TORG_BUYER_BAN
		WHERE user_id='$uid'
		ORDER BY add_date";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$bi = Array();
			$bi['id'] = $row->id;
			$bi['period'] = $row->period_days;
			$bi['dtst'] = $row->dtst;
			$bi['dten'] = $row->dten;
			$bi['comment'] = stripslashes($row->comment);
			$bi['item_id'] = $row->item_id;
			$bi['now'] = $row->isnow;
			$bi['dis'] = $row->is_disabled;
			
			$baninfo = '';
			if( $row->bantel != "" )
			{
				$baninfo .= 'Бан по тел.: '.stripslashes($row->bantel).'<br>';
			}
			if( $row->ban_email )
			{
				$baninfo .= 'Бан по E-mail: <a href="mailto:'.stripslashes($row->ban_email).'">'.stripslashes($row->ban_email).'</a><br>';
			}
			if( $row->ban_ip )
			{
				$baninfo .= 'Бан по IP: '.stripslashes($row->ban_ip).'<br>';
			}
			if( $row->ban_ses )
			{
				$baninfo .= 'Бан по SES: '.stripslashes($row->ban_ses).'<br>';
			}
			$bi['info'] = $baninfo;
			
			
			$blist[] = $bi;
		}
		mysqli_free_result( $res );
	}

	for( $i=0; $i<count($blist); $i++ )
	{
		echo '<tr>
		<td>&nbsp;</td>
		<td align="center">'.$blist[$i]['dtst'].'</td>
		<td align="center">'.$blist[$i]['dten'].'</td>
		<td align="center">'.$blist[$i]['period'].'</td>
		<td align="center">'.$blist[$i]['info'].'</td>
		<td>'.$blist[$i]['comment'].'</td>
		<td align="center">'.($blist[$i]['now'] ? '<span style="color: red;">Акт</span>' : '').'</td>
		<td align="center">'.($bi['dis'] ? 'нет' : '<span style="color: red;">Акт</span>' ).'</td>
		<td>
			<a href="'.$PHP_SELF.'?action=delete&uid='.$uid.'&bid='.$blist[$i]['id'].'" class="blink"><img src="img/delete.gif" width="20" height="20" border="0" alt="'.$strings['tipdeluser'][$lang].'" /></a>&nbsp;
			<a href="'.$PHP_SELF.'?action=status&uid='.$uid.'&active='.($blist[$i]['dis'] == 1 ? 0 : 1).'&bid='.$blist[$i]['id'].'" class="blink"><img src="img/refresh.gif" width="20" height="20" border="0" alt="'.$strings['tipstatus'][$lang].'" /></a>&nbsp;
		</td>
		</tr>';
	}
	?>
	<tr>
	      <td class="fr" colspan="8" align="center"><br /><input type="submit" value=" <?=$strings['applybtn'][$lang];?> " /><br /></td>
	</tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br /><br /><br />
<?php
	}
	else
	{
?>
    <!-- PART OF PAGE TO DISPLAY USER'S LIST -->
	<h3><?=$strings['userlist'][$lang];?></h3>

	<form action="<?=$PHP_SELF;?>" name="bselfrm" method="POST">
    <div style="padding: 10px 0px 4px 10px;">Область: &nbsp;
    	<select name="oblid" onchange="document.forms['bselfrm'].submit();">
    		<option value="0">--- Все области ---</option>
<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($oblid == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}
?>
		</select>
		&nbsp;&nbsp;&nbsp; Показать по:
		<select name="pn" onchange="document.forms['bselfrm'].submit();">
			<option value="25"<?=($pn == 25 ? ' selected' : '');?>>25</option>
			<option value="50"<?=($pn == 50 ? ' selected' : '');?>>50</option>
			<option value="100"<?=($pn == 100 ? ' selected' : '');?>>100</option>
		</select>
    </div>
    <div style="padding: 1px 0px 10px 10px;">
    	Фильтровать по E-mail: <input type="text" name="fltmail" value="<?=$fltmail;?>" /> &nbsp;&nbsp;&nbsp;&nbsp; по Тел. <input type="text" name="flttel" value="<?=$flttel;?>" />
    	&nbsp;&nbsp;&nbsp; по Имени <input type="text" name="fltname" value="<?=$fltname;?>" /> &nbsp;&nbsp;&nbsp; по ID <input type="text" name="fltid" value="<?=$fltid;?>" size="5" /> 
		&nbsp;&nbsp;&nbsp; по IP <input type="text" name="fltip" value="<?=$fltip;?>" /> &nbsp;&nbsp;&nbsp; по SES <input type="text" name="fltses" value="<?=$fltses;?>" />
		<input type="submit" value="Применить" />
    </div>
    </form>

    <table cellspacing="0" cellpadding="0" border="0" align="center" width="90%">
    <tr>
    	<th>ID</th>
    	<th width="30">&nbsp;</th>
    	<th><?=$strings['rowlogin'][$lang];?></th>
    	<th><?=$strings['rowname'][$lang];?></th>
    	<th><?=$strings['rowaddr'][$lang];?></th>
    	<th><?=$strings['rowcontact'][$lang];?></th>
    	<th>Бан</th>
    	<th>До</th>
    	<th width="100">&nbsp;</th>
    </tr>
    <tr>
    	<td colspan="9" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>
    <?php
    	$sel_cond = "";
		$sel_cond0 = "";

		$limit_cond = "";
		if( $pi > 0 )
		{
			$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
		}

		if( ($fltid != "") && ($fltid != 0) )
			$sel_cond0 .= " AND b1.id='$fltid' ";

		if( $oblid != 0 )
			$sel_cond0 .= " AND b1.obl_id=".$oblid." ";

		if( $fltname != "" )
			$sel_cond0 .= " AND ( (b1.name LIKE '%".addslashes($fltname)."%') OR (b1.orgname LIKE '%".addslashes($fltname)."%') ) ";

		if( $fltmail != "" )
			$sel_cond .= " AND e1.ban_email LIKE '%".addslashes($fltmail)."%' ";

		if( $flttel != "" )
			$sel_cond .= " AND e1.ban_phone LIKE '%".addslashes($flttel)."%' ";
		
		if( $fltip != "" )
			$sel_cond .= " AND e1.ban_ip LIKE '%".addslashes($fltip)."%' ";
		
		if( $fltses != "" )
			$sel_cond .= " AND e1.ban_ses LIKE '%".addslashes($fltses)."%' ";

		//if( $sel_cond != "" )
		//	$sel_cond = " WHERE b1.id<>0 ".$sel_cond;

		echo '<tr><td colspan="9" bgcolor="#DDDDDD" style="font-weight: bold; text-align: center;">Бан пользовтелей с аккаунтами</td></tr>';

		$its_num = 0;
		$query = "SELECT count(b1.*) as totu FROM $TABLE_TORG_BUYERS b1
			INNER JOIN $TABLE_TORG_BUYER_BAN e1 ON b1.id=e1.user_id AND e1.is_disabled=0 AND e1.add_date<=NOW() AND e1.end_date>NOW()
			WHERE e1.user_id<>0 $sel_cond $sel_cond0
			GROUP BY b1.id";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$its_num = $row->totu;
			}
			mysqli_free_result( $res );
		}


    	$query = "SELECT b1.*, e1.end_date, e1.ban_ip, e1.ban_phone, e1.ban_email, e1.ban_ses  
		FROM $TABLE_TORG_BUYERS b1
    	INNER JOIN $TABLE_TORG_BUYER_BAN e1 ON b1.id=e1.user_id AND e1.is_disabled=0 AND e1.add_date<=NOW() AND e1.end_date>NOW()
    	WHERE e1.user_id<>0 $sel_cond $sel_cond0
    	GROUP BY b1.id
    	ORDER BY b1.login
    	$limit_cond";
		if($res = mysqli_query($upd_link_db,$query))
		{
            while( $row = mysqli_fetch_object($res) )
            {
            	$payment_str = "";

                $user_city = $row->city; //"";
                /*
                $user_country = "";
                $query1 = "SELECT cl1.name as city, c2.name as country
                		FROM $TABLE_CITY c1
                		INNER JOIN $TABLE_CITY_LANG cl1 ON c1.id=cl1.city_id AND cl1.lang_id='$LangId'
                		INNER JOIN $TABLE_COUNTRY_LANG c2 ON c1.country_id=c1.country_id AND c2.lang_id='$LangId'
                		WHERE c1.id='".$row->city_id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    if( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$user_city = stripslashes($row1->city);
                    	$user_country = stripslashes($row1->country);
                    }
                    mysqli_free_result($res1);
                }
                */

                $ban_num = Torg_BuyerBanCount($LangId, $row->id);
                $ban_now = Torg_BuyerIsBan($LangId, $row->id);
				
				$baninfo = '';

                if( $row->bantel != "" )
                {
                	$baninfo .= 'Бан по тел.: '.stripslashes($row->bantel).'<br>';
                }
                if( $row->ban_email )
                {
                	$baninfo .= 'Бан по E-mail: <a href="mailto:'.stripslashes($row->ban_email).'">'.stripslashes($row->ban_email).'</a><br>';
                }
                if( $row->ban_ip )
                {
                	$baninfo .= 'Бан по IP: '.stripslashes($row->ban_ip).'<br>';
                }
				if( $row->ban_ses )
                {
                	$baninfo .= 'Бан по SES: '.stripslashes($row->ban_ses).'<br>';
                }

                //$rayname = "";
                //if( $row->rayon != null )
                //{
				//	$rayname = stripslashes($row->rayon)." район";
                //}

            	echo "<tr>
            			<td>".$row->id."</td>
            			<td><img src=\"img/user_".(($row->isactive == 0) ? "disable" : "enable").".gif\" width=\"30\" height=\"36\" border=\"0\" alt=\"\" /></td>
            			<td>".stripslashes($row->login)."<br /></td>
            			<td><b>".stripslashes($row->orgname)."</b><br />".stripslashes($row->name)."</td>
            			<td>".$REGIONS[$row->obl_id]."<br />".$user_city.", ".stripslashes($row->address)."</td>
            			<td>".( true ? $baninfo : $fields['telephone'][$lang].": ".stripslashes($row->phone)."<br />".( 
							($row->email != NULL) && ($row->email != "") ? "E-Mail: <a href=\"mailto:".stripslashes($row->email)."\">".stripslashes($row->email)."</a><br />" : "" ) )."
						</td>
            	<td align=\"center\">".($ban_now['id'] != 0 ? '<a href="#"><span style="font-weight: bold; color: red;">'.$ban_num.'</span></a>' : '<a href="#">'.$ban_num.'</a>')."</td>
            	<td align=\"center\">".$row->end_date."</td>
            	<td>";

					// Display this link only for users who are not in MANAGERS group
					echo "<br />";
					//echo "<a href=\"$PHP_SELF?action=delete&uid=".$row->id."\" class=\"blink\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdeluser'][$lang]."\" /></a>&nbsp;";
					echo "
						<a href=\"$PHP_SELF?action=status&active=".(($row->isactive == 1) ? 0 : 1)."&uid=".$row->id."\" class=\"blink\"><img src=\"img/refresh.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipstatus'][$lang]."\" /></a>&nbsp;";

                     //if( $UserGroup == $GROUP_ADMIN )
                     echo "<a href=\"$PHP_SELF?action=editprofile&uid=".$row->id."\" class=\"blink\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedituser'][$lang]."\" /></a>&nbsp;<br />";

            	echo 	"</td>
            	     </tr>
            	     <tr>
            	     	<td colspan=\"9\" bgcolor=\"#DDDDDD\"><img src=\"img/spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td>
            	     </tr>";
            }
        	mysqli_free_result($res);
        }
        echo "<b>".mysqli_error($upd_link_db)."</b>";

        echo '<tr><td colspan="9" bgcolor="#DDDDDD" style="font-weight: bold; text-align: center;">Бан по телефону или email</td></tr>';

        $its_num2 = 0;
		$query = "SELECT count(*) as totu FROM $TABLE_TORG_BUYER_BAN e1
			WHERE e1.user_id=0 AND e1.add_date<=NOW() AND e1.end_date>NOW() $sel_cond";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$its_num2 = $row->totu;
			}
			mysqli_free_result( $res );
		}


    	$query = "SELECT *, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(ban_phone,' ',''), '-', ''), '+', ''),'(', ''),')','') as bantel 
		FROM $TABLE_TORG_BUYER_BAN e1
    	WHERE e1.user_id=0 AND e1.add_date<=NOW() AND e1.end_date>NOW() $sel_cond
    	ORDER BY e1.add_date DESC
    	$limit_cond";
		if($res = mysqli_query($upd_link_db,$query))
		{
            while( $row = mysqli_fetch_object($res) )
            {
            	$payment_str = "";

                $user_city = "";//$row->city; //"";
                /*
                $user_country = "";
                $query1 = "SELECT cl1.name as city, c2.name as country
                		FROM $TABLE_CITY c1
                		INNER JOIN $TABLE_CITY_LANG cl1 ON c1.id=cl1.city_id AND cl1.lang_id='$LangId'
                		INNER JOIN $TABLE_COUNTRY_LANG c2 ON c1.country_id=c1.country_id AND c2.lang_id='$LangId'
                		WHERE c1.id='".$row->city_id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    if( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$user_city = stripslashes($row1->city);
                    	$user_country = stripslashes($row1->country);
                    }
                    mysqli_free_result($res1);
                }
                */

                $baninfo = '';

                if( $row->bantel != "" )
                {
                	$baninfo .= 'Бан по тел.: '.stripslashes($row->bantel).'<br>';
                }
                if( $row->ban_email )
                {
                	$baninfo .= 'Бан по E-mail: <a href="mailto:'.stripslashes($row->ban_email).'">'.stripslashes($row->ban_email).'</a><br>';
                }
                if( $row->ban_ip )
                {
                	$baninfo .= 'Бан по IP: '.stripslashes($row->ban_ip).'<br>';
                }
				if( $row->ban_ses )
                {
                	$baninfo .= 'Бан по SES: '.stripslashes($row->ban_ses).'<br>';
                }

                //$ban_num = Torg_BuyerBanCount($LangId, $row->id);
                //$ban_now = Torg_BuyerIsBan($LangId, $row->id);

            	echo "<tr>
            			<td>".$row->id."</td>
            			<td><img src=\"img/user_".($row->is_disabled == 1 ? "disable" : "enable").".gif\" width=\"30\" height=\"36\" border=\"0\" alt=\"\" /></td>
            			<td>&nbsp;</td>
            			<td><b>".stripslashes($row->ban_name)."</b></td>
            			<td>".( false ? $REGIONS[$row->obl_id]."<br />".$user_city.", ".stripslashes($row->address) : '&nbsp;' )."</td>
            			<td>".$baninfo."</td>
            	<td align=\"center\">".($row->is_disabled == 0 ? '<span style="font-weight: bold; color: red;">да</span>' : '')."</td>
            	<td align=\"center\">".$row->end_date."</td>
            	<td>";

					// Display this link only for users who are not in MANAGERS group
					echo "<br />";
					echo "<a href=\"$PHP_SELF?action=delete&bid=".$row->id."\" class=\"blink\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdeluser'][$lang]."\" /></a>&nbsp;";
					echo "<a href=\"$PHP_SELF?action=status&active=".($row->is_disabled == 1 ? 0 : 1)."&bid=".$row->id."\" class=\"blink\"><img src=\"img/refresh.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipstatus'][$lang]."\" /></a>&nbsp;";

                     //if( $UserGroup == $GROUP_ADMIN )
                     //echo "<a href=\"$PHP_SELF?action=editprofile&uid=".$row->id."\" class=\"blink\"><img src=\"img/edit.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipedituser'][$lang]."\" /></a>&nbsp;<br />";

            	echo 	"</td>
            	     </tr>
            	     <tr>
            	     	<td colspan=\"9\" bgcolor=\"#DDDDDD\"><img src=\"img/spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td>
            	     </tr>";
            }
        	mysqli_free_result($res);
        }
        echo "<b>".mysqli_error($upd_link_db)."</b>";


    ?>
	</table>
	<?php
    	if( $its_num > $pn )
    	{
    		$PAGES_NUM = ceil( $its_num/$pn );
    		echo '<div style="padding: 20px 20px 20px 20px; text-align: center;">Страницы: ';

    		for( $i=1; $i<=$PAGES_NUM; $i++ )
    		{
    			if( $i == $pi )
    				echo ' <b>'.($i).'</b> ';
    			else
    				echo ' <a href="'.$PHP_SELF.'?oblid='.$oblid.'&pi='.$i.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'">'.$i.'</a> ';
    		}

    		echo '</div>';
    	}
    ?>

    <br /><br />
<?php
	}

	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
