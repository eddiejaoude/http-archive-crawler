<?php
namespace Application\Model\Service;

use Common\Model\Service\Core;
use Application\Model\Entity\Url as UrlEntity;
use Application\Model\Entity\CrawledUrl as CrawledUrlEntity;
use VDB\Spider\Spider;
use VDB\Spider\Discoverer\XPathExpressionDiscoverer;
use VDB\Spider\Filter\Prefetch\AllowedHostsFilter;

/**
 * Class Crawler
 *
 * @package Application\Model\Service
 */
class CrawledUrl extends Core
{

    /**
     * @todo: add event logging
     *
     * @param UrlEntity $urlEntity
     * @return bool
     */
    public function run(UrlEntity $urlEntity)
    {
        // get url
        $urlEntity = $this->getServiceLocator()->get('Application\Model\Service\Url')->findById($urlEntity);

        // update url table with crawl start
        $urlEntity->setCrawlStart();
        $updateStart = $this->getServiceLocator()->get('Application\Model\Service\Url')->update($urlEntity);

        // add agent


        // crawl url
        $spider = new Spider($urlEntity->getUrl());
        $spider->addDiscoverer(new XPathExpressionDiscoverer("//body//a"));
        $spider->setMaxDepth($urlEntity->getDepth());
        $spider->setMaxQueueSize($urlEntity->getLimit());
        $spider->setTraversalAlgorithm(Spider::ALGORITHM_BREADTH_FIRST);
        $spider->addPreFetchFilter(new AllowedHostsFilter(array($urlEntity->getUrl()), true));
        $spider->crawl();

        // save crawl
        foreach ($spider->getPersistenceHandler() as $resource) {
            $crawledUrlEntity = new CrawledUrlEntity();
            $crawledUrlEntity->setUrlId($urlEntity->getId())
                ->setUrl($resource->getUri());
            $save = $this->getMapper()->create($crawledUrlEntity);
        }

        // remove agent


        // update url table (inc. crawl end) & statistics
        $stats = $spider->getStatsHandler();
        $urlEntity->setCrawlEnd()
            ->setSpiderId($stats->getSpiderId())
            ->setQueued(count($stats->getQueued()))
            ->setFailed(count($stats->getFailed()))
            ->setSkipped(count($stats->getFiltered()));
        $updateEnd = $this->getServiceLocator()->get('Application\Model\Service\Url')->update($urlEntity);

        return true;
    }

    /**
     * @param UrlEntity $urlEntity
     * @return UrlEntity
     */
    public function findAllByUrlId(UrlEntity $urlEntity)
    {
        $response = $this->getMapper()->findAllByUrlId($urlEntity);

        return $response;
    }


}
