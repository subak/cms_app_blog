<?php

class Entry extends Page
{
  private $id;
  public $date;

  public function __construct($context) {
    parent::__construct($context);
    $this->id = $this->query['id'];
    $this->content = $this->entry($this->id);
    array_push($this->title, $this->get_title_from_content());
    $this->date = new DateTime($this->entry_created_date($this->id));
  }

  private function entry_path($id, $ext = '.md') {
    return "content/entry/${id}/${id}${ext}";
  }

  private function entry($id) {
    return shell_exec('pandoc -f markdown_github -t html5  '.$this->entry_path($id).
      ' | sed -e "s/<p>&lt;\?/<?/" | sed -e "s/\?&gt;<\/p>/?>/"'.
      ' | php');
  }

  private function entry_created_date($id) {
    if ( $meta = yaml_parse_file($this->entry_path($id, '.meta.yml')) ) {
      return $meta["created"];
    } else {
      return exec('git log --date=iso --pretty=format:"%cd" '.$this->entry_path($id).' | tail -1');
    }
  }

  private function get_title_from_content() {
    preg_match('@.*@', $this->content, $result);
    return strip_tags($result[0]);
  }
}
