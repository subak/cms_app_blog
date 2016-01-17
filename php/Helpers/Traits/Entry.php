<?php

namespace Helpers\Traits;

trait Entry {
  protected function entry_file_name($id) {
    return "content/entry/${id}/${id}";
  }

  protected function entry_context($id) {
    return $this->doc_context($this->entry_file_name($id), 'entry');
  }

  protected function entry_uri($id) {
    // ページを考慮するように後で変更
    return "/${id}/";
  }

  public function entry_title($id) {
    return $this->doc_title($this->entry_file_name($id));
  }

  public function entry_body($id, $params=[]) {
    return $this->load_document(
      $this->entry_file_name($id),
      $this->entry_uri($id), $params);
  }

  public function entry($id=null, $summary=false) {
    if (is_null($id)) {
      $id = $this->id();
    }

    $file_name = $this->entry_file_name($id);
    $context = $this->doc_context($file_name);

    return $this->load_content($this->entry_file_name($id),
      $this->entry_uri($id), true,
      $summary ? $context->get('excerpt') : null);
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