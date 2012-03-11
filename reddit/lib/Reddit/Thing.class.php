<?php

class Reddit_Thing 
{
  public $kind = 'Thing';

  private $basic_properties = array(
    'id'      => 'id',  
    'name'    => 'name',
    'title'   => 'title',
    'score'   => 'score',
    'ups'     => 'ups',
    'downs'   => 'downs',
    'sub'     => 'subreddit',
    'sub_id'  => 'subreddit_id',
    'timestamp' => 'created_utc'
  );
  public $properties = array();
  public $match_properties = array();

  public function __construct(Array $data) 
  {
    $this->properties($data);

    _log(sprintf("\t- %s loaded [%s%s]: %s",
      $this->kind,
      ($this->self ? 'S' : ' '),
      ($this->fixed ? 'F' : ' '),
      $this->title
    ));
  }
  
  private function properties($data)
  {
    $properties = array_merge($this->basic_properties, $this->properties);

    foreach ($properties as $property => $key)
      if (empty($this->$property))
        $this->$property = $data[$key];

    foreach ($this->match_properties as $property => $match)
      if (empty($this->$property))
        $this->$property = preg_match($match[1], $data[$match[0]]);
  }

}
?>
