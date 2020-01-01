<?php

return [
    'oauth2' => ORIGIN_CONFIGS['oauth2'],
    'ignore_route_rules' => [
        'app\controllers\AuthController::login',
        'app\controllers\AuthController::refresh-token',
        'app\controllers\UserController::send-find-password-email',
        'app\controllers\CommonController::captcha',
    ],
    'email' => ORIGIN_CONFIGS['email'],
];
