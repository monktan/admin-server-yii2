<?php
namespace monktan\framework\db;

interface ModelInterface
{
    /**
     * @return QueryInterface
     */
    public function newQuery();

    public function m($model);

    public function insert($data);

    public function update($data, $condition = '');

    public function delete($condition);
}
