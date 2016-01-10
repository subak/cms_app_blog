<?php

namespace Helpers\Traits;

trait Utility {
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