<?php

namespace Helpers;

class Entry extends Page
{
  use Traits\Entry;

  public function id() {
    return $this->context('id');
  }

  public function context($key=null, $desc=true, $multiple=false) {
    static $context = null;

    if (is_null($context)) {
      $context = $this->entry_context(parent::page_context()->get('id'));
    }

    if (is_null($key)) {
      return $context;
    } else {
      return $context->get($key, $desc, $multiple);
    }
  }

}
