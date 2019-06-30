<?php

namespace StrixTask;

use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\Controller\AbstractController;

class Module
{

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return require __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig(): array
    {
        return [
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $event->getApplication()
            ->getEventManager()
            ->getSharedManager()
            ->attach(AbstractController::class, 'dispatch', function ($e) {
                $controller = $e->getTarget();
                $controllerClass = get_class($controller);

                if (strpos($controllerClass, 'StrixTask') !== false) {
                    $controller->layout('layout/strix-layout');
                }
            }, 100);
    }

}
