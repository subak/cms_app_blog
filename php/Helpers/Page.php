<?php

namespace Helpers;

class Page
{
  use Traits\View, Traits\Content;

  protected $stack=[];

  public function __construct($context) {
    self::page_context()->register(yaml_parse_file('app/config/meta.yml'), 'app');
    self::page_context()->register(yaml_parse_file('content/meta.yml'), 'content');
    self::page_context()->register($context, 'handler');
  }

  protected function push($name) {
    return array_push($this->stack, $name);
  }

  protected function pop() {
    return array_pop($this->stack);
  }

  protected function router() {
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

  public function include($name="include/") {
    static $current = null;
    $prefix = '';
    $suffix = '';

    if ('/' === $name[0]) {
      $name = ltrim($name, '/');
    } else if (!is_null($current)) {
      $prefix = preg_replace('@[^/]+$@', '', $current);
    }

    if ('/' === substr($name, -1)) {
      $suffix = '_'.ltrim(basename($current), '_');
    }

    $rel_path = join('/', array_filter([$prefix, $name])).$suffix;

    if ($path = stream_resolve_include_path($rel_path)) {
      $current = $rel_path;
      include($path);
      return null;
    } else {
      throw new \Exception($rel_path);
    }
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