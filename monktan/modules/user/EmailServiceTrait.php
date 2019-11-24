<?php
namespace monktan\modules\user;

use monktan\libraries\Email;

trait EmailServiceTrait
{
    public function sendFindPasswordEmail($params)
    {
        $title = '找回密码';
        $code = Email::genRandomCode(32, 'string');
        $content = $code;
        $receivers = [$params['email']];
        Email::send($title, $content, $receivers);

        $expiredTime = time() + 3600;
        $this->saveCode($params['email'], $code, 2, $expiredTime);
    }

    public function sendResetPasswordEmail($params)
    {
        $title = '重置密码';
        $code = Email::genRandomCode(32, 'string');
        $content = $code;
        $receivers = [$params['email']];
        Email::send($title, $content, $receivers);

        $expiredTime = time() + 3600;
        $this->saveCode($params['email'], $code, 3, $expiredTime);
    }

    public function sendBindEmail($params)
    {
        $title = '邮箱绑定验证';
        $code = Email::genRandomCode();
        $content = $code;
        $receivers = [$params['email']];

        Email::send($title, $content, $receivers);

        $expiredTime = time() + 3600;
        $this->saveCode($params['email'], $code, 1, $expiredTime);
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

    public function saveCode($email, $code, $type, $expiredTime)
    {
        $insertData['email'] = $email;
        $insertData['code'] = $code;
        $insertData['type'] = $type;
        $insertData['expired_time'] = $expiredTime;

        mt_model('EmailCode')->insert($insertData);
    }

    public function checkCode($email, $code)
    {
        $id = mt_model('EmailCode')->newQuery()
            ->where(['email'=>$email, 'code'=>$code, 'status'=>1])
            ->where(['>', 'expired_time', time()])
            ->value('id');

        if (empty($id)) {
            mt_model('验证码不正确或已过期');
        }

        mt_model('EmailCode')->update(['status'=>1], ['id'=>$id]);
    }
}
