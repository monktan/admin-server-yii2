<?php
namespace app\framework\common\models;

use monktan\common\models\AuthLogModelInterface;

class AuthLogModel extends BaseModel implements AuthLogModelInterface
{
    public static function tableName()
    {
        return 'auth_log';
    }
}
