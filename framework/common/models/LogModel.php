<?php
namespace app\framework\common\models;

use monktan\common\models\LogModelInterface;
use monktan\common\models\LogModelTrait;

class LogModel extends BaseModel implements LogModelInterface
{
    use LogModelTrait;

    public function rules()
    {
        return [
            [
                [
                    'username','password','real_name','mobile','email', 'user_id',
                    'create_by', 'update_by', 'create_time', 'update_time', 'status',
                ],
                'safe'
            ],
        ];
    }

    public static function tableName()
    {
        return 'ad_log';
    }
}
