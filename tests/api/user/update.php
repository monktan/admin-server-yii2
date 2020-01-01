<?php
$alias = [
    'login' => 'auth/login@success',
    'list' => 'user/list@success',
];

return [
    'success' => [
        'name' => '更新用户-成功',
        'uri' => '/user/' . get_list_user_id('list', $alias),
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'method' => 'put',
        'console_enable' => false,
        'body' => [
            'real_name' => '李四222',
            'mobile' => '李四',
            'email' => '222@qq.com',
            'status' => 1,
            'remark' => '',
        ],
        'dependencies' => [
            $alias['login'],
            $alias['list'],
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEquals('更新成功', $jsonBody['message']);
        }
    ]
];
