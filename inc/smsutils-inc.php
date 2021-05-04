<?php
////////////////////////////////////////////////////////////////////////////////
// Global sms gate config
$SMS_SEND_ORDEROK = 0;
$SMS_SEND_ORDERDELIV = 1;
$SMS_SEND_ORDERPRIVAT = 2;
$SMS_SEND_CONFIRMCODE = 5;
$SMS_SEND_TEST = 10;
//$SMS_SEND_TTN = 3;

$sms_sender_reg = "Agrotender";

$sms_host = "atompark.com";
$sms_login = "id.agrotender@gmail.com";
$sms_pass = "Kpc-tB8-D37-rjj";
$sms_path = "members/sms/xml.php";

$sms = new SmsAPI( $sms_host, $sms_login, $sms_pass, $sms_path );

function SmsLogDb($uid, $phone, $msg, $type, $orderid=0)
{
	global $TABLE_SMS_SEND;

	$query = "INSERT INTO $TABLE_SMS_SEND (manager_id, order_id, act_id, add_date, ip, phone, msg) VALUES
		('".$uid."', '".$orderid."', '".$type."', NOW(), '".$_SERVER['REMOTE_ADDR']."', '".addslashes($phone)."', '".addslashes($msg)."')";
	if( !mysqli_query($upd_link_db,  $query ) )
	{
		//echo mysqli_error($upd_link_db);
		debugMysql();
	}
}

function SmsReqNum($phone, $type)
{
	global $TABLE_SMS_SEND;
	
	$totnum = 0;
	
	$actid = sprintf("%d", $type);
	
	$query = "SELECT count(id) as totnum 
		FROM $TABLE_SMS_SEND 
		WHERE DATE(add_date)=CURDATE() AND phone='".addslashes($phone)."' AND act_id='".$actid."' AND ip='".$_SERVER['REMOTE_ADDR']."' ";		
	if( $res = mysqli_query($upd_link_db, $query) )
	{
		if( $row = mysqli_fetch_object($res) )
		{
			$totnum = $row->totnum;
		}
		mysqli_free_result($res);
	}
	else
		debugMysql();
	
	return $totnum;
}

function SmsGenCode($digitnum=6)
{
	//$codechartbl = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "D", "F", "G", "I", "J", "K", "L", "N", "Q", "R", "S", "U", "W", "Y", "Z"); // 27 chars
	$codechartbl = Array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9"); // 27 chars
	
	$outcode = "";
	
	for($i=0; $i<$digitnum; $i++)
	{
		//$dig = rand(0, 26);
		$dig = rand(0, 9);
		$outcode .= $codechartbl[$dig];
	}
	
	return $outcode;
}

function Sms_Send($msg, $phone)
{
	global $WWWNAMEEN, $sms_sender_reg, $sms, $sms_host, $sms_login, $sms_pass, $sms_path;
	if( $sms )
	{
		//$phone = "+380675767230";
		$sender = $sms_sender_reg;	//$WWWNAMEEN;
		$msg = $msg; //"Тестовое сообщение ".date("d.m.Y H:i", time());

		$pars = Array();
		$pars['sender'] = $sender;
		$pars['msg'] = $msg;

		$phones = Array();
		$phones[] = $phone;
		$pars['phones'] = $phones;

		$res = $sms->sendRequest("send", $pars);

		//echo $res."!!<br />";
		if( $sms->request_status >= 0 )
		{
			//echo "<br />OK<br />";
			return true;
		}
	}

	return false;
}


class SmsAPI
{
	var $host;
	var $login;
	var $password;
	var $path;
	var $url;

	var $tmp_res;

	var $request_status;

	var $headers = Array();

	// Class contractor
 	function SmsAPI($p_host, $p_login, $p_password, $p_path = "")
 	{
 		$this->host = $p_host;
 		$this->path = $p_path;
 		$this->login = $p_login;
 		$this->password = $p_password;

 		$this->tmp_res = "";
 		$this->request_status = "ok";

 		// Make web-service script url
 		//$this->url = "https://" . $p_host . ":8443" . $p_path;
 		$this->url = "http://atompark.com/members/sms/xml.php";

 		// Make request headers array for SSL access
 		$this->headers = array(
			"HTTP_AUTH_LOGIN: " . $this->login,
			"HTTP_AUTH_PASSWD: " . $this->password,
			"HTTP_PRETTY_PRINT: TRUE",
			"Content-Type: text/xml, charset=windows-1251", );
 	}

