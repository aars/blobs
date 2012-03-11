<?php

class Reddit_API_Request {
  
  private $req;

  public $fresh = true;

  public $uri;
  public $url;
  
  public $base      = 'http://www.reddit.com';
  public $format    = 'json';

  public $useragent = 'Blob reddit crawler';

  public $timestamp;

  public $contents;

  public function __construct ($uri = false, $query = false) 
  {
    if ($uri)
      $this->url = $this->url($uri, $query);
  }

  private function url($uri = false, $query = false) 
  {
    $uri = ((!$uri) || preg_match('/^\//', $uri)) // Add missing preceding slash
      ? $uri 
      : '/' . $uri;

    $uri = (preg_match('/\/$/', $uri))
      ? $uri
      : $uri . '/';

    $this->uri = $uri;

    if (is_array($query)) $query = http_build_query($query);

    return $this->base . $uri . '.' . $this->format . '?' . $query;
  }

  public function uri($uri, $query = false) 
  {
    $this->url = $this->url($uri, $query);
  }

  public function get($uri = false) 
  {
    if ($this->contents) return $this->contents;

    if (!$uri && !$this->url)
      throw new Reddit_API_Request_GetException('No URI?');

    if (!$this->url)
      $this->uri($uri);

    Reddit_Log::log('Getting fresh copy of ' . $this->uri);

    $this->timestamp = time();

    try {
      $this->contents = file_get_contents($this->url);
    } catch (Exception $e) {
      throw Reddit_API_Request_GetException($e->getMessage());
    }

    return $this->contents;
  }

  public function from_log ($file) 
  {
    $this->contents = file_get_contents($file);

    preg_match('/_([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})([0-9]{2}).log$/', $file, $t);
    $this->timestamp = mktime($t[4], $t[5], 0, $t[2], $t[3], $t[1]);
    
    $this->fresh = false;

    return true;
  }
}

class Reddit_API_Request_Exception extends Exception {};
class Reddit_API_Request_GetException Extends Reddit_API_Request_Exception {};

?>
