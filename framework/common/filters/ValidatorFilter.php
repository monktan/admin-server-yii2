<?php


namespace app\framework\common\filters;

use yii\base\ActionFilter;

class ValidatorFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        $parentResult = parent::beforeAction($action);
        if (! $parentResult) {
            return $parentResult;
        }

        $params = \Yii::$app->request->getBodyParams();
        $getParams = \Yii::$app->request->get();
        unset($getParams['r']); //去掉路由参数
        $params = array_merge($getParams, $params);


        $actionId = $this->convertActionId($action->id);
        $action->controller->validate->validate($actionId, $params);

        return true;
    }

    private function convertActionId($actionId)
    {
        $words = explode('-', $actionId);
        foreach ($words as $k => $word) {
            $words[$k] = ucwords($word);
        }
        $newActionId = join('', $words);
        $newActionId = lcfirst($newActionId);

        return $newActionId;
    }
}
