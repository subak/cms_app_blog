#!/usr/bin/env php
<?php
require_once 'web/php/function.php';

set_include_path(get_include_path().PATH_SEPARATOR.'web/php');

$context = json_decode(end($_SERVER["argv"]), true);
reset($_SERVER["argv"]);

spl_autoload_register(function ($class_name)
{
  foreach (['helpers', 'class'] as $dir_name) {
    $path = "web/php/${dir_name}/${class_name}.php";
    if (file_exists($path)) {
      require_once $path;
      return true;
    }
  }
  return false;
});

(new $context['helper']($context))->render();

exit(0);
