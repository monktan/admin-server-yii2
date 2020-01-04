<?php
return [
    'success' => [
        'name' => '获取邮箱码状态-成功',
        'uri' => '/email-code/aaa/status',
        'method' => 'get',
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertArrayHasKey('status', $jsonBody);
            assertArrayHasKey('message', $jsonBody);
        }
    ]
];
