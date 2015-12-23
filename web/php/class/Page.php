<?php

class Page
{
  protected $context;
  protected $query;
  protected $meta;
  protected $content;
  protected $title = array();

  protected function __construct($context) {
    $this->context = $context;
    parse_str($context['query'], $query);
    $this->query = $query;
    $this->meta = yaml_parse_file('web/site.meta.yml');
    array_push($this->title, $this->meta['title']);
  }

  public function title($glue = ' | ') {
    return $this->wrap('title', implode($glue, array_reverse($this->title)));
  }

  public function content() {
    return $this->content;
  }

  protected function wrap($tag, $text) {
    return "<$tag>".$text."</$tag>";
  }
}