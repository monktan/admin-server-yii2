<?php
/**
 * Description
 *
 *
 * Datetime: 2019-12-22 19:14
 */

namespace monktan\modules\common;

use monktan\common\services\BaseService;
use monktan\libraries\Captcha;

class CommonService extends BaseService
{
    public function captcha()
    {
        return  Captcha::generate();
    }

    public function captchaTest()
    {
        return  Captcha::generate(true);
    }

    public function getEmailCodeStatus($emailCode)
    {
        $result = ['status'=>0, 'message'=>'验证码已过期'];
        $item = mt_model('EmailCode')->newQuery()->where(['email'=>$emailCode])
            ->value('expired_time');
        if (empty($item)) {
            return $result;
        }

        if ($item['expired_time'] < time()) {
            return $result;
        }

        if ($item['status'] != 2 || $item['is_deleted'] != 2) {
            return $result;
        }

        return ['status'=>1, 'message'=>'ok'];
    }
}