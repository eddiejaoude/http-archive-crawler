<?php
namespace Application\Model\Mapper\Crawler;

use Application\Model\Entity\Crawler as CrawlerEntity;

interface CrawlerInterface
{

    /**
     * @param CrawlerEntity $crawler
     * @return bool
     */
    public function create(CrawlerEntity $crawler);
}