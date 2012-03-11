<?php

abstract class Cmd {

  public $argv;

  public $cmd;

  public $args = array();
  public $_args = array(
    'action' => 1
  );

  public function __construct ($argv)
  {
    _log('Empty command');
  }

  public function argv ($argv)
  {
    $this->argv = $argv;
    $this->cmd  = basename($argv[0]);

    $args = array_merge($this->_args, $this->args);
    foreach ($args as $key => $index)
      $this->$key = !empty($argv[$index]) ? $argv[$index] : false;
  }
}

?>
