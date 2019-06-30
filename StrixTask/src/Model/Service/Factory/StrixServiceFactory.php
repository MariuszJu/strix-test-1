<?php

namespace StrixTask\Model\Service\Factory;

use Interop\Container\ContainerInterface;
use StrixTask\Model\Service\StrixService;
use StrixTask\Model\Repository\TripRepository;
use Zend\ServiceManager\Factory\FactoryInterface;
use StrixTask\Model\Repository\TripMeasureRepository;

class StrixServiceFactory implements FactoryInterface
{

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return object|StrixService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new StrixService(
            $container->get(TripRepository::class), $container->get(TripMeasureRepository::class)
        );
    }

}
