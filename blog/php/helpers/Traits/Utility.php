<?php

namespace Helpers\Traits;

trait Utility {
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
    return null;
  }
}