<?php
/**
 * Description
 *
 *
 * Datetime: 2019-12-22 19:14
 */

namespace monktan\modules\common;

use Gregwar\Captcha\CaptchaBuilder;
use monktan\common\services\BaseService;
use monktan\libraries\Captcha;

class CommonService extends BaseService
{
    public function captcha()
    {
         return  Captcha::generate();
    }
}