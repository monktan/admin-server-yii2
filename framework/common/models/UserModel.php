<?php
namespace app\framework\common;

use app\framework\db\Model;
use monktan\common\models\UserModelInterface;
use monktan\common\models\UserModelTrait;

class UserModel extends Model implements UserModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;

    use UserModelTrait;

}
