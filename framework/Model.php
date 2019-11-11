<?php
namespace app\framework;

use monktan\framework\db\ModelInterface;
use yii\db\ActiveRecord;

class Model implements ModelInterface
{
    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @param $model
     * @return $this
     */
    public function m($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Query
     */
    public function newQuery()
    {
        $query = $this->model::find();

        return (new Query($query));
    }

    public function insert($data)
    {
        $this->model->setAttributes($data);
        $this->model->insert(false);
    }

    public function delete($where)
    {
        return $this->model::deleteAll($where);
    }
}
