<?php
namespace monktan\modules\user;

trait PasswordServiceTrait
{
    public function updatePassword($userId, $params)
    {
        $user = mt_model($this->model)
            ->newQuery()
            ->where(['user_id'=>$userId])
            ->one();
        if (empty($user)) {
            mt_throw_info('用户不存在');
        }

        //更新密码
        $updateData['password'] = password_hash($params['new_password'], PASSWORD_DEFAULT);
        $this->baseUpdate($updateData, [$userId]);
        $this->logUpdate([], [$user]);
    }

    public function updateSelfPassword($params)
    {
        $userId = mt_session_data('user_id');
        $user = mt_model($this->model)
            ->newQuery()
            ->where(['user_id'=>$userId])
            ->one();
        //校验原密码
        if (! password_verify($params['old_password'], $user['password'])) {
            mt_throw_info('原密码不正确');
        }

        //更新密码
        $updateData['password'] = password_hash($params['new_password'], PASSWORD_DEFAULT);
        $this->baseUpdate($updateData, [$userId]);
        $this->logUpdate([], [$user]);
        //退出登录
        $this->authService->logout();
    }

    public function resetPassword($userId)
    {
        $user = mt_model($this->model)
            ->newQuery()
            ->where(['user_id'=>$userId])
            ->one();

        if (empty($user['email'])) {
            mt_throw_info('请先设置邮箱');
        }
        $password = $this->genRandomPassword();
        $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);

        $this->baseUpdate($updateData, [$userId]);
        $this->logUpdate([], [$user]);

        $params['email'] = $user['email'];
        $this->sendResetPasswordEmail($params);
    }

    private function genRandomPassword()
    {
        return strtolower(bin2hex(random_bytes(6)));
    }
}
