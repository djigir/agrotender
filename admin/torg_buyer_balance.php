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
	$fields['activeweb']['ru'] = 'Активирован';
	$fields['address']['ru'] = 'Адрес';
	$fields['city']['ru'] = 'Город';
	$fields['country']['ru'] = 'Страна';
	$fields['zip_code']['ru'] = 'Почтовый Индекс';
	$fields['telephone']['ru'] = 'Телефон';
	$fields['telephone2']['ru'] = 'Телефон2';
	$fields['telephone3']['ru'] = 'Телефон3';
	$fields['office_phone']['ru'] = 'Рабочий тел.';
	$fields['cell_phone']['ru'] = 'Мобильный тел.';
	$fields['email1']['ru'] = 'E-Mail 1';
	$fields['email2']['ru'] = 'E-Mail 2';
	$fields['email3']['ru'] = 'E-Mail 3';
	$fields['web_url']['ru'] = 'Веб-страница';
	$fields['groupid']['ru'] = 'Группа пользователей';
	$fields['trader']['ru'] = 'Привязка к трейдеру';

	$fields['name']['en'] = 'Full Name';
	$fields['login']['en'] = 'Login';
	$fields['passwd']['en'] = 'Password';
	$fields['activeweb']['ru'] = 'Activated';
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

	$strings['editprof']['ru'] = "Редактирование Профиля Пользователя";
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

	$PAGE_HEADER['ru'] = "Движения по счету клиентов";
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

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 100);
	
	$viewtype = 0;
	
	$msg = "";

	$uprof = Array();

	$uprof['name'] = GetParameter("fullname", "");
	$uprof['orgname'] = GetParameter("orgname", "");
	$uprof['passwd'] = GetParameter("passwd", "");
	$uprof['login'] = GetParameter("login", "");
	$uprof['address'] = GetParameter("address", "");
	$uprof['city'] = GetParameter("orgcity", "");
	$uprof['isactive_web'] = GetParameter("isactive_web", "");
	$uprof['country'] = GetParameter("country", "");
	$uprof['phone'] = GetParameter("phone", "");
	$uprof['phone2'] = GetParameter("phone2", "");
	$uprof['phone3'] = GetParameter("phone3", "");
	$uprof['email'] = GetParameter("email", "");
	$uprof['web_url'] = GetParameter("weburl", "");
	$uprof['comments'] = GetParameter("comments", "");
	$uprof['max_advs'] = GetParameter("maxadv", 0);
	//$uprof['groupid'] = GetParameter("userlevel", "0");
	//$uprof['usertrader'] = GetParameter("usertrader", 0);

	switch( $action )
	{
		case "delete":
			/*
			if(empty($uid))			$uid = $_GET['uid'];
			if( $uid == $UserId )	break;

			if(mysqli_query($upd_link_db,"DELETE FROM $TABLE_USERS WHERE id='$uid' AND id<>1"))
			{
				// Make user records cleaning
			}
			else
			{
				echo mysqli_error($upd_link_db);
			}
			*/
  			break;		

		case "editbill":
			$mode = "editbill";
			$billid = GetParameter("billid", 0);
			break;

		case "apply":
			$billid = GetParameter("billid", 0);
			$mode = "editbill";
			
			$bsum = GetParameter("bsum", 0);
			$boooid = GetParameter("boooid", 0);
			$baddrid = GetParameter("baddrid", 0);
			$bcomment = GetParameter("bcomment", '');
			
			$query = "UPDATE $TABLE_PAY_BILL SET amount='".number_format($bsum, 2, ".", "")."', payer_ooo_id='$boooid', payer_addr_id='$baddrid' WHERE id='$billid'";
			if( !mysqli_query($upd_link_db,$query) )
				debugMysql();
			break;
			
		case "getpayment":
			$billid = GetParameter("billid", 0);
			$mode = "editbill";
			
			$billinf = Buyer_BillInfo($LangId, $billid);
			if( $billinf['id'] != 0 )
			{
				if( $billinf['status'] != $BILLING_STATUS_DONE )
				{
					// Add funds to client account and set status to DONE
					$query = "UPDATE $TABLE_PAY_BILL SET status='".$BILLING_STATUS_DONE."' WHERE id='$billid'";
					if( !mysqli_query($upd_link_db,$query) )
						debugMysql();
					
					$query = "INSERT INTO $TABLE_PAY_BALANCE_OPER (buyer_id, bill_id, oper_by, oper_debkred, kredit_type, debit_type, amount, add_date) 
						VALUES ('".$billinf['buyer_id']."', '".$billinf['id']."', 1, '$BILLING_PAY_OPER_KREDIT', '".$billinf['pay_meth']."', 0, '".number_format($billinf['amount'], 2, ".", "")."', NOW())";
					if( !mysqli_query($upd_link_db,$query) )
						debugMysql();
				}
			}
			
			break;
	}

	if( $mode == "editbill" )
	{
		//if( $UserGroup != $GROUP_ADMIN )
		//{
		//	break;
		//}
		$billinf = Buyer_BillInfo($LangId, $billid);
		
		$bfirms = Buyer_BillFirmList($LangId, $billinf['buyer_id']);
		$baddrs = Buyer_BillAddrList($LangId, $billinf['buyer_id']);
?>
	<div style="text-align: center; padding: 16px 0;"><a href="<?=$PHP_SELF;?>">Вернуться к списку счетов</a></div>
	<br />
	
	<?php
		if( $msg != "" )
		{
			echo '<div style="color: red; font-weight: bold; padding: 20px; text-align: center;">'.$msg.'</div>';
		}
	?>

	<h3>Информация по счету</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="apply" />
	<input type="hidden" name="billid" value="<?=$billid;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<tr>
	    <td class="ff">Дата счета:</td>
	    <td class="fr"><b><?=$billinf['add'];?></b></td>
	</tr>
	<tr>
	    <td class="ff">Тип оплаты:</td>
	    <td class="fr"><b><?=$BILLING_PAYMETH_STR[$billinf['pay_meth']];?></b></td>
	</tr>	
	<tr>
	    <td class="ff">Статус оплаты</td>
	    <td class="fr"><b><?=$BILLING_STATUS_STR[$billinf['status']];?></b></td>
	</tr>
	<tr>
	    <td class="ff">Сумма счета:</td>
	    <td class="fr"><input class="field" name="bsum" type="text" value="<?=$billinf['amount'];?>" /></td>
	</tr>	
    <tr>
	    <td class="ff">Плательщик:</td>
	    <td class="fr"><select name="boooid">
	<?php
		for($i=0; $i<count($bfirms); $i++)
		{
			echo '<option value="'.$bfirms[$i]['id'].'"'.( $bfirms[$i]['id'] == $billinf['ooo_id'] ? ' selected' : '' ).'>'.$bfirms[$i]['name'].'</option>';
		}
	?>
		</select></td>
	</tr>
    <tr>
	    <td class="ff">Адрес отправки документов:</td>
	    <td class="fr"><select name="baddrid">
			<option value="0">--- Адрес не указан ---</option>
	<?php
		for($i=0; $i<count($baddrs); $i++)
		{
			echo '<option value="'.$baddrs[$i]['id'].'"'.( $baddrs[$i]['id'] == $billinf['addr_id'] ? ' selected' : '' ).'>'.$baddrs[$i]['city'].', '.$baddrs[$i]['name'].'</option>';
		}
	?>
		</select></td>
	</tr>		
	<tr>
	    <td class="ff">Комментарии:</td>
	    <td class="fr"><textarea name="bcomment" rows="3" cols="50"><?=$billinf['purpose'];?></textarea></td>
	</tr>
	<tr>
	      <td class="fr" colspan="2" align="center"><br /><input type="submit" value=" Сохранить " /><br /></td>
	</tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br /><br />
<?php
	if( $billinf['status'] != $BILLING_STATUS_DONE )
	{
		echo "<br><br>
		<h3>Подтвердить получение денег и внести их на счет</h3>";
?>
		<form action="<?=$PHP_SELF;?>" method="POST">
		<input type="hidden" name="action" value="getpayment" />
		<input type="hidden" name="billid" value="<?=$billid;?>" />
		<input type="hidden" name="oblid" value="<?=$oblid;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
		<input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
		<input type="hidden" name="flttel" value="<?=$flttel;?>" />
		<input type="hidden" name="fltname" value="<?=$fltname;?>" />
		<input type="hidden" name="fltid" value="<?=$fltid;?>" />
		<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
		<tr><td>
			<table width="100%" cellspacing="1" cellpadding="1" border="0">
			<tr><td class="fr" colspan="2" align="center"><br /><input type="submit" value=" Подтвердить получение денег " /><br /></td></tr>	
			</table>
		</td></tr>
		</table>
		</form>
		<br><br>
<?php
	}


	$docs = Buyer_BillDocList($LangId, 0, $billid);
	
	echo '<h3>Все документы по оплате</h3><br>
	<table cellspacing="0" cellpadding="0" border="0" align="center" width="90%">
	<tr>
		'.( false ? '<th>№</th>' : '' ).'
		<th>ID</th>
		<th>Дата</th>
		<th>Тип</th>
		<th>Название</th>				
		<th>Плательщик</th>
		<th>Действия</th>
	</tr>
	<tr>
    	<td colspan="5" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>';
	
	for( $i=0; $i<count($docs); $i++ )
	{			
		$firminf = Buyer_BillFirmInfo($LangId, $docs[$i]['bill_ooo_id'], $docs[$i]['buyer_id']);
		
		echo '<tr>
			'.( false ? '<td>'.($i+1).'</td>' : '' ).'
			<td>'.$docs[$i]['id'].'</td>
			<td class="uctbl-dttm">
				<span class="uctbl-dt">'.$docs[$i]['add'].'</span>
			</td>					
			<td class="ta_center">'.$$BILLING_DOCTYPE_STR[$docs[$i]['type']].'</td>
			<td>'.$docs[$i]['file'].'</td>
			<td class="ta_center">'.( $firminf['id'] != 0 ? $firminf['name'] : ' - ').'</td>
			<td class="uctbl-nav">
				'.( false ? '<a href="'.$PHP_SELF.'?action=editbill&billid='.$docs[$i]['id'].'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/edit.gif" width="20" height="20" border="0" alt="Редактировать инф. по счету" /></a>&nbsp;<br />' : '' ).'
			</td>
		</tr>
		<tr>
			<td colspan="6" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
		</tr>';
	}

	if( count($docs) == 0 )
	{
		echo '<tr>
				<td class="ta_center" colspan="6"><p class="mtinfo_p">Нет докумнетов по данному счету</p></td>
			</tr>';
	}
	echo '</table>';	
?>		
	<br><br>
<?php
	}
	else
	{
?>

    <!-- PART OF PAGE TO DISPLAY USER'S LIST -->
	<h3>Перечень операций по счетам клиентов</h3>

	<form action="<?=$PHP_SELF;?>" name="bselfrm" method="POST">
	<div style="padding: 10px 0px 4px 10px;">
<?php
	/*
    Область: &nbsp;
    	<select name="oblid" onchange="document.forms['bselfrm'].submit();">
    		<option value="0">--- Все области ---</option>
<?php
		for( $i=1; $i<count($REGIONS); $i++ )
		{
			echo '<option value="'.$i.'"'.($oblid == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
		}
?>
		</select>
		&nbsp;&nbsp;&nbsp; 
	*/
?>
		Показать по:
		<select name="pn" onchange="document.forms['bselfrm'].submit();">
			<option value="25"<?=($pn == 25 ? ' selected' : '');?>>25</option>
			<option value="50"<?=($pn == 50 ? ' selected' : '');?>>50</option>
			<option value="100"<?=($pn == 100 ? ' selected' : '');?>>100</option>
		</select>
<?php
	/*
    </div>
    <div style="padding: 1px 0px 10px 10px;">
    	Фильтровать по E-mail: <input type="text" name="fltmail" value="<?=$fltmail;?>" /> &nbsp;&nbsp;&nbsp;&nbsp; по Тел. <input type="text" name="flttel" value="<?=$flttel;?>" />
    	&nbsp;&nbsp;&nbsp; по Имени <input type="text" name="fltname" value="<?=$fltname;?>" /> &nbsp;&nbsp;&nbsp; по ID <input type="text" name="fltid" value="<?=$fltid;?>" size="5" />
	*/
?>
		<input type="submit" value="Применить" />
    </div>
	
    </form>
	
	
<?php
	$sortby = "";
	$sel_cond = "";
	
	$its_num = Buyer_BalanceNumop(0);	
	
	$its = Buyer_BalanceList($LangId, 0, -1, -1, $pi, $pn, $sortby, "withbuyer");

	echo '<h3>Отчет по операциям по счетам клиентов</h3>
	<br>';
	
	/*
	echo '<table class="f12 tbl-dark">
	<tr>
		'.( false ? '<th>№</th>' : '' ).'
		<th>'.( $sortby == "add" ? "Дата" : '<a href="'.$PHP_SELF.'?viewtype='.$viewtype.'&sortby=add">Дата</a>' ).'</th>
		<th>'.( $sortby == "paymeth" ? "Метод" : '<a href="'.$PHP_SELF.'?viewtype='.$viewtype.'&sortby=paymeth">Метод</a>' ).'</th>
		<th>'.( $sortby == "type" ? "Физ./Юр." : '<a href="'.$PHP_SELF.'?viewtype='.$viewtype.'&sortby=type">Физ./Юр.</a>' ).'</th>
		<th>'.( $sortby == "status" ? "Статус" : '<a href="'.$PHP_SELF.'?viewtype='.$viewtype.'&sortby=status">Статус</a>' ).'</th>				
		<th>Назначение</th>
		<th>'.( $sortby == "amount" ? "Сумма" : '<a href="'.$PHP_SELF.'?viewtype='.$viewtype.'&sortby=amount">Сумма</a>' ).'</th>
		<th>Плательщик</th>
		<th>Действия</th>
	</tr>';
	*/
	echo '<table cellspacing="0" cellpadding="0" border="0" align="center" width="90%">
	<tr>
		'.( false ? '<th>№</th>' : '' ).'
		<th>'.( $sortby == "add" ? "Дата" : '<a href="'.$PHP_SELF.'?viewtype='.$viewtype.'&sortby=add">Дата</a>' ).'</th>
		<th>Логин</th>
		<th>Пользователь</th>
		<th>Кто провел</th>
		<th>Тип платежа</th>
		<th>Назначение</th>				
		<th>Сумма</th>		
		<th>Счет</th>
		<th>Действия</th>
	</tr>
	<tr>
    	<td colspan="9" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>';
	
	for( $i=0; $i<count($its); $i++ )
	{
		$nazn = '';
		//$firminf = Buyer_BillFirmInfo($LangId, $its[$i]['ooo_id'], $its[$i]['buyer_id']);
		if( $BILLING_PAY_OPER_KREDIT == $its[$i]['oper_debkred'] )
		{
			// Пополнение счета
			$nazn = "Пополнение счета";
			switch( $its[$i]['ktype'] )
			{
				case $BILLING_PAYMETH_P24:	$nazn .= " - Приват24";	break;
				case $BILLING_PAYMETH_CARD:	$nazn .= " - Картой";	break;
				case $BILLING_PAYMETH_BILL:	$nazn .= " - По счету";	break;
			}
		}
		else
		{
			// Оплата за услугу
			$packinf = Pack_Info($its[$i]['dtype']);
			if( $packinf['id'] != 0 )
			{
				$nazn = "Оплата за - ".$packinf['title'];
			}
		}
				
		echo '<tr>
			'.( false ? '<td>'.($i+1).'</td>' : '' ).'
			<td class="uctbl-dttm">
				<span class="uctbl-dt">'.$its[$i]['add'].'</span>
			</td>								
			<td>'.$its[$i]['b_login'].'</td>
			<td><b>'.$its[$i]['b_orgname'].'</b><br>'.$its[$i]['b_name'].'</td>
			<td class="ta_center">'.( $its[$i]['oper_by'] == 1 ? 'Админ' : 'Польз.' ).'</td>
			<td class="ta_center">'.$BILLING_PAY_OPER_STR[$its[$i]['oper_debkred']].'</td>
			<td class="ta_center">'.$nazn.'</td>
			<td class="ta_center">'.$its[$i]['amount'].'</td>					
			<td class="ta_center">'.( $its[$i]['bill_id'] != 0 ? $its[$i]['bill_id'] : ' - ').'</td>
			<td class="uctbl-nav">
				'.( false ? '<a href="'.$PHP_SELF.'?action=editbill&billid='.$its[$i]['id'].'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/edit.gif" width="20" height="20" border="0" alt="Редактировать инф. по счету" /></a>&nbsp;<br />' : '' ).'
			</td>
		</tr>
		<tr>
			<td colspan="9" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
		</tr>';
	}

	if( count($its) == 0 )
	{
		echo '<tr>
				<td class="ta_center" colspan="9"><p class="mtinfo_p">Еще не сделали ни одной операции</p></td>
			</tr>';
	}
	echo '</table>';				
				
?>
	
    <?php
	/*
    	$sel_cond = "";

		$limit_cond = "";
		if( $pi > 0 )
		{
			$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
		}

		if( ($fltid != "") && ($fltid != 0) )
			$sel_cond .= " AND b1.id='$fltid' ";

		if( $oblid != 0 )
			$sel_cond .= " AND b1.obl_id=".$oblid." ";

		if( $fltname != "" )
			$sel_cond .= " AND ( (b1.name LIKE '%".addslashes($fltname)."%') OR (b1.orgname LIKE '%".addslashes($fltname)."%') ) ";

		if( $fltmail != "" )
			$sel_cond .= " AND b1.email LIKE '%".addslashes($fltmail)."%' OR b1.login LIKE '%".addslashes($fltmail)."%' ";

		if( $flttel != "" )
			$sel_cond .= " AND b1.phone LIKE '%".addslashes($flttel)."%' ";

		if( $sel_cond != "" )
			$sel_cond = " WHERE b1.id<>0 ".$sel_cond;

		$its_num = 0;
		$query = "SELECT count(*) as totu FROM $TABLE_TORG_BUYERS $sel_cond";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$its_num = $row->totu;
			}
			mysqli_free_result( $res );
		}


    	$query = "SELECT b1.*, r2.name as rayon FROM $TABLE_TORG_BUYERS b1
    	LEFT JOIN $TABLE_RAYON r1 ON b1.ray_id=r1.id
    	LEFT JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
    	$sel_cond
    	ORDER BY b1.id DESC
    	$limit_cond";
	*/	
	
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
