<?php

namespace StrixTask\Model\Repository;

use Zend\Db\TableGateway\TableGateway;
use StrixTask\Model\Repository\Feature\Init;
use StrixTask\Model\Repository\Feature\Crud;

class TripRepository
{

    use Crud, Init;

    /** @var TableGateway */
    protected $tableGateway;

    /** @var string */
    protected $dbName;

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
            CREATE TABLE `trips` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(20) NOT NULL,
                `measure_interval` INT NOT NULL
            );
        ");
    }

    /**
     * @return void
     */
    private function seed()
    {
        $this->rawSqlQuery("
            INSERT INTO `trips` (`id`, `name`, `measure_interval`) VALUES
                (1, 'Trip 1', 15),
                (2, 'Trip 2', 20),
                (3, 'Trip 3', 12);
        ");
    }

}
