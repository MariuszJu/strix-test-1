<?php

namespace StrixTask\Controller;

use Zend\View\Model\ViewModel;
use StrixTask\Model\Helper\Console;
use StrixTask\Model\Helper\Runtime;
use StrixTask\View\Presenter\PresenterStrategy;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{

    /** @var PresenterStrategy */
    private $presenterStrategy;

    /** @var Console */
    private $console;

    /**
     * IndexController constructor
     *
     * @param PresenterStrategy $presenterStrategy
     * @param Console           $console
     */
    public function __construct(PresenterStrategy $presenterStrategy, Console $console)
    {
        $this->presenterStrategy = $presenterStrategy;
        $this->console = $console;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        try {
            return $this->presenterStrategy->getPresenter()->index();
        } catch (\RuntimeException $e) {
            $message = $e->getMessage();
        } catch (\Throwable $e) {
            $message = 'General error occured. Please try again later';
        }

        return $this->error($message);
    }

    /**
     * @param string $message
     * @return ViewModel
     */
    private function error(string $message): ViewModel
    {
        if (Runtime::isCommandLineInterface()) {
            $this->console->writeError($message);
            exit;
        }

        return (new ViewModel([
            'error'       => $message,
            'previousUrl' => $this->getRequest()->getHeader('HTTP_REFERER', '/'),
        ]))->setTemplate('error/500');
    }

}
