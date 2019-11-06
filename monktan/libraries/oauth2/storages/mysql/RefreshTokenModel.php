<?php


namespace star\oauth2\storages\mysql;

use star\common\models\BaseModel;
use star\oauth2\storages\RefreshTokenModelInterface;

class RefreshTokenModel extends BaseModel implements RefreshTokenModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;

    public function rules()
    {
        return [
            [['token_id','token_sign','access_token_id','expire_time'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'refresh_token';
    }

    public function saveToken($data)
    {
        $this->attributes = $data;
        $this->insert($data);
    }

    public function revokeToken($tokenId)
    {
        $where = ['token_id'=>$tokenId];
        self::deleteAll($where);
    }

    public function isTokenRevoked($tokenId)
    {
        $status = self::find()->where(['token_id'=>$tokenId])->select('status')->scalar();

        return empty($status) || $status == self::STATUS_DISABLE;
    }

    public function getRefreshTokenInfoByAccessTokenId($accessTokenId)
    {
        $refreshToken = self::find()->where(['access_token_id'=>$accessTokenId])->one();

        return $refreshToken;
    }
}
