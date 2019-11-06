<?php
/**
 * Description
 *
 *
 * Datetime: 2019-08-04 15:35
 */

namespace star\oauth2;

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
