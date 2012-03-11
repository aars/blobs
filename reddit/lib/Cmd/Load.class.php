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
    $data = is_array($data) ? $data : array($data);
    foreach ($data as $set) {
      if ($this->subreddits)
        $this->api->get_subreddits($set);

      if ($this->comments)
        $this->api->get_comments($set);
    }
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

  public function subreddit () {
    if (empty($this->sub_args['subreddit'])) die($this->usage("specify subreddit to load"));

    $subreddits = strstr($this->sub_args['subreddit'], ',')
      ? explode(',', $this->sub_args['subreddit'])
      : array($this->sub_args['subreddit']);

    $data = array();
    foreach ($subreddits as $name) {
      $data[] = $this->api->subreddit($name);
    }

    return $data;
  }

  public function usage ($msg = false)
  {
    echo "[BloBS] reddit.com parser\r\n";
    if ($msg)
      echo "\t- $msg\r\n\r\n";

    echo "usage: " . $this->cmd . " load [name] [subreddits] [comments]\r\n";
    echo "\t- names:\r\n";
    echo "\t\tfrontpage\t\t- get reddit.com homepage\r\n";
    echo "\t\tall\t\t\t- get r/all\r\n";
    echo "\t\tsubreddit:<name>,<name>\t- get specific subreddit(s)\r\n";
    echo "\t- subreddits\tget all linked subreddits\r\n";
    echo "\t- comments\tget all commentpages\r\n";
  }
}

?>
