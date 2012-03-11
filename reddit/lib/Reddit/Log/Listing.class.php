<?php

class Reddit_Log_Listing extends Reddit_Log_RequestData {

  public $logbase = 'Listing';

  public function __construct (Reddit_Listing $listing, $name = false) 
  {
    parent::__construct($listing->request, $name);
  }

}

?>
