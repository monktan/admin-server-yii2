<?php

namespace monktan\libraries\oauth2\granttypes;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\ImplicitGrant;
use monktan\libraries\oauth2\repositories\AccessToken;
use monktan\libraries\oauth2\repositories\Client;
use monktan\libraries\oauth2\repositories\Scope;

class Implicit extends Base
{
    public function __construct(
        Client $client,
        Scope$scope,
        AccessToken $accessToken
    ) {
        $this->client = $client;
        $this->scope = $scope;
        $this->accessToken = $accessToken;
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

        self::$instance->enableGrantType(
            new ImplicitGrant(new \DateInterval('PT2H')),
            new \DateInterval('PT2H') // 2个小时过期
        );

        return self::$instance;
    }


}
