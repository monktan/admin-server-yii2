<?php
namespace app\framework;

use monktan\framework\CacheInterface;

class Cache implements CacheInterface
{
    public function get($key)
    {
        return \Yii::$app->redis->get($key);
    }

    public function set($key, $value)
    {
        return \Yii::$app->redis->set($key, $value);
    }

    public function setex($key, $ttl, $value)
    {
        return \Yii::$app->redis->setex($key, $ttl, $value);
    }

    public function exists($key)
    {
        return \Yii::$app->redis->exists($key);
    }

    public function del($key1)
    {
        return \Yii::$app->redis->del($key1);
    }
}
