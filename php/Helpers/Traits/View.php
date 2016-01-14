<?php

namespace Helpers\Traits;

trait View {
  protected function attr($array) {
    $attributes = array();
    foreach ($array as $name => $value) {
      if (is_array($value)) {
        $value = join(" ", $value);
      }
      $attributes[] = "${name}=\"${value}\"";
    }
    $attr = empty($attributes) ? "" : " ".join(" ", $attributes);
    return $attr;
  }

  public function tag($tag, $content=null, $option=array(), $args=array()) {
    $tags = array('br','img','hr','meta','input','embed','area','base','col','keygen','link','param','source');

    if (is_array($content)) {
      $attr = $this->attr($content);
      $content = "";
    } else if (is_object($content) && is_callable($content)) {
      $attr = $this->attr($option);
      ob_start();
      echo "<${tag}${attr}>";
      $content($args);
      echo "</${tag}>";
      $content = ob_get_clean();
    } else {
      $attr = $this->attr($option);
    }

    if (in_array($tag, $tags)) {
      return "<${tag}${attr}>";
    } else {
      return "<${tag}${attr}>${content}</${tag}>";
    }
  }

  public function link_to($content, $path, $option=array(), $args=array()) {
    $option['href'] = $this->rel($path);

    if ( $this->context('local') ) {
      $context = $this->router()->detect($path);
      if ($this->is_dir($context['uri'])) {
        $option['href'] .= 'index.html';
      }
    }

    return $this->tag('a', $content, $option, $args);
  }

  public function url_for($path) {
    return $this->context('scheme').'://'.$this->context('host').$path;
  }

  public function rel($path) {
    $level = substr_count($this->context('uri'), "/");
    $path = preg_replace('@^/@', './', $path);
    for ($i=1; $i < $level; $i++) {
      $path = '../'.$path;
    }
    return $path;
  }

  public function each($array, $closure, $tag=null, $args=[]) {
    if ($array) {
      ob_start();
      if ($tag) {
        echo "<$tag>";
      }
      foreach ($array as $key => $value) {
        $closure($key, $value, $args);
      }
      if ($tag) {
        echo "</$tag>";
      }
      return ob_get_clean();
    }
    return null;
  }
}