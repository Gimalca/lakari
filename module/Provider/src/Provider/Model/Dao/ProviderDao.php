<?php

namespace Provider\Model\Dao;

/**
 * Description of ProductTable
 *
 * @author Pedro
 */
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Provider\Model\Entity\Provider;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProviderDao 
{

    protected $tableGateway;
    private $query;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function getAll()
    {
        $query = $this->tableGateway->getSql()->select();

        $query->order("provider_id DESC");
        //echo $query->getSqlString();die;
    
        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet);die;
    
        return $resultSet;
         
    }
    
    public function setAll()
    {
        $query = $this->tableGateway->getSql()->select();
        
        $query->order("provider_id DESC");
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
    
    public function getById($id) {
        
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('provider_id' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        
        return $row;
    }
    
   

    public function saveProvider($data)
    { 
       
        return $this->tableGateway->insert($data);
       
    }
    
    public function getTable($table)
    {
        $adapter = $this->tableGateway->getAdapter();
        $table = new TableGateway($table, $adapter);
    
        return $table;
    }
    //put your code here
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
