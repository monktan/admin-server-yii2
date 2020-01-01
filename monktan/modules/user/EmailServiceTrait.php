<?php
namespace monktan\modules\user;

use app\monktan\common\helpers\UrlHelper;
use monktan\libraries\Email;

trait EmailServiceTrait
{
    public function sendFindPasswordEmail($params)
    {
        $user = $user = $this->getUserByEmail($params['email']);
        $title = '找回密码';
        $code = Email::genRandomCode(32, 'string');
        $content = UrlHelper::buildUrlWithEmailCode($code, UrlHelper::FIND_PASSWORD);
        $receivers = [$params['email']];
        Email::send($title, $content, $receivers);

        $expiredTime = time() + 3600;
        $emailCodeData = [
            'email' => $params['email'],
            'code' => $code,
            'type' => 3,
            'expired_time' => $expiredTime,
            'user_id' => $user['user_id'],
        ];
        $this->saveCode($emailCodeData);
    }

    public function sendResetPasswordEmail($params)
    {
        $title = '重置密码';
        //
    }

    public function sendBindEmail($params)
    {
        $user = $this->getUserByEmail($params['email']);

        $title = '邮箱绑定验证';
        $code = Email::genRandomCode();
        $content = UrlHelper::buildUrlWithEmailCode($code, UrlHelper::BIND_EMAIL);
        $receivers = [$params['email']];

        Email::send($title, $content, $receivers);

        $expiredTime = time() + 3600;
        $emailCodeData = [
            'email' => $params['email'],
            'code' => $code,
            'type' => 1,
            'expired_time' => $expiredTime,
            'user_id' => $user['user_id'],
        ];
        $this->saveCode($emailCodeData);
    }

    public function updateEmail($userId, $params)
    {
        //校验随机码
        $this->checkCode($params['email'], $params['code']);
        //更新邮箱
        $updateData['email'] = $params['email'];
        $updateData['update_by'] = $params['update_by'];

        $this->baseUpdate($updateData, [$userId]);
    }

    public function saveCode($params)
    {
        $insertData['email'] = $params['email'];
        $insertData['code'] = $params['code'];
        $insertData['type'] = $params['type'];
        $insertData['expired_time'] = $params['expired_time'];
        $insertData['user_id'] = $params['user_id'];

        mt_model('EmailCode')->insert($insertData);
    }

    public function checkCode($email, $code)
    {
        $id = mt_model('EmailCode')->newQuery()
            ->where(['email'=>$email, 'code'=>$code, 'status'=>1])
            ->where(['>', 'expired_time', time()])
            ->value('id');

        if (empty($id)) {
            mt_model('邮箱验证码不正确或已过期');
        }

        mt_model('EmailCode')->update(['status'=>1], ['id'=>$id]);
    }

    public function getUserByEmail($email)
    {
        $user = mt_model($this->model)
            ->newQuery()
            ->where(['email'=>$email])
            ->one();

        if (empty($user)) {
            mt_throw_info("邮箱{$email}未绑定账户");
        }

        return $user;
    }
}
