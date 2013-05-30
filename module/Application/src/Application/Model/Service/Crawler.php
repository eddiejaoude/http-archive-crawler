<?php
namespace Application\Model\Service;

use Common\Model\Service\Core;
use Application\Model\Entity\Crawler as CrawlerEntity;
use VDB\Spider\Spider;
use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use VDB\Spider\Filter\Prefetch\AllowedHostsFilter;


/**
 * Class Crawler
 *
 * @package Application\Model\Service
 */
class Crawler extends Core
{

    public function create(CrawlerEntity $crawler)
    {
        $response = $this->getMapper()->create($crawler);

        return $response;
    }

    public function crawlUrl($url)
    {
        $url = (string) 'http://' . $url;
        $spider = new Spider($url);
        $spider->addDiscoverer(new XPathExpressionDiscoverer("//body//a"));
        $spider->setMaxDepth(10);
        $spider->setMaxQueueSize(100);
        $spider->setTraversalAlgorithm(Spider::ALGORITHM_BREADTH_FIRST);
        $spider->addPreFetchFilter(new AllowedHostsFilter(array($url), true));
        $spider->crawl();

        $stats = $spider->getStatsHandler();
        $result = "\nSPIDER ID: " . $stats->getSpiderId();
        $result .= "\n  ENQUEUED:  " . count($stats->getQueued());
        $result .= "\n  SKIPPED:   " . count($stats->getFiltered());
        $result .= "\n  FAILED:    " . count($stats->getFailed());
        $result .= "\n\nDOWNLOADED RESOURCES: ";
        foreach ($spider->getPersistenceHandler() as $resource) {
            $result .= "\n - " . $resource->getUri();//->getCrawler()->filterXpath('//title')->text();
        }

        return $result;
    }

}