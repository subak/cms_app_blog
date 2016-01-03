<?php

namespace Helpers;

class Page
{
  use Traits\View, Traits\URI, Traits\Utility, Traits\Property;

  protected $context;

  public function __construct($context) {
    $this->context = $context;
  }

  public function title() {
    return call_user_func(array($this, '\Helpers\Page::meta'), 'title');
  }

  public function site_name() {
    return self::meta('title');
  }

  public function render() {
    include 'views/'.preg_replace('@^/@', '', $this->context('view'));
  }

  public function content($dir=null) {
    $view = $this->context('view');

    if (is_null($dir)) {
      $dir = $this->config('content_include_dir');
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