<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Catalog\Controller\Index' => 'Catalog\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'catalog' => array(
                'type' => 'segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/catalogo',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Catalog\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'product' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[/:product]',
                            'defaults' => array(
                                'action' => 'detail',
                            ),
                            'constraints' => array(
                                'product' => '[a-zA-Z0-9_-]*',
                            )
                        ),
                    ),
                    'categoria' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/categoria[/:category]',
                            'constraints' => array(
                                'category' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action' => 'categoryList',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Catalog' => __DIR__ . '/../view',
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            'MyHelper' => __DIR__ . '/../view/helper\MyHelper',
            'truncateWords' => __DIR__ . '/../view/helper\TruncateWords',
        ),
    )
);
