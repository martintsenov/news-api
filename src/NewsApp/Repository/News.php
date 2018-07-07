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
     *
     * @return array
     * @throws NewsApiException
     */
    public function data(): array
    {
        try {
            /* @var $response \GuzzleHttp\Psr7\Response */
            $response = $this->guzzleClient->get($this->configArr['url'] . 'top-headlines?sources=hacker-news&apiKey=' . $this->configArr['apiKey']);
            
            if ($response->getStatusCode() != 200) {
                throw new NewsApiException('No result found');
            }
            
            $json = (string) $response->getBody();
            $data = json_decode($json, true);
            
            return $data['articles']; 
        } catch (\Exception $ex) {
            throw new NewsApiException($ex->getMessage());
        } 
    }
}
