<?php
namespace monktan\modules\auth;

use monktan\common\BaseValidate;
use monktan\libraries\Captcha;

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
        if (empty($params['captcha'])) {
            mt_throw_info('验证码为空');
        }
        if (empty($params['captcha_id'])) {
            mt_throw_info('参数captcha_id为空');
        }
        if (! Captcha::check($params['captcha'], $params['captcha_id'])) {
            mt_throw_info('验证码错误或已过期');
        }

        return true;
    }

    public function refreshToken($params)
    {
        if (! isset($params['grant_type']) || $params['grant_type'] != 'refresh_token') {
            mt_throw_info('grant_type参数错误');
        }

        if (empty($params['refresh_token'])) {
            mt_throw_info('refresh_token为空');
        }
    }
}
