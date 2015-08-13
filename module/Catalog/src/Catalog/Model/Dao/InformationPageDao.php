<?php
/***
 * Description of InformationPageDao
 * 
 * @author Enrique Luque
 */

namespace Catalog\Model\Dao;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class InformationPageDao
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function getAll()
    {
        $query = $this->tableGateway->getSql()->select();
        //$query->columns(array('page_id'));
        $query->join(array(
            'pi' => 'lk_page_information'), 
                'pi.page_id = lk_page.page_id'
               , array('title')
        );
        $query->join(array(
            'po' => 'lk_page_option'),
                'po.page_id = lk_page.page_id'
                , array('name')
        );
        
        $resultSet = $this->tableGateway->selectWith($query);
        //$result = $resultSet->toArray();
        //print_r($resultSet);die;
        
        return $resultSet;
    }
}