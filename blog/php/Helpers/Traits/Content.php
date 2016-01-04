<?php

namespace Helpers\Traits;

trait Content {
  protected function detect_content($file_name) {
    $info = pathinfo($file_name);
    if (!array_key_exists('extension', $info)) {
      $file_name = trim(`find ${file_name}.* -type f | egrep '(\.md|\.asciidoc)' | head -n 1`);
      $info = pathinfo($file_name);
    }
    return "${info['dirname']}/${info['basename']}";
  }

  public function load_content($file_name, $uri, $num_of_elements_in_summary=null) {
    $file_name = $this->detect_content($file_name);

    if (!is_null($num_of_elements_in_summary)) {
      $filter = " | jq '[.[0],.[1][0:${num_of_elements_in_summary}]]'";
    } else {
      $filter = " | jq .";
    }

    $content_dir_name = $this->config('content_dir_name');

    $rel_http_dir = str_repeat('../', substr_count($uri, '/') - 1)."./";
    $rel_content_dir = preg_replace("@^${content_dir_name}/@", '', dirname($file_name));
    $rel_dir = str_replace('/', '\/', "${rel_http_dir}${rel_content_dir}/");
    $assets = implode('|', ['jpg','png']);

    $filter .= <<<EOF
 | sed -r 's/"([^/]*)\.(${assets})"/"${rel_dir}\\1.\\2"/'
EOF;

    $info = pathinfo($file_name);
    switch ($info['extension']) {
      case 'md':
        return `pandoc -f markdown_github+footnotes+inline_notes -t json ${file_name} ${filter} | pandoc -f json -t html5`;
      case 'asciidoc':
        return 'asciidoc';
      default:
        return null;
    }
  }

  public function build_content_resource($file_name, $out_dir) {
    $content_dir_name = $this->config('content_dir_name');
    $content_dir = dirname($file_name);
    $rel_content_dir = preg_replace("@^${content_dir_name}/@", '', dirname($file_name));
    $local_dir = "${out_dir}/${rel_content_dir}";
    $resources = '\.'.implode('|\.', ['jpg','png']);

    $msg = '';
    $msg .= `mkdir -pv ${local_dir}`;
    $msg .= `find ${content_dir}/* -type f | egrep -E '${resources}' | xargs -I@ cp -v @ ${local_dir}`;

    return $msg;
  }
}
