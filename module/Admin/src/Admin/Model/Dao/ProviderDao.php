<?php

namespace Admin\Model\Dao;

/**
 * Description of ProductTable
 *
 * @author Pedro
 */
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\Entity\Provider;

class ProviderDao 
{

    protected $tableGateway;

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

    public function saveProvider($data)
    {
        //print_r($data);die;
        
        $explo = explode('img_', $data['logo']['tmp_name']);        
        $img = 'img_'. $explo[1];
        
        $data['logo'] = ($img== "img_") ?  'no-logo.jpg' : $img;
        $data['categories'] = implode (", ",  $data['categories']);
        $data['date_added'] = date("Y-m-d H:i:s");
        $data['salt'] = time();
        $data['password'] = md5($data['password'].$data['salt']);
       
        return $this->tableGateway->insert($data);
       
    }

    //put your code here
}
