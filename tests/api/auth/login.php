<?php
$alias = [
    'captcha' => 'common/captcha@test',
];
return [
    'success' => [
        'name' => '登录-成功',
        'uri' => '/access-token',
        'method' => 'post',
        'body_type' => 'raw',
        'body' => [
            'username' => 'guojueneng',
            'password' => '1234567',
            'grant_type' => 'password',
            'captcha' => getd($alias['captcha'], 'response_body.captcha'),
            'captcha_id' => getd($alias['captcha'], 'response_body.captcha_id'),
        ],
        'is_run_dependency' => true,
        'dependencies' => [
            $alias['captcha']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['access_token'] ?? '');
        }
    ],
    'failed' => [
        'name' => '登录-失败',
        'uri' => '/access-token',
        'query_params' => [
            'r' => 'auth/login'
        ],
        'method' => 'post',
        'body_type' => 'raw',
        'body' => [
            'username' => 'guojueneng',
            'password' => '12345678',
            'grant_type' => 'password',
            'captcha' => '11',
            'captcha_id' => 'dd',
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ]
];
