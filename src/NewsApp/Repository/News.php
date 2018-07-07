<?php

namespace NewsApp\Repository;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class News
{
    private $guzzleClient;

    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }
  
    /**
     * 
     * @return GuzzleResponse
     */
    public function data(): GuzzleResponse
    {
        /* @var $response \GuzzleHttp\Psr7\Response*/
        $response = $this->guzzleClient->get('https://hacker-news.firebaseio.com/v0/item/8863.json?print=pretty');
        
        return $response;
        
    }
}
