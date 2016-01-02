#!/usr/bin/env php
<?php

set_include_path(get_include_path().PATH_SEPARATOR.getenv('APP').'/php/views');

require_once getenv('APP').'/php/function.php';

$context = json_decode(end($_SERVER["argv"]), true);
reset($_SERVER["argv"]);

spl_autoload_register(function ($class_name)
{
  foreach (['helpers', 'class'] as $dir_name) {
    $path = getenv('APP')."/php/${dir_name}/${class_name}.php";
    if (file_exists($path)) {
      require_once $path;
      return true;
    }
  }
  return false;
});

(new $context['helper']($context))->render();

exit(0);
