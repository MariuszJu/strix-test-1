<?php

namespace Application;

use StrixTask\Model\Helper\Console;
use StrixTask\Controller\IndexController;
use StrixTask\View\Presenter\PresenterStrategy;
use StrixTask\Controller\Factory\IndexControllerFactory;
use StrixTask\Model\Service\Factory\AbstractServiceFactory;
use StrixTask\View\Presenter\Factory\PresenterStrategyFactory;
use StrixTask\View\Presenter\Factory\AbstractPresenterFactory;
use StrixTask\Model\Repository\Factory\AbstractRepositoryFactory;

return [
    'router' => [
        'routes' => include __DIR__ . '/routes.php',
    ],

    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            PresenterStrategy::class => PresenterStrategyFactory::class,
        ],
        'abstract_factories' => [
            AbstractServiceFactory::class,
            AbstractPresenterFactory::class,
            AbstractRepositoryFactory::class,
        ],
        'invokables' => [
            Console::class => Console::class,
        ],
    ],

    'view_manager' => [
        'template_map' => [
            'layout/strix-layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/500'           => __DIR__ . '/../view/error/500.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'phpArray',
                'base_dir' => __DIR__ . '/../data/language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
];