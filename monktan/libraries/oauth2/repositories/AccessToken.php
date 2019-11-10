<?php

namespace monktan\libraries\oauth2\repositories;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use monktan\libraries\oauth2\entities\AccessTokenEntity;
use monktan\libraries\oauth2\storages\AccessTokenModelInterface;

class AccessToken implements AccessTokenRepositoryInterface
{
    private $accessTokenModel;

    private $accessTokenEntity;

    public function __construct(
        AccessTokenEntity $accessTokenEntity,
        AccessTokenModelInterface $accessTokenModel
    ) {
        $this->accessTokenEntity = $accessTokenEntity;
        $this->accessTokenModel = $accessTokenModel;
    }

    /**
     * 创建一个新token
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $this->accessTokenEntity->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $this->accessTokenEntity->addScope($scope);
        }
        $this->accessTokenEntity->setUserIdentifier($userIdentifier);

        return $this->accessTokenEntity;
    }

    /**
     * 保存token
     * @param AccessTokenEntityInterface $accessTokenModel
     * @throws \Throwable
     * @throws \star\common\exceptions\InfoException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $saveData = [];
        $saveData['client_id'] = $accessTokenEntity->getClient()->getIdentifier();
        $saveData['token_id'] = $accessTokenEntity->getIdentifier();
        $saveData['scopes'] = join(',', $accessTokenEntity->getScopes());
        $saveData['user_id'] = $accessTokenEntity->getUserIdentifier();
        $saveData['expire_time'] = $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
        $accessTokenArr = explode('.', (string)$accessTokenEntity);
        if (! isset($accessTokenArr[2])) {
            mt_throw_info('无效token');
        }
        $saveData['token_sign'] = $accessTokenArr[2];

        $this->accessTokenModel->saveToken($saveData);
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        $this->accessTokenModel->revokeToken($tokenId);
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return $this->accessTokenModel->isTokenRevoked($tokenId);
    }
}
