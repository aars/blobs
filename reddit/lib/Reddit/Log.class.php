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

  static function filename ($name)
  {
    $date = date(str_replace('i', '*', Config::get('datetime.log')));
    $filename = $name . '_' . $date . '.log.gz';

    return $filename;
  }

  static function find ($name)
  {
    $dir   = realpath(Config::get('log.dir'));
    $files = glob($dir . '/' . self::filename($name));

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
