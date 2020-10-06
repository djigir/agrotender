<?php
/**
  * Weelinc - A PHP Framework for Creators
  *
  * @package  Weelinc
  * @author   Nikita Loginov <vujin@weelinc.com>
  */
 // Defines constant


//var_dump($_SERVER['REQUEST_URI']);die();
if(strripos($_SERVER['REQUEST_URI'],'/traders' )===0 || strripos($_SERVER['REQUEST_URI'],'/kompanii' )===0){
    include_once "laravel/public/index.php";
    die();
}

setlocale(LC_ALL, 'russian');
date_default_timezone_set("Europe/Kiev");
define('developer_mode', true);
define('weelinc_start', microtime(true));
define('PATH', [
  'root'     => __DIR__,
  'invoices' => __DIR__.'/billdocs/',
  'vendor'   => __DIR__.'/vendor/',
  'app'      => __DIR__.'/app/',
  'core'     => __DIR__.'/core/',
  'pics'     => __DIR__.'/pics/',
  'upload'   => __DIR__.'/app/uploads/',
  'locales'  => __DIR__.'/app/locales/',
  'cache'    => __DIR__.'/app/cache/'
]);

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}
if ($ip != '109.86.1.55') {
  // die;
}

// Autoloader
require_once PATH['vendor'] . 'autoload.php';

// Error and exception handlers
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Start session
session_start();

// fix server variable
if ( !isset($_SERVER['SCRIPT_URL']) ) $_SERVER['SCRIPT_URL'] = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));

// Instance & run Engine
$engine = new Core\Engine();
$engine->run();
