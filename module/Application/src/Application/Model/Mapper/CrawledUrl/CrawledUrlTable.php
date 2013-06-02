<?php
namespace Application\Model\Mapper\CrawledUrl;

use Common\Model\Mapper\Core;
use Application\Model\Entity\CrawledUrl as CrawledUrlEntity;
use Application\Model\Entity\Url as UrlEntity;

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
     * @return CrawledUrlEntity $crawledUrl
     */
    static public function mapToInternal(\ArrayObject $data)
    {
        $crawledUrlEntity = new CrawledUrlEntity;
        $crawledUrlEntity->setId($data['id'])
            ->setUrlId($data['url_id'])
            ->setUrl($data['url'])
            ->setCreatedOn($data['created_on'])
            ->setUpdatedOn($data['updated_on']);

        return $crawledUrlEntity;
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
     * @param \Application\Model\Entity\Url $urlEntity
     * @internal param \Application\Model\Entity\Url $url
     * @return array
     */
    public function findAllByUrlId(UrlEntity $urlEntity)
    {
        $data = array('url_id' => $urlEntity->getId());
        $response = $this->getDao()->findAllByUrlId($data);

        foreach ($response as $crawledUrl) {
            $resultSet = self::mapToInternal($crawledUrl);
            $urlEntity->addCrawledUrl($resultSet);
        }

        return $urlEntity;
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
