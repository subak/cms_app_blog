<?php

namespace Helpers\Traits;

trait Entry {
  public function entry($id=null, $summary=false) {
    if (is_null($id)) {
      $id = $this->id();
    }

    $file_name = "content/entry/${id}/${id}";

    if ($out_dir = $this->context('out_dir')) {
      $msg = $this->build_content_resource($file_name, $out_dir);
      fputs(STDERR, $msg);
    }

    $num_of_elements_in_summary=null;
    if ($summary) {
      $num_of_elements_in_summary = $this->config('num_of_elements_in_summary');
    }
    $filter = "";
    if (!is_null($num_of_elements_in_summary)) {
      $filter = " | jq '[.[0],.[1][0:${num_of_elements_in_summary}]]'";
    }

    return $this->load_content($file_name, $this->context('uri'), $filter);
  }

  public function entry_title($id) {
    return `entry_title.sh ${id}`;
  }

  public static function entry_created($id) {
    return new \DateTime(`entry_created.sh ${id}`);
  }

  public static function entry_updated($id) {
    return new \DateTime(`entry_updated.sh ${id}`);
  }

  public static function entry_ids() {
    return array_values(array_filter(explode("\n", `entry_ids.sh`)));
  }

  public function created($id=null) {
    if (is_null($id)) {
      $id = $this->id();
    }
    return self::entry_created($id);
  }

  public function updated($id=null) {
    if (is_null($id)) {
      $id = $this->id();
    }
    return self::entry_updated($id);
  }
}