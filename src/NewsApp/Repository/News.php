<?php

namespace NewsApp\Repository;

use NewsApp\Exception\NewsApiException;
use GuzzleHttp\Client as GuzzleClient;

class News implements RepositoryInterface
{
    private $guzzleClient;
    private $configArr;

    public function __construct(
        GuzzleClient $guzzleClient,
        array $configArr
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->configArr = $configArr;
    }
  
    /**
     * Get news data feed
     *
     * @return array
     * @throws NewsApiException
     */
    public function data(int $resultPerPage = 20): array
    {
        try {
            /* @var $response \GuzzleHttp\Psr7\Response */
            $url = sprintf('%severything?sources=hacker-news&pageSize=%d&apiKey=%s',
                $this->configArr['url'],
                $resultPerPage,
                $this->configArr['apiKey']
            );
            $response = $this->guzzleClient->get($url);
            
            if ($response->getStatusCode() != 200) {
                throw new NewsApiException('No result found');
            }
            
            $json = (string) $response->getBody();
            $data = json_decode($json, true);
            
            return $data; 
        } catch (\Exception $ex) {
            throw new NewsApiException($ex->getMessage());
        } 
    }
}
