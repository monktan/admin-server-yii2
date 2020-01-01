<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];
return [
    'success' => [
        'name' => '重置密码-成功',
        'uri' => '/user/'. get_list_user_id('list', $alias) . '/random-password',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'put',
        'dependencies' => [
            $alias['login'],
            $alias['list'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEquals('重置密码成功', $jsonBody['message']);
        }
    ]
];
