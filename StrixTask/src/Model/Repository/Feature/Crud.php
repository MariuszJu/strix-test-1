<?php

namespace StrixTask\Model\Repository\Feature;

trait Crud
{

    /**
     * @param array|null $where
     * @param null       $order
     * @param int|null   $start
     * @param int|null   $limit
     * @param null       $group
     * @return array
     */
    public function fetch(array $where = null, $order = null, int $start = null, int $limit = null, $group = null)
    {
        $select = $this->tableGateway->getSql()->select();
        $this->setOriginalResultSetPrototype();

        if (!is_null($order)) {
            $select->order($order);
        }
        if (!is_null($group)) {
            $select->group($group);
        }
        if (!is_null($start) && !is_null($limit)) {
            $select->limit((int) $limit);
            $select->offset((int) $start);
        }
        if (!is_null($where)) {
            $select->where($where);
        }

        $resultSet = $this->tableGateway->selectWith($select);
        $array = [];
        foreach ($resultSet as $result) {
            $array[] = $result;
        }

        return $array;
    }

    /**
     * @param array|null $where
     * @return array
     */
    public function fetchOne(array $where = null)
    {
        $select = $this->tableGateway->getSql()->select();
        $this->setOriginalResultSetPrototype();

        if (!is_null($joins)) {
            foreach ($joins as $join) {
                $select->join($join['table'], $join['condition'], $join['columns']);
            }
        }
        if (!is_null($where)) {
            $select->where($where);
        }

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchOneById(int $id)
    {
        $select = $this->tableGateway->getSql()->select();
        $this->setOriginalResultSetPrototype();

        $select->where(['id' => $id]);
        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet->current();
    }

    /**
     * @param string $query
     * @return array
     */
    public function rawSqlQuery(string $query): array
    {
        $results = $this->tableGateway->getAdapter()->driver->getConnection()->execute($query);

        $array = [];
        foreach ($results as $result) {
            $array[] = $result;
        }

        return $array;
    }

    /**
     * @return void
     */
    private function setOriginalResultSetPrototype()
    {
        $resultSetPrototype = $this->tableGateway->getResultSetPrototype();
        $originalResultSetPrototype = isset($this->originalResultSetPrototype) ? $this->originalResultSetPrototype : null;

        if (!is_null($originalResultSetPrototype)) {
            $resultSetPrototype->setArrayObjectPrototype($originalResultSetPrototype);
        }
    }

}