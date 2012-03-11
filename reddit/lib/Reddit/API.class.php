<?php

class Reddit_API {

  private $request;

  public $offline;

  public function __construct () {
  }

  static function load ($kind, $name, $uri, $offline = false) {
    $kind = ucfirst($kind);
    $name = ucfirst(strtolower($name));

    _log("\r\n[Loading] $name ($uri)");

    $logged = Reddit_Log::find($kind . '_' . $name);

    if ($offline && empty($logged))
      throw new Reddit_API_NoLogException(
        'No logs found for ' . Reddit_Log::filename($kind . '_' . $name)
      );

    if (!empty($logged)) {
      $request = new Reddit_API_Request();
      $request->from_log($logged[0]);
    } else {
      $request = new Reddit_API_Request($uri, array(
          'limit' => Config::get('request.limit')
        ));
    }
   
    $classname = 'Reddit_' . $kind;
    $object    = new $classname($request);

    if (Config::get('log.active'))
    {
      if ($request->fresh)
      {
        Reddit::log($object, $name);
      } else {
        Reddit::log(sprintf('%s loaded from logfile: %s',
          $name,
          date(Config::get('datetime.human'), $request->timestamp)
          ));
      }
    }

    return $object;
  }

  public function frontpage ()
  {
    $frontpage = self::load('Listing', 'Frontpage', '/', $this->offline);

    return $frontpage;
  }

  public function all ()
  {
    $all = self::load('Listing', 'All', 'r/all', $this->offline);

    return $all;
  }
  
  public function subreddit ($name)
  {
    $subreddit = self::load('Listing', $name, 'r/' . $name, $this->offline);

    return $subreddit;
  }

  function get_subreddits (Reddit_Data $data)
  {

    $list = array();
    foreach ($data->children as $id => $item) {
      $list[] = array(
        'kind' => 'Listing',
        'name' => $item->sub,
        'uri'  => 'r/' . $item->sub
      );
    }
    $this->timer($list); 
  }

  function get_comments (Reddit_Data $data)
  {
    $list = array();
    foreach ($data->children as $id => $item)
    {
      $list[] = array(
        'kind' => 'Listing',
        'name' => 'Comments-' . $item->id,
        'uri'  => $item->uri,
        'query' => array()
      );
    }
    $this->timer($list); 
  }

  function timer ($list)
  {
    $timer = new Reddit_API_RequestTimer($list);
  }
}

class Reddit_API_Exception extends Exception {};
class Reddit_API_NoLogException extends Reddit_API_Exception {};
?>
