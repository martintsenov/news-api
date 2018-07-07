<?php

namespace NewsApp\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use NewsApp\Service\News as NewsService;

class NewsController
{
    /* @var $newsService \NewsApp\Service\News  */
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }
    
    public function news()
    {
        /* @var $response \GuzzleHttp\Psr7\Response*/
        $data = $this->newsService->getData();

        return $data;
    }
}
