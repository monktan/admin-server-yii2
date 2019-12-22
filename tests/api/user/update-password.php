<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '修改密码-成功',
        'uri' => '/index.php',
        'query_params' => [
            'r' => 'user/update-password',
            'user_id' => 49315301082267650
        ],
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'body_type' => 'x-www-form-urlencoded',
        'method' => 'put',
        'body' => [
            'old_password' => 1234567,
            'confirm_password' => 1234567,
            'new_password' => 1234567,
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
