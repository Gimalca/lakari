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
    
    public function savedCustomer($data)
    {
         return $this->tableGateway->insert($data);
    }
    
    
}
