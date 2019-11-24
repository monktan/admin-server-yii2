<?php
namespace app\framework\common\models;

use monktan\common\models\AuthLogModelInterface;
use monktan\common\models\AuthLogModelTrait;

class AuthLogModel extends BaseModel implements AuthLogModelInterface
{
    use AuthLogModelTrait;

    public static function tableName()
    {
        return 'ad_auth_log';
    }

    public function rules()
    {
        return [
            [
                [
                    'ip','log_id','type','agent','remark', 'user_id',
                ],
                'safe'
            ],
        ];
    }
}
