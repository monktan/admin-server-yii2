<?php
$alias = [
];
return [
    'success' => [
        'name' => '发送找回密码邮件-成功',
        'uri' => '/user/email',
        'headers' => [
        ],
        'method' => 'post',
        'body' => [
            'email' => '453539025@qq.com',
            'type' => 'find-password-email'
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ],
    'bind' => [
        'name' => '发送绑定邮箱邮件-成功',
        'uri' => '/user/email',
        'headers' => [
        ],
        'method' => 'post',
        'body' => [
            'email' => '453539025@qq.com',
            'type' => 'bind-email'
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ],
];
