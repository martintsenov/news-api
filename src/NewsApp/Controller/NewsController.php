<?php

namespace NewsApp\Controller;

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
        /* @var $data array */
        $data = $this->newsService->getData();

        return $data;
    }
}
