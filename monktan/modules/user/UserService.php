<?php
namespace monktan\modules\user;

use monktan\common\models\UserModelInterface;
use monktan\common\services\BaseService;
use monktan\libraries\SnowFlake;

class UserService extends BaseService
{
    use PasswordServiceTrait;
    use EmailServiceTrait;
    use UserListServiceTrait;

    public function __construct(UserModelInterface $userModel)
    {
        $this->model = $userModel;
    }

    public function create($params)
    {
        $userId = mt_session_data('user_id');
        $insertData = [];
        $insertData['user_id'] = SnowFlake::getInstance()->generateId();
        $insertData['real_name'] = $params['real_name'] ?? '';
        $insertData['username'] = $params['username'] ?? '';
        $insertData['mobile'] = $params['mobile'] ?? '';
        if (isset($params['no_verify_email']) && $params['no_verify_email'] == 1) {
            $insertData['email'] = $params['email'] ?? '';
        }
        $insertData['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
        $insertData['status'] = $params['status'] ?? $this->model::STATUS_ENABLE;
        $insertData['remark'] = $params['remark'] ?? '';
        $insertData['create_by'] = $userId;
        $insertData['update_by'] = $userId;

        mt_model($this->model)->insert($insertData);
    }

    public function update($params)
    {
        $updateData['real_name'] = $params['real_name'] ?? '';
        $updateData['mobile'] = $params['mobile'] ?? '';
        $updateData['remark'] = $params['remark'] ?? '';
        $updateData['status'] = $params['status'] ?? $this->model::STATUS_ENABLE;

        $this->baseUpdate($updateData, [$params['user_id']]);
    }

    public function delete($params)
    {
        $updateData['is_deleted'] = $this->model::DELETED;
        $this->baseUpdate($updateData, $params['user_ids']);
    }

    public function updateStatus($params)
    {
        $updateData['status'] = $params['status'];
        $this->baseUpdate($updateData, $params['user_ids']);
    }

    private function baseUpdate($updateData, $userIds)
    {
        if (empty($userIds)) {
            mt_throw_info('用户ID为空');
        }
        if (is_string($userIds)) {
            $userIds = [$userIds];
        }

        if (empty($updateData['update_by'])) {
            $updateData['update_by'] = mt_session_data('user_id');
        }


        mt_model($this->model)->update($updateData, ['in', 'user_id', $userIds]);
    }
}