	///////////////////////////////////////////////////////////////////////////
	// Sends SMS API Request
	function sendRequest( $cmd, $params, $debug=false )
	{
		//echo "!!!";
		// Make request body
		switch($cmd)
		{
			case "send":
				//$request_str = $this->builder_GetDomainInfo( "oktja.eu" );
				$request_str = $this->builder_SendSms( $params['sender'], $params['msg'], $params['phones'], $params );
				break;

			case "getprice":
				$request_str = $this->builder_SendSmsPrice( $params['sender'], $params['msg'], $params['phones'], $params );
				break;

			case "getstatus":
				//$request_str = $this->builder_GetDomainsForClient( $params );
				$request_str = $this->builder_GetSmsStatus( $params['MsgIds'], $params );
				break;

			case "balance":
				//$request_str = $this->builder_CreateMailAccount( 10, "test_tolik", "tolik" );
				//$request_str = $this->builder_CreateMailAccount( $params['domain_id'], $params['account_name'], $params['account_pass'], $params );
				$request_str = $this->builder_GetBalance( $params );
				break;

			case "creditprice":
				$request_str = $this->builder_GetCreditPrice( $params );
				break;

   			default:
   				return;
		}
		
		//echo $request_str."<br>";

		if( $debug )
			echo $request_str."<br />";

		$request_str = '<?xml version="1.0" encoding="UTF-8"?>'.$request_str;
		$request_str = iconv("cp1251", "UTF-8", $request_str);

		//echo $request_str."<br />";
		//echo strlen($request_str)."<br />";

		// Build correct HTTP header for SSL access
		$request_headers = Array();
		for( $i=0; $i<count($this->headers); $i++ )
		{
			$request_headers[$i] = $this->headers[$i];
		}
		$request_headers[$i] = "Content-Length: ".strlen($request_str);

		//var_dump($request_headers);

		// Initialize the curl engine
		$ch = curl_init();

		// Set the curl options
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// this line makes it work under https
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		// make the curl to return value result but not to ouput stream
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// Set the URL to be processed
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_str);

		//echo "<br />".$this->url."<br />";
		//echo "<br />$request_str<br />";

		$result = curl_exec($ch);
		if (curl_errno($ch))
		{
			echo "\n\n-------------------------\n" . "cURL error number:" . curl_errno($ch);
			echo "\n\ncURL error:" . curl_error($ch);
		}
		curl_close($ch);

		if( $debug )
			echo "<br />+++++++++++++++<br />".$result."<br />+++++++++++++++++++++++<br />";

		$this->tmp_res = $result;

		// check the status
		$status = strtolower("OK");
		$status_s = strpos( $this->tmp_res, "<status>" );
  		if( $status_s > 0 )
  		{
  			$status_e = strpos( $this->tmp_res, "</status>", $status_s + strlen("<status>") );

			$status = strtolower( substr( $this->tmp_res, $status_s + strlen("<status>"), $status_e - $status_s - strlen("<status>") ) );
  		}

  		$this->request_status = $status;

  		if( $status != "ok" )
  		{
  			$this->getErrorMessage(null);
  		}

		// Make request body
		switch($cmd)
		{

			case "send":
				break;

			case "getprice":
				$sendprice = $this->parser_SendSmsPrice( $result );
				return $sendprice;

			case "getstatus":
				$statuslist = $this->parser_SmsStatus( $result );
				return $statuslist;

			case "balance":
				$balance = $this->parser_Balance( $result );
				return $balance;

			case "creditprice":
				$crpr = $this->parser_CreditPrice( $result );
				return $crpr;

			case "getmailaccount":
				$mailboxinfo = $this->parser_MailboxInfo( $result );
				return $mailboxinfo;
		}

