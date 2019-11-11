<?php

return [
    'env' => 'dev',
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=120.79.214.111;port=33306;dbname=permission;',
        'username' => 'root',
        'password' => 'abc123',
        'charset' => 'utf8',
    ],
    "oauth2" => [
        'self_client_id' => 'cf62dd0f-5d35-5d0d-aa83-3454b96c10bc',
        'self_client_secret' => 'starabc123',
        'public_key' => APP_PATH . '/sshkey/public.pem',
        'private_key' => APP_PATH . '/sshkey/private.pem',
        'passphrase' => '',
        'encryption_key' => 'star',
    ],
];
