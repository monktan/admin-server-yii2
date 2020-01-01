<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];
return [
    'success' => [
        'name' => '登录登出日志-成功',
        'uri' => '/user/'. get_list_user_id('list', $alias).'/auth-logs',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'get',
        'dependencies' => [
            $alias['login'],
            $alias['list'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertArrayHasKey('data', $jsonBody);
            assertArrayHasKey('count', $jsonBody);
        }
    ],
    'fixed' => [
        'name' => '登录登出日志-成功',
        'uri' => '/user/1/auth-logs',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'is_run_dependency' => true,
        'method' => 'get',
        'dependencies' => [
            $alias['login'],
            $alias['list'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertArrayHasKey('data', $jsonBody);
            assertArrayHasKey('count', $jsonBody);
        }
    ],
];
