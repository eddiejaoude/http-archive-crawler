<?php

namespace Application\Controller;

use Application\Model\Entity\Url as UrlEntity;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class CrawledUrlController
 *
 * @package Application\Controller
 */
class CrawledUrlController extends AbstractActionController
{

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id');

        $urlEntity = new UrlEntity;
        $urlEntity->setId($id);

        $response = $this->getServiceLocator()
            ->get('Application\Model\Service\CrawledUrl')
            ->findAllByUrlId($urlEntity);

        return array(
            'url' => $response
        );
    }


}
