<?php

namespace monktan\common\models;


trait AccessTokenModelTrait
{
    public function saveToken($data)
    {
        self::insert($data);
    }

    public function revokeToken($tokenId)
    {
        $where = ['token_id'=>$tokenId];
        self::delete($where);
    }

    public function isTokenRevoked($tokenId)
    {
        $status = $this->newQuery()->where(['token_id'=>$tokenId])->fields('status')->value();

        return empty($status) || $status == self::STATUS_DISABLE;
    }
}