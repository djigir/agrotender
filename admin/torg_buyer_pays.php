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

	$PAGE_HEADER['ru'] = "Управление счетами на услуги/оплаты";
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
	
	$billmeth = GetParameter("billmeth", 0);
	$billstat = GetParameter("billstat", -2);
	$billaktstat = GetParameter("billaktstat", -1);
	$bbillid = GetParameter("bbillid", 0);
	
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
	
function File_LoadDoc($uid, $billid, $billinf, $doctype, $docsum, $f_name, $f_tmp)
{
	global $TABLE_PAY_BILL_DOC, $BILLING_DOCDIR;
	global $BILLING_DOCTYPE_BILL, $BILLING_DOCTYPE_AKT, $BILLING_DOCTYPE_SCAN;
		
	if( isset($f_name) && ($f_name != "") && ($f_tmp != "") )
	{
		// ok
	}
	else
	{
		return false;
	}	

	// Make meaning name of file
	$point_pos = strrpos($f_name, ".");
	if( $point_pos == -1 )
		return;
	$newfileext = substr($f_name, $point_pos );
	
	$allowed_ext = Array(".doc", ".docx", ".pdf", ".xls", ".xlsx");
	if( !in_array(strtolower($newfileext), $allowed_ext) )
	{
		return false;
	}
	
	$base_name = "";
	switch($doctype)
	{
		case $BILLING_DOCTYPE_BILL:	$base_name = "bill_";	break;
		case $BILLING_DOCTYPE_AKT:	$base_name = "akt_";	break;
		default:					$base_name = "scan_";	break;			
	}
	
	// Check if the folder by doc date is exists, or create it
	$doc_dt0 = explode(".", $billinf['dt'], 3);
	$pdf_base_folder = "../".$BILLING_DOCDIR;	//"billdocs/";
	$pdf_folder = $doc_dt0[2]."_".$doc_dt0[1]."/";
				
	if( !file_exists($pdf_base_folder.$pdf_folder) )
	{
		mkdir($pdf_base_folder.$pdf_folder, 0755);
	}
	
	
	$base_name .= $billid."_".date("Y_m_d",time());

	/// Make the name for new file
	$inum = 0;
	$newfilename = "";
	while($inum < 100)
	{
		$randval = rand(10000, 99999);
		$newfilename = $base_name."_".$randval.$newfileext;

		echo $newfilename."<br />";

		if( !file_exists($pdf_base_folder.$pdf_folder.$newfilename) )
		{
			break;
		}
		$inum++;
	}
	if( $inum == 100 )
		return false;

	//echo "Copy<br />";
	$finalname = $BILLING_DOCDIR.$pdf_folder.$newfilename;
	echo $f_tmp;

	if( !copy($f_tmp, "../".$finalname) )		
		return false;
	
	chmod( "../".$finalname, 0644 );
	unlink( $f_tmp );
	
	$query = "INSERT INTO $TABLE_PAY_BILL_DOC (buyer_id, bill_id, doc_type, sum_tot, filename, add_date) 
		VALUES ('$uid', '$billid', '$doctype', '".number_format($docsum, 2, ".", "")."', '".addslashes($finalname)."', NOW())";
	if( !mysqli_query($upd_link_db, $query ) )
	{
	   mysqlDebug();
	}
	else
	{
		// photo was added successfully, so make thumbs - one big for car view, other smaller for catalog view
		$newimgid = mysqli_insert_id();

		return $newimgid;		
	}
	
	return false;
}

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
			
		case "delbilldoc":	
			$billid = GetParameter("billid", 0);
			$docid = GetParameter("docid", 0);
			
			$filepath = "";
			$query = "SELECT * FROM $TABLE_PAY_BILL_DOC WHERE bill_id='$billid' AND id='$docid'";
			if( $res = mysqli_query($upd_link_db,$query) )
			{
				if($row = mysqli_fetch_object($res) )
				{
					$filepath = stripslashes($row->filename);
				}
				mysqli_free_result($res);
			}
			
			if( $filepath != "" )
			{
				unlink("../".$filepath);
				
				$query = "DELETE FROM $TABLE_PAY_BILL_DOC WHERE bill_id='$billid' AND id='$docid'";
				if( !mysqli_query($upd_link_db,$query) )
				{
					debugMysql();
				}
			}
			
			$mode = "editbill";
			break;
			
		case "addbilldoc":
			$billid = GetParameter("billid", 0);
			$docsum = GetParameter("docsum", 0);
			$doctype = GetParameter("doctype", 0);	

			$mode = "editbill";			
			
			if( isset($_FILES['docfile']) && ($_FILES['docfile']['name']) )
			{
				$docfile = $_FILES['docfile'];				
				
				$billinf = Buyer_BillInfo($LangId, $billid);
				if( $billinf['id'] != 0 )
				{
					$newdocid = File_LoadDoc($billinf['buyer_id'], $billinf['id'], $billinf, $doctype, $docsum, $docfile['name'], $docfile['tmp_name']);
					//Product_LoadPhoto($newitemid, $photofile['name'], $photofile['tmp_name'], $photoind, $phototitle );
					
					if( $newdocid > 0 )
					{
						$docinf = Buyer_BillDocInf($LangId, $newdocid);
						
						// 
						include "../uhlibs/unisend/inc/unisender-init.php";
						
						$buyerinf = Torg_BuyerInfo($LangId, $billinf['buyer_id']);
						
						///////////////////////////////////////////////////////////////////
						// Send mail through unisender
						$body_data = array(
							"{FULL_NAME}" => $buyerinf['name'],
							"{ACCOUNT_NUMBER}"	=> $billinf['id'],
							"{ACCOUNT_DATE}"	=> $billinf['dt'],
							"{URL_OPEN_DOC}" => $WWWHOST.$docinf['file'],
						);
				
						Send_UniSenderMail($buyerinf['login'], $buyerinf['name'], "Акт выполненных работ по счету №".$billinf['id'], MAIL_TPL_PAYDOCS, $body_data);
						////////////////////////////////////////////////////////////////////
					}
				}
			}
		
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
			$baktstat = GetParameter("baktstat", '');
			
			$query = "UPDATE $TABLE_PAY_BILL SET amount='".number_format($bsum, 2, ".", "")."', payer_ooo_id='$boooid', payer_addr_id='$baddrid', aktstatus='".addslashes($baktstat)."' WHERE id='$billid'";
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
					
					// 
					include "../uhlibs/unisend/inc/unisender-init.php";
					
					$buyerinf = Torg_BuyerInfo($LangId, $billinf['buyer_id']);
					
					///////////////////////////////////////////////////////////////////
					// Send mail through unisender
					$body_data = array(
						"{FULL_NAME}" => $buyerinf['name'],
						"{REPLENISHMENT_VALUE}" => number_format($billinf['amount'], 2, ".", ""),
						"{CURRENCY}" => "грн",
						"{URL_ADVERTISE}" => $WWWHOST."u/posts",
						"{URL_ADS_LIMIT}" => $WWWHOST."u/posts/limits",
					);
			
					Send_UniSenderMail($buyerinf['login'], $buyerinf['name'], "На ваш баланс зачислены средства", MAIL_TPL_PAYMENT_RECV, $body_data);
					////////////////////////////////////////////////////////////////////
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
<?php
	if( $billinf['ooo_id'] != 0 )
	{
?>
	<tr>
	    <td class="ff">Указанный Плательщик:</td>
	    <td class="fr"><b>
	<?php
		for($i=0; $i<count($bfirms); $i++)
		{
			if( $bfirms[$i]['id'] == $billinf['ooo_id'] )
			{
				echo $BILLING_FIRM_STR[$bfirms[$i]['type']].': '.$bfirms[$i]['name'].'<br>
				Юр.адрес: '.$REGIONS[$bfirms[$i]['obl']].', '.$bfirms[$i]['zip'].' '.$bfirms[$i]['city'].', '.$bfirms[$i]['address'].'<br>
				ИНН: '.$bfirms[$i]['ipn'].'<br>
				ОКПО: '.$bfirms[$i]['kod'];
			}
		}		
	?>
		</b></td>
	</tr>	
<?php
	}
