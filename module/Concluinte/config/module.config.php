<?php

return array(
    'router' => array(
        'routes' => array(
            'navegacao' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:controller[/:action[/:id]]',
                    'defaults' => array(
                        'action'     => 'index',
                    ),
                ),
            ),
            'concluinte-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/concluinte',
                    'defaults' => array(
                        'controller' => 'concluinte',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'concluinte' => 'Concluinte\Controller\ConcluinteController',
            'concluinte-concluinte' => 'Concluinte\Controller\ConcluinteController',

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
