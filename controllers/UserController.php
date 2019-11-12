<?php
/**
 * Description
 *
 *
 * Datetime: 2019-11-06 21:01
 */

namespace app\controllers;

use monktan\modules\user\UserService;
use monktan\modules\user\UserValidate;
use yii\base\Module;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends BaseWebController
{
    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        UserValidate $userValidate,
        array $config = []
    ) {
        $this->service = $userService;
        $this->validate = $userValidate;

        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $params = $this->request->post();

        $this->service->create($params);

        return ['message' => '创建用户成功'];
    }
}
