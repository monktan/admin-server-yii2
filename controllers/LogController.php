<?php
/**
 * Description
 *
 *
 * Datetime: 2019-11-06 21:01
 */

namespace app\controllers;

use monktan\modules\log\LogService;
use monktan\modules\log\LogValidate;
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
        LogService $logService,
        LogValidate $logValidate,
        array $config = []
    ) {
        $this->service = $logService;
        $this->validate = $logValidate;

        parent::__construct($id, $module, $config);
    }

    public function actionGetList()
    {
        $params = $this->request->get();

        $result = $this->service->getList($params);

        return $result;
    }

    public function actionGetModules()
    {
        $result = $this->service->getModules();

        return $result;
    }
}
