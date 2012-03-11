<?php

class Reddit_Thing_Link extends Reddit_Thing 
{
  public $kind = 'Link';

  public $properties = array(
    'title'    => 'title',
    'uri'      => 'permalink',
    'url'      => 'url',
    'score'   => 'score',
    'ups'     => 'ups',
    'downs'   => 'downs',
    'sub'     => 'subreddit',
    'sub_id'  => 'subreddit_id',
    'timestamp' => 'created_utc'
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
