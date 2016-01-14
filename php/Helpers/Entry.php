<?php

namespace Helpers;

class Entry extends Page
{
  use Traits\Entry;

  public function id() {
    return $this->context('id');
  }

  public function context($key=null, $scan_or_name=false) {
    static $context = null;

    if (is_null($context)) {
      $context = $this->entry_context(parent::page_context()->search('id'));
    }

    if (is_null($key)) {
      return $context;
    } else {
      return parent::search_context($context, $key, $scan_or_name);
    }
  }

}
