<?php
namespace monktan\modules\user;

trait LogServiceTrait
{
    public function logCreate()
    {
        $data = [];
        $logModel = mt_model('Log')->getOriginModel();
        $data['app_id'] = '';
        $data['result'] = $logModel::RESULT_SUCCESS;
        $data['result_message'] = '';
        $data['new_data'] = '';
        $data['old_data'] = '';
        $data['item_id'] = 0;

        $this->logService->log($data);
    }

    protected function logUpdate($updateData, $users)
    {
        $fields = array_keys($updateData);
        $logModel = mt_model('Log')->getOriginModel();
        $newData = json_encode($updateData, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        $logData = [];
        foreach ($users as $user) {
            $oldData = [];
            foreach ($fields as $field) {
                $oldData[$field] = $user[$field];
            }
            $item = [];
            $item['new_data'] = $newData;
            $item['old_data'] = json_encode($oldData, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
            $item['app_id'] = '';
            $data['result'] = $logModel::RESULT_SUCCESS;
            $item['result_message'] = '';
            $item['item_id'] = $user['user_id'];

            $logData[] = $item;
        }

        $this->logService->log($logData);
    }
}
