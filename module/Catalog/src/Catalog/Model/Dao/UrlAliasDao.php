<?php

namespace Catalog\Model\Dao;

/**
 * Description of ProductTable
 *
 * @author Pedro
 */
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Catalog\Model\Entity\UrlAlias;

class UrlAliasDao 
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getKeywordId($keyword)
    {
        $ide = $keyword;
        $rowset = $this->tableGateway->select(array('keyword' => $ide));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $ide");
        }
        return $row;
    }

    public function getAll($urlSeo)
    {
        $sql = $this->tableGateway->getSql();
        $select = $sql->select();
        $select->columns(array('keyword'));
        $select->where(array(
            'keyword' => $urlSeo,
        ));
       // echo $sqlstring = $sql->getSqlStringForSqlObject($select);die;
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;

    }

    //put your code here
}
