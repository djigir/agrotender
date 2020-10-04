<?php
namespace Core;
/**
 * 
 */
class Session {
	
  public function has($key) {
    return array_key_exists($key, $_SESSION); 
  }
  
  public function get($key, $default = null) {
    return (self::has($key)) ? $_SESSION[$key] : $default; 
  }

  public function getOnce($key, $default = null) {
    $value = $this->get($key, $default);
    $this->delete($key);
    return $value;
  }

  public function set($key, $value) {
    $_SESSION[$key] = $value;
  }

  public function delete($key) {
  	if (self::has($key)) {
  	  unset($_SESSION[$key]);
  	}
  }

}