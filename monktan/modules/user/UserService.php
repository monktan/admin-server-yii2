<?php
namespace monktan\modules\user;

use monktan\common\models\AuthLogModelInterface;
use monktan\common\models\UserModelInterface;
use monktan\common\services\BaseService;
use monktan\libraries\SnowFlake;
use monktan\modules\auth\AuthService;
use monktan\modules\log\LogService;

class UserService extends BaseService
{
    use PasswordServiceTrait;
    use EmailServiceTrait;
    use UserListServiceTrait;
    use LogServiceTrait;
    use AuthLogServiceTrait;

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * @var LogService
     */
    protected $logService;

    /**
     * @var AuthLogModelInterface
     */
    protected $authLogService;

    public function __construct(
        UserModelInterface $userModel,
        AuthService $authService,
        LogService $logService,
        AuthLogModelInterface $authLogModel
    ) {
        $this->model = $userModel;
        $this->authService = $authService;
        $this->logService = $logService;
        $this->authLogService = $authLogModel;
    }

    public function create($params)
    {
        $userId = mt_session_data('user_id');
        $user = mt_model($this->model)->newQuery()->where(['username'=>$params['username']])->one();
        if (! empty($user)) {
            mt_throw_info('用户名已存在');
        }
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

        $this->logCreate();
    }

    public function update($userId, $params)
    {
        $users = mt_model($this->model)->newQuery()
            ->fields(['user_id', 'real_name', 'mobile', 'email', 'status'])
            ->where(['in', 'user_id', [$userId]])
            ->all();
        $updateData['real_name'] = $params['real_name'] ?? '';
        $updateData['mobile'] = $params['mobile'] ?? '';
        if (isset($params['no_verify_email']) && $params['no_verify_email'] == 1) {
            $updateData['email'] = $params['email'] ?? '';
        }
        $updateData['remark'] = $params['remark'] ?? '';
        $updateData['status'] = $params['status'] ?? $this->model::STATUS_ENABLE;

        $this->baseUpdate($updateData, [$userId]);

        $this->logUpdate($updateData, $users);
    }

    public function delete($userIds)
    {
        $users = mt_model($this->model)->newQuery()
            ->fields(['user_id', 'is_deleted'])
            ->where(['in', 'user_id', $userIds])
            ->all();
        $updateData['is_deleted'] = $this->model::DELETED;
        $this->baseUpdate($updateData, $userIds);

        $this->logUpdate($updateData, $users);
    }

    public function updateStatus($userIds, $params)
    {
        $users = mt_model($this->model)->newQuery()
            ->fields(['user_id', 'status'])
            ->where(['in', 'user_id', $userIds])
            ->all();
        $updateData['status'] = $params['status'];
        $this->baseUpdate($updateData, $userIds);

        $this->logUpdate($updateData, $users);
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

    public function detail($userId)
    {
        $fields = ['user_id', 'email', 'real_name', 'mobile', 'remark', 'update_by', 'update_time', 'create_by',
            'create_time', 'status'];
        $user = mt_model($this->model)->newQuery()->where(['user_id'=>$userId])->fields($fields)->one();
        $user = $this->rebuildItem($user);
        $user['status_text'] = $this->model->getStatusText($user['status']);

        return $users[0] ?? [];
    }
}
