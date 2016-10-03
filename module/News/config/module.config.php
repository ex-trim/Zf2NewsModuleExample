<?php

namespace News;

use News\Form\NewsFieldset;

return array(
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array( __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'news' => __DIR__ . '/../view',
        )
    ),
    'controllers' => array(
        'factories'    => array(
            'News\Controller\List'      => 'News\Factory\ListControllerFactory',
            'News\Controller\Write'     => 'News\Factory\WriteControllerFactory',
            'News\Controller\Delete'    => 'News\Factory\DeleteControllerFactory',
            'News\Controller\Theme'     => 'News\Factory\ThemeControllerFactory'
        ),
    ),
    'form_elements' => array(
        'factories' => array(
            'News\Form\NewsForm'        => 'News\Factory\NewsFormFactory',
            'News\Form\ThemeForm'       => 'News\Factory\ThemeFormFactory'
        ),
    ),
    'router' => array(
        'routes' => array(
            'archive'   => array(
                'type'      => 'segment',
                'options'   => array(
                    'route'     => '/news/archive/:year[/:month][/page/:page]',
                    'defaults'  => array(
                        'controller'    => 'News\Controller\List',
                        'action'        => 'archive',
                        'page'          => 1
                    ),
                    'constraints'   => array(
                        'page'      => '\d+'
                    ),
                    'skippable' => array(
                        'month'  => true
                    )
                ),
            ),
            'theme'   => array(
                'type'      => 'segment',
                'options'   => array(
                    'route'     => '/news/theme/:theme[/page/:page]',
                    'defaults'  => array(
                        'controller'    => 'News\Controller\List',
                        'action'        => 'theme',
                        'page'          => 1
                    ),
                    'constraints'   => array(
                        'page'      => '\d+'
                    )
                ),
            ),
            'news' => array(
                'type'      => 'literal',
                'options'   => array(
                    'route'     => '/news',
                    'defaults'  => array(
                        'controller'    => 'News\Controller\List',
                        'action'        => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'page'      => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/page/:page',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\List',
                                'action'        => 'index',
                                'page'          => 1
                            ),
                            'constraints'   => array(
                                'page'      => '\d+'
                            )
                        ),
                    ),
                    'list'   => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/list',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\List',
                                'action'        => 'list'
                            ),
                        ),
                    ),
                    'detail'    => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/:id',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\List',
                                'action'        => 'detail'
                            ),
                            'constraints'       => array(
                                'id'            => '\d+'
                            ),
                        ),
                    ),
                    'add'   => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/add',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\Write',
                                'action'        => 'add'
                            ),
                        ),
                    ),
                    'edit'  => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/edit/:id',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\Write',
                                'action'        => 'edit'
                            ),
                            'constraints'       => array(
                                'id'            => '\d+'
                            ),
                        ),
                    ),
                    'delete'    => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/delete/:id',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\Delete',
                                'action'        => 'delete'
                            ),
                            'constraints'       => array(
                                'id'            => '\d+'
                            ),
                        ),
                    ),
                ),
            ),
            'themes'    => array(
                'type'  => 'literal',
                'options'   => array(
                    'route' => '/themes',
                    'defaults'  => array(
                        'controller'    => 'News\Controller\Theme',
                        'action'        => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'add'   => array(
                        'type'      => 'literal',
                        'options'   => array(
                            'route'     => '/add',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\Theme',
                                'action'        => 'add'
                            ),
                        ),
                    ),
                    'edit'  => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/edit/:id',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\Theme',
                                'action'        => 'edit'
                            ),
                            'constraints'       => array(
                                'id'            => '\d+'
                            ),
                        ),
                    ),
                    'delete'    => array(
                        'type'      => 'segment',
                        'options'   => array(
                            'route'     => '/delete/:id',
                            'defaults'  => array(
                                'controller'    => 'News\Controller\Theme',
                                'action'        => 'delete'
                            ),
                            'constraints'       => array(
                                'id'            => '\d+'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);


