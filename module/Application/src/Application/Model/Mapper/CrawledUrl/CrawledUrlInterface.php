<?php
namespace Application\Model\Mapper\CrawledUrl;

use Application\Model\Entity\CrawledUrl as CrawledUrlEntity;

interface CrawledUrlInterface
{

    /**
     * @param CrawledUrlEntity $url
     * @return array
     */
    static public function mapToExternal(CrawledUrlEntity $url);

    /**
     * @param \ArrayObject $data
     * @return CrawledUrlEntity $url
     */
    static public function mapToInternal(\ArrayObject $data);

    /**
     * @param CrawledUrlEntity $url
     * @return bool|void
     */
    public function create(CrawledUrlEntity $url);

    /**
     * @param CrawledUrlEntity $url
     * @return bool
     */
    public function update(CrawledUrlEntity $url);

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param CrawledUrlEntity $url
     * @return array
     */
    public function findById(CrawledUrlEntity $url);

}