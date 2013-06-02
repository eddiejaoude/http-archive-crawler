<?php

namespace Application\Controller;

use Application\Model\Entity\Url as UrlEntity;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\CrawlerForm;

/**
 * Class UrlController
 *
 * @package Application\Controller
 */
class UrlController extends AbstractActionController
{

    public function indexAction()
    {
        $urlEntity = new UrlEntity();

        $urlList = $this->getServiceLocator()
            ->get('Application\Model\Service\Url')
            ->findAll();

        return array(
            'urlList'   => $urlList,
        );
    }

    /**
     * @return array|ViewModel
     */
    public function crawlAction()
    {
        $form = new CrawlerForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $urlEntity = new UrlEntity();
            $form->setInputFilter($urlEntity->getInputFilter())
                ->setData($request->getPost());

            if ($form->isValid()) {
                $urlEntity->exchangeArray($form->getData());
                $urlEntity = $this->getServiceLocator()
                    ->get('Application\Model\Service\Url')
                    ->create($urlEntity);

                if ($urlEntity->getId()) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Crawl url \'' . $urlEntity->getUrl() . '\' has been added'
                    );
                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'Crawl url \'' . $urlEntity->getUrl() . '\' has NOT been added'
                    );
                }
                return $this->redirect()->toRoute(null, array('action' => 'index'));
            }
        }

        return array(
            'form'      => $form,
        );
    }

}
