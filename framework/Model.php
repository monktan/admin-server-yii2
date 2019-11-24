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
        if (is_string($model)) {
            $modelClassName = '\app\framework\common\models\\' . $model . 'Model';
            $this->model = \Yii::$container->get($modelClassName);
        } else {
            $this->model = $model;
        }

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
        if (empty($data)) {
            return;
        }

        if (mt_is_one_assoc_array($data)) {   //一维关联数组
            $this->model->setAttributes($data);
            $this->model->insert(false);
        } elseif (isset($data[0]) && mt_is_one_assoc_array($data[0])) { //二维数组，元素是一维关联数组
            $tableName = $this->model::tableName();
            $columns = array_keys($data[0]);
            $rows = [];
            foreach ($data as $item) {
                $rows[] = array_values($item);
            }
            $this->model::getDb()->createCommand()->batchInsert($tableName, $columns, $rows);
        }
    }

    public function update($data, $condition = '')
    {
        if (empty($data)) {
            return;
        }
        if (empty($condition)) {
            mt_throw_info('更新条件不能为空');
        }
        $this->model->updateAll($data, $condition);
    }

    public function delete($condition)
    {
        if (empty($condition)) {
            mt_throw_info('删除条件不能为空');
        }
        return $this->model::deleteAll($condition);
    }

    public function getOriginModel()
    {
        return $this->model;
    }
}
