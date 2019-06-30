<?php

namespace StrixTask\View\Presenter;

use StrixTask\Model\Helper\Runtime;
use Zend\ServiceManager\ServiceLocatorInterface;
use StrixTask\View\Presenter\Index\HttpPresenter;
use StrixTask\View\Presenter\Index\IndexPresenter;
use StrixTask\View\Presenter\Index\ConsolePresenter;

class PresenterStrategy
{

    /** @var ServiceLocatorInterface */
    private $serviceManager;

    /**
     * PresenterStrategy constructor
     *
     * @param ServiceLocatorInterface $serviceManager
     */
    public function __construct(ServiceLocatorInterface $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @throws \RuntimeException
     * @return IndexPresenter
     */
    public function getPresenter(): IndexPresenter
    {
        try {
            return Runtime::isCommandLineInterface()
                ? $this->serviceManager->get(ConsolePresenter::class)
                : $this->serviceManager->get(HttpPresenter::class);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Unable to determine valid Presenter');
        }
    }

}
