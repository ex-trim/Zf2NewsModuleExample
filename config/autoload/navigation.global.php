<?php

return array(
    'service_manager'   => array(
        'abstract_factories'    => array(
            Zend\Navigation\Service\NavigationAbstractServiceFactory::class,
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home'
            ),
            array(
                'label' => 'News',
                'route' => 'news',
                'pages' => array(
                    array(
                        'label'     => 'Add news',
                        'route'     => 'news/add',
                    ),
                    array(
                        'label'     => 'Edit news',
                        'route'     => 'news/edit',
                    ),
                    array(
                        'label'     => 'Delete news',
                        'route'     => 'news/delete',
                    ),
                    array(
                        'label'     => 'News list',
                        'route'     => 'news/list',
                    ),
                    array(
                        'label'     => 'News archive',
                        'route'     => 'archive',
                    ),
                    array(
                        'label'     => 'News Topics',
                        'route'     => 'theme',
                    )
                ),
            ),array(
                'label' => 'Themes',
                'route' => 'themes',
                'pages' => array(
                    array(
                        'label'     => 'Add theme',
                        'route'     => 'themes/add',
                    ),
                    array(
                        'label'     => 'Edit theme',
                        'route'     => 'themes/edit',
                    ),
                    array(
                        'label'     => 'Delete theme',
                        'route'     => 'themes/delete',
                    ),
                ),
            ),
        ),
    ),
);