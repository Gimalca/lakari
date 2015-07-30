<?php

namespace Sales\Model\Dao;

/**
 * Description of CustomerDao
 *
 * @author Pedro
 */

use Zend\Db\TableGateway\TableGateway;

class CustomerDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
     public function getAll()
    {
        $query = $this->tableGateway->getSql()->select();

        $query->order("customer_id DESC");
        //echo $query->getSqlString();die;
    
        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet);die;
    
        return $resultSet;
         
    }
    
    public function savedCustomer($data)
    {
         return $this->tableGateway->insert($data);
    }
    
    
}
