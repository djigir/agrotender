<?php    

	define("REQENCODING_UTF8", "utf-8");
	
	define("CPREQ_CURL", "curl");
	define("CPREQ_FCONT", "file_get_contents");
	
	define("CPMETHOD_POST", "POST");
	define("CPMETHOD_GET", "GET");
	
	define("UNI_LANG_RU", "ru");
	define("UNI_LANG_EN", "en");
	
	define("UNI_TPL_DIR", __DIR__."/../");
	define("UNI_WWWHOST", "https://agrotender.com.ua/");
	
	define("UNI_API_LOGIN", "aleksey.zin@gmail.com");
	define("UNI_API_KEY", "6c968576637qepoo9mkyffnjqdqrdbshqby4dyao");
	
	define("MAIL_TPL_REGCOMFIRM","registration");
	define("MAIL_TPL_REGCOMPLETE","certificate_of_completion");
	define("MAIL_TPL_PASSRESTORE","password_reset");
	define("MAIL_TPL_ACTIVATE_DONE","congratulations_on_activation");
	define("MAIL_TPL_LOGIN_CHANGE","login_change");
	define("MAIL_TPL_PAYMENT_RECV","replenishment_of_funds");	
	define("MAIL_TPL_PAYBILL","open_account");
	define("MAIL_TPL_PAYDOCS","doc_newadded");
	define("MAIL_TPL_COMPANY_CREATE","company_create");
	define("MAIL_TPL_MSNGR_NEW_OFFER","new_offer");	
	define("MAIL_TPL_ADV_NEW","ad_accomodation");
	define("MAIL_TPL_ADV_UP", "ad_ap");
	define("MAIL_TPL_ADV_DEACT","ad_deactivated");
	define("MAIL_TPL_ADV_LIMIT_EXCEED","limit_exceeding");	
	define("MAIL_TPL_ADV_SERV_ACTIVATE","service_activation");
	define("MAIL_TPL_ADV_SERV_EXPIRE","service_expiration");
	define("MAIL_TPL_LIMIT_PACK_EXPIRE","pack_expiration");
	define("MAIL_TPL_LIMIT_PACK_EXPIRE_WARN","pack_expiration_warning");	
	define("MAIL_TPL_MODER_APPROVE","moderator_approved");		
	define("MAIL_TPL_MODER_NOT_APPROVE","moderator_not_approved");		
	define("MAIL_TPL_TRADER_EXPIRE","traiders_subscription_expiration");
	define("MAIL_TPL_TRADER_SUBSCRIBE","traiders_subscription");
	

	
    function clsAutoLoad ($clsName){
        include_once __DIR__."/../classes/".$clsName.".class.php";
    }
    spl_autoload_register("clsAutoLoad");
	
	
	//////////////////////////////////////////////////////////////////////////////////
	// Function for use
	function Send_UniSenderMail($to, $toname, $subject, $mail_tpl, $data)
	{
		// Send mail through unisender
		$uniSender = new UniSender(UNI_API_KEY, UNI_API_LOGIN);
		//$uniSender->setUserInfo("Agrotender Portal", "info@agrotender.com.ua", "Agro Tender");
		$uniSender->setUserInfo($subject, "info@agrotender.com.ua", "Agro Tender");
		$uniSender->addRecipient($to, $toname);
		
		/*
		$body_data = array(
			"{URL_SIGNUP}" => $WWWHOST."activate.php?action=act&guid=".$guid_act_account,	//"http://example.com",
			"{FULL_NAME}" => iconv("CP1251", "UTF-8", $buyername),
		);		
		//$body = $uniSender->buildHtmlMail("registration", "registration", $body_data);
		$body = $uniSender->buildHtmlMail("registration", MAIL_TPL_REGISTER, $body_data);
		*/
		$body = $uniSender->buildHtmlMail($mail_tpl, $mail_tpl, $data);
		
		//echo "<Br>!!!!!!!!!<br><pre>".$body."</pre><br>!!!!!!!!!!!!<br>";		
		//return;
		
		
		$success = $uniSender->us_mailSend(); //$username, $message, $body, $recipients
		if ($success)
		{
			$result = $uniSender->getUniResult();
		}
		else
		{
			$result = $uniSender->getLastError();
		}
		print_r($result['status']);
	}
	
?>
