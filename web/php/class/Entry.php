<?php

class Entry extends Page
{
  private $id;

  public function __construct($context) {
    parent::__construct($context);
    $this->id = $this->query('id');
  }

  public function title() {
    static $title = null;
    if (is_null($title)) {
      $title = entry_title($this->id);
    }
    return join(" | ", [parent::title(), $title]);
  }

  public function content() {
    include 'web/html/include/entry.html';
  }

  public function meta($key) {
    static $meta = null;
    if (is_null($meta)) {
      $meta = yaml_parse_file(entry_path($this->id, ".yml"));
    }

    return array_key_exists($key, $meta) ? $meta[$key] : parent::meta($key);
  }
}
