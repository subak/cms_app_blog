<?php

namespace Helpers\Traits;

trait URI {
  public function url_for($path) {
    return $this->meta('scheme').'://'.$this->meta('host').$path;
  }

  public function rel($path) {
    $level = substr_count($this->context('uri'), "/");
    $path = preg_replace('@^/@', './', $path);
    for ($i=1; $i < $level; $i++) {
      $path = '../'.$path;
    }
    return $path;
  }
}