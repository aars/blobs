<?php

class Reddit_API_RequestTimer {
  
  public $running  = true;

  public $requests = array();

  function __construct (array $list)
  {
    $timeout = Config::get('request.timeout');
    foreach ($list as $item) {
      if (!empty($this->requests[$item['name']])) continue;

      $fresh = $this->request($item['kind'], $item['name'], $item['uri']);
 
      if (!$fresh) {
        _log('Already logged ' . $item['name']);
        continue;
      }

      if ($timeout) {
        _log("Sleeping for $timeout seconds...\r\n");
        sleep($timeout);
      }
    }

    $this->running = false;
  }

  function request($kind, $name, $uri)
  {
    $thing = Reddit_API::load($kind, $name, $uri);

    $this->requests[$name] = array(
      'kind' => $kind,
      'name' => $name,
      'uri'  => $uri,
      'thing' => $thing
    );

    return $thing->request->fresh;
  }
}

?>
