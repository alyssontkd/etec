<?php

return array(
    'router' => array(
        'routes' => array(
            'banca_examinadora' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/banca_examinadora/:action[/:id][/:aux]',
                    'defaults' => array(
                        'controller' => 'banca_examinadora',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'banca_examinadora' => 'BancaExaminadora\Controller\BancaExaminadoraController',
            'banca_examinadora-bancaexaminadora' => 'BancaExaminadora\Controller\BancaExaminadoraController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);