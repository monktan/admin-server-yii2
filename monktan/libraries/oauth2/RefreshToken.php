<?php


namespace star\oauth2;

use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use star\oauth2\storages\mysql\RefreshTokenEntity;
use star\oauth2\storages\mysql\RefreshTokenModel;

class RefreshToken implements RefreshTokenRepositoryInterface
{
    private $refreshTokenModel;

    private $refreshTokenEntity;

    private $privateKey;

    public function __construct(
        RefreshTokenEntityInterface $refreshTokenEntity = null,
        RefreshTokenModel $refreshTokenModel = null
    ) {
        $this->refreshTokenEntity = is_null($refreshTokenModel) ? (new RefreshTokenEntity()) : $refreshTokenEntity;
        $this->refreshTokenModel = is_null($refreshTokenModel) ? (new RefreshTokenModel()) : $refreshTokenModel;
    }

    /**
     * 创建一个新token
     * @return RefreshTokenEntityInterface|RefreshTokenEntity|null
     */
    public function getNewRefreshToken()
    {
        $this->refreshTokenEntity->setPrivateKey($this->privateKey);
        return $this->refreshTokenEntity;
    }

    /**
     * 保存token
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     * @throws \Throwable
     * @throws \star\common\exceptions\InfoException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $saveData = [];
        $saveData['access_token_id'] = $refreshTokenEntity->getAccessToken()->getIdentifier();
        $saveData['token_id'] = $refreshTokenEntity->getIdentifier();
        $saveData['expire_time'] = $refreshTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
        $refreshTokenArr = explode('.', (string)$refreshTokenEntity);
        if (! isset($refreshTokenArr[2])) {
            throw_info('无效token');
        }
        $saveData['token_sign'] = $refreshTokenArr[2];

        $this->refreshTokenModel->saveToken($saveData);
    }

    /**
     * Revoke an refresh token.
     *
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        $this->refreshTokenModel->revokeToken($tokenId);
    }

    /**
     * Check if the refresh token has been revoked.
     * @param string $tokenId
     * @return bool
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        return $this->refreshTokenModel->isTokenRevoked($tokenId);
    }

    public function setPrivateKey(CryptKey $key)
    {
        $this->privateKey = $key;
    }

    public function getRefreshTokenInfoByAccessTokenId($accessTokenId)
    {
        return $this->refreshTokenModel->getRefreshTokenInfoByAccessTokenId($accessTokenId);
    }
}
