<?php
/**
 * Description
 *
 *
 * Datetime: 2019-11-06 21:01
 */

namespace app\controllers;

use monktan\modules\auth\AuthService;
use monktan\modules\auth\AuthValidate;
use yii\base\Module;

/**
 * Class AuthController
 * @package app\controllers
 */
class AuthController extends BaseWebController
{
    public function __construct(
        string $id,
        Module $module,
        AuthService $authService,
        AuthValidate $authValidate,
        array $config = []
    ) {
        $this->service = $authService;
        $this->validate = $authValidate;

        parent::__construct($id, $module, $config);
    }

    public function actionLogin()
    {
        $username = $this->request->post('username', '');
        $password = $this->request->post('password', '');

        $result = $this->service->login($username, $password);

        return $result;
    }

    public function actionLogout()
    {
        $this->service->logout();

        return ['message'=>'退出成功'];
    }

    public function actionRefreshToken()
    {
        $result = $this->service->refreshToken();

        return $result;
    }
}
