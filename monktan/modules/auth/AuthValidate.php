<?php
namespace monktan\modules\auth;

use monktan\common\BaseValidate;

class AuthValidate extends BaseValidate
{
    public function login($params)
    {
        if (empty($params['username'])) {
            mt_throw_info('用户名为空');
        }

        if (empty($params['password'])) {
            mt_throw_info('密码为空');
        }

        if (! isset($params['grant_type']) || $params['grant_type'] != 'password') {
            mt_throw_info('grant_type参数错误');
        }

        return true;
    }
}
