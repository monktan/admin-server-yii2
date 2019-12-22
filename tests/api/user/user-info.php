<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '获取登录用户信息-成功',
        'uri' => '/current-user',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'get',
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
//            assertJson($body);
//            $jsonBody = json_decode($body, true);
//            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ]
];
