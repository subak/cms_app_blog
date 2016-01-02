<?php
/**
 * Created by IntelliJ IDEA.
 * User: subak
 * Date: 2015/12/22
 * Time: 20:32
 */

/**
 * @param $uri
 * @return bool
 */
function is_uri_dir($uri) {
  return substr($uri, -1) === '/';
}

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

function entry($id) {
  return shell_exec('pandoc -f markdown_github+footnotes+inline_notes -t html5 '.entry_path($id).
    ' | sed -e "s/<p>&lt;\?/<?/" | sed -e "s/\?&gt;<\/p>/?>/"');
}

function entry_summary($id, $uri, $num=3) {
  // uriを受け取らないくてもいいようにクラスにしまったほうがいい
  $level = substr_count($uri, "/") - 1;
  $dir = "${id}\\/";
  $dir = str_repeat('..\/', $level).$dir;
  $path = entry_path($id);
  $assets = 'jpg|png';

  return `pandoc -f markdown_github -t json ${path} | jq '[.[0],.[1][0:${num}]]' | sed -r 's/"([^/]*)\.(${assets})"/"${dir}\\1.\\2"/' | pandoc -f json -t html5`;
}