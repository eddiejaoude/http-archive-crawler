<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Dao\Url\UrlTable as UrlDao;
use Application\Model\Mapper\Url\UrlTable as UrlMapper;
use Application\Model\Service\Url as UrlService;
use Application\Model\Dao\CrawledUrl\CrawledUrlTable as CrawledUrlDao;
use Application\Model\Mapper\CrawledUrl\CrawledUrlTable as CrawledUrlMapper;
use Application\Model\Service\CrawledUrl as CrawledUrlService;
use Application\Model\Dao\Crawl\CrawlCli as CrawlCliDao;
use Application\Model\Mapper\Crawl\CrawlCli as CrawlCliMapper;
use Application\Model\Service\Crawl as CrawlService;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                // url
                'Application\Model\Service\Url' => function($sm) {
                    $mapper = $sm->get('Application\Model\Mapper\Url\Url');
                    $service = new UrlService($mapper);
                    return $service;
                },
                'Application\Model\Mapper\Url\Url' => function($sm) {
                    $dao = $sm->get('Application\Model\Dao\Url\Url');
                    $mapper = new UrlMapper($dao);
                    return $mapper;
                },
                'Application\Model\Dao\Url\Url' =>  function($sm) {
                    $tableGateway = $sm->get('TableGatewayUrls');
                    $dao = new UrlDao($tableGateway);
                    return $dao;
                },
                'TableGatewayUrls' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    //$resultSetPrototype->setArrayObjectPrototype(new Item());
                    return new TableGateway('urls', $dbAdapter, null, $resultSetPrototype);
                },

                // crawled url
                'Application\Model\Service\CrawledUrl' => function($sm) {
                    $mapper = $sm->get('Application\Model\Mapper\CrawledUrl\CrawledUrlTable');
                    $service = new CrawledUrlService($mapper);
                    return $service;
                },
                'Application\Model\Mapper\CrawledUrl\CrawledUrlTable' => function($sm) {
                    $dao = $sm->get('Application\Model\Dao\CrawledUrl\CrawledUrlTable');
                    $mapper = new CrawledUrlMapper($dao);
                    return $mapper;
                },
                'Application\Model\Dao\CrawledUrl\CrawledUrlTable' =>  function($sm) {
                    $tableGateway = $sm->get('TableGatewayCrawledUrls');
                    $dao = new CrawledUrlDao($tableGateway);
                    return $dao;
                },
                'TableGatewayCrawledUrls' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    //$resultSetPrototype->setArrayObjectPrototype(new Item());
                    return new TableGateway('crawled_urls', $dbAdapter, null, $resultSetPrototype);
                },

                // crawl
                'Application\Model\Service\Crawl' => function($sm) {
                    $mapper = $sm->get('Application\Model\Mapper\Crawl\CrawlCli');
                    $service = new CrawlService($mapper);
                    return $service;
                },
                'Application\Model\Mapper\Crawl\CrawlCli' => function($sm) {
                    $dao = $sm->get('Application\Model\Dao\Crawl\CrawlCli');
                    $mapper = new CrawlCliMapper($dao);
                    return $mapper;
                },
                'Application\Model\Dao\Crawl\CrawlCli' =>  function($sm) {
                    $dao = new CrawlCliDao();
                    return $dao;
                },
            )
        );
    }

}
