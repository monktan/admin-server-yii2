<?php

namespace monktan\common\models;


trait UserModelTrait
{
    public function getUserByAccount($loginId, $password)
    {
        $user = $this->newQuery()->where(['user_name'=>$loginId])->one();
        if (empty($user)) {
            throw_info('用户名不存在');
        }
        if (! password_verify($password, $user['password'])) {
            throw_info('密码错误');
        }

        return $user;
    }
}