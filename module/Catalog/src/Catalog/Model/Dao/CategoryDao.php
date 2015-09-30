<?php

namespace Catalog\Model\Dao;

/**
 * Description of ProductTable
 *
 * @author Pedro
 */
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Catalog\Model\Entity\Category;
use Catalog\Model\Entity\CategoryDescription;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

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
        //$query->getSqlString(); die;
        //print_r($query);die;
        $resultSet = $this->tableGateway->selectWith($query);
        //$result = $resultSet->toArray();
        //print_r($result);die;
        
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
    
   
    private function saveCategoryDescription(CategoryDescription $categoryDescription){
        
        //print_r($categoryDescription);die;
        $categoryDescriptionData = $categoryDescription->getArrayCopy();
        //print_r($categoryDescriptionData);die;
        $table = $this->getTable('lk_category_description');
        
        $insert = $table->insert($categoryDescriptionData);
        
        return $insert;
        
    }

    public function saveCategory(Category $category, CategoryDescription $categoryDescription)
    { 
        //print_r($data);die;
        $dataCategory =  $category->getArrayCopy();
        unset($dataCategory['name']);
        
        $insert = $this->tableGateway->insert($dataCategory);
        
        if($insert){
            
            $categoryId = $this->tableGateway->getLastInsertValue();
            
            $categoryDescription->category_id = $categoryId;
            $saveCategoryDescription = $this->saveCategoryDescription($categoryDescription);
        }
       
        return $categoryId; 
    }
    
    private function getTable($tableName){
        
        $adapter = $this->tableGateway->getAdapter();
        $table = new TableGateway($tableName, $adapter);
        
        return $table;
    }

    public function fetchAll($paginated=false)
     {
         if ($paginated) {
             // create a new Select object for the table album
             $select = new Select('lk_category');
             // create a new result set based on the Album entity
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Category());
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


    //put your code here
}
