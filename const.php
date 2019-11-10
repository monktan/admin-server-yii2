<?php
/**
 * 这里定义常量
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('APPLICATION_NAME') or define('APPLICATION_NAME', 'admin-server');    //项目名称，这个名称和配置文件的目录也是对应的
defined('APP_PATH') or define('APP_PATH', __DIR__);    //项目根目录
defined('VENDOR_PATH') or define('VENDOR_PATH', __DIR__ . '/../vendor/vendor');    //项目根目录


defined('RESPONSE_CODE_NORMAL') or define('RESPONSE_CODE_NORMAL', 200);
defined('RESPONSE_CODE_WARNING') or define('RESPONSE_CODE_WARNING', 400);
defined('RESPONSE_CODE_UNAUTHORIZED') or define('RESPONSE_CODE_UNAUTHORIZED', 401);
defined('RESPONSE_CODE_FORBIDDEN') or define('RESPONSE_CODE_FORBIDDEN', 403);
defined('RESPONSE_CODE_ERROR') or define('RESPONSE_CODE_ERROR', 500);

defined('ENV_PROD') or define('ENV_PROD', 'prod');
defined('ENV_BETA') or define('ENV_BETA', 'beta');
defined('ENV_ALPHA') or define('ENV_ALPHA', 'alpha');
defined('ENV_TEST') or define('ENV_TEST', 'test');
defined('ENV_DEV') or define('ENV_DEV', 'dev');