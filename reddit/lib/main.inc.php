<?php

function _log ($string) 
{
  Reddit::log($string);
}

function usage ($msg = false)
{
  global $argv;

  echo "[BloBS] reddit.com parser\r\n";
  if ($msg) echo "- $msg\r\n\r\n";
  echo "usage: " . basename($argv[0]) . " [action]\r\n";
  echo "\taction:\r\n";
  echo "\t- load: Load current reality\r\n";
  echo "\t- fresh: Get a fresh copy\r\n";
}

function _do ($argv) 
{
  $classname = 'Cmd_' . ucfirst($argv[1]);
  if (!class_exists($classname))
    die(usage('action not found'));

  new $classname($argv);
}

?>
