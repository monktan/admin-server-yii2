<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '删除用户-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/delete',
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body' => [
            'user_ids' => [49315301082267650],
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'delete',
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['message'] ?? '');
        }
    ]
];
