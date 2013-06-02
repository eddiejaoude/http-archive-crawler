<?php
namespace Application\Model\Mapper\Crawl;

use Application\Model\Entity\Url as UrlEntity;

interface CrawlInterface
{

    /**
     * @param UrlEntity $url
     * @return bool|void
     */
    public function run(UrlEntity $url);


}