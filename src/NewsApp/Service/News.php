<?php

namespace NewsApp\Service;

use NewsApp\Exception\NewsApiException;
use NewsApp\Repository\RepositoryInterface;

class News
{
    /* @var $newsRepository \NewsApp\Repository\News */
    private $newsRepository;

    public function __construct(RepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    
    /**
     * Get and format the news data
     *
     * @return array
     */
    public function getData(): array
    {
        try {
            $responseArr = $this->newsRepository->data();

            return $this->parseData($responseArr);
        } catch (NewsApiException $ex) {
            return [];
        }
    }
    
    /**
     * Parse repository data array
     *
     * @param array $responseArr
     * @return array
     */
    private function parseData(array $responseArr): array
    {
        if (!isset($responseArr['articles'])) {
            return [];
        }
        
        $data = [];
        
        foreach ($responseArr['articles'] as $article) {
            try {
                // format date [publishedAt] => 2018-07-07T17:15:07.5263487Z
                $publishedAt = new \DateTime($article['publishedAt']);
                $publishedAt = $publishedAt->format('Y-m-d H:i:s');
            } catch (\Exception $ex) {
                $publishedAt = $article['publishedAt'];
            }
            
            $data[] = [
                'author' => $article['author'],
                'title' => $article['title'],
                'description' => $article['description'],
                'url' => $article['url'],
                'publishedAt' => $publishedAt, 
            ];             
        }
        
        return $data;
    }
}
