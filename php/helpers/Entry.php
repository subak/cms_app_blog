<?php

namespace Helpers;

class Entry extends Page
{
  use Traits\Entry;

  private $id;

  public function __construct($context) {
    parent::__construct($context);
    $this->id = $this->context('id');
  }

  public function id() {
    return $this->id;
  }

  public function title() {
    static $title = null;
    if (is_null($title)) {
      $title = trim(entry_title($this->id));
    }
    return join(" | ", [$title, parent::title()]);
  }

  public function meta($key) {
    static $meta = null;
    if (is_null($meta)) {
      $path = entry_path($this->id, ".yml");
      if (file_exists($path)) {
        $meta = yaml_parse_file(entry_path($this->id, ".yml"));
      } else {
        $meta = array();
      }
    }

    return array_key_exists($key, $meta) ? $meta[$key] : parent::meta($key);
  }
}
