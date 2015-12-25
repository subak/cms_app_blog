<?php
/**
 * Created by IntelliJ IDEA.
 * User: subak
 * Date: 2015/12/25
 * Time: 3:54
 */

class Index extends Page
{
  const NUM_OF_ENTRIES = 5;

  private $ids = array();
  private $num_of_entries;

  public function __construct($context) {
    parent::__construct($context);
    $num = self::NUM_OF_ENTRIES;

    $page = intval($this->query('page'));
    $start = ($page - 1) * $num + 1;
    $end = $page * $num;

    $ids = explode("\n", `index.sh created | sort -k2 -r | sed -n '${start},${end}p' | cut -d' ' -f 1`);
    $this->ids = array_values(array_filter($ids, "strlen"));
    $this->num_of_entries = intval(`entry_ids.sh | wc -l`);
  }

  public function content() {
    include 'web/html/include/index.html';
  }

  public function entries() {
    return array_map(function ($id) {
      return $this->entry($id);
    }, $this->ids);
  }

  public function entry($id) {
    $path = entry_path($id);
    return `pandoc -f markdown_github -t json ${path} | jq '[.[0],.[1][0:3]]' | pandoc -f json -t html5`;
  }

  public function prev_page() {
    $page = intval($this->query('page')) - 1;
    return $page === 0 ? null : $page;
  }

  public function next_page() {
    $page = intval($this->query('page'));
    return ($page * self::NUM_OF_ENTRIES) >= $this->num_of_entries ? null : $page + 1;
  }
}