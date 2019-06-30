<?php

use Zend\Router\Http\Literal;
use StrixTask\Controller\IndexController;

return [
    'home' => [
        'type' => Literal::class,
        'options' => [
            'route'    => '/',
            'defaults' => [
                'controller' => IndexController::class,
                'action'     => 'index',
            ],
        ],
    ],
];