<?php

class Entry extends Page
{
  private $id;
  public $date;

  public function __construct($context) {
    parent::__construct($context);
    $this->id = $this->query['id'];
    $this->content = $this->entry();
    array_push($this->title, $this->get_title_from_content());
    $this->date = new DateTime($this->entry_created_date());
  }

  private function entry_path($ext = '.md') {
    $id = $this->id;
    return "content/entry/${id}/${id}${ext}";
  }

  private function entry() {
    return shell_exec('pandoc -f markdown_github -t html5  '.$this->entry_path().
      ' | sed -e "s/<p>&lt;\?/<?/" | sed -e "s/\?&gt;<\/p>/?>/"'.
      ' | php');
  }

  private function entry_created_date() {
    $id = $this->id;
    return `web/bin/entry_created.sh ${id}`;
  }

  private function get_title_from_content() {
    $id = $this->id;
    return `web/bin/entry_title.sh ${id}`;
  }
}
