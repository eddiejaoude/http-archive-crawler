<?php
namespace Application\Model\Mapper\Url;

use Common\Model\Mapper\Core;
use Application\Model\Entity\Url as UrlEntity;

class UrlTable extends Core implements UrlInterface
{

    /**
     * @param UrlEntity $url
     * @return array
     */
    static public function mapToExternal(UrlEntity $url)
    {
        $data = array(
            'id'          => $url->getId(),
            'url'         => $url->getUrl(),
            'depth'         => $url->getDepth(),
            'limit'         => $url->getLimit(),
            'spider_id'   => $url->getSpiderId(),
            'queued'      => $url->getQueued(),
            'skipped'     => $url->getSkipped(),
            'failed'      => $url->getFailed(),
            'crawl_start' => $url->getCrawlStart(),
            'crawl_end'   => $url->getCrawlEnd(),
            'updated_on'  => $url->getUpdatedOn(),
            'created_on'  => $url->getCreatedOn(),
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
            ->setUrl($data['url'])
            ->setDepth($data['depth'])
            ->setLimit($data['limit'])
            ->setUserId($data['user_id'])
            ->setSpiderId($data['spider_id'])
            ->setQueued($data['queued'])
            ->setSkipped($data['skipped'])
            ->setFailed($data['failed'])
            ->setCrawlStart($data['crawl_start'])
            ->setCrawlEnd($data['crawl_end'])
            ->setCreatedOn($data['created_on'])
            ->setUpdatedOn($data['updated_on']);

        return $urlEntity;
    }

    /**
     * @param UrlEntity $url
     * @return bool|void
     */
    public function create(UrlEntity $url)
    {
        $data = self::mapToExternal($url);

        $id = $this->getDao()->create($data);

        $url->setId($id);

        return $url;
    }

    /**
     * @param UrlEntity $url
     * @internal param \Application\Model\Mapper\Url\CrawlerEntity $crawler
     * @return bool|void
     */
    public function update(UrlEntity $url)
    {
        $url->setUpdatedOn();
        $data = self::mapToExternal($url);
        unset($data['created_on']);

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
     * @param UrlEntity $url
     * @return array
     */
    public function findById(UrlEntity $url)
    {
        $data      = array('id' => $url->getId());
        $response  = $this->getDao()->findById($data);
        $resultSet = self::mapToInternal($response);

        return $resultSet;
    }

    public function crawl(UrlEntity $url)
    {
        $data     = array(
            'url' => $url->getUrl()
        );
        $response = $this->getDao()->crawl($data);

        return $response;
    }


}
