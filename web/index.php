<?php

/**
 * API接口入口文件
 */
header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 3600');
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD,PATCH');
    header('Access-Control-Allow-Headers: Authorization,Lang,Content-Type,Accept,Origin,'.
    'User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,'.
    'X-Requested-With,If-Modified-Since,Captcha,X-Result-Fields');
    header('HTTP/1.1 204 No Content');
    exit;
}

require __DIR__ . '/../init.php';
$config = require __DIR__ . '/../configs/config.php';

(new yii\web\Application($config))->run();
