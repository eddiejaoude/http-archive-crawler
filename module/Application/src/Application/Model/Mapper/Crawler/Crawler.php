<?php
namespace Application\Model\Mapper\Crawler;

use Application\Model\Entity\Crawler as CrawlerEntity;
use Common\Model\Mapper\Core;

class Crawler extends Core implements CrawlerInterface
{

    /**
     * @param CrawlerEntity $crawler
     * @return bool|void
     */
    public function create(CrawlerEntity $crawler)
    {
        $data = array(
            'url' => $crawler->getUrl()
        );

        $response = $this->getDao()->create($data);
        return $response;


        foreach($response as $url) {
            $crawler->addCrawledUrl($url);
        }

        return $crawler;
    }
}