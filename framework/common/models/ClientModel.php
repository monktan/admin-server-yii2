<?php
namespace app\framework\common\models;

use monktan\common\models\ClientModelInterface;
use monktan\common\models\ClientModelTrait;

class ClientModel extends BaseModel implements ClientModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;

    use ClientModelTrait;

    public static function tableName()
    {
        return 'client';
    }
}
