<?php

class Cmd_Load extends Cmd {
  
  public $args = array(
    'name'       => 2,
    'subreddits' => 3,
    'comments'   => 4
  );

  public function __construct ($argv)
  {
    $this->argv($argv);

    $name = $this->name;

    if (!method_exists($this, $name))
      die($this->usage('do not know how to load ' . $name));

    $this->api = new Reddit_API();

    $data = $this->$name();

    if ($this->subreddits)
      $this->api->get_subreddits($data);

    if ($this->comments)
      $this->api->get_comments($data);
  }

  public function usage ($msg = false)
  {
    echo "[BloBS] reddit.com parser\r\n";
    if ($msg)
      echo "\t- $msg\r\n\r\n";

    echo "usage: " . $this->cmd . " load [name] [subreddits] [comments]\r\n";
    echo "\t- names:\r\n";
    echo "\t\tfrontpage: get reddit.com homepage\r\n";
    echo "\t\tsubreddits: get all linked subreddits\r\n";
    echo "\t\tall: get r/all\r\n";
    echo "\t- comments: get all commentpages\r\n";
  }

  public function frontpage ()
  {
    $frontpage = $this->api->frontpage();

    return $frontpage;
  }

  public function all ()
  {
    $all = $this->api->all();

    return $all;
  }
}

?>
