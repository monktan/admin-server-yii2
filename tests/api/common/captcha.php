<?php
return [
    'success' => [
        'name' => '图形验证码-成功',
        'uri' => '/captcha',
        'is_run_dependency' => true,
        'method' => 'get',
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {

        }
    ]
];
