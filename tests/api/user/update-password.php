<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];
return [
    'other-success' => [
        'name' => '修改其他人密码-成功',
        'uri' => '/user/password',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'put',
        'body' => [
            'user_id' => get_list_user_id('list', $alias),
            'old_password' => 1234567,
            'confirm_password' => 1234567,
            'new_password' => 1234567,
        ],
        'is_run_dependency' => true,
        'after_dependencies' => [
            $alias['login'],
        ],
        'dependencies' => [
            $alias['login'],
            $alias['list'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEquals('更新密码成功', $jsonBody['message']);
        }
    ],
    'email-code-success' => [
        'name' => '通过邮箱链接更新密码-成功',
        'uri' => '/user/password',
        'method' => 'put',
        'body' => [
            'code' => 1234567,
            'confirm_password' => 1234567,
            'new_password' => 1234567,
        ],
    ],
    'self-success' => [
        'name' => '修改自己的密码-成功',
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
