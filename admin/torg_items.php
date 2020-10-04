<?php
	include "../inc/db-inc.php";
	include "../inc/connect-inc.php";

	include "../inc/utils-inc.php";
	include "../inc/countryutils-inc.php";

	include "../inc/ses-inc.php";

	include "../inc/torgutils-inc.php";

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

	$PAGE_HEADER['ru'] = "Просмотр Торгов";
	$PAGE_HEADER['en'] = "Tender Management";

	// Include Top Header HTML Style
	include "inc/header-inc.php";

	$mode = "";
	$action = GetParameter("action", "");

	$pi = GetParameter("pi", 1);
	$pn = GetParameter("pn", 50);

	$uid = GetParameter("uid", "");
	$oblid = GetParameter("oblid", 0);
	$typeid = GetParameter("typeid", 0);

	$stat = GetParameter("stat", -1);
	$sortby = GetParameter("sortby", "lotid");
	$sortdir = GetParameter("sortdir", "down");

	$uprof = Array();

	$uprof['name'] = GetParameter("fullname", "");
	$uprof['passwd'] = GetParameter("passwd", "");
	$uprof['login'] = GetParameter("login", "");
	$uprof['address'] = GetParameter("address", "");
	$uprof['city_id'] = GetParameter("city_id", 0);
	$uprof['country'] = GetParameter("country", "");
	$uprof['zip_code'] = GetParameter("zip", "");
	$uprof['telephone'] = GetParameter("phone1", "");
	$uprof['office_phone'] = GetParameter("phone2", "");
	$uprof['cell_phone'] = GetParameter("phone3", "");
	$uprof['email1'] = GetParameter("email1", "");
	$uprof['email2'] = GetParameter("email2", "");
	$uprof['email3'] = GetParameter("email3", "");
	$uprof['web_url'] = GetParameter("weburl", "");
	$uprof['groupid'] = GetParameter("userlevel", "0");
	$uprof['usertrader'] = GetParameter("usertrader", 0);

	$msg = "";

	switch( $action )
	{
		case "edititem":
			$itemid = GetParameter("itemid", 0);
			if( $itemid != 0 )
				$mode = "edit";
			break;

		case "status":
  			$active = GetParameter("active", 0);
  			$itemid = GetParameter("itemid", 0);

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_TORG_ITEMS SET active=".($active == 0 ? 0 : 1)." WHERE id='$itemid'"))
			{
				echo mysqli_error($upd_link_db);
			}
  			break;

		case "delete":
			$itemid = GetParameter("itemid", 0);
			// Delete params
			$query = "SELECT * FROM $TABLE_TORG_PARAM_VALUES WHERE item_id='$itemid'";
            if( $res = mysqli_query($upd_link_db, $query ) )
            {
                while( $row = mysqli_fetch_object($res) )
                {
                    if( !mysqli_query($upd_link_db, "DELETE FROM $TABLE_TORG_PARAM_VALUES_OPTS WHERE param_value_id='".$row->id."'" ) )
                    {
                       echo mysqli_error($upd_link_db);
                    }
                }
                mysqli_free_result($res);
            }

			$query = "DELETE FROM $TABLE_TORG_PARAM_VALUES WHERE item_id='$itemid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
			   echo mysqli_error($upd_link_db);
			}

            $query = "DELETE FROM $TABLE_TORG_ITEMS_LANGS WHERE item_id='$itemid'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

			$query = "DELETE FROM $TABLE_TORG_ITEMS WHERE id='$itemid'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

            $query = "DELETE FROM $TABLE_TORG_BIDS WHERE item_id='$itemid'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }

            $query = "DELETE FROM $TABLE_TORG_ITEM2ELEV WHERE item_id='$itemid'";
            if( !mysqli_query($upd_link_db, $query ) )
            {
               echo mysqli_error($upd_link_db);
            }
  			break;

  		case "update":
  			$itemid = GetParameter("itemid", 0);
			$newscont = GetParameter("newscont", "", false);

			$newsamount = GetParameter("newsamount", "");
			$newscost = GetParameter("newscost", "0.00");
			$newscostst = GetParameter("newscostst", "0.00");

			$datest = GetParameter("datest", "");
			$dateen = GetParameter("dateen", "");

			$newsobl = GetParameter("newsobl", 0);
			$newstype = GetParameter("newstype", 0);
			$newsstatus = GetParameter("newsstatus", 0);
			$newscult = GetParameter("newscult", 0);

			$query = "UPDATE $TABLE_TORG_ITEMS SET profile_id='$newscult', torg_type='$newstype', status='$newsstatus', amount='$newsamount', cost='$newscost', cost_start='$newscostst' WHERE id='$itemid'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

			$query = "UPDATE $TABLE_TORG_ITEMS_LANGS SET descr='".addslashes($newscont)."' WHERE item_id='$itemid' AND lang_id='$LangId'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}
  			break;
  	}

  	if( $mode == "edit" )
  	{
  		$cult_list = Torg_CultList($LangId);

		$CUR_TORG = Array();
		$query = "SELECT t1.*, DATE_FORMAT(dt_start, '%d.%m.%Y') as dtst, DATE_FORMAT(dt_end, '%d.%m.%Y') as dten, b1.name, b1.name, b1.orgname, b1.city, b1.phone, b1.email, t2.descr
			FROM $TABLE_TORG_ITEMS t1
			INNER JOIN $TABLE_TORG_BUYERS b1 ON t1.publisher_id=b1.id
			INNER JOIN $TABLE_TORG_ITEMS_LANGS t2 ON t1.id=t2.item_id AND t2.lang_id='$LangId'
			WHERE t1.id='$itemid'";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			if( $row = mysqli_fetch_object( $res ) )
			{
				$CUR_TORG['id'] = $row->id;
				$CUR_TORG['cult_id'] = $row->profile_id;
				$CUR_TORG['amount'] = $row->amount;
				$CUR_TORG['cost'] = $row->cost;
				$CUR_TORG['cost_start'] = $row->cost_start;
				$CUR_TORG['torg_type'] = $row->torg_type;
				$CUR_TORG['publisher_id'] = $row->publisher_id;
				$CUR_TORG['status'] = $row->status;
				$CUR_TORG['dtst'] = $row->dtst;
				$CUR_TORG['dten'] = $row->dten;

				$CUR_TORG['buyer_id'] = $row->publisher_id;
				$CUR_TORG['buyer_name'] = stripslashes($row->name);
				$CUR_TORG['buyer_org'] = stripslashes($row->orgname);
				$CUR_TORG['buyer_city'] = stripslashes($row->city);
				$CUR_TORG['buyer_phone'] = stripslashes($row->phone);
				$CUR_TORG['buyer_email'] = stripslashes($row->email);

				$CUR_TORG['descr'] = stripslashes($row->descr);

				// Get current best price proposal for this lot
				//$CUR_TORG['costbest'] = TorgItem_BidMinMax( $LangId, $row->id, ($row->torg_type == $TORG_BUY ? "min" : "max") );
				//if( $bidcost == 0 )
				//{
				//	$bidcost = ( $CUR_TORG['costbest'] != 0 ? $CUR_TORG['costbest'] : $CUR_TORG['cost'] );
				//}

				$CUR_TORG['costbest'] = TorgItem_BidMinMax( $LangId, $CUR_TORG['id'], ($CUR_TORG['torg_type'] == $TORG_BUY ? "min" : "max") );

				// Get list of all bids
				$bids = TorgItem_Bids( $LangId, $CUR_TORG['id'] );

				// Find current buyer proposal
				$mybid_id = 0;
				//$mybid_cost = 0;
				//$mybid_amount = 0;
				$mybid_win = 0;	// 1 - full win, with whole amount, 2 - win with part of amount
				$mybid_winamount = 0;
				$mybid_win_id = 0;
				$mybid_win_cost = 0;

				$winbid_cost_max = 0;
				$winbid_cost_min = 1000000;
				$winbid_cost_max_notmy = 0;
				$winbid_cost_min_notmy = 1000000;

				// Find different buyer indexes
				//$buyerindex = Array();
				//$bindex = 0;
				for( $i=0; $i<count($bids); $i++ )
				{
					// Check if there is bid from this buyer earlier
					//if( empty($buyerindex[$bids[$i]['buyer_id']]) )
					//{
					//	$bindex++;
					//	$buyerindex[$bids[$i]['buyer_id']] = $bindex;
					//}

					// Check if current buyer place a bid
					if( ($UserId != 0) && ($UserId == $bids[$i]['buyer_id']) )
					{
						$mybid_id = $bids[$i]['id'];
						$mybid_cost = $bids[$i]['price'];
						$mybid_amount = $bids[$i]['amount'];
					}
				}

				// Find the bids, which could win this lot
				$amount_ost_tmp = $CUR_TORG['amount'];
				$win_bids = Array();
				for( $i=(count($bids)-1); $i>=0; $i-- )
				{
					if( $amount_ost_tmp > 0 )
					{
						if( $mybid_id == $bids[$i]['id'] )
						{
							$mybid_win = ( $bids[$i]['amount'] > $amount_ost_tmp ? 2 : 1 );
							$mybid_winamount = ( $bids[$i]['amount'] > $amount_ost_tmp ? $amount_ost_tmp : $bids[$i]['amount'] );
							$mybid_win_cost = $bids[$i]['price'];
						}
						else
						{
							$winbid_cost_min_notmy = ( $winbid_cost_min_notmy > $bids[$i]['price'] ? $bids[$i]['price'] : $winbid_cost_min_notmy );
							$winbid_cost_max_notmy = ( $winbid_cost_max_notmy < $bids[$i]['price'] ? $bids[$i]['price'] : $winbid_cost_max_notmy );
						}
						$win_bids[$bids[$i]['id']] = true;
						$amount_ost_tmp -= $bids[$i]['amount'];

						$winbid_cost_min = ( $winbid_cost_min > $bids[$i]['price'] ? $bids[$i]['price'] : $winbid_cost_min );
						$winbid_cost_max = ( $winbid_cost_max < $bids[$i]['price'] ? $bids[$i]['price'] : $winbid_cost_max );
					}
					else
					{
						$win_bids[$bids[$i]['id']] = false;
					}
				}


				//
				$CUR_TORG['mybid_win'] = $mybid_win;
				$CUR_TORG['mybid_winamount'] = $mybid_winamount;
				$CUR_TORG['mybid_wincost'] = $mybid_win_cost;
				$CUR_TORG['winbid_max'] = $winbid_cost_max;
				$CUR_TORG['winbid_min'] = $winbid_cost_min;
				$CUR_TORG['winbid_ost'] = $amount_ost_tmp;
				$CUR_TORG['winbid_max_notmy'] = $winbid_cost_max_notmy;
				$CUR_TORG['winbid_min_notmy'] = $winbid_cost_min_notmy;
				$CUR_TORG['bids'] = $bids;
			}
			mysqli_free_result( $res );
		}
		else echo mysqli_error($upd_link_db);

		?>
  		<h3>Редактировать торги №<?=Torg_LotIdStr($CUR_TORG['id']);?></h3>
	    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
	    <tr><td>
	    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
		<form action="<?=$PHP_SELF;?>" method="POST" name="advfrm">
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="typeid" value="<?=$typeid;?>" />
		<input type="hidden" name="oblid" value="<?=$oblid;?>" />
		<input type="hidden" name="pi" value="<?=$pi;?>" />
		<input type="hidden" name="pn" value="<?=$pn;?>" />
		<input type="hidden" name="itemid" value="<?=$itemid;?>" />
		<tr><td class="ff">Дата начала:</td><td class="fr">
	<?php
		echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
		<td><input type=\"text\" id=\"datest\" name=\"datest\" size=\"10\" maxlength=\"10\" value=\"".$CUR_TORG['dtst']."\" /> &nbsp;</td>
		<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.advfrm.datest', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
		</tr></table>";
	?>
	</td></tr>
		<tr><td class="ff">Дата окончания:</td><td class="fr">
	<?php
		echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr>
		<td><input type=\"text\" id=\"dateen\" name=\"dateen\" size=\"10\" maxlength=\"10\" value=\"".$CUR_TORG['dten']."\" /> &nbsp;</td>
		<td><a href=\"javascript:OpenPopup('calendar.php?target=self.opener.document.advfrm.dateen', 190, 160)\"><img src=\"img/ico_cal.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"Выбрать дату\" /></a></td>
		</tr></table>";
	?>
	</td></tr>
		<tr><td class="ff">Автор:</td><td class="fr"><b><?=$CUR_TORG['buyer_name'].' ('.$CUR_TORG['buyer_org'].')';?></b></td></tr>
		<tr><td class="ff">E-mail:</td><td class="fr"><?=$CUR_TORG['buyer_email'];?></td></tr>
		<tr><td class="ff">Телефон:</td><td class="fr"><?=$CUR_TORG['buyer_phone'];?></td></tr>
		<tr><td class="ff">Тип торгов:</td><td class="fr"><select name="newstype">
			<option value="1"<?=($CUR_TORG['torg_type'] == 1 ? ' selected' : '');?>>Закупка</option>
			<option value="2"<?=($CUR_TORG['torg_type'] == 2 ? ' selected' : '');?>>Продажа</option>
		</select></td></tr>
		<tr><td class="ff">Статус:</td><td class="fr"><select name="newsstat">
	<?php
		for($i=0; $i<count($TORG_STATUS); $i++ )
		{
			echo '<option value="'.$i.'"'.($CUR_TORG['status'] == $i ? ' selected' : '').'>'.$TORG_STATUS[$i].'</option>';
		}
	?>
		</select></td></tr>
		<tr><td class="ff">Культура:</td><td class="fr"><select name="newscult">
	<?php
		for( $i=0; $i<count($cult_list); $i++ )
		{
			echo '<option value="'.$cult_list[$i]['id'].'"'.($CUR_TORG['cult_id'] == $cult_list[$i]['id'] ? ' selected' : '').'>'.$cult_list[$i]['name'].'</option>';
		}
	?>
		</select></td></tr>
		<tr><td class="ff">Область:</td><td class="fr"><select name="newsobl">
		<?php
			for( $i=1; $i<count($REGIONS); $i++ )
			{
				echo '<option value="'.$i.'"'.($newsobl == $i ? ' selected' : '').'>'.$REGIONS[$i].'</option>';
			}
		?>
		</select></td></tr>
		<tr><td class="ff">Объем:</td><td class="fr"><input type="text" name="newsamount" value="<?=$CUR_TORG['amount'];?>" /></td></tr>
		<tr><td class="ff">Цена:</td><td class="fr"><input type="text" name="newscost" value="<?=$CUR_TORG['cost']?>" /> </td></tr>
		<tr><td class="ff">Цена стартовая:</td><td class="fr"><input type="text" name="newscostst" value="<?=$CUR_TORG['cost_start']?>" /></td></tr>
		<tr><td class="ff">Комментарии:</td><td class="fr"><textarea rows="8" cols="70" name="newscont"><?=$CUR_TORG['descr'];?></textarea></td></tr>
	    <script language="javascript1.2">
	    	editor_generate('newscont'); // field, width, height
		</script>
		<tr><td colspan="2" class="fr" align="center"><input type="submit" value=" Сохранить "></td></tr>
		</form>
			</table>
		</td></tr>
		</table>
		<?php
		echo '<div style="padding: 15px 0px 20px 0px; text-align: center;"><a href="torg_items.php?pi='.$pi.'&pn='.$pn.'">Перейти к списку торгов</a></div>';


		////////////////////////////////////////////////////////////////////////////
		// Предложения на данный лот
		$bids = TorgItem_Bids( $LangId, $CUR_TORG['id'] );

		//if( $bidcost == 0 )
		//{
		//	$bidcost = ( $CUR_TORG['costbest'] != 0 ? $CUR_TORG['costbest'] : $CUR_TORG['cost_start'] );
		//}

		// Find current buyer proposal
		$mybid_id = 0;
		$mybid_cost = 0;
		$mybid_amount = 0;
		$mybid_win = 0;	// 1 - full win, with whole amount, 2 - win with part of amount
		$mybid_winamount = 0;

		// Find different buyer indexes
		$buyerindex = Array();
		$bindex = 0;
		for( $i=0; $i<count($bids); $i++ )
		{
			// Check if there is bid from this buyer earlier
			if( empty($buyerindex[$bids[$i]['buyer_id']]) )
			{
				$bindex++;
				$buyerindex[$bids[$i]['buyer_id']] = $bindex;
			}

			// Check if current buyer place a bid
			/*
			if( ($UserId != 0) && ($UserId == $bids[$i]['buyer_id']) )
			{
				$mybid_id = $bids[$i]['id'];
				$mybid_cost = $bids[$i]['price'];
				$mybid_amount = $bids[$i]['amount'];
				$bidamount = $mybid_amount;
			}
			*/
		}

		// Find the bids, which could win this lot
		$amount_ost_tmp = $CUR_TORG['amount'];
		$win_bids = Array();
		for( $i=(count($bids)-1); $i>=0; $i-- )
		{
			if( $amount_ost_tmp > 0 )
			{
				if( $mybid_id == $bids[$i]['id'] )
				{
					$mybid_win_id = $bids[$i]['id'];
					$mybid_win = ( $bids[$i]['amount'] > $amount_ost_tmp ? 2 : 1 );
					$mybid_winamount = ( $bids[$i]['amount'] > $amount_ost_tmp ? $amount_ost_tmp : $bids[$i]['amount'] );
				}
				$win_bids[$bids[$i]['id']] = true;
				$amount_ost_tmp -= $bids[$i]['amount'];
			}
			else
			{
				$win_bids[$bids[$i]['id']] = false;
			}
		}

		if( $msg != "" )
			echo '<div class="errmsg">'.$msg.'</div>';
