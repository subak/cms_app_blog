<?php

namespace Helpers\Traits;

trait Content {
  protected function detect_content($file_name) {
    $info = pathinfo($file_name);
    if (!array_key_exists('extension', $info)) {
      $file_name = trim(`find ${file_name}.* -type f | egrep '(\.md|\.rst|\.adoc)' | head -n 1`);
      $info = pathinfo($file_name);
    }
    return "${info['dirname']}/${info['basename']}";
  }

  public function load_content($file_name, $uri, $filter='') {
    $file_name = $this->detect_content($file_name);

    $content_dir_name = $this->config('content_dir_name');

    $rel_http_dir = str_repeat('../', substr_count($uri, '/') - 1)."./";
    $rel_content_dir = preg_replace("@^${content_dir_name}/@", '', dirname($file_name));
    $rel_dir = str_replace('/', '\/', "${rel_http_dir}${rel_content_dir}/");
    $assets = implode('|', $this->config('resources'));

    $filter .= <<<EOF
 | jq . | sed -r 's/"([^/]*)\.(${assets})"/"${rel_dir}\\1.\\2"/'
EOF;

    $info = pathinfo($file_name);
    $ext = $info['extension'];
    switch ($ext) {
      case 'md':
      case 'rst':
      $format = $this->config("pandoc_format_${ext}");
      return `pandoc -f ${format} -t json ${file_name} ${filter} | pandoc -f json -t html5`;
      case 'adoc':
        return `asciidoctor -o - ${file_name} | pup 'div#header, div#content' | sed -r 's/"\.\/([^"]+)\.(jpg|png)"/"${rel_dir}\\1.\\2"/'`;
      default:
        return null;
    }
  }

  public function build_content_resource($file_name, $out_dir) {
    $content_dir_name = $this->config('content_dir_name');
    $content_dir = dirname($file_name);
    $rel_content_dir = preg_replace("@^${content_dir_name}/@", '', dirname($file_name));
    $local_dir = "${out_dir}/${rel_content_dir}";
    $resources = '\.'.implode('|\.', $this->config('resources'));

    $msg = '';
    $msg .= `mkdir -pv ${local_dir}`;
    $msg .= `find ${content_dir}/* -type f | egrep -E '${resources}' | xargs -I@ cp -v @ ${local_dir}`;

    return $msg;
  }
}
