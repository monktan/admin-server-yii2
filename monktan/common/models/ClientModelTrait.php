<?php

namespace monktan\common\models;


trait ClientModelTrait
{
    public function getClient($clientIdentifier)
    {
        $client = mt_model($this)->newQuery()->where(['client_id'=>$clientIdentifier])->one();
        if (empty($client)) {
            mt_throw_info('不可信任的客户端', RESPONSE_CODE_UNAUTHORIZED);
        }

        if ($client['status'] == self::STATUS_DISABLE) {
            mt_throw_info('客户端已被禁用', RESPONSE_CODE_UNAUTHORIZED);
        }

        return $client;
    }
}
