<?php
namespace monktan\modules\user;

trait EmailServiceTrait
{
    public function sendBindEmail()
    {

    }

    public function updateEmail($params)
    {
        //校验随机码
        $user = [];
        //更新邮箱
        $updateData['email'] = $params['email'];
        $updateData['update_by'] = $params['update_by'];

        $this->baseUpdate($updateData, [$user['user_id']]);
    }
}