		return $result;
	}

	function getErrorMessage($translate_err)
	{
		$use_redefine = ($translate_err != null);

  		// now we should find internal error code
  		if( $this->request_status == "ok" )
  			return "";

		$errcode = $this->parser_getTagValue( $this->tmp_res, "errcode" );
  		$errtext = $this->parser_getTagValue( $this->tmp_res, "errtext" );

		if( $use_redefine )
		{
			if( isset( $translate_err[$errcode] ) )
			{
				$errtext = $translate_err[$errcode];
			}
		}
  		//echo "Plesk Service Error: Returned code = $errcode; Message = $errtext<br />";
  		return $errtext;
	}

	function getErrorCode()
	{
		// now we should find internal error code
  		if( $this->request_status == "ok" )
  			return "";

		$errcode = $this->parser_getTagValue( $this->tmp_res, "errcode" );

		return $errcode;
	}

	function parser_getTagValue( $xml_data, $tag_name )
	{
		if( $tag_name == "" )
			return "";

		$tag_name_start = "<".$tag_name.">";
		$tag_name_end = "</".$tag_name.">";

		$tag_value = "";

		$value_s = strpos( $xml_data, $tag_name_start );
  		if( $value_s > 0 )
  		{
  			$value_e = strpos( $xml_data, $tag_name_end, $value_s + strlen($tag_name_start) );

			if( $value_e > $value_s )
			{
				$tag_value = substr( $xml_data, $value_s + strlen($tag_name_start), $value_e - $value_s - strlen($tag_name_start) );
			}
  		}

		return $tag_value;
	}

	function parser_SendSmsPrice( $xmldata )
	{
		$sendpriceres = 0;

		return $sendpriceres;
	}

	function parser_SmsStatus( $xmldata )
	{
		$stat = Array();

		return $stat;
	}

	function parser_Balance( $xmldata )
	{
		$balance = 0;

		return $balance;
	}

	function parser_CreditPrice( $xmldata )
	{
		$crprice = 0;

		return $crprice;
	}

	function parser_MailboxInfo( $xmldata )
	{
		//echo "<br />-----------------<br />".$xmldata."<br />------------------<br />";

		$cur_pos = 0;

		// Parse all data
		// Get mailbox id value
   		$id_st_pos = strpos( $xmldata, "<id>" );
   		$id_en_pos = strpos( $xmldata, "</id>" );

   		$box_id = substr( $xmldata, $id_st_pos+4, ($id_en_pos - $id_st_pos - 4) );

		// Get mailbox name value
   		$name_st_pos = strpos( $xmldata, "<name>" );
   		$name_en_pos = strpos( $xmldata, "</name>" );

   		$box_name = substr( $xmldata, $name_st_pos+6, ($name_en_pos - $name_st_pos - 6) );

   		$boxinfo = Array();
   		$boxinfo['id'] = $box_id;
   		$boxinfo['name'] = $box_name;
   		$boxinfo['enabled'] = (true == $box_enabled);
   		$boxinfo['quota'] = $box_quota;
   		$boxinfo['antivir'] = $box_antivir;
   		$boxinfo['password'] = $box_password;

     	return $boxinfo;
	}

	///////////////////////////////////////////////////////
	// Sms request builing routins
	function builder_SendSms( $sender, $msg, $phones, $pars )
	{
		$rq = '<SMS>
	<operations>
		<operation>SEND</operation>
	</operations>
	<authentification>
		<username>'.$this->login.'</username>
		<password>'.$this->password.'</password>
	</authentification>
	<message>
		<sender>'.$sender.'</sender>
		<text><![CDATA['.$msg.']]></text>
	</message>
	<numbers>';
		for( $i=0; $i<count($phones); $i++ )
		{
			$rq .= '<number>'.$phones[$i].'</number>';
			//<number  messageID="msg12"  variables="var1;var2;var3;"></number>
		}
		$rq .= '</numbers>
</SMS>';
		return $rq;
	}

	function builder_SendSmsPrice( $sender, $msg, $phones, $pars )
	{
		$rq = '<SMS>
	<operations>
		<operation>GETPRICE</operation>
	</operations>
	<authentification>
		<username>'.$this->login.'</username>
		<password>'.$this->password.'</password>
	</authentification>
	<message>
		<sender>'.$sender.'</sender>
		<text><![CDATA['.$msg.']]></text>
	</message>
	<numbers>';
		for( $i=0; $i<count($phones); $i++ )
		{
			$rq .= '<number>'.$phones[$i].'</number>';
			//<number  messageID="msg12"  variables="var1;var2;var3;"></number>
		}
		$rq .= '</numbers>
</SMS>';
		return $rq;
	}

	function builder_GetSmsStatus( $msgIds, $pars )
	{
		$rq = '<SMS>
	<operations>
		<operation>GETSTATUS</operation>
	</operations>
	<authentification>
		<username>'.$this->login.'</username>
		<password>'.$this->password.'</password>
	</authentification>
	<statistics>';
		for( $i=0; $i<count($msgIds); $i++ )
		{
			$rq .= '<messageid>'.$msgIds[$i].'</messageid>';
		}
		$rq .= '</statistics>
</SMS>';
		return $rq;
	}

	function builder_GetBalance( $pars )
	{
		$rq = '<SMS>
	<operations>
		<operation>BALANCE</operation>
	</operations>
	<authentification>
		<username>'.$this->login.'</username>
		<password>'.$this->password.'</password>
	</authentification>
</SMS>';
		return $rq;
	}

	function builder_GetCreditPrice( $pars )
	{
		$rq = '<SMS>
	<operations>
		<operation>CREDITPRICE</operation>
	</operations>
	<authentification>
		<username>'.$this->login.'</username>
		<password>'.$this->password.'</password>
	</authentification>
</SMS>';
		return $rq;
	}

} // end class

