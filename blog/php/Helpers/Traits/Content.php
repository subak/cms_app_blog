<?php

namespace Helpers\Traits;

trait Content {
  protected function normalize_content_path($file_name) {
    $info = pathinfo($file_name);
    if (!array_key_exists('extension', $info)) {
      $file_name = trim(`find ${file_name}.* -type f | egrep '(\.md|\.asciidoc)' | head -n 1`);
      $info = pathinfo($file_name);
    }
    return $info;
  }

  public function load_content($file_name, $content_uri, $uri, $num_of_elements_in_summary=null) {
    $info = $this->normalize_content_path($file_name);
    $file_name = "${info['dirname']}/${info['basename']}";

    $filter = '';

    if (!is_null($num_of_elements_in_summary)) {
      $filter = " | jq '[.[0],.[1][0:${num_of_elements_in_summary}]]'";
    }

    if ($content_uri != $uri) {
      $level = substr_count($content_uri, "/") - 1;
      $dir = preg_replace(array('@^/@','@/$@'), array('','\\/'), $uri);
      $dir = str_repeat('..\/', $level).$dir;
      $assets = implode('|', ['jpg','png']);
      $filter .= <<< EOF
 | sed -r 's/"([^/]*)\.(${assets})"/"${dir}\\1.\\2"/'
EOF;
    }

    switch ($info['extension']) {
      case 'md':
        return `pandoc -f markdown_github+footnotes+inline_notes -t json ${file_name} ${filter} | pandoc -f json -t html5`;
      case 'asciidoc':
        return 'asciidoc';
      default:
        return null;
    }
  }

  public function build_content($file_name, $uri, $out_dir) {
    $dir = $this->is_dir($uri) ? $uri : dirname($uri).'/';
    $info = pathinfo($file_name);

    $ptn = '\.'.implode('|\.', ['jpg','png']);

    $info['dirname'];

    $target = $out_dir.$dir;

    $msg = '';
    $msg .= `mkdir -pv ${target}`;
    $msg .= `find ${info['dirname']}/* -type f | egrep -E '${ptn}' | xargs -I@ cp -v @ ${target}`;

    return $msg;
  }
}
