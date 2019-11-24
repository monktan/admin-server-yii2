<?php
namespace app\framework\common\models;

use monktan\common\models\EmailCodeModelInterface;
use monktan\common\models\EmailCodeModelTrait;

class EmailCodeModel extends BaseModel implements EmailCodeModelInterface
{
    use EmailCodeModelTrait;

    public function rules()
    {
        return [
            [
                [
                    'email','code','status','type','is_deleted', 'expired_time',
                    'create_by', 'update_by', 'create_time', 'update_time',
                ],
                'safe'
            ],
        ];
    }

    public static function tableName()
    {
        return 'ad_email_code';
    }
}
