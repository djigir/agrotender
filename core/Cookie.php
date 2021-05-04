<?php
namespace Core;
/**
 * 
 */
class Cookie {
	
  public function has($key) {
    return array_key_exists($key, $_COOKIE); 
  }
  
  public function get($key, $default = null) {
    return (self::has($key)) ? $_COOKIE[$key] : $default; 
  }

  public static function getOnce($key, $default = null) {
    $value = $this->get($key, $default);
    $this->delete($key);
    return $value;
}

  public function set($key, $value) {
    setcookie($key, $value, time() + 3600 * 24 * 365 * 999, '/', 'agrotender.com.ua', true, true);
  }

  public function delete($key) {
  	if (self::has($key)) {
  	  unset($_COOKIE[$key]);
      setcookie($key, '', time() - 3600, '/', 'agrotender.com.ua', true, true);
  	}
  }

}