<?php


namespace monktan\common\filters;

use yii\base\ActionFilter;

class ResponseFilter extends ActionFilter
{
    public function afterAction($action, $result)
    {
        return parent::afterAction($action, $result);
    }
}