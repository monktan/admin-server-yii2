<?php
namespace monktan\framework;

class App
{
    /**
     * @var ConfigInterface
     */
    public static $config;

    /**
     * @var AppInterface
     */
    public static $app;

    /**
     * @var ContainerInterface
     */
    public static $container;

    public static function setApp(AppInterface $app)
    {
        self::$app = $app;
    }

    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }

    public static function setConfig(ConfigInterface $config)
    {
        self::$config = $config;
    }
}
