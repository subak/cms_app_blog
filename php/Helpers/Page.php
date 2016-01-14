<?php

namespace Helpers;

class Page
{
  use Traits\View, Traits\Content;

  public function __construct($context) {
    self::page_context()->register(yaml_parse_file('app/config/app.yml'), 'app');
    self::page_context()->register(yaml_parse_file('content/web.yml'), 'content');
    self::page_context()->register($context, 'handler');
  }

  private function router() {
    static $router = null;
    if (is_null($router)) {
      $router = new \Router(yaml_parse_file('app/config/routes.yml'));
    }
    return $router;
  }

  static public function page_context($key=null, $scan_or_name=false) {
    static $context = null;
    if (is_null($context)) {
      $context = new \Context();
    }

    if (is_null($key)) {
      return $context;
    } else {
      return self::search_context($context, $key, $scan_or_name);
    }
  }

  static protected function search_context($context, $key, $scan_or_name=false) {
    if (is_string($scan_or_name)) {
      return $context->search($key, $scan_or_name);
    } else if ($scan_or_name) {
      return $context->scan($key);
    } else {
      return $context->search($key);
    }
  }

  public function context($key=null, $scan_or_name=false) {
    return self::page_context($key, $scan_or_name);
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