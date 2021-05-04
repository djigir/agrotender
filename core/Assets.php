<?php
namespace Core;

class Assets {
  /**
   * Получить хэш на основе последнего изменения файла
   * @param $file
   * @return string
   */
  private static function getVersion($file) {
    return md5(time());
  }

  /**
   * Ссылка на js-файл с версией файла
   * @param $file
   * @return string
   */
  public static function getjsVersion($file, $link, $params = []) {
    if ($params != []) {
      $str = '';
      foreach ($params as $key => $value) {
        $str .= ' '.$key.'="'.$value.'"';
      }
      return '<script type="text/javascript" src="' . $link . '?v=' . self::getVersion($file) . '"'.$str.'></script>';
    }
    return '<script type="text/javascript" src="' . $link . '?v=' . self::getVersion($file) . '"></script>';
  }

  /**
   * Ссылка на css-файл с версией файла
   * @param $file
   * @return string
   */
  public static function getcssVersion($file, $link, $params = []) {
    if ($params != []) {
      $str = '';
      foreach ($params as $key => $value) {
        $str .= ' '.$key.'="'.$value.'"';
      }
      return '<link rel="stylesheet" href="' . $link . '?v=' . self::getVersion($file) . '"'.$str.' type="text/css" />';
    }
    return '<link rel="stylesheet" href="' . $link . '?v=' . self::getVersion($file) . '" type="text/css" />';
  }

  public static function set($arr) {
    $html = '';
    foreach ($arr as $key => $value) {
      foreach ($value as $file) {
        if (is_array($file)) {
          $params = $file['params'];
          $file = $file['file'];
        } else {
          $params = [];
        }
        $type =  substr(strrchr($file, '.'), 1);
        if (isPage == $key or $key == explode('/', isPage)[0] or preg_match('/'.str_replace("/","\/", $key).'/i', isPage)) {
          $link = "/app/assets/{$type}/{$file}";
          if ( substr($file, 0, 8) == 'https://' ) {
            $link = $file;
          }
          $typeGet = "get{$type}Version";
          $html .= self::$typeGet(app_path . "assets/{$type}/{$file}", $link, $params)."\n\t";
        }
      }
    }
    return trim($html, "\n\t");
  }

}
