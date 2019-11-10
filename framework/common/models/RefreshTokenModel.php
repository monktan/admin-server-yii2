<?php
namespace app\framework\common\models;

use app\framework\db\Model;
use monktan\common\models\ClientModelInterface;
use monktan\common\models\ClientModelTrait;
use monktan\common\models\RefreshTokenModelInterface;
use monktan\common\models\RefreshTokenModelTrait;
use monktan\common\models\UserModelInterface;
use monktan\common\models\UserModelTrait;

class RefreshTokenModel extends Model implements RefreshTokenModelInterface
{
    use RefreshTokenModelTrait;

}
