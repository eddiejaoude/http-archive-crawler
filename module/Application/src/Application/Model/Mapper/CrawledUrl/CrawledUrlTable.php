<?php
namespace Application\Model\Mapper\CrawledUrl;

use Common\Model\Mapper\Core;
use Application\Model\Entity\CrawledUrl as CrawledUrlEntity;

class CrawledUrlTable extends Core implements CrawledUrlInterface
{

    /**
     * @param CrawledUrlEntity $url
     * @return array
     */
    static public function mapToExternal(CrawledUrlEntity $url)
    {
        $data = array(
            'id'        => $url->getId(),
            'url_id'    => $url->getUrlId(),
            'url'        => $url->getUrl(),
            'updated_on' => $url->getUpdatedOn(),
            'created_on' => $url->getCreatedOn(),
        );

        return $data;
    }

    /**
     * @param \ArrayObject $data
     * @return UrlEntity $url
     */
    static public function mapToInternal(\ArrayObject $data)
    {
        $urlEntity = new UrlEntity;
        $urlEntity->setId($data['id'])
            ->setUrlId($data['url_id'])
            ->setUrl($data['url'])
            ->setCreatedOn($data['created_on'])
            ->setUpdatedOn($data['updated_on']);

        return $urlEntity;
    }

    /**
     * @param CrawledUrlEntity $url
     * @return bool|void
     */
    public function create(CrawledUrlEntity $url)
    {
        $data = self::mapToExternal($url);

        $id = $this->getDao()->create($data);

        $url->setId($id);

        return $url;
    }

    /**
     * @param CrawledUrlEntity $url
     * @return bool
     */
    public function update(CrawledUrlEntity $url)
    {
        $data = self::mapToExternal($url);
        unset($data['updated_on']);

        $response = $this->getDao()->update($data);

        return $response;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $response = $this->getDao()->findAll();

        $collection = array();
        foreach ($response as $url) {
            $collection[] = self::mapToInternal($url);
        }

        return $collection;
    }

    /**
     * @param CrawledUrlEntity $url
     * @return array
     */
    public function findById(CrawledUrlEntity $url)
    {
        $data = array('id' => $url->getId());
        $response = $this->getDao()->findById($data);
        $resultSet = self::mapToInternal($response);

        return $resultSet;
    }


}
