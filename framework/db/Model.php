<?php
namespace app\framework\db;

use yii\db\ActiveRecord;

class Model extends ActiveRecord implements \monktan\framework\db\ModelInterface
{
    public static function newQuery()
    {
        return self::find();
    }
}
