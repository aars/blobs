<?php

class Reddit_Thing 
{
  public $kind = 'Thing';

  private $basic_properties = array(
    'id'      => 'id',  
    'name'    => 'name',
  );
  public $properties = array();
  public $match_properties = array();
  public $function_properties = array();

  public function __construct(Array $data) 
  {
    $this->properties($data);

    if (Config::get('log.posts'))
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

    foreach ($this->function_properties as $property => $method)
      if (method_exists($this, $method))
        $this->$method($data[$property]);
  }

}
?>
