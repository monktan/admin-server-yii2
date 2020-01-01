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

class CommonService extends BaseService
{
    public function captcha()
    {
        $builder = new CaptchaBuilder();
        $builder->build();
        header('Content-type: image/jpeg');
        $builder->output();
    }
}