<?php
namespace app\framework\common\models;

use monktan\common\models\UserModelInterface;
use monktan\common\models\UserModelTrait;

class UserModel extends BaseModel implements UserModelInterface
{
    use UserModelTrait;

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
        return 'ad_user';
    }
}
