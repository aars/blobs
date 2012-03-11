<?php

class Cmd_Show extends Cmd {
  
  public $args = array(
    'name'  => 2,
    'key'   => 3,
    'value' => 4
  );

  private $data;

  public function __construct ($argv)
  {
    $this->argv($argv);
    
    if (!$this->name)
      die($this->usage('show what?'));

    $this->api = new Reddit_API();
    $this->api->offline = true;

    try {
      switch ($this->name) {
        case 'frontpage':
          $this->data = $this->api->frontpage();
          break;
        default:
          $this->data = $this->api->subreddit($name);
          break;
      }
    } catch (Reddit_API_NoLogException $e) {
      return _log($e->getMessage());
    }

    if ($this->key || $this->value)
    {
      $this->search($key);
    } else {
      $this->show();
    }
  }

  public function search ($key, $value = false)
  {
    if (!empty($this->data[$key]))
      _log('- ' . $key . ' : ' . $this->data[$key]);
  }

  public function show ()
  {
    $this->data->show();
  }

  public function usage ($msg = false)
  {
    echo "[BloBS] reddit.com parser\r\n";
    if ($msg)
      echo "\t- $msg\r\n\r\n";

    echo "usage: " . $this->cmd . " show [name] [key] [value]\r\n";
    echo "\t- names:\r\n";
    echo "\t\tfrontpage\t\t- get reddit.com homepage\r\n";
    echo "\t\tall\t\t\t- get r/all\r\n";
    echo "\t\tsubreddit:<name>\t- get specific subreddit\r\n";
    echo "\t- key\tsearch for key\r\n";
    echo "\t- value\tsearch for value\r\n";
  }
}

?>
