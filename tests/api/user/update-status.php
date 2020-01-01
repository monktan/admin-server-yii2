<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];
return [
    'success' => [
        'name' => '更新状态-成功',
        'uri' => '/user/status',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'put',
        'body' => [
            'user_ids' => get_list_user_ids('list', $alias),
            'status' => 1,
        ],
        'dependencies' => [
            $alias['login'],
            $alias['list'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEquals('更新状态成功', $jsonBody['message']);
        }
    ]
];
