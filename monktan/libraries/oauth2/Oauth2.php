<?php
namespace monktan\libraries\oauth2;

class Oauth2
{
    public static function getInstance($grantType = 'Password')
    {
        $modeClass = __NAMESPACE__ . '\granttypes\\' . $grantType;

        if (! class_exists($modeClass)) {
            throw_info("类{$modeClass}不存在");
        }

        $instance = (new $modeClass);

        return $instance;
    }
}
