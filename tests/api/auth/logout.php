<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '退出登录-成功',
        'uri' => '/index.php',
        'headers' => [
            'Authorization' => getd($alias['login'], 'response_body.access_token')
        ],
        'query_params' => [
            'r' => 'auth/logout'
        ],
        'is_run_dependency' => true,
        'method' => 'get',
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertTrue($jsonBody['message'] == '退出成功');
        }
    ],
    'failed' => [
        'name' => '退出登录-失败',
        'uri' => '/index.php',
        'headers' => [
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJjZjYyZGQwZi01ZDM1LTVkMGQtYWE4My0zNDU0Yjk2YzEwYmMiLCJqdGkiOiJhZmQ2ZTY3M2RkZmZjNzlmNDY2N2YzYTdlZGM0ODY5NGE3YjViOTc0MzhhZGE1NDRiYTUwYTdmOGFlMTM1NDEyMjc0NDgwYmMxZWU5NWUxZiIsImlhdCI6MTU3Mzc0NTQ1OCwibmJmIjoxNTczNzQ1NDU4LCJleHAiOjE1NzM3NTI2NTgsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.HpSlwbZUoU1sIpaY-P9YuHtzSCsGgK0FgkNgwOdGoW8AksvTf_mKVN1LuwywC-_3s0aEu5azIVOJ1rPCh3OJA06j5fiT3af2_bDtO_-uIA9XXX-MnKDvt3dnCWS9xBGPN8c13Dpwe_fk6UaJinQf7Tz3H8ccyAtPvZTbsWzG8B0'
        ],
        'query_params' => [
            'r' => 'auth/logout'
        ],
        'method' => 'get',
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertTrue($jsonBody['message'] != '退出成功');
        }
    ],
];
