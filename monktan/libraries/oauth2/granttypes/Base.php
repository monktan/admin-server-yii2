<?php

namespace monktan\libraries\oauth2\granttypes;

use star\oauth2\AccessToken;
use star\oauth2\Client;
use star\oauth2\Scope;
use star\oauth2\User;

abstract class Base
{
    protected static $instance;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Scope
     */
    protected $scope;

    /**
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var \star\oauth2\RefreshToken
     */
    protected $refreshToken;

    abstract public function getInstance();

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