?>
		<h3>Участники торгов</h3>
		<table class="fbtl_tbl">
		<tr>
	    	<th>Участник</th>
	    	<th>Предложил</th>
	    	<th>Выигрыш</th>
	    	<th>Цена</th>
	    	<th>Контакт</th>
	    	<th>&nbsp;</th>
	    	<th>Время предложения</th>
	    </tr>
	<?php
		for( $i=0; $i<count($bids); $i++ )
		{
			$dt_rus_str = makeDtStr( $bids[$i]['date'] );

			$dt_parts = explode(" ", $bids[$i]['date'], 2);
			$tm_parts = explode(":", $dt_parts[1], 2);

			//echo $bids[$i]['date']." - ".$bids[$i]['datesrc'];

			$dt_pass_tm = leftDtFromNow( $dt_parts[0], false, $tm_parts[0], $tm_parts[1] );

			$buyer_str_name = ($CUR_TORG['torg_type'] == $TORG_BUY ? "Продавец" : "Покупатель");

			//if( ($CUR_TORG['publisher_id'] == $UserId) && ($CUR_TORG['status'] == $TORG_STATUS_FINISH) )
			if( true )
			{
				$bidder_name = $buyer_str_name.' '.$buyerindex[$bids[$i]['buyer_id']];
				$bidder_amount = $bids[$i]['amount'];

				$bid_label = '<td class="fbtl_td4">Предложение добавлено</td>
				<td class="fbtl_td5"><img height="20" width="19" alt="" src="'.$IMGHOST.'img/ico-timeleft.png" class="block" /></td>
				<td class="fbtl_td6">'.$dt_rus_str.'<br/> '.$dt_pass_tm.'</td>';

				// Режим отображения для завершенных торгов, когда просматривает владелец
				//if( $bids[$i]['status'] == $BID_STATUS_WIN )
				if( true )
				{
					// Данное предложение является победителем. Показать реальное название и контакты
					$bidder_i = Torg_BuyerInfo( $LangId, $bids[$i]['buyer_id'] );
					$bidder_name = ( $bidder_i['orgname'] != "" ? $bidder_i['orgname'] : $bidder_i['name'] );
					$bidder_amount = $bids[$i]['win_amount'];

					$bid_label = '<td class="fbtl_td4">Тел.: '.$bidder_i['phone'].'<br/>E-mail: '.$bidder_i['email'].'</td>';
				}

				echo '<tr>
					<td class="fbtl_td1"><b>'.$bidder_name.'</b></td>
					<td class="fbtl_td2">'.$bids[$i]['amount'].' т</td>
					<td class="fbtl_td2">'.$bidder_amount.' т</td>
					<td class="fbtl_td3">'.( $win_bids[$bids[$i]['id']] ? '<span>'.$bids[$i]['price'].' грн</span>' : $bids[$i]['price'].' грн' ).' за тонну</td>
                       '.$bid_label.'
     				<td class="fbtl_td5"><img height="20" width="19" alt="" src="'.$IMGHOST.'img/ico-timeleft.png" class="block" /></td>
					<td class="fbtl_td6">'.$dt_rus_str.'<br/> '.$dt_pass_tm.'</td>
				</tr>';
			}
			else
			{
				echo '<tr>
					<td class="fbtl_td1"><a class="a-tuser" href="#">'.( $UserId == $bids[$i]['buyer_id'] ? "<b>Мое предложение</b>" : $buyer_str_name.' '.$buyerindex[$bids[$i]['buyer_id']] ).'</a></td>
					<td class="fbtl_td2">'.$bids[$i]['amount'].' т</td>
					<td class="fbtl_td2"> &nbsp; </td>
					<td class="fbtl_td3">'.( $win_bids[$bids[$i]['id']] ? '<span>'.$bids[$i]['price'].' грн</span>' : $bids[$i]['price'].' грн' ).' за тонну</td>
					<td class="fbtl_td4">Предложение добавлено</td>
					<td class="fbtl_td5"><img height="20" width="19" alt="" src="'.$IMGHOST.'img/ico-timeleft.png" class="block" /></td>
					<td class="fbtl_td6">'.$dt_rus_str.'<br/> '.$dt_pass_tm.'</td>
				</tr>';
			}
		}
	?>
		</table>
		<div class="fbtsum">
			<span class="wincolor">Цена</span> - Красным цветом указана цена для лидирующих предложений.
		<?php
			if( $amount_ost_tmp > 0 )
			{
				echo 'В данных торгах на объем в <b>'.$amount_ost_tmp.' т</b> еще нет предложений.';
			}
		?>
		</div>
