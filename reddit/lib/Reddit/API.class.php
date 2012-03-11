<?php

class Reddit_API {

  private $request;

  public $frontpage;

  public function __construct () {
  }

  public function frontpage () {
    $logged = Reddit_Log::find('Listing_Frontpage');

    if (!empty($logged)) {
      $request = new Reddit_API_Request();
      $request->from_log($logged[0]);
    } else {
      $request = new Reddit_API_Request('/', array(
          'limit' => Config::get('request.limit'),
          'kind'  => 'comment'
        ));
    }

    _log('Loading Frontpage');
    
    $this->frontpage = new Reddit_Listing($request);

    if (Config::get('log.active'))
    {
      if ($request->fresh)
      {
        Reddit::log($this->frontpage, 'Frontpage');
      } else {
        Reddit::log(sprintf('Frontpage loaded from logfile: %s', 
          date(Config::get('datetime.human'), $request->timestamp)
          ));
      }
    }

    return $this->frontpage; 
  }

}

?>
