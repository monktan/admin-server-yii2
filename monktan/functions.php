<?php
if (! function_exists('get_config')) {
    function get_config($data)
    {
        return response($data, RESPONSE_CODE_NORMAL);
    }
}

if (! function_exists('throw_info')) {
    function throw_info($message, $httpCode = RESPONSE_CODE_WARNING)
    {
        $exception = new \monktan\common\exceptions\InfoException($message, $httpCode);

        throw $exception;
    }
}