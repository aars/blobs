<?php

class Reddit_Log {

  static function log ($data, $name = false) 
  {
    if (is_object($data)) { 
      if (get_class($data) == 'Reddit_Listing')
        return new Reddit_Log_Listing($data, $name);

      if (get_class($data) == 'Reddit_Thing')
        return new Reddit_Log_Thing($data, $name);

      if (is_array($data))
        return new Reddit_Log_Array($data);
    }

    if (Config::get('log.verbose'))
      echo $data . "\r\n";
  }

  static function find ($name, $date = false)
  {
    $date  = date(str_replace('i', '*', Config::get('datetime.log')));
    $dir   = realpath(Config::get('log.dir'));
    $files = glob($dir . '/' . $name . '_' . $date . '.log');

    if (!empty($files)) {
      Reddit::log(sprintf("Logs (%s) found:\r\n\t%s", 
        sizeof($files), 
        str_replace($dir . '/', '- ', implode("\r\n\t", $files)))
      );
      
    } 
  
    return $files;
  }
}
?>
