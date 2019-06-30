<?php

namespace StrixTask\View\Presenter\Factory;

use Interop\Container\ContainerInterface;
use StrixTask\View\Presenter\PresenterStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;

class PresenterStrategyFactory implements FactoryInterface
{

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return PresenterStrategy
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): PresenterStrategy
    {
        return new PresenterStrategy($container);
    }

}
