<?php

abstract class Cmd {

  public $argv;

  public $cmd;

  public $args = array();
  public $_args = array(
    'action' => 1
  );

  public $sub_args = array();

  public function __construct ($argv)
  {
    _log('Empty command');
  }

  public function argv ($argv)
  {
    $this->argv = $argv;
    $this->cmd  = basename($argv[0]);

    $args = array_merge($this->_args, $this->args);
    foreach ($args as $key => $index) {
      $arg = !empty($argv[$index]) ? $argv[$index] : false;
      
      if ($arg && strstr($arg, ':'))
      {
        $pos      = strpos($arg, ':');
        $main_arg = substr($arg, 0, $pos);
        $sub_arg  = substr($arg, $pos+1);
        $this->sub_args[$main_arg] = $sub_arg;
        
        $arg = $main_arg;
      }

      $this->$key = $arg;
    }
  }
}

?>
