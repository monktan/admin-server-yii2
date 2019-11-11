<?php
namespace app\framework\common\models;

use monktan\common\models\UserModelInterface;
use monktan\common\models\UserModelTrait;

class UserModel extends BaseModel implements UserModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;

    use UserModelTrait;

    public static function tableName()
    {
        return 'user';
    }
}
