<?php
namespace monktan\modules\user;

use monktan\framework\App;
use monktan\libraries\SnowFlake;

trait AuthLogServiceTrait
{
    public function log($type)
    {
        $log = [];
        $log['user_id'] = mt_session_data('user_id');
        $log['type'] = $type;
        $log['ip'] = App::$request->ip();
        $log['agent'] = App::$request->userAgent();
        $log['log_id'] = SnowFlake::getInstance()->generateId();

        mt_model('AuthLog')->insert($log);
    }

    public function getLogList()
    {

    }

    public function getLogListQuery()
    {

    }

    public function getLogListData()
    {

    }

    public function getLogListCount()
    {

    }
}
