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

    public function actionUserInfo()
    {
        $result = $this->service->getCurrentUserInfo();

        return $result;
    }

    public function actionCreate()
    {
        $params = $this->request->post();

        $this->service->create($params);

        return ['message' => '创建成功'];
    }

    public function actionUpdate($userId)
    {
        $params = $this->request->getBodyParams();
        $this->service->update($userId, $params);

        return ['message' => '更新成功'];
    }

    public function actionDelete()
    {
        $params = $this->request->getBodyParams();
        $userIds = $params['user_ids'] ?? [];
        $this->service->delete($userIds);

        return ['message' => '删除成功'];
    }

    public function actionUpdateStatus()
    {
        $params = $this->request->getBodyParams();
        $userIds = $params['user_ids'] ?? [];
        $this->service->updateStatus($userIds, $params);

        return ['message' => '更新状态成功'];
    }

    public function actionUpdatePassword()
    {
        $params = $this->request->getBodyParams();
        $this->service->updatePassword($params);

        return ['message' => '更新密码成功'];
    }

    public function actionResetPassword($userId)
    {
        $this->service->resetPassword($userId);

        return ['message' => '重置成功'];
    }

    public function actionUpdateEmail()
    {
        $params = $this->request->getBodyParams();
        $userId = $params['user_id'] ?? [];
        $this->service->updateEmail($userId, $params);

        return ['message' => '更新邮箱成功'];
    }

    public function actionGetList()
    {
        $params = $this->request->get();

        $result = $this->service->getList($params);

        return $result;
    }

    public function actionDetail($userId)
    {
        $detail = $this->service->detail($userId);

        return $detail;
    }

    public function actionSendEmail()
    {
        $params = $this->request->getBodyParams();
        $this->service->sendEmail($params);

        return ['message' => '邮件发送成功'];
    }

    public function actionGetAuthLogList($userId)
    {
        $params = $this->request->get();
        $params['user_id'] = $userId;
        $result = $this->service->getLogList($params);

        return $result;
    }
}
