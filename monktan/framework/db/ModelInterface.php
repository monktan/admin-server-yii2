<?php
namespace monktan\framework\db;

interface ModelInterface
{
    /**
     * @return QueryInterface
     */
    public function newQuery();

    public function m($model);

    public function insert($model);

    public function delete($model);
}
