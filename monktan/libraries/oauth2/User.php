<?php


namespace monktan\libraries\oauth2;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use monktan\common\models\UserModelInterface;
use monktan\libraries\oauth2\entities\UserEntity;

class User implements UserRepositoryInterface
{
    private $userModel;

    public function __construct(UserModelInterface $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $user = $this->userModel->getUserByAccount($username, $password);
        if ($clientEntity->getIdentifier() != $user['client_id']) {
            throw_info('客户端没有授权');
        }
        $userEntity = new UserEntity();
        $userEntity->setIdentifier($user['user_id']);

        return $userEntity;
    }
}