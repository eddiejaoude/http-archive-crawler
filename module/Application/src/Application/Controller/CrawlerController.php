<?php

namespace Application\Controller;

use Application\Model\Entity\Crawler as CrawlerEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\CrawlerForm;

/**
 * Class CrawlerController
 *
 * @package Application\Controller
 */
class CrawlerController extends AbstractActionController
{

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
        $form          = new CrawlerForm();
        $crawlerEntity = new CrawlerEntity();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($crawlerEntity->getInputFilter())
                ->setData($request->getPost());

            if ($form->isValid()) {
                $crawlerEntity->exchangeArray($form->getData());
                $crawlerEntity = $this->getServiceLocator()
                    ->get('Application\Model\Service\Crawler')
                    ->create($crawlerEntity);

            }
        }

        return array(
            'form'          => $form,
            'crawlerEntity' => $crawlerEntity
        );
    }

    public function createAction()
    {
        $request = $this->getRequest();

        // We can access named value parameters directly by their name:
        $url = $request->getParam('url');

        $response = $this->getServiceLocator()
            ->get('Application\Model\Service\Crawler')
            ->crawlUrl($url);

        return $response;
    }

}
