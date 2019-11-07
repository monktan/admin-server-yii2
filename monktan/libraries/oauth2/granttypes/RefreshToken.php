<?php


namespace monktan\libraries\oauth2\granttypes;

use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use monktan\libraries\oauth2\AccessToken;
use monktan\libraries\oauth2\Client;
use monktan\libraries\oauth2\Scope;
use monktan\libraries\oauth2\User;

class RefreshToken extends Base
{
    public function __construct(
        ClientRepositoryInterface $client = null,
        ScopeRepositoryInterface $scope = null,
        AccessTokenRepositoryInterface $accessToken = null,
        UserRepositoryInterface $user = null,
        RefreshTokenRepositoryInterface $refreshToken = null
    ) {
        $this->client = is_null($client) ? (new Client()) : $client;
        $this->scope = is_null($scope) ? (new Scope()) : $scope;
        $this->accessToken = is_null($accessToken) ? (new AccessToken()) : $accessToken;
        $this->user = is_null($user) ? (new User()) : $user;
        $this->refreshToken = is_null($refreshToken) ? (new \star\oauth2\RefreshToken()) : $refreshToken;
    }

    public function getInstance()
    {
        $privateKey = new CryptKey(
            \Yii::$app->params['oauth2']['private_key'],
            \Yii::$app->params['oauth2']['passphrase'],
            false
        );

        self::$instance = new \League\OAuth2\Server\AuthorizationServer(
            $this->client,
            $this->accessToken,
            $this->scope,
            $privateKey,
            \Yii::$app->params['oauth2']['encryption_key']
        );

        $this->refreshToken->setPrivateKey($privateKey);
        $grant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($this->refreshToken);
        $grant->setRefreshTokenTTL(new \DateInterval('P1M'));
        self::$instance->enableGrantType(
            $grant,
            new \DateInterval('PT2H')
        );

        return self::$instance;
    }
}
