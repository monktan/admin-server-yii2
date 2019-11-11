<?php


namespace app\framework\common\filters;

use monktan\common\services\TokenAuthServiceInterface;
use monktan\modules\auth\AuthService;
use yii\base\ActionFilter;

class AuthFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        \Yii::$container->set(TokenAuthServiceInterface::class, AuthService::class);
        $authService = \Yii::$container->get(TokenAuthServiceInterface::class);
        $authService->auth();

        return parent::beforeAction($action);
    }
}
