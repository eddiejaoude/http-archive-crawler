<?php
namespace Application\Model\Dao\Crawler;

use Common\Model\Dao\DaoInterface;
use VDB\Spider\Spider;
use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use Zend\Mvc\Application;


class Crawler implements CrawlerInterface, DaoInterface
{

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        return shell_exec('php ' . getcwd() . '/public/index.php crawl url ' . escapeshellarg(($data['url'])));
    }
}