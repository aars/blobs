<?php

class Reddit {

  static function log ($data, $name= false) {
    if (Config::get('log.active'))
      return Reddit_Log::log($data, $name);
  }
}

?>
