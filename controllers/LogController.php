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
 * Class LogController
 * @package app\controllers
 */
class LogController extends BaseWebController
{
    public function __construct(
        string $id,
        Module $module,
        Log $userService,
        UserValidate $userValidate,
        array $config = []
    ) {
        $this->service = $userService;
        $this->validate = $userValidate;

        parent::__construct($id, $module, $config);
    }
}
