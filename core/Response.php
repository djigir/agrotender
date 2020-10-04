<?php 
namespace Core;

class Response {

  private static $instance;

  private $headers = [];
  private $responseCode = 200;
  private $body;

  private $httpCodes = [
    100 => 'Continue',
    101 => 'Switching Protocols',
    102 => 'Processing',            // RFC2518
    103 => 'Early Hints',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    207 => 'Multi-Status',          // RFC4918
    208 => 'Already Reported',      // RFC5842
    226 => 'IM Used',               // RFC3229
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    308 => 'Permanent Redirect',    // RFC7238
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Payload Too Large',
    414 => 'URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Range Not Satisfiable',
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot',                                               // RFC2324
    421 => 'Misdirected Request',                                         // RFC7540
    422 => 'Unprocessable Entity',                                        // RFC4918
    423 => 'Locked',                                                      // RFC4918
    424 => 'Failed Dependency',                                           // RFC4918
    425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
    426 => 'Upgrade Required',                                            // RFC2817
    428 => 'Precondition Required',                                       // RFC6585
    429 => 'Too Many Requests',                                           // RFC6585
    431 => 'Request Header Fields Too Large',                             // RFC6585
    451 => 'Unavailable For Legal Reasons',                               // RFC7725
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates',                                     // RFC2295
    507 => 'Insufficient Storage',                                        // RFC4918
    508 => 'Loop Detected',                                               // RFC5842
    510 => 'Not Extended',                                                // RFC2774
    511 => 'Network Authentication Required',                             // RFC6585
  ];


  public function redirect($url, $responseCode = 301) {
    $this->setResponseCode($responseCode)->setHeaders("Location: $url")->send();
  }

  public function send() {
    header(sprintf('HTTP/%s %s %s', '1.1', $this->responseCode, $this->httpCodes[$this->responseCode]), true);
    foreach ($this->headers as $header) {
      header($header);
    }
    echo $this->body;
    exit;
  }

  public function ajax($text, $status = 0, $arr = []) {
    $response = ['code' => $status, 'text' => $text];
    if ($arr != []) {
      foreach ($arr as $key => $value) {
        $response[$key] = $value;
      }  
    }
    $this->setHeaders("")->setBody(json_encode($response))->send();
  }

  public function json($arr = []) {
    $response = [];
    if ($arr != []) {
      foreach ($arr as $key => $value) {
        $response[$key] = $value;
      }  
    }
    $this->setHeaders("")->setBody(json_encode($response, JSON_UNESCAPED_UNICODE))->send();
  }


  /**
   * Gets the value of headers.
   *
   * @return mixed
   */
  public function getHeaders() {
    return $this->headers;
  }

  /**
   * Sets the value of headers.
   *
   * @param mixed $headers the headers
   *
   * @return self
   */
  public function setHeaders($headers) {
    $this->headers[] = $headers;
    return $this;
  }

  /**
   * Gets the value of responseCode.
   *
   * @return mixed
   */
  public function getResponseCode() {
    return $this->responseCode;
  }

  /**
   * Sets the value of responseCode.
   *
   * @param mixed $responseCode the http response code
   *
   * @return self
   */
  public function setResponseCode($responseCode){
    $this->responseCode = $responseCode;
    return $this;
  }

  /**
   * Gets the value of body.
   *
   * @return mixed
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * Sets the value of body.
   *
   * @param mixed $body the body
   *
   * @return self
   */
  public function setBody($body) {
    $this->body = $body;
    return $this;
  }
}