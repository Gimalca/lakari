<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Usuario' => 'Admin\Controller\UsuarioController',
            'Admin\Controller\Product' => 'Admin\Controller\ProductController',
            'Admin\Controller\Product' => 'Admin\Controller\ProductController',
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
    )
);
