<?php

namespace Helpers\Traits;

trait Entry {
  protected function entry_context($from, $id) {
    $context = new \Context($from->get());
    $context->insert_before('handler', $this->entry_meta($id), 'entry');
    return $context;
  }

  protected function entry_file_name($id) {
    $content_dir_name = $this->config('content_dir_name');
    return "${content_dir_name}/entry/${id}/${id}";
  }

  protected function entry_uri($id) {
    // ページを考慮するように後で変更
    return "/${id}/";
  }

  public function entry_meta($id=null) {
    if (is_null($id)) {
      $id = $this->id();
    }

    $file_name = $this->entry_file_name($id);
    $meta = @yaml_parse_file("${file_name}.yml");
    $meta = $meta ? $meta : [];

    return $meta;
  }

  public function entry_title($id=null) {
    if (is_null($id)) {
      $id = $this->id();
    }

    return $this->content_title($this->entry_file_name($id));
  }

  public function entry_body($id=null, $summary=false) {
    if (is_null($id)) {
      $id = $this->id();
    }

    $file_name = $this->entry_file_name($id);
    $context = $this->doc_context($file_name);

    return $this->content_body($file_name,
      $this->entry_uri($id),
      $summary ? $context->search('excerpt') : null);
  }

  public function entry($id=null, $summary=false) {
    if (is_null($id)) {
      $id = $this->id();
    }

    $file_name = $this->entry_file_name($id);
    $context = $this->doc_context($file_name);

    return $this->load_content($file_name,
      $this->entry_uri($id), true,
      $summary ? $context->search('excerpt') : null);
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