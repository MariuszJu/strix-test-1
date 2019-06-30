<?php

namespace StrixTask\Model\Repository\Feature;

trait Init
{

    /**
     * @return void
     */
    public function init()
    {
        $result = $this->rawSqlQuery("
            SELECT * 
            FROM information_schema.tables
            WHERE table_schema = '{$this->dbName}' 
                AND table_name = '{$this->tableGateway->getTable()}'
            LIMIT 1;
        ");

        if (empty($result) && is_callable($callback = [$this, 'create'])) {
            try {
                call_user_func($callback);
            } catch (\Throwable $e) {

            }

            if (is_callable($callback = [$this, 'seed'])) {
                try {
                    call_user_func($callback);
                } catch (\Throwable $e) {

                }
            }
        }
    }

}