<?php

namespace StrixTask\Model\Service;

use StrixTask\Model\Entity\Trip;
use StrixTask\Model\Entity\TripMeasure;
use StrixTask\Model\Repository\TripRepository;
use StrixTask\Model\Repository\TripMeasureRepository;

class StrixService
{

    /** @var TripRepository */
    private $tripRepository;

    /** @var TripMeasureRepository */
    private $tripMeasureRepository;

    /**
     * StrixService constructor
     *
     * @param TripRepository        $tripRepository
     * @param TripMeasureRepository $tripMeasureRepository
     */
    public function __construct(TripRepository $tripRepository, TripMeasureRepository $tripMeasureRepository)
    {
        $this->tripRepository = $tripRepository;
        $this->tripMeasureRepository = $tripMeasureRepository;
    }

    /**
     * @throws \RuntimeException
     * @return array
     */
    public function calculateTripMeasures(): array
    {
        $calculation = [];
        $trips = $this->trips();
        $this->hydrateTrips($trips);

        foreach ($trips as $trip) {
            $measures = $trip->getMeasures();
            /** @var TripMeasure|null $lastMeasure */
            $lastMeasure = end($measures);

            $avgSpeeds = $this->averageSpeedsForTrip($trip);

            $distance = (float) ($lastMeasure instanceof TripMeasure ? $lastMeasure->getDistance() : 0.0);
            $maxAvgSpeed = !empty($avgSpeeds) ? max($avgSpeeds) : 0;

            $calculation[] = [
                'trip'      => $trip,
                'distance'  => $distance,
                'avg_speed' => (int) $maxAvgSpeed,
            ];
        }

        return $calculation;
    }

    /**
     * @throws \RuntimeException
     * @param Trip $trip
     * @return array
     */
    protected function averageSpeedsForTrip(Trip $trip): array
    {
        $avgSpeeds = [];
        $measures = $trip->getMeasures();
        $inteval = $trip->getMeasureInterval();

        if (($measuresCount = count($measures)) <= 1) {
            return [];
        }

        for ($i = 0; $i < $measuresCount; $i++) {
            if ($i === $measuresCount - 1) {
                break;
            }

            /** @var TripMeasure $current */
            /** @var TripMeasure $next */
            $current = $measures[$i];
            $next = $measures[$i + 1];

            if (($nextDistance = $next->getDistance()) < ($currentDistance = $current->getDistance())) {
                throw new \RuntimeException(sprintf(
                    'Invalid data for trip %s provided: Distance of measure #%s is lower than previous measure',
                    $trip->getName(), $i + 1
                ));
            }

            $avgSpeed = 3600 * ($nextDistance - $currentDistance) / $inteval;
            $avgSpeeds[] = $avgSpeed;
        }

        return $avgSpeeds;
    }

    /**
     * @param array $trips
     */
    protected function hydrateTrips(array $trips)
    {
        foreach ($trips as $trip) {
            $trip->setMeasures($this->measuresForTrip($trip));
        }
    }

    /**
     * @return Trip[]
     */
    protected function trips(): array
    {
        return $this->tripRepository->fetch();
    }

    /**
     * @param Trip|int $trip
     * @return TripMeasure[]
     */
    protected function measuresForTrip($trip): array
    {
        return $this->tripMeasureRepository->fetchByTripId(is_object($trip) ? $trip->getId() : (int) $trip);
    }

}
