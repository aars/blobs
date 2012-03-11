<?php

abstract class Reddit_Log_RequestData extends Reddit_Log_Item
{
  public $request;

  public function __construct($request, $name = false) 
  {
    $this->request = $request;

    parent::__construct($request->contents, $name);
  }
  
  public function datetime() 
  {
    return date(Config::get('datetime.log'), $this->request->timestamp);  
  }


}
?>
