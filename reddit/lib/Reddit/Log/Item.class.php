<?php

class Reddit_Log_Item
{
  public $logbase = 'Item';

  public $logdata;
 
  public $name;

  public function __construct($data, $name = false) 
  {
    $this->data    = $data;
    $this->name    = $name;
    
    $this->logdata = (string) $data;

    $this->write();
  }

  public function datetime() 
  {
    return date(Config::get('datetime.log'), time());  
  }

  public function filename()
  {
    $filename = sprintf('%s/%s_%s_%s.log.gz',
      realpath(Config::get('log.dir')),
      $this->logbase,
      ucfirst(strtolower($this->name)),
      $this->datetime()
    );

    return $filename;
  }

  public function write() 
  {
    if (!$this->logdata)
      die('nothing to log');

    $filename = $this->filename();
   
    _log('writing logfile: ' . $filename);

    $compressed = gzdeflate($this->logdata);
    file_put_contents($filename, $compressed);
  }
}
?>
