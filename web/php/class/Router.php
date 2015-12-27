<?php

class Router
{
  private $routes;

  public function __construct($routes)
  {
    $this->routes = $routes;
  }

  public function detect($uri) {
    $context = null;

    foreach ($this->routes as $route) {
      $ptn = "@${route['route']}@";

      if (preg_match($ptn, $uri, $matches)) {
        foreach ( $matches as $key => $val ) {
          if (is_string($key)) {
            $route[$key] = $val;
          }
        }
        $context = $route;
        break;
      }
    }

    return $context;
  }
}
