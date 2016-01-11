<?php

namespace Helpers\Traits;

trait Property {
  public function context($key=null) {
    if (is_null($key)) {
      return $this->context;
    } else if (array_key_exists($key, $this->context)) {
      return $this->context[$key];
    } else {
      return null;
    }
  }

  public function config($key=null) {
    static $config = null;
    if (is_null($config)) {
      $config = yaml_parse_file('app/config/app.yml');
    }
    if (is_null($key)) {
      return $config;
    } else if (array_key_exists($key, $config)) {
      return $config[$key];
    } else {
      return null;
    }
  }

  private function router() {
    static $router = null;
    if (is_null($router)) {
      $router = new \Router(yaml_parse_file('app/config/routes.yml'));
    }
    return $router;
  }

  public function meta($key) {
    static $meta = null;
    if (is_null($meta)) {
      $meta = yaml_parse_file('content/web.yml');
    }

    return $meta[$key];
  }
}