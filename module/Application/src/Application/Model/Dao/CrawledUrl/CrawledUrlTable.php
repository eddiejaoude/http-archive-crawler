<?php
namespace Application\Model\Dao\CrawledUrl;

use Common\Model\Dao\DaoInterface;
use Common\Model\Dao\Table;


class CrawledUrlTable extends Table implements CrawledUrlInterface, DaoInterface
{

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data)
    {
        $this->getTableGateway()->insert($data);
        $id = $this->getTableGateway()->getLastInsertValue();
        return $id;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findAll()
    {
        $resultSet = $this->getTableGateway()->select();
        return $resultSet;
    }

    /**
     * @param array $data
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findById(array $data)
    {
        $row = $this->getTableGateway()->select($data);

        return $row->current();
    }

    /**
     * @param array $data
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findAllByUrlId(array $data)
    {
        $rowSet = $this->getTableGateway()->select($data);

        return $rowSet;
    }

    /**
     * @param array $data
     * @return int
     */
    public function update(array $data)
    {
        $resultSet = $this->getTableGateway()->update($data, array('id' => $data['id']));
        return $resultSet;
    }

}