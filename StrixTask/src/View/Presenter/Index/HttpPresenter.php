<?php

namespace StrixTask\View\Presenter\Index;

use Zend\Http\Request;
use Zend\View\Model\ViewModel;
use StrixTask\Model\Entity\Trip;
use StrixTask\Model\Service\StrixService;

class HttpPresenter implements IndexPresenter
{

    /** @var StrixService */
    private $service;

    /** @var Request */
    private $request;

    /**
     * HttpPresenter constructor
     *
     * @param Request      $request
     * @param StrixService $service
     */
    public function __construct(Request $request, StrixService $service)
    {
        $this->service = $service;
        $this->request = $request;
    }

    /**
     * @throws \RuntimeException
     * @return ViewModel
     */
    public function index(): ViewModel
    {
        $viewData = [];
        $calculation = $this->service->calculateTripMeasures();

        foreach ($calculation as $item) {
            /** @var Trip $trip */
            $trip = $item['trip'];

            $viewData['calculation'][] = [
                'trip'      => $trip->getName(),
                'distance'  => $item['distance'],
                'interval'  => $trip->getMeasureInterval(),
                'avg_speed' => $item['avg_speed'],
            ];
        }
        
        return new ViewModel($viewData);
    }

}
