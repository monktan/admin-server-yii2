<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '更新用户-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/update',
            'user_id' => 49315301082267650,
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'put',
        'body' => [
            'real_name' => '李四222',
            'mobile' => '李四',
            'email' => '222@qq.com',
            'status' => 1,
            'remark' => '',
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
