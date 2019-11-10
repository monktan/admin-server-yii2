<?php


namespace monktan\common;

use monktan\common\exceptions\InfoException;

class ErrorHandler extends \yii\web\ErrorHandler
{
    public function renderException($exception)
    {
        if (YII_DEBUG) {
            if ($exception instanceof InfoException) {
                return mt_warn($exception);
            }
            // 如果为开发模式时，可以按照之前的页面渲染异常，因为框架的异常渲染十分详细，方便我们寻找错误
            return parent::renderException($exception);
        }

        if ($exception instanceof InfoException) {
            return mt_warn($exception);
        }

        return mt_error($exception);
    }
}
