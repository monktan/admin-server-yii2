<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '更新状态-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/update-status',
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'put',
        'body' => [
            'user_ids' => [49315301082267650],
            'status' => 1,
        ],
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
