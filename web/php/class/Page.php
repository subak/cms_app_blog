<?php

class Page
{
  protected $context;
  protected $query;
  protected $meta;
  protected $content;
  protected $title = array();

  public function __construct($context) {
    $this->context = $context;
    parse_str($context['query'], $query);
    $this->query = $query;
    $this->meta = yaml_parse_file('web/site.meta.yml');
    array_push($this->title, $this->meta['title']);
  }

  public function title($glue = ' | ') {
    return $this->wrap('title', implode($glue, array_reverse($this->title)));
  }

  public function site_name() {
    return $this->meta['title'];
  }

  public function content() {
    return $this->content;
  }

  protected function wrap($tag, $text) {
    return "<$tag>".$text."</$tag>";
  }

  public function include($path) {
    include $path;
  }

  public function render() {
    include $this->context['path'];
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

  // 単一の閉じタグ
  // $contentがarrayの時
  public function tag($tag, $content=null, $option=array()) {

    $tags = array('br','img','hr','meta','input','embed','area','base','col','keygen','link','param','source');

    if (is_array($content)) {
      $attr = attr($content);
      $content = "";
      //return "<${tag}${attr}>";
    } else if (is_object($content) && is_callable($content)) {
      $attr = attr($option);
      ob_start();
      echo "<${tag}${attr}>";
      $content();
      echo "</${tag}>";
      $content = ob_get_clean();
      //return ob_get_clean();
    } else {
      $attr = attr($option);
      //return "<${tag}${attr}>${content}</${tag}>";
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

  public function rel($path) {
    $level = substr_count($this->query['uri'], "/");
    $path = preg_replace('@^/@', '', $path);
    for ($i=1; $i < $level; $i++) {
      $path = '../'.$path;
    }
    return $path;
  }

  public function uri() {
    return $this->query['uri'];
  }

  public function meta($key) {
    return $this->meta[$key];
  }

  public function query($key) {
    return $this->query[$key];
  }
}