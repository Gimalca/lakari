<?php

namespace Catalog\Model\Dao;

/**
 * Description of ProductTable
 *
 * @author Pedro
 */
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\Entity\Category;

class CategoryDao 
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getAll()
    {
        $query = $this->tableGateway->getSql()->select();
        $query->join(array(
            'cd' => 'lk_category_description'
        ),  'cd.category_id = lk_category.category_id');
        
        $query->order("lk_category.category_id DESC");
        //echo $query->getSqlString();die;
        
        $resultSet = $this->tableGateway->selectWith($query);
       
        //var_dump($resultSet);die;
        
        return $resultSet;
       
    }
    public function getCategories($categories)
    {     
        $query = $this->tableGateway->getSql()->select();
        $query->join(array(
            'cd' => 'lk_category_description'
        ),  'cd.category_id = lk_category.category_id');
        
        if ($categories) {
            $query->where(array('lk_category.category_id' => $categories));
        }
        //echo $query->getSqlString();die;
        $resultSet = $this->tableGateway->selectWith($query);
         
    
        return $resultSet;
    }

    //put your code here
}