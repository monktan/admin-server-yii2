<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '用户列表-成功',
        'uri' => '/users',
        'query_params' => [
            'real_name' => '军',
            'page_size' => '10',
            'page' => '1',
            'username' => '',
            'status' => 1,
        ],
        'is_run_dependency' => true,
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
            assertArrayHasKey('data', $jsonBody);
            assertArrayHasKey('count', $jsonBody);
        }
    ],
    'for-delete' => [
        'name' => '用户列表-给删除',
        'uri' => '/users',
        'query_params' => [
            'real_name' => '',
            'page_size' => '10',
            'page' => '1',
            'username' => 'delete',
            'status' => 1,
        ],
        'is_run_dependency' => true,
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
            assertArrayHasKey('data', $jsonBody);
            assertArrayHasKey('count', $jsonBody);
        }
    ],
];
