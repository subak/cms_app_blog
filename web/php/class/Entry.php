<?php

class Entry extends Page
{
  private $id;
  public $created;

  public function __construct($context) {
    parent::__construct($context);
    $this->id = $this->query['id'];
    $this->content = $this->entry();
    array_push($this->title, entry_title($this->id));
    $this->created = entry_created($this->id);
  }

  public function content() {
    include 'web/html/include/entry.html';
  }

  private function entry() {
    return shell_exec('pandoc -f markdown_github+footnotes+inline_notes -t html5 '.entry_path($this->id).
      ' | sed -e "s/<p>&lt;\?/<?/" | sed -e "s/\?&gt;<\/p>/?>/"'.
      ' | php');
  }
}
