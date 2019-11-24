<?php

namespace monktan\common\models;


trait LogModelTrait
{
    public function getResultText($result)
    {
        $text = '';
        switch ($result) {
            case self::RESULT_SUCCESS:
                $text = '成功';
                break;
            case self::RESULT_FAILED:
                $text = '失败';
                break;
            default:
                break;
        }

        return $text;
    }
}
