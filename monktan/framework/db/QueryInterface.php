<?php
namespace monktan\framework\db;

interface QueryInterface
{
    /**
     * @return array
     */
    public function one();

    /**
     * @param $fields
     * @return QueryInterface
     */
    public function fields($fields);

    /**
     * @param $field
     * @return mixed
     */
    public function value($field = '');

    /**
     * @param $field
     * @return array
     */
    public function column($field = '');

    /**
     * @param $condition
     * @param array $params
     * @return QueryInterface
     */
    public function where($condition, $params = []);

    /**
     * @param $limit
     * @return QueryInterface
     */
    public function limit($limit);

    /**
     * @param $offset
     * @return QueryInterface
     */
    public function offset($offset);
}

