<?php

namespace Sales\Model\Dao;

/**
 * Description of CustomerDao
 *
 * @author Pedro
 */

use Zend\Db\TableGateway\TableGateway;
use Sales\Model\Entity\Customer;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CustomerDao {

    protected $tableGateway;
    private $query;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

     public function getAll() {
        $query = $this->tableGateway->getSql()->select();

        $query->order("customer_id DESC");
        //echo $query->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet);die;

        return $resultSet;
    }
    
    public function setAll()
    {        
        $query = $this->tableGateway->getSql()->select();

        $query->order("customer_id DESC");
        //echo $query->getSqlString();die;

        $this->query = $query;
        
        return $this;
    }

        public function getResulSet()
    {    
        return  $this->tableGateway->selectWith($this->query);  
    }


    public function getPaginator()
    {   
         $select = $this->query ;
         //$select = $this->tableGateway->getSql()->select();
        // create a new result set based on the Album entity
        $resultSetPrototype = $this->tableGateway->getResultSetPrototype();
        // create a new pagination adapter object
        $paginatorAdapter = new DbSelect(
                // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $resultSetPrototype
        );
        
        $paginator = new Paginator($paginatorAdapter);
        
        return $paginator;
    }

    public function getById($id, $columns) {

        $id = (int) $id;
        $sql = $this->tableGateway->getSql();

        $query = $sql->select()
                    ->columns($columns)
                    ->where(array('lk_customer.customer_id' => $id));

        $resultSet = $this->tableGateway->selectWith($query);
        $row = $resultSet->current();
        return $row;
    }

    public function savedCustomer($data) {
        
        //print_r($data);die;
         return $this->tableGateway->insert($data);
    }
    
     public function fetchAll($paginated=false)
     {
         if ($paginated) {
             // create a new Select object for the table album
             $select = $this->tableGateway->getSql()->select();
             // create a new result set based on the Album entity
             $resultSetPrototype = $this->tableGateway->getResultSetPrototype();
             // create a new pagination adapter object
             $paginatorAdapter = new DbSelect(
                 // our configured select object
                 $select,
                 // the adapter to run it against
                 $this->tableGateway->getAdapter(),
                 // the result set to hydrate
                 $resultSetPrototype
             );
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }
}