?>
    <tr>
	    <td class="ff">Задать Плательщика:</td>
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
	    <td class="ff">Указанный адрес отправки док.:</td>
	    <td class="fr">
	<?php
		for($i=0; $i<count($baddrs); $i++)
		{
			echo ( $baddrs[$i]['id'] == $billinf['addr_id'] ? '<b>'.$REGIONS[$baddrs[$i]['obl']].', '.$baddrs[$i]['zip'].' '.$baddrs[$i]['city'].', '.$baddrs[$i]['address'].'</b>' : '' );
		}
	?>
		</td>
	</tr>
    <tr>
	    <td class="ff">Сменить адрес:</td>
	    <td class="fr"><select name="baddrid">
			<option value="0">--- Адрес не указан ---</option>
	<?php
		for($i=0; $i<count($baddrs); $i++)
		{
			echo '<option value="'.$baddrs[$i]['id'].'"'.( $baddrs[$i]['id'] == $billinf['addr_id'] ? ' selected' : '' ).'>'.$baddrs[$i]['city'].', '.$baddrs[$i]['address'].'</option>';
		}
	?>
		</select></td>
	</tr>		
	<tr>
	    <td class="ff">Комментарии:</td>
	    <td class="fr"><textarea name="bcomment" rows="3" cols="50"><?=$billinf['purpose'];?></textarea></td>
	</tr>
	<tr>
	    <td class="ff">Потребность акта:</td>
	    <td class="fr"><select name="baktstat">
	<?php
		for($i=0; $i<count($BILLING_AKTSTATUS_STR); $i++)
		{
			echo '<option value="'.$i.'"'.( $i == $billinf['aktstatus'] ? ' selected' : '' ).'>'.$BILLING_AKTSTATUS_STR[$i].'</option>';
		}
	?>
		</select></td>
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
    	<td colspan="6" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
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
			<td class="ta_center">'.$BILLING_DOCTYPE_STR[$docs[$i]['type']].'</td>
			<td>'.( $docs[$i]['file'] != "" ? '<a href="'.$WWWHOST.$docs[$i]['file'].'" target="_blank">'.$WWWHOST.$docs[$i]['file'].'</a>' : '' ).'</td>
			<td class="ta_center">'.( $firminf['id'] != 0 ? $firminf['name'] : ' - ').'</td>
			<td class="uctbl-nav">
				'.( false ? '<a href="'.$PHP_SELF.'?action=editbill&billid='.$docs[$i]['id'].'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/edit.gif" width="20" height="20" border="0" alt="Редактировать инф. по счету" /></a>&nbsp;<br />' : '' ).'
				<a href="'.$PHP_SELF.'?action=delbilldoc&billid='.$billid.'&docid='.$docs[$i]['id'].'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/delete.gif" width="20" height="20" border="0" alt="Удалить документ" /></a>&nbsp;<br />
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
	
		<form action="<?=$PHP_SELF;?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="action" value="addbilldoc" />
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
			<tr>
				<td class="ff">Дата загрузки документа:</td>
				<td class="fr"><b><?=date("d.m.Y", time());?></b></td>
			</tr>
			<tr>
				<td class="ff">Тип документа:</td>
				<td class="fr"><select name="doctype">
			<?php
				for($i=0; $i<(count($BILLING_DOCTYPE_STR)-1); $i++)
				{
					echo '<option value="'.$i.'"'.( $i == $doctype ? ' selected' : '' ).'>'.$BILLING_DOCTYPE_STR[$i].'</option>';
				}
			?>
				</select></td>
			</tr>
			<tr>
				<td class="ff">Сумма счета:</td>
				<td class="fr"><input class="field" name="docsum" type="text" value="<?=$billinf['amount'];?>" /></td>
			</tr>	
			<tr>
				<td class="ff">Файл документа (*.doc, *.pdf):</td>
				<td class="fr"><input class="field" name="docfile" type="file"></td>
			</tr>	
			<tr><td class="fr" colspan="2" align="center"><br /><input type="submit" value=" Загрузить Счет/Акт в систему " /><br /></td></tr>	
			</table>
		</td></tr>
		</table>
		</form>
		<br><br>
