<?php

namespace Sales\Model\Dao;

/**
 * Description of CustomerDao
 *
 * @author Pedro
 */

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Sales\Model\Entity\Seller;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class SellerDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
     public function getAll()
    {
        $query = $this->tableGateway->getSql()->select();

        $query->order("seller_id DESC");
        //echo $query->getSqlString();die;
    
        $resultSet = $this->tableGateway->selectWith($query);
        //var_dump($resultSet);die;
    
        return $resultSet;
    }
    
    public function savedSeller($data)
    {
         return $this->tableGateway->insert($data);
    }
    
    public function updateSeller(Seller $seller)
    {
        $sellerId = (int) $seller->getSeller_id();
        
        $data_seller = array(
            'seller_id' => $seller->getSeller_id(),
            'firstname' => $seller->getFirstname(),
            'lastname' => $seller->getLastname(),
            'telephone' => $seller->getTelephone(),
            'movil' => $seller->getMovil(),
            'fax' => $seller->getFax(),
            'email' => $seller->getEmail(),
        );
        
        if ($this->getSellerById($sellerId)) {
            //$data_seller['date_modified'] = date("Y-m-d H:i:s");
            //print_r($data_seller);die;
            $this->tableGateway->update($data_seller, array(
               'seller_id' => $sellerId,
            ));
       }  
       
       return $sellerId;
    }

    public function getSellerById($id)
    {
        $id = (int) $id;
        
        $query = $this->tableGateway->getSql()->select();
        //echo $query->getSqlString();die;
        $query->where(array(
            'lk_seller.seller_id' => $id
        ));
        $resultSet = $this->tableGateway->selectWith($query);
        
        return $resultSet->current();
        //var_dump($resultSet->toArray()); die;
    }
    
      public function fetchAll($paginated=false)
     {
         if ($paginated) {
             // create a new Select object for the table album
             $select = new Select('lk_seller');
             // create a new result set based on the Album entity
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Seller());
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
