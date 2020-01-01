<?php
$alias = [
];
return [
    'success' => [
        'name' => '发送找回密码邮件-成功',
        'uri' => '/user/find-password-email',
        'headers' => [
        ],
        'method' => 'post',
        'body' => [
            'email' => '453539025@qq.com',
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ]
];
