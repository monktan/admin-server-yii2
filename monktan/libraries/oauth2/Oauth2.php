<?php
namespace monktan\libraries\oauth2;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use monktan\framework\App;

class Oauth2
{
    public static function getInstance($grantType = 'Password')
    {
        $modeClass = __NAMESPACE__ . '\granttypes\\' . $grantType;

        if (! class_exists($modeClass)) {
            mt_throw_info("类{$modeClass}不存在");
        }

        $instance = App::$container->get($modeClass);

        return $instance;
    }
}
