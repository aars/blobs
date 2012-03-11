<?php

function blobs_spl_autoload($classname)
{
  $dir = dirname(__FILE__) . '/';
  $classfile = str_replace('_', '/', $classname) . '.class.php';
  if(file_exists($dir . $classfile))
    require_once($dir . $classfile);
}

spl_autoload_register('blobs_spl_autoload');

?>
