<?php
namespace app\framework\common\models;

use monktan\common\models\AccessTokenModelInterface;
use monktan\common\models\AccessTokenModelTrait;

class AccessTokenModel extends BaseModel implements AccessTokenModelInterface
{
    use AccessTokenModelTrait;

    public function rules()
    {
        return [
            [['token_id','token_sign','user_id','client_id','expire_time'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'ad_access_token';
    }
}
