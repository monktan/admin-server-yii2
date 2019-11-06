<?php
/**
 * Description
 *
 *
 * Datetime: 2019-08-04 15:31
 */

namespace star\oauth2\granttypes;


use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\ImplicitGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use star\oauth2\AccessToken;
use star\oauth2\Client;
use star\oauth2\Scope;

class Implicit extends Base
{
    public function __construct(
        ClientRepositoryInterface $client = null,
        ScopeRepositoryInterface $scope = null,
        AccessTokenRepositoryInterface $accessToken = null
    ) {
        $this->client = is_null($client) ? (new Client()) : $client;
        $this->scope = is_null($scope) ? (new Scope()) : $scope;
        $this->accessToken = is_null($accessToken) ? (new AccessToken()) : $accessToken;
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

        self::$instance->enableGrantType(
            new ImplicitGrant(new \DateInterval('PT2H')),
            new \DateInterval('PT2H') // 2个小时过期
        );

        return self::$instance;
    }


}
