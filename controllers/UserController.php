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

    public function actionUpdate()
    {
        $params = $this->request->getBodyParams();
        $userId = $this->request->get('user_id', '');

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
        $userId = $this->request->get('user_id');
        $this->service->updatePassword($userId, $params);

        return ['message' => '更新密码成功'];
    }

    public function actionResetPassword()
    {
        $params = $this->request->getBodyParams();
        $userIds = $params['user_ids'] ?? [];
        $this->service->updateStatus($userIds, $params);

        return ['message' => '更新状态成功'];
    }

    public function actionUpdateEmail()
    {
        $params = $this->request->getBodyParams();
        $userId = $params['user_id'] ?? [];
        $this->service->updateEmail($userId, $params);

        return ['message' => '更新邮箱成功'];
    }

    public function actionUpdateSelfPassword()
    {
        $params = $this->request->getBodyParams();
        $this->service->updateSelfPassword($params);

        return ['message' => '更新密码成功'];
    }

    public function actionGetList()
    {
        $params = $this->request->get();

        $result = $this->service->getList($params);

        return $result;
    }

    public function actionGetListForOptions()
    {
        $params = $this->request->get();

        $result = $this->service->getListForOptions($params);

        return $result;
    }

    public function actionDetail()
    {
        $userId = $this->request->get('user_id');
        $detail = $this->service->detail($userId);

        return $detail;
    }

    public function actionSendFindPasswordEmail()
    {
        $params = $this->request->getBodyParams();
        $this->service->sendFindPasswordEmail($params);

        return ['message' => '邮件发送成功'];
    }

    public function actionSendBindEmail()
    {
        $params = $this->request->getBodyParams();
        $this->service->sendBindEmail($params);

        return ['message' => '邮件发送成功'];
    }

    public function actionSendResetPasswordEmail()
    {
        $params = $this->request->getBodyParams();
        $this->service->sendResetPasswordEmail($params);

        return ['message' => '邮件发送成功'];
    }

    public function actionGetAuthLogList()
    {
        $params = $this->request->get();

        $result = $this->service->getLogList($params);

        return $result;
    }
}
