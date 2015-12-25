<?php
/**
 * Created by IntelliJ IDEA.
 * User: subak
 * Date: 2015/12/22
 * Time: 20:32
 */

/**
 * @param $id
 * @param string $ext
 * @return string
 */
function entry_path($id, $ext = '.md') {
  return "content/entry/${id}/${id}${ext}";
}

function entry_title($id) {
  return `entry_title.sh ${id}`;
}

function entry_created($id) {
  return new DateTime(`entry_created.sh ${id}`);
}

function get_title_from_content($id) {
  return new DateTime(`entry_title.sh ${id}`);
}

function attr($array) {
  $attributes = array();
  foreach ($array as $name => $value) {
    if (is_array($value)) {
      $value = join(" ", $value);
    }
    $attributes[] = "${name}=\"${value}\"";
  }
  $attr = empty($attributes) ? "" : " ".join(" ", $attributes);
  return $attr;
}

function entry_summary($id) {
  $path = entry_path($id);
  return `pandoc -f markdown_github -t json ${path} | jq '[.[0],.[1][0:3]]' | pandoc -f json -t html5`;
}