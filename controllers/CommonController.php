<?php
/**
 * Description
 *
 *
 * Datetime: 2019-11-06 21:01
 */

namespace app\controllers;

use monktan\modules\common\CommonService;
use monktan\modules\common\CommonValidate;
use yii\base\Module;

/**
 * Class CommonController
 * @package app\controllers
 */
class CommonController extends BaseWebController
{
    public function __construct(
        string $id,
        Module $module,
        CommonService $commonService,
        CommonValidate $commonValidate,
        array $config = []
    ) {
        $this->service = $commonService;
        $this->validate = $commonValidate;

        parent::__construct($id, $module, $config);
    }

    public function actionCaptcha()
    {
        return $this->service->captcha();
    }
}
