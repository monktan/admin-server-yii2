<?php

namespace monktan\common\models;


trait AccessTokenModelTrait
{
    public function saveToken($data)
    {
        mt_model($this)->insert($data);
    }

    public function revokeToken($tokenId)
    {
        $where = ['token_id'=>$tokenId];
        mt_model($this)->delete($where);
    }

    public function isTokenRevoked($tokenId)
    {
        $id = mt_model($this)->newQuery()->where(['token_id'=>$tokenId])->value('id');

        return empty($id);
    }
}