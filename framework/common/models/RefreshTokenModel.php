<?php
namespace app\framework\common\models;

use monktan\common\models\RefreshTokenModelInterface;
use monktan\common\models\RefreshTokenModelTrait;

class RefreshTokenModel extends BaseModel implements RefreshTokenModelInterface
{
    use RefreshTokenModelTrait;

    public static function tableName()
    {
        return 'ad_refresh_token';
    }

    public function rules()
    {
        return [
            [['token_id','token_sign','access_token_id','expire_time'], 'safe'],
        ];
    }
}
