#!/usr/bin/env php
<?php
require_once 'web/php/function.php';

$url = end($_SERVER["argv"]);
reset($_SERVER["argv"]);

$context = parse_url($url);
parse_str($context['query']);

spl_autoload_register(function ($className)
{
  require_once 'web/php/class/' . $className . '.php';
  return true;
});
$page= new $class($context);
$page->render();

exit(0);