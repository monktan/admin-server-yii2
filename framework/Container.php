<?php
namespace app\framework;

use monktan\framework\ContainerInterface;

class Container implements ContainerInterface
{
    public function get($interface)
    {
        return \Yii::$container->get($interface);
    }

    public function set($interface, $class)
    {
        return \Yii::$container->set($interface, $class);
    }
}
