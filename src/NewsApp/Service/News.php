<?php

namespace NewsApp\Service;

use NewsApp\Repository\News as NewsRepository;

class News
{
    /* @var $newsRepository \NewsApp\Repository\News  */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    
    public function getData()
    {
        /* @var $response \GuzzleHttp\Psr7\Response*/
        $response = $this->newsRepository->data();
        var_dump($response->getReasonPhrase()); 
        var_dump($response->getStatusCode()); 
        var_dump((string) $response->getBody()); 
        die;
    }
}
