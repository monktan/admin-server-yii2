<?php


namespace star\oauth2\granttypes;


use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use star\oauth2\AccessToken;
use star\oauth2\Client;
use star\oauth2\RefreshToken;
use star\oauth2\Scope;
use star\oauth2\User;

class Password extends Base
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
        $this->refreshToken = is_null($refreshToken) ? (new RefreshToken()) : $refreshToken;
    }

    public function getInstance()
    {
        if (! is_null(self::$instance)) {
            return self::$instance;
        }

        $privateKey = new CryptKey(
            \Yii::$app->params['oauth2']['private_key'],
            \Yii::$app->params['oauth2']['passphrase'],
            false
        );

        self::$instance = new AuthorizationServer(
            $this->client,
            $this->accessToken,
            $this->scope,
            $privateKey,
            \Yii::$app->params['oauth2']['encryption_key']
        );

        $this->refreshToken->setPrivateKey($privateKey);
        $grant = new PasswordGrant(
            $this->user,
            $this->refreshToken
        );
        $grant->setRefreshTokenTTL(new \DateInterval('P1M'));   //一个月后过期
        self::$instance->enableGrantType(
            $grant,
            new \DateInterval('PT2H') //access_token2个小时过期
        );

        return self::$instance;
    }

    public function setUser(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }
}
