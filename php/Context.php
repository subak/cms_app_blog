<?php

class Context
{
  private $stack;

  public function __construct($stack=[]) {
    $this->stack = $stack;
  }

  public function scan($key) {
    $values = [];
    foreach ( array_reverse($this->stack) as $obj) {
      $value = $this->filter($key, $obj['context']);
      if (!is_null($value)) {
        $values[] = $value;
      }
    }
    return $values;
  }

  public function search($key, $name=null) {
    if (is_null($name)) {
      $value = null;
      foreach ( array_reverse($this->stack) as $obj) {
        $value = $this->filter($key, $obj['context']);
        if (!is_null($value)) {
          break;
        }
      }
      return $value;
    } else {
      if ($index = $this->find_stack($name)) {
        return $this->filter($key,$this->stack[$index]['context']);
      } else {
        return null;
      }
    }
  }

  private function find_stack($name) {
    $index = array_search($name, array_column($this->stack, 'name'));
    if (array_key_exists($index, $this->stack)) {
      return $index;
    } else {
      return null;
    }
  }

  private function filter($key, $context) {
    $value = null;
    $path = preg_replace('@\.([^.]+)@', "['\\1']", '.'.ltrim($key, '.'));

    try {
      eval('$value=$context'.$path.';');
    } catch(Exception $e) {

    }

    return $value;
  }

  public function get() {
    return $this->stack;
  }

  public function set($stack) {
    $this->stack = $stack;
  }

  public function register($context, $name, $prepend=false) {
    $func = $prepend ? 'array_unshift' : 'array_push';
    $func($this->stack, ['context' => $context, 'name' => $name]);
  }

  public function unregister($name) {
    if ($index = $this->find_stack($name)) {
      $context = $this->stack[$index]['context'];
      unset($this->stack[$index]);
      return $context;
    } else {
      return null;
    }
  }

  public function pop() {
    array_pop($this->stack);
  }

  public function insert_before($ref, $context, $name) {
    $index = $this->find_stack($ref);
    if (is_int($index)) {
      $this->splice($index, $context, $name);
    } else {
      throw new Exception();
    }
  }

  public function insert_after($ref, $context, $name) {
    $index = $this->find_stack($ref);
    if (is_int($index)) {
      $this->splice($index + 1, $context, $name);
    } else {
      throw new Exception();
    }
  }

  private function splice($index, $context, $name) {
    return array_splice($this->stack, $index, 0,
      [['context' => $context, 'name' => $name]]);
  }

  public function replace($context, $name) {
    $index = $this->find_stack($name);
    if (is_int($index)) {
      $old = $this->stack[$index]['context'];
      $this->stack[$index]['context'] = $context;
      return $old;
    } else {
      throw new Exception();
    }
  }

}