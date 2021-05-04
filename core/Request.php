<?php
namespace Core;
/**
 *
 */
class Request {

  public function isPost() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  public function getMethod() {
  	$method =  $_SERVER['REQUEST_METHOD'];
    if (self::isPost()) {
      if (isset($_SERVER['X-HTTP-METHOD-OVERRIDE'])) {
        $method = strtoupper($_SERVER['X-HTTP-METHOD-OVERRIDE']);
      }
    }
    return $method;
  }

  public  function isHttps() {
    return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
  }

  public static function getHttpHost() {
    $host = $this->isHttps() ? 'https://' : 'http://';
    $host .= $this->getHost();
    return $host;
  }

  public function getHost() {
    $host = $_SERVER['HTTP_HOST'];
    $host = strtolower(preg_replace('/:\d+$/', '', trim($host)));
    if ($host && !preg_match('/^\[?(?:[a-zA-Z0-9-:\]_]+\.?)+$/', $host)) {
      throw new \UnexpectedValueException(sprintf("Invalid Host \"{$host}\""));
    }

    return $host;
  }

  public function getPathInfo($baseUrl = null) {
    $pathInfo = $_SERVER['REQUEST_URI'] ?? '/';
    $schemeAndHttpHost = $this->isHttps() ? 'https://' : 'http://';
    $schemeAndHttpHost .= $_SERVER['HTTP_HOST'];
    if (strpos($pathInfo, $schemeAndHttpHost) === 0) {
      $pathInfo = substr($pathInfo, strlen($schemeAndHttpHost));
    }
    if ($pos = strpos($pathInfo, '?')) {
      $pathInfo = substr($pathInfo, 0, $pos);
    }
    if (null != $baseUrl) {
      $pathInfo = substr($pathInfo, strlen($baseUrl));
    }
    return $pathInfo;
  }

  public function __get($variable) {

    switch ($variable) {
      // Variables to process requests
      case 'post':
        return $_POST;
        break;

      case 'get':
        return $_GET;
        break;

      case 'request':
        return $_REQUEST;
        break;

      case 'files':
        return $_FILES;
        break;

      default:
        if (property_exists($this, $variable)) {
          return $this->$variable;
        } else {
          throw new Fail("The \"{$variable}\" variable does not exist");
        }
        break;
    }
  }

}
