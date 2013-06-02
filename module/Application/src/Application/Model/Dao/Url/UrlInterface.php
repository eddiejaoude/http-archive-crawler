<?php
namespace Application\Model\Dao\Url
;

/**
 * Class UrlInterface
 *
 * @package Application\Model\Dao\Url
 */
interface UrlInterface
{

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data);

    /**
     * @param array $data
     * @return int
     */
    public function update(array $data);

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findAll();

    /**
     * @param array $data
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findById(array $data);

}