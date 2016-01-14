<?php

namespace Helpers;

class Entry extends Page
{
  use Traits\Content, Traits\Entry;

  public function id() {
    return $this->context('id');
  }

  public function context($key=null, $scan_or_name=false) {
    static $context = null;
    if (is_null($context)) {
      $context = $this->entry_context(parent::page_context(),
        parent::page_context()->search('id'));
    }

    if (is_null($key)) {
      return $context;
    } else {
      return parent::search_context($context, $key, $scan_or_name);
    }
  }

  public function meta($key=null) {
    static $meta = null;
    if (is_null($meta)) {
      $id = $this->id();
      $path = "content/entry/${id}/${id}.yml";
      if (file_exists($path)) {
        $meta = yaml_parse_file($path);
      } else {
        $meta = array();
      }
    }

    return array_key_exists($key, $meta) ? $meta[$key] : parent::meta($key);
  }

}
