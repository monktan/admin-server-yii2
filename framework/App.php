<?php
namespace app\framework;

use monktan\framework\AppInterface;

class App implements AppInterface
{
    public function actionName()
    {
        return \Yii::$app->controller->action->id;
    }

    public function controllerName()
    {
        return \Yii::$app->controller->id;
    }
}
