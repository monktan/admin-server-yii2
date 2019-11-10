<?php
namespace app\framework\common\models;

use app\framework\db\Model;
use monktan\common\models\ClientModelInterface;
use monktan\common\models\ClientModelTrait;
use monktan\common\models\UserModelInterface;
use monktan\common\models\UserModelTrait;

class ClientModel extends Model implements ClientModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;

    use ClientModelTrait;

}
