<?php
namespace monktan\modules\user;

use app\monktan\common\helpers\UrlHelper;
use monktan\libraries\Email;

trait EmailServiceTrait
{
    public function sendEmail($params)
    {
        switch ($params['type']) {
            case self::FIND_PASSWORD_EMAIL:
                $this->sendFindPasswordEmail($params);
                break;
            case self::BIND_EMAIL:
                $this->sendBindEmail($params);
                break;
            case self::RESET_PASSWORD_EMAIL:
                $this->sendFindPasswordEmail($params);
                break;
        }
    }

    private function sendFindPasswordEmail($params)
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
        $content = "新密码为: {$params['password']}";
        $receivers = [$params['email']];

        Email::send($title, $content, $receivers);
    }

    private function sendBindEmail($params)
    {
        $user = $this->getUserByEmail($params['email']);

        $title = '邮箱绑定验证';
        $code = Email::genRandomCode(32, 'string');
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

    public function updateEmail($params)
    {
        //校验随机码
        $emailItem = $this->checkCode($params['code'], 1);


        $userId = mt_model('User')->newQuery()
            ->where(['email'=>$emailItem['email']])->value('user_id');
        //更新邮箱
        $updateData['email'] = $emailItem['email'];
        $updateData['update_by'] = $userId;

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

    public function checkCode($code, $type)
    {
        $item = mt_model('EmailCode')->newQuery()
            ->where(['code'=>$code, 'status'=>2, 'type'=>$type])
            ->where(['>', 'expired_time', time()])
            ->sql();

        if (empty($item)) {
            mt_model('邮箱验证码不正确或已过期');
        }

        mt_model('EmailCode')->update(['status'=>1], ['id'=>$item['id']]);

        return $item;
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
