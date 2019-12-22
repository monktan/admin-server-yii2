<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '用户详情-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/detail',
            'user_id' => 49315301082267650,
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'get',
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
