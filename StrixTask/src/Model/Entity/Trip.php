<?php

namespace StrixTask\Model\Entity;

use StrixTask\Model\Entity\Feature\EntityExchange;

class Trip
{

    use EntityExchange;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var int */
    protected $measureInterval;

    /** @var array */
    protected $measures = [];

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getMeasureInterval(): int
    {
        return $this->measureInterval;
    }

    /**
     * @param int $measure_interval
     */
    public function setMeasureInterval(int $measure_interval): void
    {
        $this->measureInterval = $measure_interval;
    }

    /**
     * @param TripMeasure $measure
     */
    public function addMeasure(TripMeasure $measure)
    {
        $this->measures[] = $measure;
    }

    /**
     * @param $measures
     */
    public function setMeasures($measures)
    {
        $this->measures = $measures;
    }

    /**
     * @return array
     */
    public function getMeasures(): array
    {
        return $this->measures;
    }

}
