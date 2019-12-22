<?php

return [
    //权限
    'DELETE access-token' => 'auth/logout',
    'GET access-token' => 'auth/logout',
    'POST access-token' => 'auth/login',
    'POST refresh-token' => 'auth/refresh-token',
    'GET captcha' => 'common/captcha',
    'GET current-user' => 'user/user-info',
];
