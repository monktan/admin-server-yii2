<?php
namespace app\framework;

use monktan\framework\ConfigInterface;
use monktan\framework\RequestInterface;

class Request implements RequestInterface
{
    public function ip()
    {
        return \Yii::$app->request->getUserIP();
    }

    public function userAgent()
    {
        return \Yii::$app->request->getUserAgent();
    }
}
