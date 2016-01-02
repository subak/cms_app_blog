#!/usr/bin/env php
<?php

set_include_path(get_include_path().PATH_SEPARATOR.getenv('APP').'/php');

require_once getenv('APP').'/php/function.php';

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

$helper = "\\Helpers\\${context['helper']}";
(new $helper($context))->render();

exit(0);
