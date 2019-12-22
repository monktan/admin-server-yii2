<?php
/**
 * 这里是初始化代码
 */


require __DIR__ . '/const.php';
require __DIR__ . '/../vendor/vendor/autoload.php';
require_once __DIR__ . '/../vendor/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/monktan/functions/common.php';

$originConfigs = require __DIR__ . '/configs.php';
defined('ORIGIN_CONFIGS') or define('ORIGIN_CONFIGS', $originConfigs);