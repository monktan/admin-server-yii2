<?php
namespace monktan\framework;

use monktan\framework\db\ModelInterface;

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
     * @var ModelInterface
     */
    public static $model;

    /**
     * @var RequestInterface
     */
    public static $request;

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

    public static function setModel(ModelInterface $model)
    {
        self::$model = $model;
    }

    public static function setRequest(RequestInterface $request)
    {
        self::$request = $request;
    }
}
