<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];
return [
    'success' => [
        'name' => '修改密码-成功',
        'uri' => '/user/password',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'put',
        'body' => [
            'old_password' => 1234567,
            'confirm_password' => 1234567,
            'new_password' => 1234567,
        ],
        'after_dependencies' => [
            $alias['login'],
        ],
        'dependencies' => [
            $alias['login'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEquals('更新密码成功', $jsonBody['message']);
        }
    ]
];
