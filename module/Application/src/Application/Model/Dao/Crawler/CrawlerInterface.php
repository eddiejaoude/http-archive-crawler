<?php
namespace Application\Model\Dao\Crawler;

/**
 * Class CrawlerInterface
 *
 * @package Application\Model\Dao\Crawler
 */
interface CrawlerInterface
{

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data);

}