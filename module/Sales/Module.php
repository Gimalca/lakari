<?php
namespace Sales;





use Sales\Model\Entity\Customer;
use Sales\Model\Dao\CustomerDao;
use Sales\Model\Entity\Seller;
use Sales\Model\Dao\SellerDao;
use Sales\Model\Entity\Order;
use Sales\Model\Dao\OrderDao;

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
                },
                'Model\Dao\SellerDao' => function ($sm) {
                    $tableGateway = $sm->get('SellerTableGateway');
                    $dao = new SellerDao($tableGateway);
                    return $dao;
                },
                
                'SellerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Seller());
                    return new TableGateway('lk_seller', $dbAdapter, null, $resultSetPrototype);
                },
                'Model\Dao\OrderDao' => function ($sm) {
                    $tableGateway = $sm->get('OrderTableGateway');
                    $dao = new OrderDao($tableGateway);
                    return $dao;
                },
                'Model\Dao\OrderDaoAdmin' => function ($sm) {
                    $tableGateway = $sm->get('OrderTableGateway');
                    $dao = new OrderDao($tableGateway);
                    return $dao;
                },
                'Model\Dao\OrderDao' => function ($sm) {
                    $tableGateway = $sm->get('OrderTableGateway');
                    $dao = new OrderDao($tableGateway);
                    return $dao;
                },
                
                'OrderTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Order());
                    return new TableGateway('lk_order', $dbAdapter, null, $resultSetPrototype);
                },
            )
        )
        ;
    }
}
