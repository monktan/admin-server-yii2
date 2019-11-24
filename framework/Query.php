<?php
namespace app\framework;

use monktan\framework\db\QueryInterface;
use yii\db\ActiveQuery;

class Query implements QueryInterface
{
    /**
     * @var \yii\db\ActiveQuery
     */
    public $query;

    public function __construct(ActiveQuery $query)
    {
        $this->query = $query;
    }

    public function where($condition, $params = [])
    {
        $this->query->andWhere($condition, $params);

        return $this;
    }

    public function one()
    {
        return $this->query->asArray()->one();
    }

    public function fields($fields)
    {
        $this->query->select($fields);

        return $this;
    }

    public function value($field = '')
    {
        return $this->query->select($field)->scalar();
    }

    public function column($field = '')
    {
        return $this->query->select($field)->column();
    }

    public function all()
    {
        return $this->query->asArray()->all();
    }

    public function limit($limit)
    {
        $this->query->limit($limit);

        return $this;
    }

    public function offset($offset)
    {
        $this->query->offset($offset);

        return $this;
    }

    public function count($field = '*')
    {
        $count = $this->query->count($field);

        return intval($count);
    }

    public function order($fields)
    {
        $this->query->orderBy($fields);

        return $this;
    }

    public function sql()
    {
        return $this->query->createCommand()->getRawSql();
    }
}
