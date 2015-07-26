<?php
namespace Sales;





use Sales\Model\Entity\Customer;
use Sales\Model\Dao\CustomerDao;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
     public function getServiceConfig()
    {
        return array(
            'factories' => array(
                 
                'Model\Dao\CustomerDao' => function ($sm) {
                    $tableGateway = $sm->get('CustomerTableGateway');
                    $dao = new CustomerDao($tableGateway);
                    return $dao;
                },
                
                'CustomerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Customer());
                    return new TableGateway('lk_customer', $dbAdapter, null, $resultSetPrototype);
                }
            )
        )
        ;
    }
}
