<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '登录登出日志-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/get-auth-log-list',
            'user_id' => 1,
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'is_run_dependency' => true,
        'method' => 'get',
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertArrayHasKey('data', $jsonBody);
            assertArrayHasKey('count', $jsonBody);
        }
    ]
];
