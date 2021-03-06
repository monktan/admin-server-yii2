<?php
$alias = [
    'login' => 'auth/login@success',
    'new-del' => 'user/create@for-delete',
    'list-del' => 'user/list@for-delete',
    'list' => 'user/list@success',
];

return [
    'success' => [
        'name' => '删除用户-成功',
        'uri' => '/users',
        'is_run_dependency' => true,
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body' => [
            'user_ids' => get_list_user_ids('list-del', $alias),
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'delete',
        'after_dependencies' => [
            $alias['list'],
        ],
        'dependencies' => [
            $alias['login'],
            $alias['new-del'],
            $alias['list-del'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEquals('删除成功', $jsonBody['message']);
        }
    ]
];