<?php
  	}
?>

<?php

	$where_cond = "";
	$obl_cond = "";

	if( $stat >= 0 )
	{
		$where_cond .= " AND i1.status='".$stat."' ";
	}
	if( $uid > 0 )
	{
		$where_cond .= " AND i1.publisher_id='".$uid."' ";
	}

	if( $oblid > 0 )
	{
		$obl_cond = " AND r1.obl_id='".$oblid."' ";
	}

	$sort_cond = "";
	switch( $sortby )
	{
		case "lotid":
			$sort_cond = " ORDER BY i1.id ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "timeend":
			$sort_cond = " ORDER BY i1.dt_end ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "amount":
			$sort_cond = " ORDER BY i1.amount ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "ray":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "stcost":
			$sort_cond = " ORDER BY i1.cost ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "nowcost":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "bidnum":
			$sort_cond = " ORDER BY r2.name ".($sortdir == "down" ? "DESC" : "")." ";
			break;
		case "cult":
			$sort_cond = " ORDER BY p2.type_name ".($sortdir == "down" ? "DESC" : "").",i1.dt_end";
			break;
	}

	$limit_cond = "";
	if( $pi >= 0 )
	{
		$limit_cond = " LIMIT ".(($pi-1)*$pn).",$pn ";
	}

	//i1.dt_end>NOW() AND i1.dt_start<NOW()

	$its = Array();
	$query = "SELECT i1.*, i2.descr, p1.icon_filename, p2.type_name, r2.name as rayon, e1.id as elevator_id, e2.name as elevname,
			DATE_FORMAT(dt_start,'%d.%m.%Y') as dtst, DATE_FORMAT(dt_end,'%d.%m.%Y') as dten, r1.id as ray_id, r1.obl_id,
			b1.name as publisher, b1.orgname, b1.login
		FROM $TABLE_TORG_ITEMS i1
		INNER JOIN $TABLE_TORG_BUYERS b1 ON i1.publisher_id=b1.id
		INNER JOIN $TABLE_TORG_ITEM2RAY i2i ON i1.id=i2i.item_id
		INNER JOIN $TABLE_TORG_ITEMS_LANGS i2 ON i1.id=i2.item_id AND i2.lang_id='$LangId'
		INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id
		INNER JOIN $TABLE_TORG_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
		INNER JOIN $TABLE_RAYON r1 ON i2i.ray_id=r1.id $obl_cond
		INNER JOIN $TABLE_RAYON_LANGS r2 ON r1.id=r2.ray_id AND r2.lang_id='$LangId'
		LEFT JOIN $TABLE_TORG_ITEM2ELEV e2i ON i1.id=e2i.item_id
		LEFT JOIN $TABLE_TORG_ELEV e1 ON e2i.elev_id=e1.id
		LEFT JOIN $TABLE_TORG_ELEV_LANGS e2 ON e1.id=e2.item_id AND e2.lang_id='$LangId'
		WHERE i1.archive=0 $where_cond
		$sort_cond
		$limit_cond";
	if( $res = mysqli_query($upd_link_db, $query ) )
	{
		while( $row = mysqli_fetch_object( $res ) )
		{
			$it = Array();
			$it['id'] = $row->id;
			$it['status'] = $row->status;
			$it['torg_type'] = $row->torg_type;
			$it['obl_id'] = $row->obl_id;
			$it['ray_id'] = $row->ray_id;
			$it['amount'] = $row->amount;
			$it['cost'] = $row->cost;
			$it['st'] = $row->dt_start;
			$it['en'] = $row->dt_end;
			$it['dtst'] = $row->dtst;
			$it['dten'] = $row->dten;
			$it['descr'] = stripslashes($row->descr);
			$it['cultname'] = stripslashes($row->type_name);
			$it['cultico'] = ( stripslashes($row->icon_filename) != "" ? $WWWHOST.$FILE_DIR.stripslashes($row->icon_filename) : '' );
			$it['cultico_rel'] = stripslashes($row->icon_filename);
			$it['rayon'] = stripslashes($row->rayon);
			$it['status'] = $row->status;

			$it['buyer'] = stripslashes($row->publisher);
			$it['buyerorg'] = stripslashes($row->orgname);
			$it['buyerlog'] = stripslashes($row->login);

			$it['active'] = $row->active;

			$it['elev_id'] = 0;
			$it['elev_name'] = "";
			if( $row->elevator_id != null )
			{
				$it['elev_id'] = $row->elevator_id;
				$it['elev_name'] = stripslashes($row->elevname);
			}

			$its[] = $it;
		}
		mysqli_free_result( $res );
	}


	$totitems = 0;
   	$query = "SELECT count(*) as totitems
            FROM $TABLE_TORG_ITEMS i1
            INNER JOIN $TABLE_TORG_PROFILE p1 ON i1.profile_id=p1.id";
    if( $res = mysqli_query($upd_link_db, $query ) )
    {
        while( $row = mysqli_fetch_object($res) )
        {
        	$totitems = $row->totitems;
        }
        mysqli_free_result($res);
    }
    else
    	echo mysqli_error($upd_link_db);

    $pagesnum = ceil($totitems / $pn);

