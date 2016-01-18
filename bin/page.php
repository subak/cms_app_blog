#!/usr/bin/env php
<?php

set_include_path(join(PATH_SEPARATOR, [
  get_include_path(), 'app/php', 'web/php', 'html/views']));

#set_include_path(get_include_path().PATH_SEPARATOR.'app/php'.PATH_SEPARATOR.'web/php');

require_once 'web/php/function.php';
if ($path = stream_resolve_include_path('app/php/function.php')) {
  require_once $path;
}

$context = json_decode(end($_SERVER["argv"]), true);
reset($_SERVER["argv"]);

spl_autoload_register(function ($name)
{
  $file_name = str_replace('\\', '/', ltrim($name, '\\'));
  if ($path = stream_resolve_include_path($file_name.'.php')) {
    return include $path;
  }
  return false;
});

$klass = "\\Helpers\\${context['helper']}";
$helper = new $klass($context);
$helper->include($context['view']);

exit(0);
