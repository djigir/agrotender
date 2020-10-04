<?php
namespace Core;

class View {
  
  /**
   * Data to display
   * @var array
   */
  private $data;
  private $smarty;

  public function __construct() { 
    // new Smarty class object
    $this->smarty = new \SmartyBC;
    $this->smarty->error_reporting = E_ALL & ~E_NOTICE;
  }

  public function setTitle(string $title):self {
    $this->data['title'] = $title;
    return $this;
  }

  public function setDescription(string $description):self {
    $this->data['description'] = $description;
    return $this;
  }

  public function setKeywords(string $keywords):self {
    $this->data['keywords'] = $keywords;
    return $this;
  }

  public function setHeader(array $files):self {
    $this->setComponent($files, 'header');
    return $this;
  }

  public function setFooter(array $files):self {
    $this->setComponent($files, 'footer');
    return $this;
  }

  /**
   * We get html-code for inserting scripts
   * @param $file
   * @return string
   */
  public function getjsVersion($file, $link, $params = []) {
    $numStr = uniqid();
    if ($params != []) {
      $str = '';
      foreach ($params as $key => $value) {
        $str .= ' '.$key.'="'.$value.'"';
      }
      return '<script type="text/javascript" src="' . $link.'"></script>';
    }
    return '<script type="text/javascript" src="' . $link .'?v='.$numStr.'" class="script"></script>';
  }

  /**
   * We get the html-code to insert the stylesheet
   * @param $file
   * @return string
   */
  public function getcssVersion($file, $link, $params = []) {
    $numStr = uniqid();
    if ($params != []) {
      $str = '';
      foreach ($params as $key => $value) {
        $str .= ' '.$key.'="'.$value.'"';
      }
      return '<link rel="stylesheet" href="' . $link.'" type="text/css"/>';
    }
    return '<link rel="stylesheet" href="' . $link.'?t='.$numStr.'" type="text/css"/>';
  }

  /**
   * Inserting Components (.css | .js)
   * @param $arr Files array
   * @param $to  Subject to insert component (footer | header)
   * @return void
   */
  public function setComponent($arr, $to) {
    if (!isset($this->data[$to])) {
      $this->data[$to] = '';
    }
    if (mb_strlen($this->data[$to]) > 0) {
      $this->data[$to] .= "\n\t";
    }

    $html = '';
    foreach ($arr as $key => $value) {
      foreach ($value as $file) {
        $type =  substr(strrchr($file, '.'), 1);
        $pos = strpos($type, "?");
        if ($this->data['page'] == $key or $key == explode('/', $this->data['page'])[0] or preg_match('/'.str_replace("/","\/", $key).'/i', $this->data['page']) or is_int($key)) {
          $link = (substr($file, 0, 8) == 'https://') ? $file : "/app/assets/{$type}/{$file}";
          $typeGet = "get{$type}Version";
          $html .= $this->$typeGet(PATH['app'] . "assets/{$type}/{$file}", $link)."\n\t";
        }
      }
    }
    $this->data[$to] .= $html;
  }

  /**
   * Set data to global data array
   *
   * @param array $data Data array
   *
   * @return self
   */
  public function setData(array $data):self {
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        $this->data[$key] = $value;
      }
    }
    return $this;
  }

  /**
   * Get data from global data array
   *
   * @param array $data Data array
   *
   * @return self
   */
  public function getData() {
  	return array_merge($this->data);
  }

  public function fetch($template, $args = [], $onlyPage = false) {
    
    $fileTpl = PATH['app'] . "views/{$template}.tpl";
    if (!is_readable($fileTpl)) {
      throw new Fail("Template \"{$template}\" not found.");
    } 


    // Smarty properties
    $this->smarty->template_dir = PATH['app'] . 'views/'; // папка с шаблонами
    $this->smarty->compile_dir  = PATH['app'] . 'views_compile/'; // папка с компилированными шаблонами
    $this->smarty->cache_dir    = PATH['cache']; // папка для хранения кэша

    // Data variable
    $data = $this->getData();

    // Send the data to the template
    foreach ($data as $key => $value) {
      $this->smarty->assign($key, $value); 
    }

    // Код шаблона - Smarty
    $output = '';
    $output = $this->smarty->fetch($fileTpl);

    return $output;
  }

  /**
   * Displaying a view with Smarty
   *
   * @param string $template View template
   *
   * @return void
   */
  public function display($template, $onlyPage = false, $cache = false) {
    
    $fileTpl = PATH['app'] . "views/{$template}.tpl";
    if (!is_readable($fileTpl)) {
      throw new Fail("Template \"{$template}\" not found.");
    } 



    // Smarty properties
    $this->smarty->template_dir = PATH['app'] . 'views/'; // папка с шаблонами
    $this->smarty->compile_dir  = PATH['app'] . 'views_compile/'; // папка с компилированными шаблонами
    $this->smarty->cache_dir    = PATH['cache']; // папка для хранения кэша
    $this->smarty->caching      = $cache; // включение(true)/выключение(false) кэша

    // Data variable
    $data = $this->getData();

    // Send the data to the template
    foreach ($data as $key => $value) {
      $this->smarty->assign($key, $value); 
    }

    // Prefix to display (_header & _footer) template
    $prefix = ($onlyPage) ? null : (isset(explode('/', $template)[0])) ? explode('/', $template)[0] . '/' : '';
    // Display template
    if ($prefix) $this->smarty->display(PATH['app'] . "views/{$prefix}_header.tpl");
    $this->smarty->display($fileTpl);
    if ($prefix) $this->smarty->display(PATH['app'] . "views/{$prefix}_footer.tpl");
  }

}