?>
    <!-- PART OF PAGE TO DISPLAY USER'S LIST -->
	<h3><?=$strings['userlist'][$lang];?></h3>
    <table cellspacing="0" cellpadding="0" border="0" align="center" width="95%">
    <tr>
    	<td colspan="3">
   			<form action="<?=$PHP_SELF;?>" name="pagenfrm" style="margin:0; padding:0;">
   			Показывать по: <select name="pn" onchange="javascript:document.forms['pagenfrm'].submit();">
   				<option value="25"<?=($pn == 25 ? " selected" : "");?>>25</option>
   				<option value="50"<?=($pn == 50 ? " selected" : "");?>>50</option>
   				<option value="100"<?=($pn == 100 ? " selected" : "");?>>100</option>
   				<option value="150"<?=($pn == 150 ? " selected" : "");?>>150</option>
   			</select>
   			</form>
   		</td>
   		<td colspan="6" align="right">Страницы:
   		<?php
   			for( $i=1; $i<=$pagesnum; $i++ )
   			{
   				if( $i != 1 )
   					echo " :: ";

   				if( $i == $pi )
   					echo "<b>$i</b>";
   				else
       				echo "<a href=\"$PHP_SELF?pi=$i&pn=".$pn."\">$i</a>";
   			}
   		?>
   		</td>
   	</tr>
    <tr>
    	<th>№ лота</th>
    	<th>Опубликовал</th>
    	<th>Тип</th>
    	<th>Место провед.</th>
    	<th>Культура</th>
    	<th>Начало</th>
    	<th>Конец</th>
    	<th>&nbsp;</th>
    	<th width="100">&nbsp;</th>
    </tr>
    <tr>
    	<td colspan="9" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
    </tr>
    <?php
    	for($i=0; $i<count($its); $i++)
    	{
    		$LOTIURL = TorgItem_BuildUrl( $LangId, $its[$i]['id'], $its[$i]['id'], $REGIONS_URL[$its[$i]['obl_id']], $its[$i]['ray_id'], $its[$i]['torg_type'] );
    		echo '<tr'.($its[$i]['active'] == 0 ? ' style="background: #f6f6f6;"' : '').'>
    		<td><a href="'.$LOTIURL.'">'.Torg_LotIdStr($its[$i]['id']).'</a></td>
    		<td><b>'.$its[$i]['buyerorg'].'</b><br />'.$its[$i]['buyer'].'</td>
    		<td>'.($its[$i]['torg_type'] == $TORG_BUY ? "Закупка" : "Продажа").'</td>
    		<td>'.$REGIONS[$its[$i]['obl_id']].'<br />'.$its[$i]['rayon'].' район'.($its[$i]['elev_id'] != 0 ? '<br /><i>'.$its[$i]['elev_name'].'</i>' : '').'</td>
    		<td>'.$its[$i]['cultname'].'</td>
    		<td>'.$its[$i]['dtst'].'</td>
    		<td>'.$its[$i]['dten'].'</td>
    		<td align="center"><img src="img/ico-status-0'.($its[$i]['status'] >= 2 ? '3' : ($its[$i]['status']+1)).'.gif" width="11" height="26" alt="" /></td>
    		<td align="center">
    			<a href="'.$PHP_SELF.'?action=edititem&itemid='.$its[$i]['id'].'" class="blink" title="Редактировать"><img src="img/edit.gif" width="20" height="20" border="0" alt="Редактировать" /></a>&nbsp;
    			<a href="'.$PHP_SELF.'?action=status&active='.(($its[$i]['active'] == 1) ? 0 : 1).'&itemid='.$its[$i]['id'].'" class="blink" title="Включить/отключить торг"><img src="img/refresh.gif" width="20" height="20" border="0" alt="Включить/отключить торг" /></a>&nbsp;
    			<a href="'.$PHP_SELF.'?action=delete&itemid='.$its[$i]['id'].'" class="blink" title="Удалить торг с сайта"><img src="img/delete.gif" width="20" height="20" border="0" alt="Удалить торг" /></a>&nbsp;
    		</td>
    		</tr>
    		<tr>
       	     	<td colspan="9" bgcolor="#DDDDDD"><img src="img/spacer.gif" width="1" height="1" alt="" /></td>
      		</tr>';
    	}
    ?>
	</table>

<?php
	include "inc/footer-inc.php";

	include "../inc/close-inc.php";
?>
