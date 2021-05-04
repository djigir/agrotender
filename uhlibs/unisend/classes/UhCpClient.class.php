<?php	
	class UhCpClient {
		private $url;
		private $req_type;
		private $encode;
		private $req_result = '';
		
		private $debug_on = true;
		private $debug_path = __DIR__."/../log/isp_log.txt";
		
		function __construct($url, $reqType = CPREQ_CURL, $encode = REQENCODING_UTF8) 
		{
			$this->url = $url;
			$this->req_type = $reqType;
			$this->encode = $encode;
        }
		
		protected function setDebugMode($isDebug = false)
        {
            $this->debug_on = $isDebug;
        }
		
		protected function getDebugMode()
        {
            return $this->debug_on;
        }
		
		protected function setDebugFile($path = "log/isp_log.txt")
		{
            $this->debug_path = $path;
        }
		
		protected function getDebugFile()
		{
            return $this->debug_path;
        }
        
        protected function setRequestType($req = CPREQ_CURL)
        {
            $this->req_type = $req;
        }
        
        protected function setEncoding($encod = REQENCODING_UTF8)
        {
            $this->encode = $encod;
        }
		
		protected function getResponse() 
		{
			return $this->req_result;
		} 

		private function _headers_arr_to_str($headers)
		{
			$str = "";
			if(is_array($headers))
			{
				foreach($headers as $val)
				{
					$str .= $val."\r\n";
				}
			}
			return $str;
		}

		private function _get_customrequest_url($method)
		{
			$subUrl = substr($this->url, strrpos($this->url, ':') + 5);
			$preparedHeader = $method.' '.$subUrl.' HTTP/1.1';
			return $preparedHeader;
		}

		protected function setUrl($url)
		{
			$this->url = $url;
		}
		
		protected function sendRequest($method = CPMETHOD_POST, $params = '', $additionalHeaders = array()) 
		{
			if($this->_send_request($method, $params, $additionalHeaders)) 
			{
				return $this->getResponse();
			}
			return false;
		}

		private function _send_request($method, $params, $additionalHeaders) 
		{	
			//Формирование заголовков запроса
			$headers = array();
			//$headers[] = $this->_get_customrequest_url($method);
			$headers = array_merge($headers, $additionalHeaders);

			//Проверка наличия в headers Content-Type
			$areHeadersContaionContType = false;
			foreach($headers as $header)
			{
				if( strpos(strtolower($header), 'content-type:') !== false )
				{
					$areHeadersContaionContType = true;
					break;
				}
			}
			if( !$areHeadersContaionContType )
			{
				$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset='.$this->encode;
			}

			$headers[] = 'Connection: Close';
			//$headers = $this->_headers_arr_to_str($headers);

            $result = true;
			
            if(strtolower($this->req_type) == CPREQ_FCONT)
            {
                $response = $this->_send_fgc($params, $headers, $method);
            }
            else
            {
				//$headers = $this->_get_customrequest_url($method)."\r\n".$headers;
                $response = $this->_send_curl($params, $headers, $method);
            }
			
			if ($response === false) {
				$result = false;
			}
			else 
			{
				$this->req_result = $response;
			}
			
            return $result;
		}

		private function _send_curl($params, $headers, $method) 
		{
			$curl = curl_init();
			$url = $this->url;

			if (strtoupper($method) === CPMETHOD_POST) 
			{
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			}
			else 
			{
				if ($params > 0 )
				{
					$url = $url.'?'.$params;
				}
			}

			//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $headers);

			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			
			curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  
			curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, FALSE);  

			//curl_setopt ($curl, CURLINFO_HEADER_OUT, true);			
			$response = curl_exec($curl);
			//$curlInfo = curl_getinfo($curl);
			
			curl_close($curl);
			return $response;
		}
		
		private function _send_fgc($params, $headers, $method) 
		{		
			$url = $this->url;	
		
			$opts = array(
						'http' => array(
							'protocol_version' => '1.1',
							'method' => $method,
							'header' => $headers,		
						),
						'ssl' => array(
							'verify_peer' => false,
							'verify_peer_name' => false,
						),
			);
			
			if (strtoupper($method) === CPMETHOD_POST) 
			{
				$opts['http']['content'] = $params;
			}
			else 
			{
				$url = $url.'?'.$params;
			}
			
			$context = stream_context_create($opts);			
			$response = file_get_contents($url, null, $context);
			
			return $response;
		}
	}
?>