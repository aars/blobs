<?php

class Reddit_Data {

  public $kind;

  public $request;

  public $children;

  public function __construct (Reddit_API_Request $request)
  {
    $this->request = $request;
    $this->data    = $request->get();

    $this->parse($this->data);
  }

  private function parse ($data)
  {
    _log('Loading data...');
    try {
      $data = json_decode($data, true);
    } catch (Exception $e) {
      throw new Reddit_Data_Exception('Could not parse request data');
    }
    
    if ($data['kind'] != $this->kind)
      throw new Reddit_Data_Exception('Request data is not not a ' . $this->kind);
   
    foreach ($data['data']['children'] as $item) {
      try {
        $kind = Config::get('kind_id.' . $item['kind']);
      } catch(Exception $e) {
        throw new Reddit_Data_Exception('Unknown kind ' . $item['kind']);
      }

      $classname = 'Reddit_Thing_' . ucfirst($kind);
      if (!class_exists($classname))
        throw new Reddit_Data_Exception('No class to handle ' . $kind);
      
      $item = new $classname($item['data']);
      
      $this->children[$item->id] = $item;
    }
    
  }

  public function __toString()
  {
    echo (string) $this->data();
  }
}

class Reddit_Data_Exception extends Exception {};

?>
