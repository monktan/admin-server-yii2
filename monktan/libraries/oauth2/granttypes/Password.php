<?php

namespace monktan\libraries\oauth2\granttypes;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

use monktan\libraries\oauth2\repositories\AccessToken;
use monktan\libraries\oauth2\repositories\Client;
use monktan\libraries\oauth2\repositories\Scope;
use monktan\libraries\oauth2\repositories\User;
use monktan\libraries\oauth2\repositories\RefreshToken;

class Password extends Base
{
    public function __construct(
        Client $client,
        Scope $scope,
        AccessToken $accessToken,
        User $user,
        RefreshToken $refreshToken
    ) {
        $this->client = $client;
        $this->scope = $scope;
        $this->accessToken = $accessToken;
        $this->user = $user;
        $this->refreshToken = $refreshToken;
    }

    public function getInstance()
    {
        if (! is_null(self::$instance)) {
            return self::$instance;
        }

        $privateKey = new CryptKey(
            mt_config('oauth2.private_key'),
            mt_config('oauth2.passphrase'),
            false
        );

        self::$instance = new AuthorizationServer(
            $this->client,
            $this->accessToken,
            $this->scope,
            $privateKey,
            mt_config('oauth2.encryption_key')
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
