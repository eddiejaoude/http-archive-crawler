<?php

namespace Application\Controller;

use Application\Model\Entity\Url as UrlEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class CrawlController
 *
 * @package Application\Controller
 */
class CrawlController extends AbstractActionController
{

    /**
     * @return mixed
     */
    public function runAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id');

        $urlEntity = new UrlEntity;
        $urlEntity->setId($id);

        $response = $this->getServiceLocator()
            ->get('Application\Model\Service\CrawledUrl')
            ->run($urlEntity);

        return new ViewModel();
    }

}
