<?php
    //define("LOG_RAW_STRING", true);
	define("LOG_RAW_STRING", false);
    
    // implements IUhClient
    class UniSender extends UhCpClient
    {
        private $apiKey = "";
        private $username = "";
        private $message = [];
        private $recipients  = "";
        private $body = "";


        private $hostUrl = 'https://one.unisender.com';
        private $requestMethod = CPMETHOD_POST;

		private $uniError = "";
        private $uniResult = "";
        
        private $imgPath = UNI_WWWHOST."img/";
        private $tplPath = UNI_TPL_DIR."tpl/";
        private $baseTplName = "base_tpl.html";

        private $tplNamesToFiles = array(
            "registration" => "registration.tpl",
            "certificate_of_completion" => "certificate_of_completion.tpl",
            "password_reset" => "password_reset.tpl",
            "congratulations_on_activation" => "congratulations_on_activation.tpl",
			"login_change" => "login_change.tpl",
            "replenishment_of_funds" => "replenishment_of_funds.tpl",            
            "open_account" => "open_account.tpl",
			"doc_newadded" => "doc_newadded.tpl",
            "company_create" => "company_create.tpl",
            "new_offer" => "new_offer.tpl",
            "service_activation" => "service_activation.tpl",
            "ad_ap" => "ad_ap.tpl",
            "ad_deactivated" => "ad_deactivated.tpl",
            "moderator_approved" => "moderator_approved.tpl",
            "pack_expiration" => "pack_expiration.tpl",
            "service_expiration" => "service_expiration.tpl",
            "moderator_not_approved" => "moderator_not_approved.tpl",
            "limit_exceeding" => "limit_exceeding.tpl",
            "ad_accomodation" => "ad_accomodation.tpl",
            "pack_expiration_warning" => "pack_expiration_warning.tpl",
            "traiders_subscription_expiration" => "traiders_subscription_expiration.tpl",
            "traiders_subscription" => "traiders_subscription.tpl",            
            "force_change_password" => "force_change_password.tpl", 
        );

        function __construct($apiKey, $username, $reqType = CPREQ_CURL, $lang = UNI_LANG_RU)
        {
            $this->apiKey = $apiKey;
            $this->username = $username;
            $this->hostUrl = $this->_prepare_url($lang);
            $this->uniResult = array();
            $this->uniError = array();
            parent::__construct($this->hostUrl, $reqType, REQENCODING_UTF8);
        }

        public function setUserInfo($subject, $fromEmail, $fromName)
        {
            $this->message["subject"] = $subject;
            $this->message["from_email"] = $fromEmail;
            $this->message["from_name"] = $fromName;
        }

        public function addRecipient($email, $name)
        {
            if( empty($this->message["recipients"]) || !is_array($this->message["recipients"]))
            {
                $this->message["recipients"] = array();
            }
            array_push(
                $this->message["recipients"], 
                array(
                    "email" => $email,	//"xknavemail@gmail.com",
                    "substitutions" => array(
                        "to_name" => $name	//"Roman",
                    )
                )
            );
        }

        public function hcp_SetRequestMethod($requestMethod)
        {
            $this->requestMethod = $requestMethod;
        }
        
        // Ошибка представляет из себя массив, содержащий имя функции и
        // полученное сообщение об ошибке.
        private function _set_last_error($funcName, $errCode = '', $errMsg = '')
        {
            $this->uniError = array('function'  => $funcName,
                                    'code'      => $errCode,
                                    'message'   => $errMsg,
            );
        }

        private function _prepare_url($lang)
		{
            $url = $this->hostUrl.'/'.$lang."/transactional/api/v1/";
            return $url;
        }

		public function getLastError()
		{
			return $this->uniError;
        }
        
        // Результат тоже можно было бы сделать массивом, содержащим
        // имя функции и сам результат, для большей информативности
        private function _set_uni_result($result)
        {
			$this->uniResult = $result;
        }
		
		public function getUniResult()
		{
			return $this->uniResult;
        }
        
        private function _images_inline_convert($img)
		{
            $attach = array();
            foreach ($img as $row)
            {
                $attach[] = array(
                    "type" => "image/png",
                    "name" => $row, //pathinfo( $row, PATHINFO_FILENAME),
                    "content" => base64_encode(file_get_contents($this->imgPath.$row)),
                );
            }

			return $attach;
		}
         
        private function _set_result_and_error($response, $method)
        {
            $result = '';
            $errorResponse = '';
            $success = true;

            $parsedResult = json_decode($response, true);

            if ($parsedResult['status'] == "error")
            {
                $this->_set_last_error($method, $parsedResult['code'], $parsedResult['message']);
                $success = false;
            }
            else
            {
                $result = $parsedResult;
            }

            $this->_set_uni_result($result);          

            return $success;
        }
        
        // Подготавливает массив параметров для запроса
        //    $params - Массив параметров в формате Array("name" => "val", "name2" => "val2")
		private function _prepare_reqparams($params)
		{
            $params['api_key'] = $this->apiKey;

            //$uhCpReqPar = new UhCpReqParams();
            //$uhCpReqPar->addParamsArr($params);
            //$query = $uhCpReqPar->getHttpQuery();

            $query = json_encode($params);
            return $query;
		}

        private function _log_add($funcResult, $funcName)
        {

        }
		
		private function _run_action($reqpars, $objmethod, $funcRequest = '')
		{
            $this->setUrl($this->hostUrl.$funcRequest);

			$query = $this->_prepare_reqparams($reqpars);
			
			$response = $this->sendRequest($this->requestMethod, $query);
			$this->_log_add($response, $objmethod);  
			$success = $this->_set_result_and_error($response, $objmethod);
			
			return $success;
		}

        /*---------- Общие действия по аккаунту ----------*/

        public function us_balanceCheck($username)
        {
            $request = "balance.json"; 

            $reqpars = array(
                "username" => $username,
            );
 
			return $this->_run_action($reqpars, __METHOD__, $request);
        }

        public function us_mailSend($img = null) //$username, $message, $body, $recipients, 
        {
            $request = "email/send.json";

            if($img)
            {
                $this->message["inline_attachments"] = $this->_images_inline_convert($img);
            }
            
            $reqpars = array(
                "username"  => $this->username,
                "message"   => $this->message,
            );
 
			return $this->_run_action($reqpars, __METHOD__, $request);
        }

        public function buildHtmlMail($title, $tpl_name, $data)
        {
            $ml = $this->_get_base_tpl();
            $ml_body = $this->_get_html_body_tpl($tpl_name, $data);

            $content = array(
                "{MAIN_MAIL_TITLE}" => $title,
                "{MAIN_MAIL_BODY}"  => $ml_body,
            );
            $this->message["body"]["html"] = $this->_set_base_tpl_content($ml, $content);
        }

        private function _set_base_tpl_content($ml, $content)
        {
            $html = strtr($ml, $content);
            return $html;
        }

        private function _body_data_get_vals($bodyData)
        {
			//echo "!!!<br>bodyData<br>";
			//var_dump($bodyData);
			//echo "<br>!!!<br>";
			
            $varsArr = array();
            foreach($bodyData as $data_key => $data_val)
            {
                if(strpos($data_key, "{ARR_") === false)
                {
                    $varsArr[$data_key] = $data_val;
                }
            }
            return $varsArr;
        }

        private function _body_data_get_tpl_arrs($bodyData)
        {
            $tplArrsArr = array();
            foreach($bodyData as $data_key => $data_val)
            {
                if(strpos($data_key, "{ARR_TPL_") !== false)
                {
                    $tplArrsArr[$data_key] = $data_val;
                }
            }
            return $tplArrsArr;
        }

        private function _body_data_get_txt_arrs($bodyData)
        {
            $txtArrsArr = array();
            foreach($bodyData as $data_key => $data_val)
            {
                if(strpos($data_key, "{ARR_TXT_") !== false)
                {
                    $txtArrsArr[$data_key] = $data_val;
                }
            }
            return $txtArrsArr;
        }

        private function _get_html_body_tpl($tpl_name, $data)
        {
            $body_tpl = file_get_contents($this->tplPath.$this->tplNamesToFiles[$tpl_name]);

            $data = $this->_chek_for_txt_array($data);
            $body_tpl = $this->_chek_for_tpl_array($body_tpl, $data);

            $varsArr = $this->_body_data_get_vals($data);
            $varsArr = array_merge($varsArr, $this->_body_data_get_txt_arrs($data));
            $body_tpl = strtr($body_tpl, $varsArr);

            return $body_tpl;
        }

        private function _chek_for_txt_array($data)
        {
            $txtArrsArr = $this->_body_data_get_txt_arrs($data);
            foreach($txtArrsArr as $key => $value)
            {
                $joinedStr = "";
                foreach($value as $str)
                {
                    $joinedStr .= $str."<br>";
                }
                $data[$key] = $joinedStr;
            }
            return $data;
        }

        // Очень сложный (наверное?) для понимания метод, который парсит теги
        // массивов для повторяющейся верстки.
        // Все, что находится внутри переменной-тега {ARR_TPL_[название]} будет
        // дублироваться и заполняться значениями для каждой переменной этого массива
        private function _chek_for_tpl_array($body_tpl, $data)
        {
            $newBodyTpl = $body_tpl;
            $tplArrsArr = $this->_body_data_get_tpl_arrs($data);
			
            foreach($tplArrsArr as $key => $val)
            {           
                $end_key = str_replace("{", "{/", $key);
                $end_preg_key = str_replace("{", "{\/", $key);
                $arr_tpl_preg = "/".$key."[\s\S]*".$end_preg_key."/";
                preg_match($arr_tpl_preg, $body_tpl, $matches);
                if(!isset($matches[0]))
                {
                    return $newBodyTpl;
                }
                $newTpl = "";
				if( $val === FALSE )
				{
					// Skip empty
				}
				else
				{
					foreach($val as $arrInVal)
					{
						$varsArr = $this->_body_data_get_vals($arrInVal);
						$newOneTpl = strtr($matches[0], $varsArr);
						$newOneTpl = str_replace($key, "", $newOneTpl);
						$newOneTpl = trim(str_replace($end_key, "", $newOneTpl))."\n";

						// Если прдставить структуру вложенных тегов как дерово (хотя бы попытайтесь)
						// то здесь реализован медот поиска вглубину. 
						$newOneTpl = $this->_chek_for_tpl_array($newOneTpl, $arrInVal);
						$newTpl .= $newOneTpl;
					}
				}
                $newBodyTpl = str_replace($matches[0], $newTpl, $body_tpl);
            }    
            return $newBodyTpl;
        }

        private function _get_base_tpl()
        {
            return file_get_contents($this->tplPath.$this->baseTplName);
        }
    }
?> 