<?php
namespace Application\Model\Dao\Crawl;

/**
 * Class CrawlInterface
 *
 * @package Application\Model\Dao\Crawl
 */
interface CrawlInterface
{

    /**
     * @param array $data
     * @return bool
     */
    public function run(array $data);

}