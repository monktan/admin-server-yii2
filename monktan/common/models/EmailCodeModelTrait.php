<?php

namespace monktan\common\models;


trait EmailCodeModelTrait
{
    public function getStatusText($status)
    {
        $text = '';
        switch ($status) {
            case self::STATUS_NOT_VALIDATE:
                $text = '已验证';
                break;
            case self::STATUS_VALIDATED:
                $text = '未验证';
                break;
            default:
                break;
        }

        return $text;
    }
}
