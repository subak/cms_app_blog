<?php
/**
 * Created by IntelliJ IDEA.
 * User: subak
 * Date: 2015/12/22
 * Time: 20:32
 */

function __autoload($className) {
  var_dump("hogehuga");
  require_once 'web/php/class/'.$className.'.php';
  return true;
}

function entry_path ($id, $ext = 'entry.md') {
  return "content/entry/${id}.${ext}";
}

function entry($id) {
  return shell_exec('pandoc -f markdown_github -t html5  '.entry_path($id).
    ' | sed -e "s/<p>&lt;\?/<?/" | sed -e "s/\?&gt;<\/p>/?>/"'.
    ' | php');
}

/**
 * @param $id
 * @return string
 * エントリーの作成時刻を返す
 * 最初にメタデータを読み込む
 */
function entry_created_date($id) {
  if ( $meta = @yaml_parse_file(entry_path($id, '.entry.meta.yml')) ) {
    return $meta["created"];
  } else {
    return exec('git log --date=iso --pretty=format:"%cd" '.entry_path($id).' | tail -1');
  }
}
