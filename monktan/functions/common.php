<?php
if (! function_exists('mt_config')) {
    function mt_config($data)
    {
        return response($data, RESPONSE_CODE_NORMAL);
    }
}

if (! function_exists('mt_throw_info')) {
    function mt_throw_info($message, $httpCode = RESPONSE_CODE_WARNING)
    {
        $exception = new \monktan\common\exceptions\InfoException($message, $httpCode);

        throw $exception;
    }
}
