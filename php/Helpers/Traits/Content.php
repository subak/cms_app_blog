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

  protected function rel_content_dir($path) {
    $content_dir_name = $this->config('content_dir_name');
    return preg_replace("@^${content_dir_name}/@", '', dirname($path));
  }

  protected function rel_dir($path, $uri) {
    $rel_http_dir = str_repeat('../', substr_count($uri, '/') - 1)."./";
    $rel_content_dir = $this->rel_content_dir($path);
    $rel_dir = str_replace('/', '\/', "${rel_http_dir}${rel_content_dir}/");
    return $rel_dir;
  }

  protected function pandoc_filter($including_title, $excerpt) {
    if ($including_title) {
      $filter = ' | jq .';
    } else {
      $filter = " | jq '[.[0],.[1][1:]]'";
    }

    if (!is_null($excerpt)) {
      $filter .= " | jq '[.[0],.[1][0:${excerpt}]]'";
    }

    return $filter;
  }

  protected function adoc_filter($including_title, $excerpt) {
    $selectors = [];

    if ($including_title) {
      $selectors[] = '#header > :nth-child(n+0)';
    }

    if (is_null($excerpt)) {
      $selectors[] = '#content > :nth-child(n+0)';
    } else {
      for ($i=1; $i<=$excerpt; $i++) {
        $selectors[] = "#content > :nth-child(${i})";
      }
    }

    $selector = join(',', $selectors);

    return " | pup --pre '${selector}'";
  }

  protected function rel_filter($rel_dir, $assets) {
    $assets_ptn = implode('|', $assets);
    return <<<EOF
 | sed -r 's/"([^/]+)\.(${assets_ptn})"/"${rel_dir}\\1.\\2"/'
EOF;
  }

  public function content_title($file_name) {
    $path = $this->detect_content($file_name);
    return trim(`head -1 ${path} | sed -r 's/^[#= ]*(.+)[#= ]*$/\\1/'`);
  }

  public function content_body($file_name, $uri, $excerpt=null) {
    return $this->load_content($file_name, $uri, false, $excerpt);
  }

  /**
   * @param $file_name
   * @param $uri
   * @param bool $including_title
   * @param null $excerpt
   * @return null
   * @throws \Exception
   */
  public function load_content($file_name, $uri, $including_title=false, $excerpt=null) {
    $path = $this->detect_content($file_name);
    $info = pathinfo($path);
    $meta = @yaml_parse_file("${info['dirname']}/${info['filename']}.yml");
    $meta = $meta ? $meta : [];
    $rel_dir = $this->rel_dir($path, $uri);
    $assets = $this->config('resources');

    if ($out_dir = $this->context('out_dir')) {
      $msg = $this->build_content_resource($path, $this->config('content_dir_name'), $out_dir);
      fputs(STDERR, $msg);
    }

    $ext = $info['extension'];
    switch ($ext) {
      case 'md':
      case 'rst':
        $filter = $this->pandoc_filter($including_title, $excerpt);
        $filter .= $this->rel_filter($rel_dir, $assets);
        $format = $this->config("pandoc_format_${ext}");
        return `pandoc -f ${format} -t json ${path} ${filter} | pandoc -f json -t html5`;
      case 'adoc':
        $filter = $this->adoc_filter($including_title, $excerpt);
        $filter .= $this->rel_filter($rel_dir, $assets);
        $option = $this->config('asciidoctor_option');

        if ($meta && array_key_exists('diagram', $meta)) {
          $content_dir = "/tmp/cms";
          $destination_dir = $content_dir.'/'.$this->rel_content_dir($path);
          fputs(STDERR, `mkdir -pv ${destination_dir}`);
          $tmp_path = "${destination_dir}/${info['basename']}";
          copy($path, $tmp_path);

          if ($out_dir = $this->context('out_dir')) {
            $msg = $this->build_content_resource($tmp_path, $content_dir, $out_dir);
            fputs(STDERR, $msg);
          }

          return `asciidoctor ${option} -r asciidoctor-diagram -o - ${tmp_path} ${filter}`;
        } else {
          return `asciidoctor ${option} -o - ${path} ${filter}`;
        }
      default:
        throw new \Exception();
    }
  }

  protected function build_content_resource($file_name, $content_dir_name, $out_dir) {
    $content_dir = dirname($file_name);
    $rel_content_dir = preg_replace("@^${content_dir_name}/@", '', dirname($file_name));
    $local_dir = "${out_dir}/${rel_content_dir}";
    $resources = '\.'.implode('$|\.', $this->config('resources')).'$';

    $msg = '';
    $msg .= `mkdir -pv ${local_dir}`;
    $msg .= `find ${content_dir}/* -type f | egrep -E '${resources}' | xargs -I@ cp -v @ ${local_dir}`;

    return $msg;
  }
}
