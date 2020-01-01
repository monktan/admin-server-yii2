<?php
namespace app\framework;

use monktan\framework\CacheInterface;

class Cache implements CacheInterface
{
    public function get($key)
    {
        return \Yii::$app->cache->get($key);
    }

    public function set($key, $value, $duration = null, $dependency = null)
    {
        return \Yii::$app->cache->set($key, $value, $duration, $dependency);
    }

    public function exists($key)
    {
        return \Yii::$app->cache->exists($key);
    }
}
