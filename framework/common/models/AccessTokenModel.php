<?php
namespace app\framework\common\models;

use app\framework\db\Model;
use monktan\common\models\AccessTokenModelInterface;
use monktan\common\models\AccessTokenModelTrait;
use monktan\common\models\ClientModelInterface;
use monktan\common\models\ClientModelTrait;
use monktan\common\models\UserModelInterface;
use monktan\common\models\UserModelTrait;

class AccessTokenModel extends Model implements AccessTokenModelInterface
{
    use AccessTokenModelTrait;

}
