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

function entry_updated($id) {
  return new DateTime(`entry_updated.sh ${id}`);
}

function entry_ids() {
  return array_values(array_filter(explode("\n", `entry_ids.sh`)));
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

function entry($id) {
  return shell_exec('pandoc -f markdown_github+footnotes+inline_notes -t html5 '.entry_path($id).
    ' | sed -e "s/<p>&lt;\?/<?/" | sed -e "s/\?&gt;<\/p>/?>/"');
}

function entry_summary($id, $uri, $num=3) {
  // uriを受け取らないくてもいいようにクラスにしまったほうがいい
  $level = substr_count($uri, "/");
  $dir = "${id}\\/";
  if ($level) {
    $dir = str_repeat('..\/', $level).$dir;
  }
  $path = entry_path($id);
  return `pandoc -f markdown_github -t json ${path} | jq '[.[0],.[1][0:${num}]]' | sed -e 's/"\([^/]*\)\.\(jpg\)"/"${dir}\\1.\\2"/' | pandoc -f json -t html5`;
}