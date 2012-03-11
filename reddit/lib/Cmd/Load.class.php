<?php

class Cmd_Load extends Cmd {

  public $argv;

  public function __construct ($argv)
  {
    $this->argv = $argv;
    
    $name = !empty($argv[2]) ? $argv[2] : Config::get('default.load');

    if (!method_exists($this, $name))
      return _log('do not know how to load ' . $name);

    $this->api = new Reddit_API();

    $this->name();
  }

  public function frontpage ()
  {
    $frontpage = $this->api->frontpage();
  }
}

?>
