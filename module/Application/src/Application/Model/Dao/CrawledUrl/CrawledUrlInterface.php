<?php
namespace Application\Model\Dao\CrawledUrl
;

/**
 * Class CrawledUrlInterface
 *
 * @package Application\Model\Dao\CrawledUrl
 */
interface CrawledUrlInterface
{
    /**
     * @param array $data
     * @return int
     */
    public function create(array $data);

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findAll();

    /**
     * @param array $data
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findById(array $data);

    /**
     * @param array $data
     * @return int
     */
    public function update(array $data);
}