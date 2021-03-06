<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Usuario' => 'Admin\Controller\UsuarioController',
            'Admin\Controller\Product' => 'Admin\Controller\ProductController',
            'Admin\Controller\Provider' => 'Admin\Controller\ProviderController',
            'Admin\Controller\Customer' => 'Admin\Controller\CustomerController',
            'Admin\Controller\Order' =>    'Admin\Controller\OrderController',
            'Admin\Controller\Seller' =>    'Admin\Controller\SellerController',
            'Admin\Controller\Category' =>    'Admin\Controller\CategoryController',
            'Admin\Controller\InformationPage' =>    'Admin\Controller\InformationPageController',
        ),
    ),
     'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin[/:controller][/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'MyHelper' => 'Admin\View\Helper\MyHelper',
            'Alert' => 'Admin\View\Helper\AlertHelper',
            'FormCollection' => 'Admin\View\Helper\FormCollection'
        )
    ),
    'module_layouts' => array(
        'Admin' => 'layout/admin',
    ),
    'controller_layouts' => array(
        'Admin/Login' => 'layout/layout',
    ),
    'strategies' => array(
        'ViewJsonStrategy',
    )
);
