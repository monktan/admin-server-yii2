<?php

namespace monktan\common\models;


trait UserModelTrait
{
    public function getUserByAccount($loginId, $password)
    {
        $user = mt_model($this)->newQuery()->where(['username'=>$loginId])->one();
        if (empty($user)) {
            mt_throw_info('用户名不存在');
        }
        if (! password_verify($password, $user['password'])) {
            mt_throw_info('密码错误');
        }

        return $user;
    }
}