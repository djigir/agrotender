<?php

namespace Core;

use \PDO;
use \PDOException;
use Core\Fail;

class Db {

  public $db; // handle of the db connetion
  private static $instance;
//  public static $host = 'idl-mysql-01';
//  public static $db_name = 'agrotend';
//  public static $user = 'agrotend';
//  public static $password = 'vA7tMkl6Tk680qtsfNYl';
  public static $host = 'localhost';
  public static $db_name = 'agrotender';
  public static $user = 'root';
  public static $password = 'root';



  public function __construct() {
    // building data source name from config
    $dsn = 'mysql:host='.static::$host.';dbname='.static::$db_name.';port=3306;connect_timeout=25';
    $this->db = new \PDO($dsn, static::$user, static::$password);
    $this->db->query('set sql_mode=""');
    $this->db->query('set names utf8');
    $this->db->query("set time_zone='".date('P')."';");
    // russian date
    $this->db->query("set lc_time_names = 'ru_RU'");
    $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
    $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, 1);
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      $object = __CLASS__;
      self::$instance = new $object;
    }
    return self::$instance;
  }

  public function query($query) {
    $sth = self::getInstance()->db->prepare($query);
    if ($sth->execute()) {
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } else {
      return false;
    }
  }

  public function insert($table, array $data, $dataKeys = [], $dataValues = []) {
    $dataPreValues = [];
    foreach ($data as $key => $value) {
      $dataKeys[] = "`$key`";
      if (strpos($value, '()') === false ) {
        $dataPreValues[] = "?";
        $dataValues[] = htmlentities($value);
      } else {
        $dataPreValues[] = "$value";
      }
    }

    $strKeys = implode(', ', $dataKeys);
    $strValues = implode(',', $dataPreValues);
    $query = "insert into $table ($strKeys) values ($strValues)";
    $sth = self::getInstance()->db->prepare($query);

    if ($sth->execute($dataValues)) {
      return true;
    } else {
      return false;
    }
  }

  public function select($table, $select = '*', $condition = null, $dataValues = []) {
    if (is_array($select)) {
      $select = implode(',', $select);
    }
    $condition_str = null; // where <предикат>

    if ($condition != null) { 
      foreach ($condition as $key => $value) {
        $dataValues[] = $value;
        $condition_str[] = "`$key` = ?"; // (array) $condition to (array) $condition_str -> `имя поля` = 'значение'
      }
      $condition_str = implode(" && ", $condition_str); // (array) $condition_str to (string) $condition_str, separating: ' and '
    } 

    // формируем запрос: select from $table (where условие)
    $query = "select $select from $table ";
    $query .= ($condition == null) ? "" : " where $condition_str";
    $sth = self::getInstance()->db->prepare($query);
    if ($sth->execute($dataValues)) {
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } else {
      return false;
    }

  }
  public function update($table, $set = null, $condition = null, $dataValues = []) {

    $value_str     = null; // set <присваивание>
    $condition_str = null; // where <предикат>


    foreach ($set as $key => $value) {
      if ($value == null) {
        $value_str[] = "`$key` = null";
      } else {
        if (strpos($value, '()') === false ) {
          $dataValues[] = $value;
          $value = "?";
        } else {
          $value = "$value";
        }
        // (array) $value to (array) $value_str -> `имя поля` = 'значение'
        $value_str[] = "`$key` = $value"; 
      }
    }
     
    $value_str = "set ".implode(", ", $value_str); // (array) $value_str to (string) $value_str, separating: ', '
    if ($condition != null) { 
      foreach ($condition as $key => $value) {
        $condition_str[] = "`$key` = ?"; // (array) $condition to (array) $condition_str -> `имя поля` = 'значение'
        $dataValues[] = $value;
      }
      $condition_str = implode(" and ", $condition_str); // (array) $condition_str to (string) $condition_str, separating: ' and '
    } 

    // формируем запрос: update $table set key = value (where условие)
    $query = "update $table ";
    $query .= $value_str;
    $query .= ($condition == null) ? "" : " where $condition_str";
    $sth = self::getInstance()->db->prepare($query);
    if ($sth->execute($dataValues)) {
      return true;
    } else {
      print_r($sth->errorInfo()); exit;
    }

  }

  public function delete($table, $condition = null) {

    $condition_str = []; // where <предикат>
    $dataValues    = [];

    if ($condition != null) { 
      foreach ($condition as $key => $value) {
        $dataValues[] = $value;
        $condition_str[] = "`$key` = ?"; // (array) $condition to (array) $condition_str -> `имя поля` = 'значение'
      }
      $condition_str = implode(" && ", $condition_str); // (array) $condition_str to (string) $condition_str, separating: ' and '
    } 

    // формируем запрос: update $table set key = value (where условие)
    $query = "delete from $table ";
    $query .= ($condition == null) ? "" : " where $condition_str";

    $sth = self::getInstance()->db->prepare($query);
    if ($sth->execute($dataValues)) {
      return true;
    } else {
      return false;
      // return $sth->errorInfo()[2];
    }

  }

  public function getLastId() {
    $stmt = self::getInstance()->db->query("SELECT LAST_INSERT_ID()");
    $lastId = $stmt->fetch(PDO::FETCH_NUM);
    return $lastId[0];
  }


  public static function destruct() {
    self::getInstance()->db = null;
  }

}
?>