<?php
	}
	else
	{
?>

    <!-- PART OF PAGE TO DISPLAY USER'S LIST -->
	<h3>Перечень счетов на оплату</h3>

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
		
		&nbsp;&nbsp;&nbsp;&nbsp; Метод <select name="billmeth" onchange="document.forms['bselfrm'].submit();">
    		<option value="0">--- Показать все ---</option>
<?php
		for( $i=1; $i<count($BILLING_PAYMETH_STR); $i++ )
		{
			echo '<option value="'.$i.'"'.($billmeth == $i ? ' selected' : '').'>'.$BILLING_PAYMETH_STR[$i].'</option>';
		}
?>
		</select> 
		&nbsp;&nbsp;&nbsp;&nbsp; Статус <select name="billstat" onchange="document.forms['bselfrm'].submit();">
    		<option value="-2">--- Показать все ---</option>
<?php
		for( $i=0; $i<count($BILLING_STATUS_STR); $i++ )
		{
			echo '<option value="'.($i-1).'"'.($billstat == ($i-1) ? ' selected' : '').'>'.$BILLING_STATUS_STR[$i-1].'</option>';
		}
?>
		</select>
		&nbsp;&nbsp;&nbsp;&nbsp; Статус акта <select name="billaktstat" onchange="document.forms['bselfrm'].submit();">
    		<option value="-1">--- Показать все ---</option>
<?php
		for( $i=0; $i<count($BILLING_AKTSTATUS_STR); $i++ )
		{
			echo '<option value="'.($i).'"'.($billaktstat == $i ? ' selected' : '').'>'.$BILLING_AKTSTATUS_STR[$i].'</option>';
		}
?>
		</select> &nbsp;&nbsp;&nbsp; по ID <input type="text" name="bbillid" value="<?=$bbillid;?>" size="5" />
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
	
	if( $billmeth > 0 )
		$sel_cond .= ($sel_cond != "" ? " AND " : "")." b1.paymeth_type='".intval($billmeth)."' ";
	if( $billstat > -2 )
		$sel_cond .= ($sel_cond != "" ? " AND " : "")." b1.status='".intval($billstat)."' ";
	if( $billaktstat > -1 )
		$sel_cond .= ($sel_cond != "" ? " AND " : "")." b1.aktstatus='".intval($billaktstat)."' ";
	if( $bbillid > 0 )
		$sel_cond .= ($sel_cond != "" ? " AND " : "")." b1.id='".intval($bbillid)."' ";		
	
	$its_num = 0;
	$query = "SELECT count(*) as totu FROM $TABLE_PAY_BILL b1 ".( $sel_cond != "" ? " WHERE $sel_cond " : "" );
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$its_num = $row->totu;
		}
		mysqli_free_result( $res );
	}
	
	$its = Buyer_BillList($LangId, 0, $pi, $pn, $sortby, "withbuyer", $sel_cond);

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
		<th>№</th>
		<th>Дата</th>		
		<th>Логин</th>
		<th>Пользователь</th>
		<th>Метод</th>
		<th>Физ./Юр.</th>
		<th>№ док.</th>
		<th>Статус</th>
		'.( false ? '<th>Назначение</th>' : '' ).'
		<th>Сумма</th>
		<th>Акт</th>
		<th>Плательщик</th>
		<th>Действия</th>
	</tr>
	<tr>
    	<td colspan="12" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>';
	
	for( $i=0; $i<count($its); $i++ )
	{
		$firminf = Buyer_BillFirmInfo($LangId, $its[$i]['ooo_id'], $its[$i]['buyer_id']);
		
		$alldoclist = Buyer_BillDocList($LangId, $its[$i]['buyer_id'], $its[$i]['id'], 0);//, $BILLING_DOCTYPE_BILL);
		$doclist = Array();
		$aktlist = Array();
		for( $j=0; $j<count($alldoclist); $j++ )
		{
			if( $alldoclist[$j]['type'] == $BILLING_DOCTYPE_BILL )
			{
				$doclist[] = $alldoclist[$j];
			}
			else if( $alldoclist[$j]['type'] == $BILLING_DOCTYPE_AKT )
			{
				$aktlist[] = $alldoclist[$j];
			}
		}
		
		$billlnk = '';
		if( count($doclist)>0 )
		{
			for($ij=0; $ij<count($doclist); $ij++)
			{
				$billlnk .= ($billlnk != "" ? "<br>" : "").'<a href="'.$WWWHOST.$doclist[$ij]['file'].'" target="_blank">Счет №'.$doclist[$ij]['bill_id'].'</a>';
			}
		}
		
		$aktlnk = $BILLING_AKTSTATUS_STR[$its[$i]['aktstatus']];		
		if( count($aktlist)>0 )
		{
			for($ij=0; $ij<count($aktlist); $ij++)
			{
				$aktlnk .= ($aktlnk != "" ? "<br>" : "").'<a href="'.$WWWHOST.$aktlist[$ij]['file'].'" target="_blank">Акт для №'.$aktlist[$ij]['bill_id'].'</a>';
			}
		}
				
		echo '<tr>
			<td>'.$its[$i]['id'].'</td>
			<td class="uctbl-dttm">
				<span class="uctbl-dt">'.$its[$i]['add'].'</span>
			</td>								
			<td>'.$its[$i]['b_login'].'</td>
			<td><b>'.$its[$i]['b_orgname'].'</b><br>'.$its[$i]['b_name'].'</td>
			<td class="ta_center">'.$BILLING_PAYMETH_STR[$its[$i]['pay_meth']].'</td>
			<td class="ta_center">'.$BILLING_FIRM_STR[$its[$i]['orgtype']].'</td>
			<td class="ta_center">'.( $billlnk != "" ? $billlnk : ' &nbsp; ').'</td>
			<td class="ta_center"'.($BILLING_STATUS_NEW == $its[$i]['status'] ? ' style="color: red;"' : '').'>'.$BILLING_STATUS_STR[$its[$i]['status']].'</td>
			'.( false ? '<td class="ta_center">'.$its[$i]['purpose'].'</td>' : '' ).'
			<td class="ta_center">'.$its[$i]['amount'].'</td>					
			<td class="ta_center">'.( $aktlnk != "" ? $aktlnk : ' &nbsp; ').'</td>
			<td class="ta_center">'.( $firminf['id'] != 0 ? $firminf['name'] : ' - ').'</td>
			<td class="uctbl-nav">
				<a href="'.$PHP_SELF.'?action=editbill&billid='.$its[$i]['id'].'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/edit.gif" width="20" height="20" border="0" alt="Редактировать инф. по счету" /></a>&nbsp;<br />
			</td>
		</tr>
		<tr>
			<td colspan="12" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
		</tr>';
	}

	if( count($its) == 0 )
	{
		echo '<tr>
				<td class="ta_center" colspan="12"><p class="mtinfo_p">Еще не сделали ни одной операции</p></td>
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
