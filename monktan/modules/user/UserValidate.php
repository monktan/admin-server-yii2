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
        if (empty($params['password'])) {
            mt_throw_info('密码为空');
        }
        if ($params['confirm_password'] != $params['password']) {
            mt_throw_info('密码与确认密码不一致');
        }
        if (empty($params['status'])) {
            mt_throw_info('状态值为空');
        }
        $model = mt_model('User')->getOriginModel();
        if (! in_array($params['status'], [$model::STATUS_ENABLE, $model::STATUS_DISABLE])) {
            mt_throw_info('状态值为空');
        }
        if (empty($params['mobile'])) {
            mt_throw_info('手机为空');
        }
        if (! empty($params['email']) && strpos($params['email'], '@') == false) {
            mt_throw_info('邮箱格式错误');
        }
    }

    public function update($params)
    {
        $model = mt_model('User')->getOriginModel();
        if (! in_array($params['status'], [$model::STATUS_ENABLE, $model::STATUS_DISABLE])) {
            mt_throw_info('状态值为空');
        }
        if (empty($params['mobile'])) {
            mt_throw_info('手机为空');
        }
        if (! empty($params['email']) && strpos($params['email'], '@') == false) {
            mt_throw_info('邮箱格式错误');
        }
    }

    public function delete($params)
    {
        if (empty($params['user_ids'])) {
            mt_throw_info('参数user_ids为空');
        }
    }

    public function updateStatus($params)
    {
        if (empty($params['user_ids'])) {
            mt_throw_info('参数user_ids为空');
        }

        $model = mt_model('User')->getOriginModel();
        if (! in_array($params['status'], [$model::STATSU_ENABLE, $model::STATSU_DISABLE])) {
            mt_throw_info('状态值为空');
        }
    }

    public function updatePassword($params)
    {
        if (empty($params['old_password'])) {
            mt_throw_info('原密码不能为空');
        }
        if (empty($params['confirm_password'])) {
            mt_throw_info('确认密码为空');
        }
        if (empty($params['new_password'])) {
            mt_throw_info('密码为空');
        }
        if ($params['confirm_password'] != $params['new_password']) {
            mt_throw_info('密码与确认密码不一致');
        }
    }

    public function getAuthLogList($params)
    {
    }
}
