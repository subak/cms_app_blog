<?php

namespace Helpers;

class Page
{
  use Traits\View, Traits\Content;

  public function __construct($context) {
    self::page_context()->register(yaml_parse_file('app/config/meta.yml'), 'app');
    self::page_context()->register(yaml_parse_file('content/meta.yml'), 'content');
    self::page_context()->register($context, 'handler');
  }

  private function router() {
    static $router = null;
    if (is_null($router)) {
      $router = new \Router(yaml_parse_file('app/config/routes.yml'));
    }
    return $router;
  }

  static public function page_context() {
    static $context = null;
    if (is_null($context)) {
      $context = new \Context();
    }
    return $context;
  }

  public function context($key=null, $desc=true, $multiple=false) {
    if (is_null($key)) {
      return self::page_context();
    } else {
      return self::page_context()->get($key, $desc, $multiple);
    }
  }

  public function render() {
    include 'views/'.preg_replace('@^/@', '', $this->context('view'));
  }

  public function content($dir=null) {
    $view = $this->context('view');

    if (is_null($dir)) {
      $dir = $this->context('content_include_dir');
    }
    $dir = '/'.trim($dir, '/').'/';

    if (is_null($this->context('main'))) {
      $path = dirname($view).$dir.basename($view);
    } else {
      $path = dirname($view).$dir.$this->context('main');
    }

    if ($path = stream_resolve_include_path('views/'.$path)) {
      include $path;
    }
    return null;
  }

  protected function is_dir($uri) {
    return substr($uri, -1) === '/';
  }
}