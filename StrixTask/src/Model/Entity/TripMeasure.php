<?php

namespace StrixTask\Model\Entity;

use StrixTask\Model\Entity\Feature\EntityExchange;

class TripMeasure
{

    use EntityExchange;

    /** @var int */
    protected $id;

    /** @var int */
    protected $tripId;

    /** @var float */
    protected $distance;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getTripId(): int
    {
        return $this->tripId;
    }

    /**
     * @param int $tripId
     */
    public function setTripId(int $tripId): void
    {
        $this->tripId = $tripId;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

}
