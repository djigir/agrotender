<?php
	include("../inc/db-inc.php");
	include("../inc/connect-inc.php");

	include "../inc/catutils-inc.php";

	include "../inc/ses-inc.php";

	include "inc/authorize-inc.php";

	if( $UserId == 0 )
	{
		header("Location: index.php");
		exit;
	}

	include "../inc/countryutils-inc.php";
	include "../inc/utils-inc.php";
	//include "../inc/catutils-inc.php";

	$PAGE_HEADER['ru'] = "Заказы пользователей";
	$PAGE_HEADER['en'] = "Client's orders";

	// INCLUDE YOUR HEADER FILE HERE
	include "inc/header-inc.php";

	$strings['formhdr']['ru'] = "Просмотр заказов";
	$strings['formhdr']['en'] = "Orders view";

	$strings['formhdr1']['ru'] = "Обработка заказа";
	$strings['formhdr1']['en'] = "Update order";

	$order_status = Array("<span style=\"color: #888888;\">Ложный</span>",
		"<span style=\"color: #FF0000;\">Новый !!!!!</span>",
		"<span style=\"color: #FF8800;\">Подтвержденный</span>",
		"<span style=\"color: #CCCC00;\">** В доставке **</span>",
		"<span style=\"color: #00FF00;\">Выполненный</span>"
		 );

	$payment_status = Array("<span style=\"color: #000000;\">Нет</span>",
		"<span style=\"color: #22EE22; font-weight: bold;\">ДА</span>"
	);

	$pi = GetParameter("pi", 0);
	$pn = GetParameter("pn", 50);
	$action = GetParameter("action", "");
	$mode = "";
	$msg = "";

	$clientreg = GetParameter("clientreg", 1);

	$clientname = "";
	$clientaddr = "";
	$clientphone = "";
	$clientemail = "";
	$clienttime = "";
	$clientnote = "";
	$clientdeliv = "deliv";
	$clientcity = "";

	$MAX_PROD = 10;

	switch( $action )
	{
		case "addnew":
			$mode = "addorder";
			break;

		case "makeorder":
			$mode = "addorder";
			$clientname = GetParameter( "clientname", "" );
			$clientaddr = GetParameter( "clientaddr", "" );
			$clientphone = GetParameter( "clientphone", "" );
			$clientemail = GetParameter( "clientemail", "" );
			$clienttime = GetParameter( "clienttime", "" );
			$clientnote = GetParameter( "clientnote", "" );
			$clientdeliv = GetParameter( "clientdeliv", "deliv" );
			$clientcity = GetParameter("clientcity", "");

			if( $clientname == "" )
			{
				$msg = "Вы не заполнили имя покупателя.";
				break;
			}

			if( ($clientdeliv == "deliv") && (trim($clientaddr) == "") )
			{
				$msg = "Вы не указали адрес доставки.";
				break;
			}

			if( trim($clientphone) == "" )
			{
				$msg = "Вы не указали контактный телефон покупателя.";
				break;
			}

			if( $clientcity == "" )
			{
				$clientcity = GetCityById( $clientreg, $LangId );
			}


			// Check if the user used the same email
			if( $clientemail != "" )
			{
				// check email format
				//$is_all_fields = false;

				// check if the user with this email is exists
				$email_exists = false;
				$query = "SELECT * FROM $TABLE_SHOP_BUYERS WHERE email='".addslashes($clientemail)."'";
				if( $res = mysqli_query($upd_link_db, $query ) )
				{
					while( $row = mysqli_fetch_object( $res ) )
					{
						$email_exists = true;
					}
					mysqli_free_result( $res );
				}

				if( $email_exists )
				{
					$msg = "Клиент с таким E-mail адресом уже зарегистрирован у нас в магазине. Необходимо указать другой E-mail адрес или клиент должен сам войти на сайт и выполнить заказ.";
					break;
				}
			}

			$discount_levels = Shop_DiscountLevels($LangId);

			$tmp_cart_ses = makeUuid();

			// Check if there are any goods in cart
			$total_order_cost = 0;
			$total_order_cost_grn = 0;

			$goods = Array();

			// Add products to tmp cart
			for( $i=1; $i<=$MAX_PROD; $i++ )
			{
				$modelid = GetParameter("prodmodel".$i, 0);
				$modelnum = GetParameter("prodnum".$i, 0);
				$modelcost = GetParameter("prodcost".$i, 0.00);

				if( ($modelid == 0) || ($modelnum == 0) || ($modelcost == 0) )
					continue;

				$query1 = "INSERT INTO $TABLE_SHOP_CART (ses_id, oborud_id, oborud_num, oborud_price, add_date) VALUES
					('".addslashes($tmp_cart_ses)."', '$modelid', '$modelnum', 0, NOW())";
				if( !mysqli_query($upd_link_db, $query1 ) )
				{
					echo mysqli_error($upd_link_db);
				}
			}

            // Process the order in same manner as in cart.php
			$query = "SELECT m1.make_name as brand, i1.id as id, c1.id as cart_id, i1.model as model, p1.price, c1.oborud_num
				FROM $TABLE_SHOP_CART c1
				INNER JOIN $TABLE_CAT_ITEMS i1 ON c1.oborud_id=i1.id
				INNER JOIN $TABLE_CAT_MAKE_LANGS m1 ON i1.make_id=m1.make_id AND m1.lang_id='".$LangId."'
				INNER JOIN $TABLE_CAT_PRICES p1 ON i1.id=p1.item_id
				WHERE c1.ses_id='".addslashes($tmp_cart_ses)."'";

			if( $res = mysqli_query($upd_link_db, $query ) )
			{
				while( $row = mysqli_fetch_object($res) )
				{
					$gi = Array();
					$gi['cart_id'] = $row->cart_id;
					$gi['price'] = $row->price;
					$gi['amount'] = $row->oborud_num;

					$total_order_cost += ($row->price*$row->oborud_num);
					$total_order_cost_grn += (ceil($row->price*$PREFS['DOLLAR_KURS'])*$row->oborud_num);

					$goods[] = $gi;
				}
				mysqli_free_result($res);
			}

			$guid_act_account = makeUuid();

			if( count($goods) == 0 )
			{
				$msg = "Заказ выполнить невозможно, так как в корзине нет товаров.";
				break;
			}

			$buyer_alltime_payed = 0;
			$buyer_discount_level = 0;
			$buyer_discount_value = 0;

			$buyer_new_payed = 0;

			$newpasswd = "";
			for($i=0; $i<8; $i++)
			{
				$newpasswd .= "".rand(0,9);
			}

			$guid_deact_account = makeUuid();

			$query = "INSERT INTO $TABLE_SHOP_BUYERS (add_date, login, passwd, name, city, address, phone, email, comments, guid_act, guid_deact)
				VALUES (NOW(), '".addslashes($clientemail)."', '".addslashes($newpasswd)."', '".addslashes($clientname)."', '".addslashes($clientcity)."',
				'".addslashes($clientaddr)."', '".addslashes($clientphone)."', '".addslashes($clientemail)."', '".addslashes($clientnote)."',
				'".addslashes($guid_act_account)."', '".addslashes($guid_deact_account)."')";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
				break;
			}

			$buyer_id = mysqli_insert_id($upd_link_db);

			$buyer_new_payed = $total_order_cost_grn;

			// Find if the amount of order is enought to set the discount level
			for( $i=(count($discount_levels)-1); $i>=0; $i-- )
			{
				if( $buyer_new_payed >= $discount_levels[$i]['amount'] )
				{
					$buyer_discount_level = $discount_levels[$i]['id'];
					$buyer_discount_value = $discount_levels[$i]['discount'];
					break;
				}
			}

			if( $buyer_discount_value > 0 )
			{
				$total_order_cost = $total_order_cost - $total_order_cost*$buyer_discount_value;
				$total_order_cost_grn = $total_order_cost_grn - $total_order_cost_grn*$buyer_discount_value;
			}

			// Add order
			$query = "INSERT INTO $TABLE_SHOP_ORDERS (buyer_id, order_time, order_status, client_name, client_address,
				client_phone, client_email, client_delivery_time, client_comments, manager_notes, delivery_id,
				total_cost, total_cost_grn, ue_kurs, order_discount)
				VALUES ('$buyer_id', NOW(), 1, '".addslashes($clientname)."', '".addslashes($clientaddr)."', '".addslashes($clientphone)."',
				'".addslashes($clientemail)."', '', '".addslashes($clientnote)."', '', '".( $clientdeliv == "deliv" ? 2 : 1)."',
				'".str_replace(",",".",$total_order_cost)."', '".str_replace(",",".",$total_order_cost_grn)."',
				'".str_replace(",",".",$PREFS['DOLLAR_KURS'])."', '".str_replace(",",".",$buyer_discount_value)."')";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
				break;
			}

			$order_id = mysqli_insert_id($upd_link_db);

			for( $i=0; $i<count($goods); $i++ )
			{
				if( !mysqli_query($upd_link_db,"UPDATE $TABLE_SHOP_CART SET oborud_price='".$goods[$i]['price']."' WHERE id='".$goods[$i]['cart_id']."'") )
				{
					echo mysqli_error($upd_link_db);
				}

				if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_SHOP_CART_ORDERS (cart_id, order_id)
					VALUES ('".$goods[$i]['cart_id']."', ".$order_id.")") )
				{
					echo mysqli_error($upd_link_db);
				}
			}

			$order_done = true;

			// Now it is important to clear session field to remove ordere items from current session
			$query = "UPDATE $TABLE_SHOP_CART SET ses_id='' WHERE ses_id='".addslashes($tmp_cart_ses)."'";
			if( !mysqli_query($upd_link_db, $query ) )
			{
				echo mysqli_error($upd_link_db);
			}

            // Extract contacts from database
			$continfo = Contacts_Get( $LangId );

			$order_email = $continfo['infomail'];
			if( $order_email != "" )
			{
				$prod_num = 0;
				$prod_price = 0.00;

				$product_list_str = "\r\n\r\nЗаказанные товары:\r\n";

				if( $res1 = mysqli_query($upd_link_db,"SELECT a.oborud_num, a.oborud_price, p.articul, p.model as product_name, z.make_name as brand
				    FROM $TABLE_SHOP_CART_ORDERS b
				    INNER JOIN $TABLE_SHOP_CART a ON a.id=b.cart_id
				    INNER JOIN $TABLE_CAT_ITEMS p ON a.oborud_id=p.id
				    INNER JOIN $TABLE_CAT_MAKE_LANGS z ON p.make_id=z.make_id AND z.lang_id='".$LangId."'
				    WHERE b.order_id=".$order_id) )
				{
					while( $row1 = mysqli_fetch_object($res1) )
					{
						$this_prod_pr = ceil($row1->oborud_price*$PREFS['DOLLAR_KURS']);

						$product_list_str .= "(артикул: ".stripslashes($row1->articul).") ".stripslashes($row1->brand)." ".stripslashes($row1->product_name)." - ".Show_Price($this_prod_pr)." ".$CURRENCY_NAME.". - ".$row1->oborud_num." шт.\n";

						$prod_num += $row1->oborud_num;
						$prod_price += $row1->oborud_num*$this_prod_pr;
					}
					mysqli_free_result($res1);
				}
				else
				{
					echo mysqli_error($upd_link_db);
				}

				// Get the delivery information if it is selected
				$delivstr = ( $clientdeliv == "deliv" ? "Доставка" : "Самовывоз");

				$mail_body = "Номер Заказа: ".$order_id."\r\n
Заказчик : ".$clientname."\r\n
Адрес: ".$clientaddr."\r\n
Тел.: ".$clientphone."\r\n
E-Mail: ".$clientemail."\r\n
Коментарии: ".$clientnote."\r\n
Товаров: $prod_num\nОбщая Цена: ".$prod_price."\r\n".$delivstr;

				$mailto = $order_email;
				$mailsubj = "Заказ через админ: $order_id, на сайте ".substr($WWWHOST, 7, strlen($WWWHOST)-8);
				$mailbody = $mail_body.$product_list_str;
				$mailhdr = "Content-type: text/plain; charset=windows-1251\r\nFrom: Avtoradosti.com.ua <$order_email>\r\nReply-To: $order_email";
				// Отправить в магазин с информацией о новом заказе
				mail( $mailto, $mailsubj, $mailbody, $mailhdr );

				// Отправить клиенту с информацией, что он заказал и доступом на сайт
				if( $clientemail != "" )
				{
					$mailbody = $mail_body."\r\n\r\nВаш доступ к заказам\r\nЛогин: ".$clientemail."\r\nПароль: ".$newpasswd."\r\n";
					$mailbody .= "\r\nДля того, чтобы активировать учетную запись на сайте avtoradosti.com.ua и в дальнейшем участвовать в программе начисления бонусов и скидок пройдите по этой ссылке ".$WWWHOST."activate.php?action=act&guid=".$guid_act_account."\r\n\r\n";
					$mailbody .= $product_list_str;

					mail($clientemail, $mailsubj, $mailbody, $mailhdr );
				}
			}

			$msg = "Заказ выволнен успешно.";

            /*
  			$query = "INSERT INTO $TABLE_SHOP_ORDERS (order_time, order_status, client_name, client_address,
				client_phone, client_email, client_delivery_time, client_comments, manager_notes, delivery_id, client_city, client_delivery)
				VALUES (NOW(), 2, '".addslashes($clientname)."', '".addslashes($clientaddr)."', '".addslashes($clientphone)."',
				'".addslashes($clientemail)."', '".addslashes($clienttime)."', '".addslashes($clientnote)."', '', '0',
				'".addslashes($clientcity)."', '".( $clientdeliv == "deliv" ? 1 : 0)."')";
			if( mysqli_query($upd_link_db, $query ) )
			{
				$order_id = mysqli_insert_id();

				for( $i=1; $i<=$MAX_PROD; $i++ )
				{
					$modelid = GetParameter("prodmodel".$i, 0);
					$modelnum = GetParameter("prodnum".$i, 0);
					$modelcost = GetParameter("prodcost".$i, 0.00);

					if( ($modelid == 0) || ($modelnum == 0) || ($modelcost == 0) )
						continue;

					$query1 = "INSERT INTO $TABLE_SHOP_CART (ses_id, oborud_id, oborud_num, oborud_price, add_date) VALUES
						('', '$modelid', '$modelnum', '$modelcost', NOW())";
					if( !mysqli_query($upd_link_db, $query1 ) )
					{
						echo mysqli_error($upd_link_db);
					}
					else
					{
						$cart_id = mysqli_insert_id();

						if( !mysqli_query($upd_link_db,"INSERT INTO $TABLE_SHOP_CART_ORDERS (cart_id, order_id) VALUES ('".$cart_id."', ".$order_id.")") )
						{
							echo mysqli_error($upd_link_db);
						}
					}
				}
			}
			else
				echo mysqli_error($upd_link_db);
			*/

			$mode = "";
			break;

		case "delete":
			$item_id = GetParameter("item_id", 0);
			// Marks order as wrong or false
			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_SHOP_ORDERS SET order_status='0' WHERE id='$item_id'"))
			{
	    		echo "<b>".mysqli_error($upd_link_db)."</b>";
			}
			break;

		case "deleteall":
			$items_id = GetParameter("items_id", null);
			// Mark as false orders
			for($i = 0; $i < count($items_id); $i++)
			{
				if(!mysqli_query($upd_link_db,"UPDATE $TABLE_SHOP_ORDERS SET order_status='0' WHERE id='".$items_id[$i]."'"))
				{
	                echo "<b>".mysqli_error($upd_link_db)."</b>";
	            }
			}
			break;

		case "update":
			$item_id = GetParameter("item_id", 0);
			$ordstatus = GetParameter("ordstatus", 1);
			$ordpayment = GetParameter("ordpayment", 0);
			$ordmsg = GetParameter("ordmsg", "");

			if(!mysqli_query($upd_link_db,"UPDATE $TABLE_SHOP_ORDERS
	        		SET order_status='$ordstatus', payment_status='$ordpayment', manager_notes='".addslashes($ordmsg)."'
	                WHERE id='".$item_id."'"))
			{
	    		echo "<b>".mysqli_error($upd_link_db)."</b>";
			}

			if( $ordstatus == 4 )
			{
				// order done
				if(!mysqli_query($upd_link_db,"UPDATE $TABLE_SHOP_ORDERS SET update_time=NOW() WHERE id='".$item_id."'"))
				{
		    		echo "<b>".mysqli_error($upd_link_db)."</b>";
				}
			}
			break;

		case "edit":
    		$mode = "edit";
    		break;
    }

	if( $mode == "addorder" )
	{
		$types = Array();

		$query = "SELECT p1.*, p2.type_name FROM $TABLE_CAT_PROFILE p1
			INNER JOIN $TABLE_CAT_PROFILE_LANGS p2 ON p1.id=p2.profile_id AND p2.lang_id='$LangId'
			ORDER BY p2.type_name";
		if( $res = mysqli_query($upd_link_db, $query ) )
		{
			while( $row = mysqli_fetch_object( $res ) )
			{
				$ti = Array();
				$ti['id'] = $row->id;
				$ti['name'] = stripslashes($row->type_name);
				$types[] = $ti;
			}
			mysqli_free_result( $res );
		}
?>
		<br>
    	<h3>Создать новый заказ</h3>
<script language="javascript">
function checkFields(frm, numfields, fio_obj_id, tel_obj_id)
{
	var fio_obj = uh_get_object( fio_obj_id );
	var tel_obj = uh_get_object( tel_obj_id );

	if( fio_obj.value == "" )
	{
		alert('Вы заполнили не все обязательные поля');
		return false;
	}

	if( tel_obj.value == "" )
	{
		alert('Вы заполнили не все обязательные поля');
		return false;
	}


	//var numf_obj = uh_get_object( numfields_obj_id );
	//if( !numf_obj )
	//	return true;

	//var num_val = parseInt(numf_obj.value);
	var num_val = numfields;
	if( isNaN(num_val) )
	{
		alert('Кол-во товаров введено неправильно');
		return false;
	}

	var prodnumsel = 0;

	for( var i=0; i<num_val; i++ )
	{

		var typeobj = uh_get_object('prodtype'+(i+1));
		var prodobj = uh_get_object('prodmodel'+(i+1));
		var numobj = uh_get_object('prodnum'+(i+1));
		var costobj = uh_get_object('prodcost'+(i+1));

		if( typeobj != null )
		{
			if( (prodobj.options[prodobj.selectedIndex].value != "0") && (costobj.value == 0) )
			{
				alert('Вы не заполнили цену для товара в позиции ' + (i+1) + '.');
				return false;
			}

			if( prodobj.options[prodobj.selectedIndex].value != "0" )
			{
				prodnumsel++;
			}
		}
	}

	if( prodnumsel == 0 )
	{
		alert('Вы не выбрали ни одного товара в заказ.');
		return false;
	}

	return true;
}

var prodcostarr = new Array(<?=$MAX_PROD;?>);
for( i=0; i<<?=$MAX_PROD;?>; i++ )
{
	prodcostarr[i] = null;
}
</script>
<?php
	if( $msg != "" )
		echo '<div style="padding: 20px 0px 20px 0px; text-align: center; color: red;">'.$msg.'</div>';
?>
<table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
<tr><td>
    	<table cellspacing="2" cellpadding="0" border="0" align="center" width="800">
		<form id="clientfrm" name="clientfrm" action="<?=$PHP_SELF;?>" method="POST" onsubmit="return checkFields(this, <?=$MAX_PROD;?>, 'clientname', 'clientphone')">
		<input type="hidden" name="action" value="makeorder" />
		<tr><td class="fr" colspan="5"><b>Данные о покупателе</b></td></tr>
		<tr>
			<td class="ff">Ф.И.О. покупателя: <span style="color: red">*</span></td>
			<td class="fr" colspan="4"><input type="text" name="clientname" id="clientname" value="<?=$clientname;?>" size="50" /></td>
		</tr>
		<tr>
			<td class="ff">Контактный Телефон: <span style="color: red">*</span></td>
			<td class="fr" colspan="4"><input type="text" name="clientphone" id="clientphone" value="<?=$clientphone;?>" size="50" /></td>
		</tr>
		<tr>
			<td class="ff">E-Mail: </td>
			<td class="fr" colspan="4"><input type="text" name="clientemail" value="<?=$clientemail;?>" size="50" /></td>
		</tr>
		<tr>
			<td class="ff">Адрес доставки: <span style="color: red">*</span></td>
			<td class="fr" colspan="4">
				<input type="text" name="clientaddr" value="<?=$clientaddr;?>" size="50" />
				<select name="clientdeliv"><option value="deliv" <?=($clientdeliv == "deliv" ? "selected" : "");?>>Доставка</option><option value="nodeliv" <?=($clientdeliv == "nodeliv" ? "selected" : "");?>>самовывоз</option></select>
			</td>
		</tr>
		<tr>
			<td class="ff">Дата доставки: </td>
			<td class="fr" colspan="4"><input type="text" name="clienttime"  value="<?=$clienttime;?>" size="50" /></td>
		</tr>
		<tr>
			<td class="ff">Регион доставки (обл. центр): </td>
			<td class="fr" colspan="4">
				<select name="clientreg">
		<?php
			$cities = GetCityList($LangId);
			for($i=0; $i<count($cities); $i++)
			{
				echo '<option value="'.$cities[$i]['cityid'].'"'.($clientreg == $cities[$i]['cityid'] ? " selected" : "").'>'.$cities[$i]['city'].'</option>';
			}
		?>
				</select>  Город в обл.: <input type="text" name="clientcity" size="20" value="<?=$clientcity;?>" /> (оставить пустым если обл. центр)
			</td>
		</tr>
		<tr>
			<td class="ff">Примечания: </td>
			<td class="fr" colspan="4"><textarea cols="50" rows="4" name="clientnote"><?=$clientnote;?></textarea></td>
		</tr>
		<tr><td class="fr" colspan="5"><b>Товары в заказ</b></td></tr>
		<tr>
			<td class="fr"></td>
			<td class="fr">Тип товара</td>
			<td class="fr">Модель товара</td>
			<td class="fr">Кол-во</td>
			<td class="fr">Цена в заказ</td>
		</tr>
<?php
	for( $j=1; $j<=$MAX_PROD; $j++ )
	{
?>
		<tr>
			<td class="ff">Товар <?=$j;?>: </td>
			<td class="fr">
				<select name="prodtype<?=$j;?>" id="prodtype<?=$j;?>" style="width: 130px;" onchange="javascript:fillProductList('prodmodel<?=$j;?>', <?=$j;?>, 'prodtype', this.options[this.selectedIndex].value, 'progress<?=$j;?>', <?=$MAX_PROD;?>);">
					<option value="0">---- Тип не выбран ----</option>
<?php
		for( $i=0; $i<count($types); $i++ )
		{
			echo '<option value="'.$types[$i]['id'].'">'.$types[$i]['name'].'</option>';
		}
?>
				</select>
			</td>
			<td class="fr">
				<select name="prodmodel<?=$j;?>" id="prodmodel<?=$j;?>" style="width: 350px; visibility: visible; display: inline;" onchange="javascript:fillProductCost('prodcost<?=$j;?>', <?=$j;?>, this.selectedIndex, this.options[this.selectedIndex].value);">
					<option value="0">---- Товар не выбран ----</option>
				</select>
				<div style="text-align: center; font-size: 7pt; color: #666666; visibility: visible; display: none;" id="progress<?=$j;?>">
					<img src="img/progress.gif" width="100" height="16" alt="Идет загрузка данных" border="0" />
					<br />
					подождите, идет загрузка данных...
				</div>
			</td>
			<td class="fr"><input type="text" id="prodnum<?=$j;?>" name="prodnum<?=$j;?>" size="2" value="1" /></td>
			<td class="fr"><input type="text" id="prodcost<?=$j;?>" name="prodcost<?=$j;?>" style="text-align: right; width: 60px;" value="0.00" /></td>
		</tr>
<?php
	}
?>
		<tr>
			<td class="fr" colspan="5" align="center"><input type="submit" name="orderbut" value=" Выполнить Заказ " /></td>
		</tr>
		</table>
</td></tr>
</table>
<?php
	}
	else if($mode == "edit")
	{
?>
	<br>
    <h3><?=$strings['formhdr'][$lang];?></h3>
<?php
		$item_id = GetParameter("item_id", 0);

		$order = Array();

        if( $res = mysqli_query($upd_link_db,"SELECT * FROM $TABLE_SHOP_ORDERS WHERE id='$item_id'") )
		{
			if( $row = mysqli_fetch_object($res) )
			{
				$order['id'] = $row->id;
				$order['comments'] = stripslashes( $row->manager_notes );
				$order['status'] = $row->order_status;
				$order['payment'] = $row->payment_status;

				echo "<table align=\"center\" border=\"0\">
					<tr><td><b>Состав заказа</b><br />";

            	// Print order content
                $total_sum = 0;

                $query1 = "SELECT b1.make_name as brand, p1.model, p1.articul, c1.oborud_num as num, c1.oborud_price as price
                	FROM $TABLE_SHOP_CART_ORDERS o1
                	INNER JOIN $TABLE_SHOP_CART c1 ON o1.cart_id=c1.id
                	INNER JOIN $TABLE_CAT_ITEMS p1 ON c1.oborud_id=p1.id
                	INNER JOIN $TABLE_CAT_MAKE_LANGS b1 ON p1.make_id=b1.make_id AND b1.lang_id='$LangId'
                	WHERE o1.order_id='".$row->id."'";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object($res1) )
                    {
                    	//$item_price = ceil($row1->price * $DOLLAR_KURS);
						//$it_grn=$row1->price;

						$item_price = $row1->price;
                    	$item_price_grn = ceil($row1->price * $PREFS['EVRO_KURS']);

                    	echo stripslashes($row1->brand)." ".stripslashes($row1->model)."<br />".
                    		"Арт. ".$row1->articul.": ".$row1->num." шт * ".$item_price_grn." = ".($row1->num * $item_price_grn)." грн.<br />";

                    	//echo stripslashes($row1->brand)." ".stripslashes($row1->model)." - ".$row1->num." * ".$it_grn." = ".($row1->num * $it_grn)." грн.<br />";

                    	$total_sum += $row1->num * $item_price_grn;
                    }
                    mysqli_free_result($res1);
                }
                else
                	echo mysqli_error($upd_link_db);

                echo "<b>Всего на сумму: ".($total_sum)." грн.</b></br />
                </td></tr>
                <tr><td><br /><br />Контактная информация<br />";

                //////////////////////
                echo "Имя клиента: ".stripslashes($row->client_name)."<br />
                    	Тел.: ".stripslashes($row->client_phone)."<br />
                    	E-Mail: <a href=\"mailto:".stripslashes($row->client_email)."\">".stripslashes($row->client_email)."</a><br />
                    	Адрес: ".stripslashes($row->client_address)."<br />
                      <br /><b>Комментарии клиента:</b><br />
                      Желаемое время доставки: ".stripslashes($row->client_delivery_time)."<br />
                      Комментарии:<br />".nl2br(stripslashes($row->client_comments))."<br />
                </td></tr>
                </table><br />";
            }
            mysqli_free_result($res);
		}
?>
    <table align="center" cellspacing="0" cellpadding="1" border="0" class="tableborder">
    <tr><td>
    	<table width="100%" cellspacing="1" cellpadding="1" border="0">
         <form action="<?=$PHP_SELF;?>" method="POST">
         <input type="hidden" name="action" value="update" />
         <input type="hidden" name="item_id" value="<?=$item_id;?>" />
         <tr><td class="ff">Статус заказа:</td><td class="fr">
         	<select name="ordstatus">
         		<option value="1"<?=($order['status'] == 1 ? " selected" : "");?>>Новый</option>
         		<option value="2"<?=($order['status'] == 2 ? " selected" : "");?>>Проверенный</option>
         		<option value="3"<?=($order['status'] == 3 ? " selected" : "");?>>В Доставке</option>
         		<option value="4"<?=($order['status'] == 4 ? " selected" : "");?>>Выполнен</option>
         	</select>
         </td></tr>
         <tr><td class="ff">Статус оплаты:</td><td class="fr">
         	<select name="ordpayment">
         		<option value="0"<?=($order['payment'] == 0 ? " selected" : "");?>>Неоплачен</option>
         		<option value="1"<?=($order['payment'] == 1 ? " selected" : "");?>>Оплата за товар получена</option>
         	</select>
         </td></tr>
         <tr><td class="ff">Мои комментарии:</td><td class="fr"><textarea rows="8" cols="60" name="ordmsg"><?=$order['comments'];?></textarea></td></tr>
         <tr><td class="fr" colspan="2" align="center"><input type="submit" value=" Применить "></td></tr>
         </form>
         </table>
     </td></tr>
     </table>
<?php
	}
	else
	{
		echo '<div style="text-align: center; padding: 10px 0px 20px 0px;"><a href="'.$PHP_SELF.'?action=addnew" class="a">Добавить новый заказ</a></div>';

		$where_str = "WHERE order_status>0 AND order_status<=3";

        switch($action)
        {
        	case "viewall":
        		$where_str = "";
        		break;
        	case "viewdone":
				$where_str = "WHERE order_status=4";
				break;
            case "viewfalse":
				$where_str = "WHERE order_status=0";
				break;
        }

		$totits = 0;
        $query = "SELECT count(*) as totits FROM $TABLE_SHOP_ORDERS $where_str";
        if( $res = mysqli_query($upd_link_db, $query ) )
        {
            while( $row = mysqli_fetch_object( $res ) )
            {
            	$totits = $row->totits;
            }
            mysqli_free_result( $res );
        }

        $viewmodearr = Array("viewall"=>"Все","viewcur"=>"Текущие","viewdone"=>"Выполненные","viewfalse"=>"Ложные");
?>
	<table width="100%" border="0">
	<tr><td>
	Заказы -
	<?php
		$i=0;
		foreach($viewmodearr as $k=>$v)
		{
			$i++;

			if( $i > 1 )
				echo ' :: ';

			$sellnk = false;
			if( ($i == 1) && ($action == "") )
				$sellnk = true;
			if( $k == $action )
				$sellnk = true;

			if( $sellnk )
				echo '<b>'.$v.'</b>';
			else
				echo '<a href="'.$PHP_SELF.'?action='.$k.'">'.$v.'</a>';
		}

		/*
	?>
	<a href="<?=$PHP_SELF;?>?action=viewall">Все</a> ::
	<a href="<?=$PHP_SELF;?>?action=viewcur">Текущие</a> ::
	<a href="<?=$PHP_SELF;?>?action=viewdone">Выполненные</a> ::
	<a href="<?=$PHP_SELF;?>?action=viewfalse">Ложные</a>
		*/
	?>
	</td>
	<td align="right">
		Страницы:
<?php
		$pages = ceil( $totits / $pn );
		for( $i=0; $i<$pages; $i++ )
		{
			if( $i == $pi )
				echo " &nbsp;".($i+1)."&nbsp; ";
			else
				echo " <a href=\"$PHP_SELF?action=$action&pi=$i&pn=$pn\">".($i+1)."</a> ";
		}
?>
	</td></tr>
	</table>
    <br>
    <table align="center" width="100%" cellspacing="1" cellpadding="0" class="tbl_orders">
    <form action="<?=$PHP_SELF;?>" method=POST>
    <input type="hidden" name="action" value="deleteall" />
    <tr>
    	<th>&nbsp;</th>
    	<th>№</td>
    	<th>Создан</th>
    	<th width="27%">Содержание заказа</th>
    	<th>Кол-во</th>
    	<th>Сумма</th>
    	<th>Доставка</th>
    	<th>Город</th>
    	<th>Покупатель</th>
    	<th>Оплачен</th>
    	<th>Статус</th>
    	<th>&nbsp;</th>
    </tr>
<?php
		$query = "SELECT *, DATE_FORMAT(order_time, '%d.%m.%y') as dtcr, DATE_FORMAT(order_time, '%H:%i') as tmcr
			FROM $TABLE_SHOP_ORDERS
			$where_str
			ORDER BY id DESC
			LIMIT ".($pi*$pn).",$pn";
		if( $res = mysqli_query($upd_link_db,$query) )
		{
			while( $row = mysqli_fetch_object($res) )
			{
				$order_summary = "";
				$order_cost = "";
				$order_numitems = 0;


				$buyer = Array();

				$query1 = "SELECT * FROM $TABLE_SHOP_BUYERS WHERE id=".$row->buyer_id." ";
				if( $res1 = mysqli_query($upd_link_db, $query1 ) )
				{
					if( $row1 = mysqli_fetch_object( $res1 ) )
					{
						$buyer['id'] = $row->buyer_id;
						$buyer['name'] = stripslashes($row1->name);
						$buyer['city'] = stripslashes($row1->city);
						$buyer['address'] = stripslashes($row1->address);
						$buyer['phone'] = stripslashes($row1->phone);
						$buyer['email'] = stripslashes($row1->email);
					}
					mysqli_free_result( $res1 );
				}


				// Print order content
                $total_sum = 0;

                $query1 = "SELECT b1.make_name as brand, p1.articul, p1.model, c1.oborud_num as num, c1.oborud_price as price
                	FROM $TABLE_SHOP_CART_ORDERS o1
                	INNER JOIN $TABLE_SHOP_CART c1 ON o1.cart_id=c1.id
                	INNER JOIN $TABLE_CAT_ITEMS p1 ON c1.oborud_id=p1.id
                	INNER JOIN $TABLE_CAT_MAKE_LANGS b1 ON p1.make_id=b1.make_id AND b1.lang_id='$LangId'
                	WHERE o1.order_id=".$row->id." ";
                if( $res1 = mysqli_query($upd_link_db, $query1 ) )
                {
                    while( $row1 = mysqli_fetch_object($res1) )
                    {
                    	$item_price = $row1->price;
                    	$item_price_grn = ceil($row1->price * $PREFS['EVRO_KURS']);

                    	$order_summary .= stripslashes($row1->brand)." ".stripslashes($row1->model)."<br />".
                    		"Арт. ".$row1->articul.": ".$row1->num." шт * ".$item_price_grn." = ".($row1->num * $item_price_grn)." грн.<br />";

                    	//$total_sum += $row1->num * $item_price;
                    	$total_sum += $row1->num * $item_price_grn;
                    	$order_numitems += $row1->num;
                    }
                    mysqli_free_result($res1);
                }
                else
                	echo mysqli_error($upd_link_db);

				$order_cost = $total_sum;

				$delivery_str = "";
				switch( $row->delivery_id)
				{
					case 2:
						$delivery_str = "Дост";
						break;
					default:
						$delivery_str = "Сам";
						break;
				}


				$Ccity = "";	//stripslashes($row->client_city);

				echo "<tr>
                     	<td><input type=\"checkbox\" name=\"items_id[]\" value=\"".$row->id."\" /></td>
                     	<td class=\"c\"><a href=\"$PHP_SELF?item_id=".$row->id."&action=edit\">".(10000 + $row->id)."</a></td>
                     	<td class=\"c\">".$row->dtcr."<br />".$row->tmcr."</td>
                     	<td>".$order_summary."</td>
                     	<td class=\"c\">".$order_numitems."</td>
                     	<td class=\"r\">".$order_cost."  грн.</td>
                     	<td class=\"c\">".$delivery_str."</td>
                     	<td class=\"c\">".$buyer['city']."</td>
                     	<td>".$buyer['name']."<br />Тел.: ".$buyer['phone'].($buyer['email'] != "" ? "<br />E-mail: <a href=\"mailto:".$buyer['email']."\">".$buyer['email']."</a>" : "")."</td>
                     	<td class=\"c\">".$payment_status[$row->payment_status]."</td>
                        <td class=\"c\">".$order_status[$row->order_status]."</td>
                        <td>
                        	<a href=\"$PHP_SELF?item_id=".$row->id."&action=edit\"><img src=\"img/edit.gif\" alt=\"Редактировать\" border=\"0\" /></a>&nbsp;
                        	<a href=\"$PHP_SELF?item_id=".$row->id."&action=delete\"><img src=\"img/delete.gif\" alt=\"Пометить как ложный\" border=\"0\" /></a>
                        </td>
                     </tr>
                     <tr><td colspan=\"12\" bgcolor=\"#EEEEEE\"><img src=\"spacer.gif\" width=\"1\" height=\"1\" alt=\"\" /></td></tr>";
            }
            mysqli_free_result($res);
		}
?>
         <tr><td align="center" colspan="12"><input type="submit" name="delete_but" value=" Отметить как ложные " /></td></tr>
    </form>
    </table>
<?php
    }
    include("inc/footer-inc.php");

    include("../inc/close-inc.php");
?>
