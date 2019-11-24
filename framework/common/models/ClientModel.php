<?php
namespace app\framework\common\models;

use monktan\common\models\ClientModelInterface;
use monktan\common\models\ClientModelTrait;

class ClientModel extends BaseModel implements ClientModelInterface
{
    use ClientModelTrait;

    public static function tableName()
    {
        return 'ad_client';
    }
}
