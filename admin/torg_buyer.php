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

	$PAGE_HEADER['ru'] = "Управление Трейдерами";
	$PAGE_HEADER['en'] = "User Management";	

	/////////////////////////////////////////////////////////////////
	$mode = "";
	$action = GetParameter("action", "");
	$uid = GetParameter("uid", "");

	$oblid = GetParameter("oblid", 0);

	$fltmail = trim(strip_tags(GetParameter("fltmail", ""), ""));
	$flttel = trim(strip_tags(GetParameter("flttel", ""), ""));
	$fltname = trim(strip_tags(GetParameter("fltname", ""), ""));
	$fltid = trim(strip_tags(GetParameter("fltid", 0), ""));
	$fltip  = trim(strip_tags(GetParameter("fltip", ""), ""));
	
	$fltadv1 = trim(strip_tags(GetParameter("fltadv1", ""), ""));
	$fltadv2 = trim(strip_tags(GetParameter("fltadv2", ""), ""));
	
	$fltadv1 = intval($fltadv1);
	$fltadv2 = intval($fltadv2);

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 100);
	
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
	$uprof['avail_advs'] = GetParameter("availadv", 0);	
	//$uprof['groupid'] = GetParameter("userlevel", "0");
	//$uprof['usertrader'] = GetParameter("usertrader", 0);

	switch( $action )
	{
		case "unlog":
			$ulogin = GetParameter("ulogin", "");
			
			if(!mysqli_query($upd_link_db,"DELETE FROM $TABLE_TORG_BUYER_AUTH WHERE user_login='".addslashes($ulogin)."' "))
			{
				debugMysql();
			}
			
			break;
			
		case "status":
  			$active = GetParameter("active", 0);
  			$uid = GetParameter("uid", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_TORG_BUYERS SET isactive=".($active == 0 ? 0 : 1)." WHERE id=$uid"))
			{
				debugMysql();
			}
  			break;

		case "deleteUser":
			$userID = GetParameter("userId", 0);

			if($userID){
				$query = "DELETE FROM $TABLE_TORG_BUYERS WHERE id='".$userID."'";
				if(!mysqli_query($upd_link_db, $query)){
					debugMysql();
					echo mysqli_error($upd_link_db);
				}
				//$mode = "edit";
			}
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
			
		case "setnewpass":
			$newpass1 = GetParameter("newpass1", "");
			$newpass2 = GetParameter("newpass2", "");
			
			$mode = "edit";
			
			if( trim($newpass1) == "" )
			{
				$msg = "Пароль не может быть пустым.";
				break;
			}
			else if( trim($newpass1) != trim($newpass2) )
			{
				$msg = "Пароли должны быть одинаковыми.";
				break;
			}
			
			$query = "UPDATE $TABLE_TORG_BUYERS SET passwd='".addslashes($newpass1)."' WHERE id='".$uid."'";
			if( !mysqli_query($upd_link_db,$query) )
			{
				debugMysql();
			}
			
			$msg = "Пароль изменен.";
			
			break;

		case "applynew":
			if( !mysqli_query($upd_link_db,"UPDATE $TABLE_TORG_BUYERS SET max_adv_posts='".$uprof['max_advs']."', avail_adv_posts='".$uprof['avail_advs']."', 
						login='".addslashes($uprof['login'])."', 
						name='".addslashes($uprof['name'])."', orgname='".addslashes($uprof['orgname'])."', address='".addslashes($uprof['address'])."',
						city='".addslashes($uprof['city'])."', isactive_web ='".($_POST['activated'] == 'Да' ? 1 : 0)."',
        				phone='".addslashes($uprof['phone'])."', email='".addslashes($uprof['email'])."', comments='".addslashes($uprof['comments'])."'
        				WHERE id=".$uid." "))
			{
				//echo "<b>".mysqli_error($upd_link_db)."</b>";
				debugMysql();
			}

			$mode = "edit";
			//$uid = $_POST['uid'];
			break;

		case "editprofile":
			$mode = "edit";
			break;
			
		case "editbalance":
			$mode = "editbal";
			break;
			
		case "addpack":
			$mode = "editbal";
			
			$packcomment = GetParameter("packcomment", "");
			$payedpack = GetParameter("payedpack", 0);
			if( $payedpack == 0 )
				break;
			
			$packinf = Pack_Info($payedpack);
			
			$stdt = date("Y-m-d 00:00:01", time());
			$intervalarr = Array(0 => "DAY", 1 => "MONTH", 2 => "YEAR");
			$interval = $intervalarr[$packinf['periodt']];
			
			$query = "INSERT INTO $TABLE_PAYED_PACK_ORDERS (user_id, pack_type, pack_id, add_date, comments, stdt, endt) 
				VALUES ('$uid', '".$packinf['pack_type']."', '$payedpack', NOW(), '".addslashes($packcomment)."', '$stdt', DATE_ADD('$stdt', INTERVAL ".$packinf['period']." ".$interval."))";
			//echo $query."<br>";
			if( !mysqli_query($upd_link_db,$query) )
			{
				debugMysql();
			}	
						
			break;
			
		case "filtitems":						
			$getxlsfile = GetParameter("getxlsfile", "");
			if( $getxlsfile != "" ) 
				$mode = "in_csv";
			break;
	}
	
	
	if( $mode != "in_csv" )
	{
	//
	// Include Top Header HTML Style
	include "inc/header-inc.php";
	//
	}

	if( $mode == "editbal" )
	{
		if( $UserGroup == $GROUP_ADMIN )
		{
			$uprof = User_Info($uid);
			
			echo '<div style="text-align: center; padding: 16px 0;"><a href="'.$PHP_SELF.'">Вернуться к списку пользователей</a> &gt; <a href="'.$PHP_SELF.'?action=editprofile&uid='.$uprof['id'].'">Редактировать &quot;'.$uprof['name'].'&quot;</a></div>
			<br />';
			
			echo '<h3>Перечень заказаных пакетов для &quot;'.$uprof['name'].'&quot;</h3>';
			
			$plist = Buyer_PayedPacks($uprof['id']);
			
			echo '<table cellspacing="0" cellpadding="0" border="0" align="center" width="90%">
			<tr>
				<th>ID</th>
				<th width="30">&nbsp;</th>
				<th>Дата</th>
				<th>Пакет</th>
				<th>Активен</th>
				<th>Оформлен с</th>
				<th>Оформлен до</th>
				<th>Цена</th>
				<th>ID Объяв.</th>
				'.( false ? '<th>Лимит</th>' : '' ).'
				<th width="100">&nbsp;</th>
			</tr>
			<tr>
				<td colspan="10" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
			</tr>
			';
			
			$group_id = -1;
			for($i=0; $i<count($plist); $i++)
			{
				if( $group_id != $plist[$i]['pack_type'] )
				{
					$group_id = $plist[$i]['pack_type'];
					echo '<tr><td colspan="10" style="padding: 14px 0; text-align: center;">'.$BILLING_PACK_STR[$group_id].'</td></tr>';
				}
				
				$postinf = "";
				if( $plist[$i]['post_id'] != 0 )
				{
					$ppinf = Board_PostInfo($LangId, $plist[$i]['post_id']);
					if( $ppinf['id'] != 0 )
					{
						$POSTURL = $WWWHOST.'board/post-'.$ppinf['id'].'.html';
						$postinf = ' - <a href="'.$POSTURL.'" target="_blank">'.$ppinf['title'].'</a>';
					}
					else
					{
						$postinf = " - Объявление не существует";
					}
				}
				
				echo '<tr>
				<td>'.$plist[$i]['id'].'</td>
				<td>&nbsp;</td>
				<td>'.$plist[$i]['dt'].'</td>
				<td>'.$plist[$i]['title'].$postinf.'</td>
				<td>'.( $plist[$i]['nowactive'] == 1 ? '<b style="color: red;">Да</b>' : 'Нет' ).'</td>
				<td>'.$plist[$i]['stdt'].'</td>
				<td>'.$plist[$i]['endt'].'</td>
				<td>'.$plist[$i]['cost'].'</td>
				<td>'.( $plist[$i]['post_id'] != 0 ? $plist[$i]['post_id'] : 0 ).'</td>
				'.( false ? '<td>'.$plist[$i]['adv_num'].'</td>' : '' ).'
				</tr>
				<tr>
					<td colspan="10" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
				</tr>';
			}
			
			if( count($plist) == 0 )
			{
				echo '<tr><td colspan="10" style="text-align: center;">Данный пользователь ни разу не заказывал платные услуги</td></tr>
				<tr>
					<td colspan="10" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
				</tr>';
			}
			
			echo '</table>';
			
			$packs = Pack_List($BILLING_PACK_POSTNUM);
?>
			<br><br>
			<h3>Добавить пакет услуг</h3>
			<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
			<tr><td>
				<table width="100%" cellspacing="1" cellpadding="1" border="0">
			<form action="<?=$PHP_SELF;?>" method="POST">
			<input type="hidden" name="action" value="addpack" />
			<input type="hidden" name="uid" value="<?=$uid;?>" />
			<tr>
				<td class="ff">Пользователь:</td>
				<td class="fr"><b><?=$uprof['name'];?></b></td>
			</tr>
			<tr>
				<td class="ff">Пакет:</td>
				<td class="fr">
		<?php
			for( $i=0; $i<count($packs); $i++ )
			{
				echo '<div><input type="radio" id="payedpack'.$packs[$i]['id'].'" name="payedpack" value="'.$packs[$i]['id'].'"> <label for="payedpack'.$packs[$i]['id'].'">'.$packs[$i]['title'].' ['.$packs[$i]['cost'].' грн. / '.$packs[$i]['period'].' '.$PAYED_PERIOD_TYPE[$packs[$i]['periodt']].']</label></div>';
			}
		?>
				</td>
			</tr>	
			<tr>
				<td class="ff">Комментарии:</td>
				<td class="fr"><textarea name="packcomment" rows="3" cols="50"></textarea></td>
			</tr>
			<tr>
				<td class="fr" colspan="2" align="center"><br /><input type="submit" value=" Добавить пакет " /><br /></td>
			</tr>
			</form>
				</table>
				</td></tr>
			</table>
			<br /><br /><br />
<?php
		}
		
		$sortby = "";
		//$its = Buyer_BillList($LangId, $uid, -1, 100, $sortby);
		
		$buyer_bal = Buyer_Balance($uid);
		
		$total_ops = Buyer_BalanceNumop($uid);
		$its = Buyer_BalanceList($LangId, $uid, $BILLING_PAY_OPER_ALL, $BILLING_PACK_ALL, -1, 200, $sortby, "withdebitop");
	
		echo '<h3>Отчет по операциям по счету</h3>
			<div style="text-align: center;">Текущий баланс: '.$buyer_bal.'</div>
			<br>';
		
		/*а
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
		/*
		echo '<table align="center" class="f12 tbl-dark">
		<tr>
			'.( false ? '<th>№</th>' : '' ).'
			<th>Дата</th>
			<th>Метод</th>
			<th>Физ./Юр.</th>
			<th>Статус</th>				
			<th>Назначение</th>
			<th>Сумма</th>
			<th>Плательщик</th>
			<th>Действия</th>
		</tr>';
		*/
		echo '<table align="center" class="f12 tbl-dark">
		<tr>
			'.( false ? '<th>№</th>' : '' ).'
			<th>Дата</th>
			<th>Операция</th>
			<th>Сумма</th>
			<th>Метод</th>
			<th>Счет</th>							
			<th>Действия</th>
		</tr>';
		
		for( $i=0; $i<count($its); $i++ )
		{
			//$SENDER_COMP_ID = Comp_ItemByUser($LangId, $its[$i]['sender_id']);
			
			$purpose_str = "";
			$method_str = "";
			if( $its[$i]['oper_debkred'] == $BILLING_PAY_OPER_KREDIT )	// Пополнение счета
			{
				$purpose_str = 'Пополнение счета';
				$method_str = $BILLING_PAYMETH_STR[$its[$i]['ktype']];
			}
			else
			{
				$packinf = Array("id" => 0);
				if( $its[$i]['dtype'] != 0 )
				{
					if( isset($packlist[$its[$i]['dtype']]) )
						$packinf = $packlist[$its[$i]['dtype']];
					else
						$packinf = $packlist[$its[$i]['dtype']] = Pack_Info($its[$i]['dtype']);
					
					if( $packinf['id'] != 0 )
					{
						$purpose_str = $packinf['title'];
					}						
				}	

				if( $its[$i]['o_post_id'] != 0 )
				{
					$POSTURL = $WWWHOST.'board/post-'.$its[$i]['o_post_id'].'.html';
					$purpose_str .= ' - <a href="'.$POSTURL.'" target="_blank">'.$its[$i]['p_title'].'</a>';
				}
			}
			
			echo '<tr>
				'.( false ? '<td>'.($i+1).'</td>' : '' ).'
				<td class="uctbl-dttm">
					<span class="uctbl-dt">'.$its[$i]['add'].'</span>
				</td>					
				'.( false ? '<td class="ta_center">'.$BILLING_PAYMETH_STR[$its[$i]['pay_meth']].'</td>
				<td class="ta_center">'.$BILLING_FIRM_STR[$its[$i]['orgtype']].'</td>
				<td class="ta_center">'.$BILLING_STATUS_STR[$its[$i]['status']].'</td>' : '' ).'
				<td class="ta_center">'.$purpose_str.'</td>
				<td class="ta_center">'.$its[$i]['amount'].'</td>
				<td class="ta_center">'.$method_str.'</td>				
				<td class="ta_center">'.( ($its[$i]['bill_id'] != 0) && ($its[$i]['ktype'] == $BILLING_PAYMETH_BILL) ? 'Счет №'.$its[$i]['bill_id'] : ' - ' ).'</td>
				<td class="uctbl-nav"></td>
			</tr>';
			
			/*
			$firminf = Buyer_BillFirmInfo($LangId, $its[$i]['ooo_id'], $UserId);
					
			echo '<tr>
				'.( false ? '<td>'.($i+1).'</td>' : '' ).'
				<td class="uctbl-dttm">
					<span class="uctbl-dt">'.$its[$i]['add'].'</span>
				</td>					
				<td class="ta_center">'.$BILLING_PAYMETH_STR[$its[$i]['pay_meth']].'</td>
				<td class="ta_center">'.$BILLING_FIRM_STR[$its[$i]['orgtype']].'</td>
				<td class="ta_center">'.$BILLING_STATUS_STR[$its[$i]['status']].'</td>
				<td class="ta_center">'.$its[$i]['purpose'].'</td>
				<td class="ta_center">'.$its[$i]['amount'].'</td>					
				<td class="ta_center">'.( $firminf['id'] != 0 ? $firminf['name'] : ' - ').'</td>
				<td class="uctbl-nav">'.( false ? 
					'<a class="a-del" href="'.$PHP_SELF.'?action=decline&itemid='.$its[$i]['id'].'&viewdir=1" title="Отклонить" onclick="return confirm(\'Действительно отклонить запрос?\')">Отклонить</a><br />
					<a class="a-up" href="'.$PHP_SELF.'?action=approve&itemid='.$its[$i]['id'].'&viewdir=1" title="Принять">Принять</a><br />' : 
					( ($its[$i]['pay_meth'] == $BILLING_PAYMETH_BILL) && false ? '<a href="bcab_addfund.php?action=viewbill&billid='.$its[$i]['id'].'" target="_blank">Счет</a>' : '')
				).'</td>
			</tr>';
			
			*/
		}
	
		if( count($its) == 0 )
		{
			echo '<tr>
					<td class="ta_center" colspan="8"><p class="mtinfo_p">Вы еще не сделали ни одной операции</p></td>
				</tr>';
		}
		echo '</table>';				
						
		
	}
	else if( $mode == "edit" )
	{
		//if( $UserGroup != $GROUP_ADMIN )
		//{
		//	break;
		//}

		$query = "SELECT u.* FROM $TABLE_TORG_BUYERS u WHERE u.id='".$uid."' ";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			if( $row = mysqli_fetch_object($res) )
			{
				$uprof['name'] = stripslashes($row->name);
				$uprof['passwd']=stripslashes($row->passwd);
				$uprof['orgname'] = stripslashes($row->orgname);
				$uprof['login'] = stripslashes($row->login);
				$uprof['city'] = stripslashes($row->city);
				$uprof['isactive_web'] = stripslashes($row->isactive_web);
				//$uprof['country'] = stripslashes($row->country);
				$uprof['address'] = stripslashes($row->address);
				$uprof['phone'] = stripslashes($row->phone);
				$uprof['phone2'] = stripslashes($row->phone2);
				$uprof['phone3'] = stripslashes($row->phone3);
				
				$uprof['email'] = stripslashes($row->email);
				$uprof['avail_advs'] = stripslashes($row->avail_adv_posts);
				$uprof['max_advs'] = stripslashes($row->max_adv_posts);
				//$uprof['web_url'] = stripslashes($row->web_url);
				$uprof['comments'] = stripslashes($row->comments);
				
				$uprof['conflimit'] = Buyer_LoadLimits($row->id);
				
				$uprof['adv_cur'] = Board_PostsNumByAuthor( $row->id, "", -1 );
				$uprof['adv_cur_act'] = Board_PostsNumByAuthor( $row->id, "", -1, 1 );	
				$uprof['adv_max'] = $uprof['conflimit']['max_post'];
				
			}
			mysqli_free_result($res);
		}

?>
	<div style="text-align: center; padding: 16px 0;"><a href="<?=$PHP_SELF;?>">Вернуться к списку пользователей</a></div>
	<br />
	
	<?php
		if( $msg != "" )
		{
			echo '<div style="color: red; font-weight: bold; padding: 20px; text-align: center;">'.$msg.'</div>';
		}
	?>

	<h3><?=($action == "editprofile" ? $strings['editprof'][$lang] : $strings['newprof'][$lang]);?></h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="applynew" />
	<input type="hidden" name="uid" value="<?=$uid;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<tr>
	    <td class="ff"><?=$fields['login'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="login" size="60" type="text" value="<?=$uprof['login'];?>" /></td>
	</tr>


	<tr>
	    <td class="ff"><?=$fields['passwd'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="passwd" size="60" type="text" value="<?=$uprof['passwd'];?>" /></td>
	</tr>



	<tr>
	    <td class="ff"><?=$fields['name'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="fullname" size="60" type="text" value="<?=$uprof['name'];?>" /></td>
	</tr>
	<tr>
	    <td class="ff">Организация:</td>
	    <td class="fr"><input class="field" name="orgname" size="60" type="text" value="<?=$uprof['orgname'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['address'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="address" size="70" type="text" value="<?=$uprof['address'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['city'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="orgcity" type="text" value="<?=$uprof['city'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['telephone'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="phone" type="text" value="<?=$uprof['phone'];?>" /></td>
	</tr>



   <tr>
	    <td class="ff"><?=$fields['telephone2'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="phone2" type="text" value="<?=$uprof['phone2'];?>" /></td>
	</tr>
   <tr>
	    <td class="ff"><?=$fields['telephone3'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="phone3" type="text" value="<?=$uprof['phone3'];?>" /></td>
	</tr>





    <tr>
	    <td class="ff"><?=$fields['email1'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="email" type="text" value="<?=$uprof['email'];?>" /></td>
	</tr>
    <tr>
	    <td class="ff"><?=$fields['web_url'][$lang];?>:</td>
	    <td class="fr"><input class="field" name="weburl" type="text" value="<?=$uprof['web_url'];?>" /></td>
	</tr>
	<tr>
	    <td class="ff">Сейчас доступно бесплатно объявл.:</td>
	    <td class="fr"><input class="field" name="availadv" type="text" value="<?=$uprof['avail_advs'];?>" /></td>
	</tr>
	<tr>
	    <td class="ff">Максимальное кол-во объявл.:</td>
	    <td class="fr"><input class="field" name="maxadv" type="text" value="<?=$uprof['max_advs'];?>" /></td>
	</tr>
	<tr>
	    <td class="ff">Текущее кол-во объявлений:</td>
	    <td class="fr"><b><?=$uprof['adv_cur'];?></b></td>
	</tr>
	<tr>
	    <td class="ff">Текущее кол-во активных объяв.:</td>
	    <td class="fr"><b><?=$uprof['adv_cur_act'];?></b></td>
	</tr>
	<tr>
	    <td class="ff">Доступно к размещению объявлений:</td>
	    <td class="fr"><b><?=$uprof['adv_max'];?></b></td>
	</tr>
	<tr>
	    <td class="ff">Активированный E-Mail</td>
	    <td class="fr"><select name="activated"> <option><?=($uprof['isactive_web'] ? 'Да' : 'Нет');?></option><option><?=($uprof['isactive_web'] ? 'Нет' : 'Да');?></td>
	</tr>
	<tr>
	    <td class="ff">Комментарии:</td>
	    <td class="fr"><textarea name="comment" rows="3" cols="50"><?=$uprof['comments'];?></textarea></td>
	</tr>
	<tr>
	      <td class="fr" colspan="2" align="center"><br /><input type="submit" value=" <?=$strings['applybtn'][$lang];?> " /><br /></td>
	</tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br /><br />
		
	<h3>Установить новый пароль</h3>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
	<form action="<?=$PHP_SELF;?>" method="POST">
	<input type="hidden" name="action" value="setnewpass" />
	<input type="hidden" name="uid" value="<?=$uid;?>" />
	<input type="hidden" name="oblid" value="<?=$oblid;?>" />
    <input type="hidden" name="pn" value="<?=$pn;?>" />
    <input type="hidden" name="fltmail" value="<?=$fltmail;?>" />
    <input type="hidden" name="flttel" value="<?=$flttel;?>" />
    <input type="hidden" name="fltname" value="<?=$fltname;?>" />
    <input type="hidden" name="fltid" value="<?=$fltid;?>" />
	<tr>
	    <td class="ff">Пароль:</td>
	    <td class="fr"><input class="field" name="newpass1" size="30" type="text" value="" /></td>
	</tr>
	<tr>
	    <td class="ff">Повторить пароль:</td>
	    <td class="fr"><input class="field" name="newpass2" size="30" type="text" value="" /></td>
	</tr>	
	<tr>
		<td class="fr" colspan="2" align="center"><br /><input type="submit" value=" Применить новый пароль " /><br /></td>
	</tr>
	</form>
		</table>
		</td></tr>
	</table>
	<br /><br />
	<br />
	<div style="text-align: center; padding: 16px 0;"><a href="<?=$PHP_SELF;?>?action=editbalance&uid=<?=$uid;?>">Посмотреть услуги и баланс по пользователю</a></div>
	<br><br>
<?php
	}
	else
	{
		if( $mode == "in_csv" )
		{
			// don't show
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
		&nbsp;&nbsp;&nbsp; по IP <input type="text" name="fltip" value="<?=$fltip;?>" />
		&nbsp;&nbsp;&nbsp; Объявл. от <input type="text" name="fltadv1" value="<?=$fltadv1;?>" size="2" /> до <input type="text" name="fltadv2" value="<?=$fltadv2;?>" size="2" />
		<input type="submit" value="Применить" />
    </div>	
    </form>
	<form action="<?=$PHP_SELF;?>" name="fselcsv" method="POST" target="_blank">
		<input type="hidden" name="action" value="filtitems">
		<input type="hidden" name="oblid" value="<?=$oblid;?>">
		<input type="hidden" name="fltmail" value="<?=$fltmail;?>">
		<input type="hidden" name="flttel" value="<?=$flttel;?>">
		<input type="hidden" name="fltname" value="<?=$fltname;?>">
		<input type="hidden" name="fltid" value="<?=$fltid;?>" size="5">
		<input type="hidden" name="fltip" value="<?=$fltip;?>">
		<input type="hidden" name="fltadv1" value="<?=$fltadv1;?>">
		<input type="hidden" name="fltadv2" value="<?=$fltadv2;?>">
		<div class="padding: 1px 0px 10px 10px;">Выгрузить в виде *.CSV - <input type="submit" name="getxlsfile" value="Выгрузить в CSV"></div>
	</form>

    <table cellspacing="0" cellpadding="0" border="0" align="center" width="90%">
    <tr>
    	<th>ID</th>
    	<th width="30">&nbsp;</th>
    	<th><?=$strings['rowlogin'][$lang];?></th>
    	<th>Дата регистрации</th>
		<th>Активация</th>
		<th>Телефон</th>
		<th>Баланс</th>
    	<th><?=$strings['rowname'][$lang];?></th>
    	<!--<th><?=$strings['rowaddr'][$lang];?></th>-->
    	<th><?=$strings['rowcontact'][$lang];?></th>
		<th>Пакеты</th>
		<th>Объявл.</th>		
		<!--<th>IP</th>-->
    	<th>Бан</th>
		<!--<th>Бан типы</th>
    	<th>Макс. об.</th>-->
    	<th width="100">&nbsp;</th>
    </tr>
    <tr>
    	<td colspan="12" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>
    <?php
		}
	
    	$sel_cond = "";
		$join_cond = "";

		$limit_cond = "";
		if( $mode != "in_csv" )
		{
			if( $pi > 0 )
			{
				$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
			}
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
		
		if( $fltip != "" )
			$sel_cond .= " AND b1.last_ip='".addslashes($fltip)."' ";

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

		$having_cond = "";
		$join_cond = " LEFT JOIN $TABLE_ADV_POST p1 ON b1.id=p1.author_id ";
		if( ($fltadv1 >= 0) && ($fltadv2 > 0) )
		{
			$join_cond = " INNER JOIN $TABLE_ADV_POST p1 ON b1.id=p1.author_id ";
			$having_cond = " HAVING totpostnum>=$fltadv1 AND totpostnum<=$fltadv2 ";
		}		
		
		$csv = '"id";"login";"active";"orgname";"name";"region";"IP";"phone";"email";"packs_act";"packs_all";"advs";"ban";
';

		/*
    	$query = "SELECT b1.*, r2.name as rayon, count(p1.id) as totpostnum 
		FROM $TABLE_TORG_BUYERS b1
    	LEFT JOIN $TABLE_RAYON r1 ON b1.ray_id=r1.id
    	LEFT JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		$join_cond 
    	$sel_cond
		GROUP BY b1.id 
		$having_cond 
    	ORDER BY b1.id DESC
    	$limit_cond";
		*/
		$query = "SELECT b1.*, count(p1.id) as totpostnum, round(coalesce(sum(b2.amount), 0)) as balance 
		FROM $TABLE_TORG_BUYERS b1
    	LEFT JOIN $TABLE_PAY_BALANCE_OPER b2 ON b1.id = b2.buyer_id
		$join_cond 
    	$sel_cond 
		GROUP BY b1.id 
		$having_cond 
    	ORDER BY b1.id DESC
    	$limit_cond";
		//echo $query."<br>";
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
				
				$ban_num_ip = Torg_BuyerBanCount($LangId, $row->id, true);
				$ban_num_ses = Torg_BuyerBanCount($LangId, $row->id, false, true);
				
                $ban_now = Torg_BuyerIsBan($LangId, $row->id);
				
				$packtypearr = Array($BILLING_PACK_POSTUP, $BILLING_PACK_POSTCOLOR, $BILLING_PACK_POSTNUM);
				
				$payed_pack_total = Buyer_PayedPacksNum($row->id, $packtypearr);
				$payed_pack_act = Buyer_PayedPacksNum($row->id, $packtypearr, "onlyactive");

                $rayname = "";
                if( $row->rayon != null )
                {
					$rayname = stripslashes($row->rayon)." район";
                }
			 //         $query = "SELECT round(coalesce(sum(amount), 0)) as balance from $TABLE_PAY_BALANCE_OPER where buyer_id = ";
				// if($res_b = mysqli_query($upd_link_db, $query)){
				// 	if($row_b = mysqli_fetch_object($res)){
				// 		$row->balance = $row_b->balance;
				// 	}
				// 	mysqli_free_result($res);
				// }else{
				// 	mysqli_error($res);
				// }
				if( $mode == "in_csv" )
				{
					// don't show
					$csv .= '"'.$row->id.'";"'.stripslashes($row->login).'";"'.(($row->isactive_web == 0) ? 'НЕТ':'ДА').'";"'.str_replace("\"", "", stripslashes($row->orgname)).'";"'.str_replace("\"", "", stripslashes($row->name)).'";"'.$REGIONS[$row->obl_id].', '.$user_city.'";"'.$row->last_ip.'";"'.stripslashes($row->phone).'";"'.( (($row->email != NULL) && ($row->email != "")) ? stripslashes($row->email) : '' ).'";"'.$payed_pack_act.'";"'.$payed_pack_total.'";"'.$row->totpostnum.'";"'.( ($ban_num_ip > 0 ? "Бан по IP" : "").($ban_num_ses > 0 ? "Бан по SES" : "") ).'";
';
				}
				else
				{

            	echo "<tr>
            			<td>".$row->id."</td>
            			<td><img src=\"img/user_".(($row->isactive == 0) ? "disable" : "enable").".gif\" width=\"30\" height=\"36\" border=\"0\" alt=\"\" /></td>
            			<td>".stripslashes($row->login)."<br /></td>
            			<td>".$row->add_date."<br /></td>
						<td style=\"text-align:center\">".(($row->isactive_web == 0)? '<b style="color:red;">НЕТ</b>':'<b style="color:green;">ДА</b>')."<br></td>
						<td style=\"text-align:center\">".(($row->smschecked == 0)? '<b style="color:red;">НЕТ</b>':'<b style="color:green;">ДА</b>')."<br></td>
						<td>".$row->balance."<br /></td>
            			<td><b>".stripslashes($row->orgname)."</b><br />".stripslashes($row->name)."<br>".$REGIONS[$row->obl_id].", ".$user_city."</td>
            			".( false ? "<td>".$REGIONS[$row->obl_id]."<br />".$user_city.", ".stripslashes($row->address)."</td>" : "" )."
            			<td>".$row->last_ip."<br>".$fields['telephone'][$lang].": ".stripslashes($row->phone)."<br />";
						if( ($row->email != NULL) && ($row->email != "") )
            				echo "E-Mail: <a href=\"mailto:".stripslashes($row->email)."\">".stripslashes($row->email)."</a><br />";
            	echo "</td>
				<td style=\"text-align:center;\"><a href=\"".$PHP_SELF."?action=editbalance&uid=".$row->id."\" target=\"_blank\">".$payed_pack_act." / ".$payed_pack_total."</a></td>
				<td style=\"text-align:center;\"><a href=\"board.php?authorid=".$row->id."\" target=\"_blank\">".$row->totpostnum."</a></td>				
				".( false ? "<td style=\"text-align:center;\">".$row->last_ip."</td>" : "" )."
            	<td>".($ban_now['id'] != 0 ?
            		'<a href="torg_buyer_ban.php?action=editprofile&uid='.$row->id.'" target="_blank"><span style="font-weight: bold; color: red;">'.$ban_num.'</span></a>' :
            		'<a href="torg_buyer_ban.php?action=editprofile&uid='.$row->id.'" target="_blank">'.$ban_num.'</a>')."</td>
				".( false ? "<td>
					".($ban_num_ip > 0 ? "Бан по IP<br>" : "")."
					".($ban_num_ses > 0 ? "Бан по SES<br>" : "")."
				</td>
            	<td>".$row->max_adv_posts."</td>" : "" )."
            	<td>";

				// Display this link only for users who are not in MANAGERS group
				echo "<br />";
				//echo "<a href=\"$PHP_SELF?action=delete&uid=".$row->id."\" class=\"blink\"><img src=\"img/delete.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"".$strings['tipdeluser'][$lang]."\" /></a>&nbsp;";
				echo '<a href="'.$PHP_SELF.'?action=status&active='.(($row->isactive == 1) ? 0 : 1).'&uid='.$row->id.'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/refresh.gif" width="20" height="20" border="0" alt="'.$strings['tipstatus'][$lang].'" /></a>&nbsp;';

				//if( $UserGroup == $GROUP_ADMIN )
				echo '<a href="'.$PHP_SELF.'?action=editprofile&uid='.$row->id.'&oblid='.$oblid.'&pi='.$pi.'&pn='.$pn.'&fltmail='.$fltmail.'&flttel='.$flttel.'&fltname='.$fltname.'&fltid='.$fltid.'" class="blink"><img src="img/edit.gif" width="20" height="20" border="0" alt="'.$strings['tipedituser'][$lang].'" /></a>&nbsp;
				<!-- <br />
			
				<a href="'.$PHP_SELF.'?action=unlog&ulogin='.stripslashes($row->login).'">Разлогинить</a> -->
				
				<br>';
				echo "<a href=\"".$WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($row->login)."&buyerpass=".stripslashes($row->passwd)."\" target=\"_blank\">Залогиниться</a>";
            	?></td>
            		<td>
            			<form action="<?=$PHP_SELF;?>" method="POST">
		<input type="hidden" name="action" value="deleteUser">
		<input type="hidden" name="userId" value="<?=$row->id;?>">
					<button>Удалить</button>
					</form>
					</td>
				</tr>
				
				<?php
				echo "
				<tr>
					<td colspan=\"12\" bgcolor=\"#DDDDDD\"><img src=\"img/spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td>

				</tr>";
				
				}
            }
        	mysqli_free_result($res);
        }
		
		if( $mode == "in_csv" )
		{
			// export csv
			header("Content-Type: text/csv; name=\"allbuyers".time().".csv\";");
			header("Content-Disposition: attachment; filename=\"allbuyers".time().".csv\";");

			//echo iconv("cp1251", "UTF-8", $xml);
			echo $csv;
		}
		else
		{
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
	}

	if( $mode == "in_csv" )
	{
		// don't show
	}
	else
		include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
