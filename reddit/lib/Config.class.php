<?php

class ConfigException extends Exception {}
class ConfigFileException extends ConfigException {}
class ConfigKeyException extends ConfigException {}

$_config = false; // global var to store ConfigContent in.

class Config {

  static function get($key)
  {
    if(empty($_config) || get_class($_config) != 'ConfigContent')
      $_config = new Config_Content(dirname(dirname(__FILE__)));

      return $_config->get($key);
  }

}

?>
