<?php


namespace monktan\libraries\oauth2\granttypes;

use League\OAuth2\Server\CryptKey;
use monktan\libraries\oauth2\repositories\AccessToken;
use monktan\libraries\oauth2\repositories\RefreshToken as RefreshTokenRepository;
use monktan\libraries\oauth2\repositories\Client;
use monktan\libraries\oauth2\repositories\Scope;
use monktan\libraries\oauth2\repositories\User;

class RefreshToken extends Base
{
    public function __construct(
        Client $client,
        Scope $scope,
        AccessToken $accessToken,
        User $user,
        RefreshTokenRepository $refreshToken
    ) {
        $this->client = $client;
        $this->scope = $scope;
        $this->accessToken = $accessToken;
        $this->user = $user;
        $this->refreshToken = $refreshToken;
    }

    public function getInstance()
    {
        $privateKey = new CryptKey(
            mt_config('oauth2.private_key'),
            mt_config('oauth2.passphrase'),
            false
        );

        self::$instance = new \League\OAuth2\Server\AuthorizationServer(
            $this->client,
            $this->accessToken,
            $this->scope,
            $privateKey,
            mt_config('oauth2.encryption_key')
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
