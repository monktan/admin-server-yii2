<?php

return [
    //权限
    'DELETE access-token' => 'auth/logout',
    'GET access-token' => 'auth/logout',
    'POST access-token' => 'auth/login',
    'POST refresh-token' => 'auth/refresh-token',
    'GET captcha' => 'common/captcha',
    'GET captcha-test' => 'common/captcha-test',
    'GET email-code/<emailCode>/status' => 'common/email-code-status',

    //用户
    'GET current-user' => 'user/user-info',
    'POST user' => 'user/create',
    'DELETE users' => 'user/delete',
    'GET users' => 'user/get-list',
    'POST user/email' => 'user/send-email',
    'PUT user/status' => 'user/update-status',

    'PUT user/password' => 'user/update-password',

    'GET user/<userId>/auth-logs' => 'user/get-auth-log-list',
    'GET user/<userId>' => 'user/detail',
    'PUT user/<userId>/random-password' => 'user/reset-password',
    'PUT user/<userId>' => 'user/update',   //注意不能放在user/password前面

];
