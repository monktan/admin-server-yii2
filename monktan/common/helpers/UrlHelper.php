<?php
namespace app\monktan\common\helpers;

class UrlHelper
{
    const FIND_PASSWORD = '';
    const BIND_EMAIL = '';

    public static function buildUrlWithEmailCode($code, $partUri)
    {
        $baseUrl = \Yii::$app->params['base_url'];

        return "{$baseUrl}\\{$partUri}\\{$code}";
    }

    public static function buildUrl()
    {

    }
}
