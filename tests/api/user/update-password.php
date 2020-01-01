<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];
return [
    'success' => [
        'name' => '修改其他人密码-成功',
        'uri' => '/user/'. get_list_user_id('list', $alias) . '/password',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'put',
        'body' => [
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
    ]
];
