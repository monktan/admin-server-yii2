<?php
namespace app\framework;

use monktan\framework\ConfigInterface;

class Config implements ConfigInterface
{
    public function get($key = '')
    {
        $configs = \Yii::$app->params;

        if (empty($key)) {
            return $configs;
        }

        $keyArr = explode('.', $key);

        $config = $configs;
        foreach ($keyArr as $k) {
            if (! isset($config[$k])) {
                mt_throw_info('找不到配置:' . $key);
            }
            $config = $config[$k];
        }

        return $config;
    }
}
