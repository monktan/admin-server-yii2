<?php
return [
    'success' => [
        'name' => '图形验证码-成功',
        'uri' => '/captcha',
        'method' => 'get',
        'dependencies' => [
        ],
        'tests' => function ($body, $headers) {
            assertArrayHasKey('Captcha-Uuid', $headers);
            assertTrue(strpos($body, 'data:image/jpeg;') == 0);
        }
    ],
    'test' => [
        'name' => '图形验证码-依赖',
        'uri' => '/captcha-test',
        'method' => 'get',
    ],
];
