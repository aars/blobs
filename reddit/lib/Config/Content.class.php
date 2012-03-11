<?php

class Config_Content {
  
  public $dir  = 'etc';
  public $file = 'reddit.ini';

  public $content;

  public function __construct($root)
  {
    $this->parse($root);  
  }

  public function get($key)
  {
    $parts = explode('.', $key);
  
      if(!isset($this->content[$parts[0]][$parts[1]]))
        throw new ConfigKeyException();

    return $this->content[$parts[0]][$parts[1]];
  }

  private function parse($root)
  {
    $file = realpath($this->dir . '/' . $this->file);
    
    if(!file_exists($file))
      throw new ConfigFileException("Configfile not found. ($file)");

    try {
      $this->content = parse_ini_file($file, true);
    } catch(Exception $e) {
      throw new ConfigException($e);
    }
  }
 
}

?>
