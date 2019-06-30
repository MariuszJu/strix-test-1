<?php

namespace StrixTask\Model\Service\Factory;

use Interop\Container\ContainerInterface;
use StrixTask\Model\Service\StrixService;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractServiceFactory implements AbstractFactoryInterface
{

    /** @var array */
    protected $services = [
        StrixService::class => StrixServiceFactory::class,
    ];

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return array_key_exists($requestedName, $this->services);
    }

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $factory = new $this->services[$requestedName];
        
        return $factory($container, $requestedName, $options);
    }

}