function Sms_SendConfirmCode($codestr, $phone)
{
	global $UserId, $SMS_SEND_CONFIRMCODE, $txt_res;

	$msg = $txt_res['smsconfirmcode']['text'];
	$msg = str_replace("{TPL_COMFIRMCODE}", $codestr, $msg);			
	SmsLogDb($UserId, $phone, $msg, $SMS_SEND_CONFIRMCODE, 0);
	$res = Sms_Send($msg, $phone);

	return $res;
}

function Sms_SendOrderOk($order_num, $phone)
{
	global $UserId, $SMS_SEND_ORDEROK, $txt_res;

	//$msg = "Spasibo za vash zakaz #".$order_id.". V techenii neskolkih minut menedger scagetsya s vami";
	//$msg = "Спасибо за Ваш заказ №".$order_id.". Мы свяжемся с Вами в ближайшее время.";
	$msg = $txt_res['smsorderdone']['text'];
	$msg = str_replace("{ORDERNUM}", $order_num, $msg);			
	SmsLogDb($UserId, $phone, $msg, $SMS_SEND_ORDEROK, Make_OrderIdFromNum($order_num));
	$res = Sms_Send($msg, $phone);

	return $res;
}

function Sms_SendTtn($order_id, $ttnnum, $dtstr, $phone)
{
	global $UserId, $SMS_SEND_ORDERDELIV, $txt_res;

	//$msg = "Spasibo za vash zakaz #".$order_id.". V techenii neskolkih minut menedger scagetsya s vami";
	$msg = $txt_res['smsttn']['text'];
	$msg = str_replace("{TTNNUM}", $ttnnum, $msg);
	$msg = str_replace("{DELIVDT}", $dtstr, $msg);
	//$msg = $ttnnum." Расчетная дата прибытия заказа: ".$dtstr." ";
	SmsLogDb($UserId, $phone, $msg, $SMS_SEND_ORDERDELIV, $order_id);	//($order_id-10000));
	$res = Sms_Send($msg, $phone);

	return $res;
}

function Sms_SendCardPrivate($order_id, $amount, $phone)
{
	global $UserId, $SMS_SEND_ORDERPRIVAT, $PREFS, $txt_res;

	//$msg = "Spasibo za vash zakaz #".$order_id.". V techenii neskolkih minut menedger scagetsya s vami";	
	//$msg = $PREFS['CARDPRIVAT']." Сумма ".$amount." грн.";
	$msg = $txt_res['smsprivatcard']['text'];
	$msg = str_replace("{ORDERSUM}", $amount, $msg);
	SmsLogDb($UserId, $phone, $msg, $SMS_SEND_ORDERPRIVAT, $order_id);	//($order_id-10000));
	$res = Sms_Send($msg, $phone);

	return $res;
}

function Sms_SendTest($msg0, $phone)
{
	global $UserId, $SMS_SEND_TEST;

	//$msg = "Spasibo za vash zakaz #".$order_id.". V techenii neskolkih minut menedger scagetsya s vami";
	$msg = $msg0; 
	SmsLogDb($UserId, $phone, $msg, $SMS_SEND_TEST, 0);
	$res = Sms_Send($msg, $phone, true);

	return $res;
}
?>
