<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '用户列表-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/get-list',
            'real_name' => '军',
            'page_size' => '10',
            'page' => '1',
            'username' => '',
            'status' => 1,
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
            assertNotEmpty($jsonBody['access_token'] ?? '');
        }
    ]
];
