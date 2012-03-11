<?php

class Reddit_Thing_Comment extends Reddit_Thing 
{
  public $kind = 'Comment';
  
  public $properties = array(
    'ups'     => 'ups',
    'downs'   => 'downs',
    'sub'     => 'subreddit',
    'sub_id'  => 'subreddit_id',
    'timestamp' => 'created_utc',
  );

  public $function_properties = array(
    'replies' => 'replies',
  );

  public function __construct ($data) {
    parent::__construct($data);
  }
  
  public function replies () {
    return;
  }
}

?>
