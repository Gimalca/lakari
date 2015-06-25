<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Provider\Controller\Index' => 'Provider\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'provider' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/provider[/:action][/:id]',
                    'constraints' => array(
                        'controller' => 'index',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Provider\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Provider' => __DIR__ . '/../view',
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            
        ),
    )
);
