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
use Application\Model\Dao\Crawler\Crawler as CrawlerDao;
use Application\Model\Mapper\Crawler\Crawler as CrawlerMapper;
use Application\Model\Service\Crawler as CrawlerService;

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
                // crawler
                'Application\Model\Service\Crawler' => function($sm) {
                    $mapper = $sm->get('Application\Model\Mapper\Crawler\Crawler');
                    $service = new CrawlerService($mapper);
                    return $service;
                },
                'Application\Model\Mapper\Crawler\Crawler' => function($sm) {
                    $dao = $sm->get('Application\Model\Dao\Crawler\Crawler');
                    $mapper = new CrawlerMapper($dao);
                    return $mapper;
                },
                'Application\Model\Dao\Crawler\Crawler' =>  function($sm) {
                    $dao = new CrawlerDao();
                    return $dao;
                },
            )
        );
    }

}
