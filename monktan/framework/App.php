<?php
namespace monktan\framework;

use monktan\framework\db\ModelInterface;

class App
{
    private static $map = [
        'app' => \monktan\framework\AppInterface::class,
        'container' => \monktan\framework\ContainerInterface::class,
        'config' => \monktan\framework\ConfigInterface::class,
        'model' => \monktan\framework\db\ModelInterface::class,
        'request' => \monktan\framework\RequestInterface::class,
        'cache' => \monktan\framework\CacheInterface::class,
    ];

    private static function get($alias)
    {
        return \Yii::$container->get(self::$map[$alias]);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::get($name);
    }
}
