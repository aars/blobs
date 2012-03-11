<?php

class Reddit_Log_Thing extends Reddit_Log_RequestData 
{
  public $logbase = 'Thing';

  public function __construct (Reddit_Listing $listing, $name = false) 
  {
    parent::__construct($listing->request, $name);
  }


}

?>
