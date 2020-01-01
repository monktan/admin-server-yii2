<?php
$alias = [
    'login' => 'auth/login@success'
];
return [
    'success' => [
        'name' => '刷新token-成功',
        'uri' => '/refresh-token',
        'method' => 'post',
        'body_type' => 'raw',
        'body' => [
            'refresh_token' => getd($alias['login'], 'response_body.refresh_token'),
            'grant_type' => 'refresh_token',
        ],
        'after_dependencies' => [
            $alias['login'],
        ],
        'dependencies' => [
            $alias['login']
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertNotEmpty($jsonBody['access_token'] ?? '');
        }
    ],
    'failed' => [
        'name' => '刷新token-失败',
        'uri' => '/refresh-token',
        'method' => 'post',
        'body_type' => 'raw',
        'body' => [
            'refresh_token' => 'def5020099a6d0a4e40236e05a6c3315561c73c7cd3b23b9d25fda9f9da3d1c470be717f0c64933da109b10bd837db99967a8687e8cecf0c5348e4f63508de8236c19addc6ab985d0ee106f55976f78c7858d67adfd27c3fefdd9a51ddecae1c8fadd08c53be56c1cd8194137e369873ed28f9fd03f719a046f0a50c12549ea32cc071584c99736a10494f06b0e74966526336a2a2f15bf1403f4e116ceba4b3326b00d56f5129e2b1a3d412d712b0b3de12d1ebb9196fb42fdec20f12ab131e235fe3fb7ccd53225ede42593a35b535a46621700d106151f2b09e07355620404046f24ce213ac7c3d6a4f461bee126eaa9fb5601894ad86d538b10683c5612e5917691d8f1f65075b2960493ae3940bb8d0a70029a27b8947a93affb31df06df3cfe0fb54854d12199c48c748e52dc5d65376f85b39f6e0ee297452df6589f0d4a14f5a7548a6c15399f79571b5e0302e855b71852f8ebdb6d999fd5e40bba1bc15c45d47cf3af05ea096eaa789ecffe94b904e39fd6ddf6f7359b1313535f5bd4dd81c52ce',
            'grant_type' => 'refresh_token',
        ],
        'tests' => function ($body, $headers) {
            assertJson($body);
            $jsonBody = json_decode($body, true);
            assertEmpty($jsonBody['access_token'] ?? '');
        }
    ]
];
