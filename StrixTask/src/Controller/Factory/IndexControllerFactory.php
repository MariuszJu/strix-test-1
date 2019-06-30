<?php

namespace StrixTask\Controller\Factory;

use StrixTask\Model\Helper\Console;
use Interop\Container\ContainerInterface;
use StrixTask\Controller\IndexController;
use StrixTask\View\Presenter\PresenterStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): IndexController
    {
        return new IndexController(
            $container->get(PresenterStrategy::class), $container->get(Console::class)
        );
    }

}
