<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '创建用户-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/create'
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'post',
        'body' => [
            'username' => bin2hex(random_bytes(6)),
            'password' => '123456',
            'confirm_password' => '123456',
            'real_name' => '刘军',
            'mobile' => '111111',
            'email' => '222@qq.com',
            'status' => 1,
            'remark' => '',
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
