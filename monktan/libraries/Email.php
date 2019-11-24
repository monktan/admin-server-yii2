<?php
namespace monktan\libraries;

class Email
{
    public static function send($title, $content, $receivers)
    {
        $config = mt_config('email');
        $transport = (new \Swift_SmtpTransport($config['smtp_host'], $config['smtp_port'])) // 邮箱服务器
        ->setUsername($config['username'])  // 邮箱用户名
        ->setPassword($config['password'])   // 邮箱密码，有的邮件服务器是授权码
        ;

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message($title)) // 邮件标题
        ->setFrom([$config['username'] => $config['from']]) // 发送者
        ->setTo($receivers) //发送对象，数组形式支持多个
        ->setBody($content) //邮件内容
        ;

        $result = $mailer->send($message);

        return $result;
    }

    public static function genRandomCode($length = 6, $type = 'int')
    {
        if ($type == 'int') {
            $min = 10 ^ ($length - 1);
            $max = 10 ^ ($length + 1) - 1;
            $code = random_int($min, $max);
        } else {
            $code = bin2hex(random_bytes($length));
        }

        return $code;
    }
}