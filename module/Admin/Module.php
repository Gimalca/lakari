<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Admin\Model\Dao\CategoryDao;
use Admin\Model\Entity\Category;
use Admin\Model\Entity\Product;
use Admin\Model\Dao\ProductDao;
use Provider\Model\Entity\Provider;
use Provider\Model\Dao\ProviderDao;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface
{
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                 'Admin\Model\Dao\ProductDao' =>  function($sm) {
                     $tableGateway = $sm->get('ProductTableGateway');
                     $table = new ProductDao($tableGateway);
                     return $table;
                 },
                 'ProductTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Product());
                     return new TableGateway('lk_product', $dbAdapter, null, $resultSetPrototype);
                 },
                'Model\Dao\UsuarioDao' => function ($sm) {
                    $dao = new \Admin\Model\Dao\UsuarioDao();
                    return $dao;
                },
                
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    return new TableGateway('lk_category', $dbAdapter, null, $resultSetPrototype);
                },
                'Model\Dao\ProviderDao' => function ($sm) {
                    $tableGateway = $sm->get('ProviderTableGateway');
                    $dao = new ProviderDao($tableGateway);
                    return $dao;
                },
                
                'ProviderTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Provider());
                    return new TableGateway('lk_provider', $dbAdapter, null, $resultSetPrototype);
                }
            )
        )
        ;
    }
    
  
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'Admin\Controller\Login' => function($sm) {
               
                    $locator = $sm->getServiceLocator();
                    $usuarioDao = $locator->get('Model\Dao\UsuarioDao');
                    
                    $config = "";
                    $controller = new \Admin\Controller\LoginController($config, $usuarioDao );

                    return $controller;
                }
            ),
        );
    }
}
