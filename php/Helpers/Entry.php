<?php

namespace Helpers;

class Entry extends Page
{
  use Traits\Entry;

  public function id() {
    $id = $this->context('id');
    if (is_null($id)) {
      $uri = $this->context('uri');
      throw new \Exception("id(uri: ${uri})");
    }
    return $id;
  }

  public function context($key=null, $desc=true, $multiple=false) {
    static $context = null;

    if (is_null($context)) {
      $context = $this->entry_context(parent::page_context()->get('id'));
      if(!$context->get_by_name('title', 'entry')) {
        $context->set('title', $this->entry_title($context->get('id')), 'entry');
      }
    }

    if (is_null($key)) {
      return $context;
    } else {
      return $context->get($key, $desc, $multiple);
    }
  }

}
