<?php
namespace Core;

class Route {

  public $routeArray = [];

  private $host;
  private $matcher;
  private $generator;
  private $matcherCacheFile;
  private $generatorCacheFile;

  private $page;
  private $controller;
  private $parameters = [];
  private $method;

  private $methods = [
    'GET',
    'POST',
    'PUT',
    'DELETE',
    'HEAD',
    'EMPTY'
  ];

  private $routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => [],
    'PATCH' => [],
    'HEAD' => [],
    'EMPTY' => []
  ];

  private $patterns = [
    'num' => '[0-9]+',
    'str' => '[a-zA-Z\.\-_%]+',
    'any' => '[a-zA-Z0-9\.\-_%]+'
  ];

  public function __construct($host = null) {
    $this->host = $host;
  }
  public function add($rules) {
    foreach ($rules as $rule) {
      $this->routeArray[$rule[0]] = [
        'pattern' => $rule[1],
        'controller' => $rule[2],
        'method' => $rule[3] ?? 'GET'
      ];
    }
  }
  /**
   * @param $method
   * @param $uri
   * @return MatchedRoute
   */
  public function matchedRoute($method, $uri) {
    foreach ($this->routeArray as $key => $route) {
      $this->register($key, $route['method'], $route['pattern'], $route['controller']);
    }
    return $this->match($method, $uri);
  }

  public function setHost($host) {
    $this->host = $host;
    if ($this->generator) {
      $this->generator->setHost($host);
    }
  }

   public function register($page, $method, $route, $controller) {
    $methods = strtoupper($method);
    if (false !== strpos($methods, '|')) {
      $methods = explode('|', $methods);
    }
    if ($methods == '*') {
      $methods = $this->methods;
    }
    $methods   = (array) $methods;
    $converted = $this->convertRoute($route);
    foreach ($methods as $m) {
      $this->routes[$m][$converted] = [$page, $controller];
    }
  }

  private function convertRoute($route) {
    if (false === strpos($route, '(')) {
      return $route;
    }
    if (preg_match('#^/\((\w+):(\w+):\?\)$#', $route)) {
      throw new \InvalidArgumentException(sprintf('Prefix required when use optional placeholder in route "%s"', $route));
    }
    $parse = preg_replace_callback('#/\((\w+):(\w+):\?\)$#', array(
      $this,
      'replaceOptionalRoute'
    ), $route);
    return preg_replace_callback('#\((\w+):(\w+)\)#', array(
      $this,
      'replaceRoute'
    ), $parse);
  }
  private function replaceOptionalRoute($match) {
    $name    = $match[1];
    $pattern = $match[2];
    return '(?:/(?<' . $name . '>' . strtr($pattern, $this->patterns) . '))?';
  }
  private function replaceRoute($match) {
    $name    = $match[1];
    $pattern = $match[2];
    return '(?<' . $name . '>' . strtr($pattern, $this->patterns) . ')';
  }
  /**
   * @param $method
   * @param $uri
   * @return MatchedRoute
   */
  public function match($method, $uri) {
    $method            = strtoupper($method);
    $route             = $this->doMatch($method, $uri);
    if ($route != null)
      return $route;
    if ($method == 'GET')
      $this->tryFindUrlToRedirect($uri);
  }
  /**
   * Try find similar url, e.g.
   *   /blog/ -> /blog if /blog exists
   *   /blog -> /blog/ if /blog/ exists
   * @param $uri
   */
  private function tryFindUrlToRedirect($uri) {
    $tmpUri = $uri . '/';
    if (substr($uri, -1) === '/')
      $tmpUri = rtrim($uri, '/');
    $route = $this->doMatch('GET', $tmpUri);
    if ($route) {
      (new Response)->redirect($tmpUri, 301);
      exit;
    }
  }
  private function routes($method) {
    return isset($this->routes[$method]) ? $this->routes[$method] : [];
  }
  private function doMatch($method, $uri) {
    $routes = $this->routes($method);
    if (array_key_exists($uri, $routes)) {
      $this->page       = $routes[$uri][0];
      $this->controller = $routes[$uri][1];
      $this->method     = $method;
      return $this;
    }
    foreach ($routes as $route => $arr) {
      if (false !== strpos($route, '(')) {
        $pattern = '#^' . $route . '$#s';
        //print_r(preg_match($pattern, $uri, $parameters)); die();
        if (preg_match($pattern, $uri, $parameters)) {
          $this->page       = $arr[0];
          $this->controller = $arr[1];
          $this->method     = $method;
          $this->parameters = $this->processParameters($parameters);
          return $this;
        }
      }
    }
  }
  private function processParameters($parameters) {
    foreach ($parameters as $k => $v) {
      if (is_int($k)) {
        unset($parameters[$k]);
      }
    }
    return $parameters;
  }
  public function getPage() {
    return $this->page;
  }

  public function getController() {
    return $this->controller;
  }

  public function getParameters() {
    return $this->parameters;
  }

  public function getMethod() {
    return $this->method;
  }
}
