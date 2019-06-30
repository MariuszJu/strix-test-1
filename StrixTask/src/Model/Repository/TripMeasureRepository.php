<?php

namespace StrixTask\Model\Repository;

use Zend\Db\TableGateway\TableGateway;
use StrixTask\Model\Entity\TripMeasure;
use StrixTask\Model\Repository\Feature\Init;
use StrixTask\Model\Repository\Feature\Crud;

class TripMeasureRepository
{

    use Crud, Init;

    /** @var TableGateway */
    protected $tableGateway;

    /** @var string */
    private $dbName;

    /**
     * TripRepository constructor
     *
     * @param TableGateway $tableGateway
     * @param string       $dbName
     */
    public function __construct(TableGateway $tableGateway, string $dbName)
    {
        $this->tableGateway = $tableGateway;
        $this->dbName = $dbName;
        $this->init();
    }

    /**
     * @return void
     */
    private function create()
    {
        $this->rawSqlQuery("
            CREATE TABLE `trip_measures` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `trip_id` INT NOT NULL,
                `distance` DECIMAL(5, 2) NOT NULL
            );
        ");
    }

    /**
     * @return void
     */
    private function seed()
    {
        $this->rawSqlQuery("
          INSERT INTO `trip_measures` (`id`, `trip_id`, `distance`) VALUES
            (1, 1, 0.0),
            (2, 1, 0.19),
            (3, 1, 0.5),
            (4, 1, 0.75),
            (5, 1, 1.0),
            (6, 1, 1.25),
            (7, 1, 1.5),
            (8, 1, 1.75),
            (9, 1, 2.0),
            (10, 1, 2.25),
            (11, 2, 0.0),
            (12, 2, 0.23),
            (13, 2, 0.46),
            (14, 2, 0.69),
            (15, 2, 0.92),
            (16, 2, 1.15),
            (17, 2, 1.38),
            (18, 2, 1.61),
            (19, 3, 0.0),
            (20, 3, 0.11),
            (21, 3, 0.22),
            (22, 3, 0.33),
            (23, 3, 0.44),
            (24, 3, 0.65),
            (25, 3, 1.08),
            (26, 3, 1.26),
            (27, 3, 1.68),
            (28, 3, 1.89),
            (29, 3, 2.1),
            (30, 3, 2.31),
            (31, 3, 2.52),
            (32, 3, 3.25);
        ");
    }

    /**
     * @param int $tripId
     * @return TripMeasure[]
     */
    public function fetchByTripId(int $tripId)
    {
        return $this->fetch([
            'trip_id' => $tripId,
        ]);
    }

}
