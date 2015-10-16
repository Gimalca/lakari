<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Account\Controller\Register' => 'Account\Controller\RegisterController',
          
        ),
    ),
    'router' => array(
        'routes' => array(
            'account' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/account[/:controller][/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Account\Controller',
                        'controller' => 'Register',
                        'action' => 'add',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Account' => __DIR__ . '/../view',
        ),
    ),
  
);