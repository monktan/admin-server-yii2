<?php
namespace monktan\modules\user;

use monktan\common\BaseValidate;

class UserValidate extends BaseValidate
{
    public function create($params)
    {
        if (empty($params['username'])) {
            mt_throw_info('用户名为空');
        }
        if (empty($params['password'])) {
            mt_throw_info('密码为空');
        }
        if (empty($params['confirm_password'])) {
            mt_throw_info('确认密码为空');
        }
        if ($params['confirm_password'] != $params['password']) {
            mt_throw_info('密码与确认密码不一致');
        }
        if (empty($params['status'])) {
            mt_throw_info('状态值为空');
        }
        $model = mt_model('User');
        if (! in_array($params['status'], [$model::STATSU_ENABLE, $model::STATSU_DISABLE])) {
            mt_throw_info('状态值为空');
        }
        if(! empty($params['mobile'])) {
            mt_throw_info('手机格式错误');
        }
        if(! empty($params['email'])) {
            mt_throw_info('邮箱格式错误');
        }

    }
}
