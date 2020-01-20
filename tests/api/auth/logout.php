<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '退出登录-成功',
        'uri' => '/access-token',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'after_dependencies' => [
            $alias['login'],
        ],
        'body_type' => 'raw',
        'method' => 'delete',
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertTrue($jsonBody['message'] == '退出成功');
        }
    ],
];
