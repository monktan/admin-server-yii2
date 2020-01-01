<?php

use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/params.php'
);

return [
    'id' => 'admin-server',
    'basePath' => dirname(__DIR__),
    'runtimePath' => dirname(__DIR__) . '/../runtime',
    'language' => 'zh-CN',
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'defaultRoute' => 'index/index',
    'aliases' => [
        '@app' => dirname(__DIR__),
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin-server-yii2',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'errorHandler' => [
            'class' => 'monktan\common\ErrorHandler',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'admin-server-yii2',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => ORIGIN_CONFIGS['redis'],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => require __DIR__ . '/route_rules.php',
        ],
        'db' => ORIGIN_CONFIGS['db']
    ],
    'params' => $params,
];
