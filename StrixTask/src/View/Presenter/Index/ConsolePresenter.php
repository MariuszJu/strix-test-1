<?php

namespace StrixTask\View\Presenter\Index;

use Zend\Http\Request;
use StrixTask\Model\Entity\Trip;
use StrixTask\Model\Helper\Console;
use StrixTask\Model\Service\StrixService;

class ConsolePresenter implements IndexPresenter
{

    /** @var Request */
    private $request;

    /** @var StrixService */
    private $service;

    /** @var Console */
    private $console;

    /**
     * ConsolePresenter constructor
     *
     * @param Request      $request
     * @param StrixService $service
     * @param Console      $console
     */
    public function __construct(Request $request, StrixService $service, Console $console)
    {
        $this->request = $request;
        $this->service = $service;
        $this->console = $console;
    }

    /**
     * @throws \RuntimeException
     */
    public function index()
    {
        $calculation = $this->service->calculateTripMeasures();

        $header = '| trip        | distance | measure interval | avg speed |';

        $this->console->writeInfo(str_repeat('-', strlen($header)));
        $this->console->writeInfo($header);
        $this->console->writeInfo(str_repeat('-', strlen($header)));

        foreach ($calculation as $item) {
            /** @var Trip $trip */
            $trip = $item['trip'];
            $tripName = strlen($trip->getName()) > 8 ? substr($trip->getName(), 0, 8) . '..' : $trip->getName();

            $name = str_pad($tripName, 11, ' ');
            $distance = str_pad($item['distance'], 8, ' ', STR_PAD_LEFT);
            $interval = str_pad($trip->getMeasureInterval(), 16, ' ', STR_PAD_LEFT);
            $speed = str_pad($item['avg_speed'], 9, ' ', STR_PAD_LEFT);

            $this->console->writeInfo(sprintf('| %s | %s | %s | %s |',
                $name, $distance,$interval, $speed
            ));
        }

        $this->console->writeInfo(str_repeat('-', strlen($header)));

        exit;
    }

}
