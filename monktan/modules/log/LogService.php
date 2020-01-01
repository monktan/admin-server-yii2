<?php
namespace monktan\modules\log;

use monktan\common\models\LogModelInterface;
use monktan\common\services\BaseService;
use monktan\framework\App;
use monktan\libraries\SnowFlake;

class LogService extends BaseService
{
    use LogListServiceTrait;
    use ModuleTrait;

    public function __construct(LogModelInterface $logModel)
    {
        $this->model = $logModel;
    }

    public function log($data)
    {
        $insertData = $this->buildLogData($data);

        mt_model($this->model)->insert($insertData);
    }

    protected function buildLogData($data)
    {
        $actionName = App::app()->actionName();
        $controllerName = App::app()->controllerName();
        $ip = App::request()->ip();
        $userAgent = App::request()->userAgent();
        $moduleTitle = $this->getModuleTitle($controllerName);
        $actionTitle = $this->getActionTitle($controllerName, $actionName);
        $userId = mt_session_data('user_id');

        if (mt_is_one_assoc_array($data)) {
            $data = [$data];
        }

        $newData = [];
        foreach ($data as $item) {
            $insertData = [];
            $insertData['log_id'] = SnowFlake::getInstance()->generateId();
            $insertData['user_id'] = $userId;

            $insertData['item_id'] = $item['item_id'] ?? 0;
            $insertData['app_id'] = $item['app_id'] ?? 0;
            $insertData['result_message'] = $item['result_message'] ?? '';
            $insertData['result'] = $item['result'] ?? 0;
            $insertData['new_data'] = $item['new_data'] ?? '';
            $insertData['old_data'] = $item['old_data'] ?? '';

            $insertData['module_title'] = $moduleTitle;
            $insertData['module_name'] = $controllerName;
            $insertData['action_title'] = $actionTitle;
            $insertData['action_name'] = $actionName;
            $insertData['remark'] = '';
            $insertData['ip'] = $ip;
            $insertData['agent'] = $userAgent;
            $insertData['create_time'] = date('Y-m-d H:i:s');

            $newData[] = $insertData;
        }

        return $newData;
    }
}
