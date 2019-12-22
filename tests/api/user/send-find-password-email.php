<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '发送找回密码邮件-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/send-find-password-email'
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'post',
        'body' => [
            'email' => '453539025@qq.com',
        ],
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ]
];
