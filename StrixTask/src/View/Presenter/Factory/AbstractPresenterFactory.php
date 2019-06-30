<?php

namespace StrixTask\View\Presenter\Factory;

use StrixTask\Model\Helper\Console;
use StrixTask\View\Presenter\Presenter;
use Interop\Container\ContainerInterface;
use StrixTask\Model\Service\StrixService;
use StrixTask\View\Presenter\Index\HttpPresenter;
use StrixTask\View\Presenter\Index\ConsolePresenter;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractPresenterFactory implements AbstractFactoryInterface
{

    /** @var array */
    protected $services = [
        ConsolePresenter::class,
        HttpPresenter::class,
    ];

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return in_array($requestedName, $this->services);
    }

    /**
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \ReflectionException
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     * @return Presenter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $presenterArgs = [
            $container->get('Request'), $container->get(StrixService::class)
        ];

        if ($requestedName == ConsolePresenter::class) {
            $presenterArgs[] = $container->get(Console::class);
        }

        return (new \ReflectionClass($requestedName))
            ->newInstanceArgs($presenterArgs);
    }

}
