<?php

class Page
{
  protected $context;

  public function __construct($context) {
    $this->context = $context;
  }

  public function context($key=null) {
    if (is_null($key)) {
      return $this->context;
    } else {
      return $this->context[$key];
    }
  }

  public function title() {
    return call_user_func(array($this, 'Page::meta'), 'title');
  }

  public function site_name() {
    return self::meta('title');
  }

  public function content() {
    return "";
  }

  protected function wrap($tag, $text) {
    return "<$tag>".$text."</$tag>";
  }

  public function render() {
    include $this->context('path');
  }

  public function each($array, $closure, $tag=null) {
    if ($array) {
      ob_start();
      if ($tag) {
        echo "<$tag>";
      }
      foreach ($array as $key => $value) {
        $closure($key, $value);
      }
      if ($tag) {
        echo "</$tag>";
      }
      return ob_get_clean();
    }
    return "";
  }

  public function tag($tag, $content=null, $option=array()) {
    $tags = array('br','img','hr','meta','input','embed','area','base','col','keygen','link','param','source');

    if (is_array($content)) {
      $attr = attr($content);
      $content = "";
    } else if (is_object($content) && is_callable($content)) {
      $attr = attr($option);
      ob_start();
      echo "<${tag}${attr}>";
      $content();
      echo "</${tag}>";
      $content = ob_get_clean();
    } else {
      $attr = attr($option);
    }

    if (in_array($tag, $tags)) {
      return "<${tag}${attr}>";
    } else {
      return "<${tag}${attr}>${content}</${tag}>";
    }
  }

  public function link_to($content, $path, $option=array()) {
    $option['href'] = $this->rel($path);
    return $this->tag('a', $content, $option);
  }

  public function url_for($path) {
    return $this->meta('scheme').'://'.$this->meta('host').$path;
  }

  public function rel($path) {
    $level = substr_count($this->context('uri'), "/");
    $path = preg_replace('@^/@', '', $path);
    for ($i=1; $i < $level; $i++) {
      $path = '../'.$path;
    }
    return $path;
  }

  public function meta($key) {
    static $meta = null;
    if (is_null($meta)) {
      //$meta = json_decode(`yaml2json web/site.yml`, true);
      $meta = yaml_parse_file('web/site.yml');
    }

    return $meta[$key];
  }
}