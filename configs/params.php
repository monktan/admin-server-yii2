<?php

return [
    'oauth2' => ORIGIN_CONFIGS['oauth2'],
    'ignore_route_rules' => [
        'app\controllers\AuthController::login',
        'app\controllers\AuthController::refresh-token',
        'app\controllers\UserController::send-email',
        'app\controllers\CommonController::captcha',
        'app\controllers\CommonController::captcha-test',
        'app\controllers\CommonController::email-code-status',
    ],
    'email' => ORIGIN_CONFIGS['email'],
    'base_url' => 'http://39.108.160.31',
];
