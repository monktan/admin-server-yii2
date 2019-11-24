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

    public function getUserById($userId)
    {
        $where = ['user_id' => $userId];
        $fields = ['user_id', 'real_name', 'username', 'mobile',
            'email', 'status', 'remark', 'create_time', 'update_time', 'create_by', 'update_by'];
        $user = mt_model($this)->newQuery()->where($where)->fields($fields)->one();

        return $user;
    }

    public function getStatusText($status)
    {
        $text = '';
        switch ($status) {
            case self::STATUS_ENABLE:
                $text = '已启用';
                break;
            case self::STATUS_DISABLE:
                $text = '已禁用';
                break;
            default:
                break;
        }

        return $text;
    }
}