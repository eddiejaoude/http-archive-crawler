<?php
namespace Application\Model\Service;

use Common\Model\Service\Core;
use Application\Model\Entity\Url as UrlEntity;

/**
 * Class Crawler
 *
 * @package Application\Model\Service
 */
class Url extends Core
{

    /**
     * @param UrlEntity $url
     * @return UrlEntity
     */
    public function create(UrlEntity $url)
    {
        $url = $this->getMapper()->create($url);

        // start crawl
        $this->getServiceLocator()->get('Application\Model\Service\Crawl')->run($url);

        return $url;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $response = $this->getMapper()->findAll();

        return $response;
    }

    /**
     * @param UrlEntity $url
     * @return UrlEntity
     */
    public function findById(UrlEntity $url)
    {
        $url = $this->getMapper()->findById($url);

        return $url;
    }

    /**
     * @param UrlEntity $url
     * @return int
     */
    public function update(UrlEntity $url)
    {
        $response = $this->getMapper()->update($url);

        return $response;
    }


}