<?php

namespace monktan\common\models;


trait AuthLogModelTrait
{
    public function getTypeText($type)
    {
        $text = '';
        switch ($type) {
            case self::LOG_TYPE_LOGOUT:
                $text = '登出';
                break;
            case self::LOG_TYPE_LOGIN:
                $text = '登录';
                break;
            default:
                break;
        }

        return $text;
    }
}
