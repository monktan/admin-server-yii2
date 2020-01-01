<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];

return [
    'success' => [
        'name' => '用户详情-成功',
        'uri' => '/user/' . get_list_user_id('list', $alias),
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
            assertArrayHasKey('user_id', $jsonBody);
        }
    ]
];