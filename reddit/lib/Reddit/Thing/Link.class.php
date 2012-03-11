<?php

class Reddit_Thing_Link extends Reddit_Thing 
{
  public $kind = 'Link';

  public $properties = array(
    'uri'      => 'url',
    'comments' => 'num_comments'
  );
  
  public $match_properties = array(
    'self'  => array('domain', '/^self\./'),
    'fixed' => array('title', '/\[fixed\]$/')
  );

  public function __construct ($data) {
    parent::__construct($data);
  }
}

?>
