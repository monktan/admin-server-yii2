<?php
namespace monktan\common;

class BaseValidate
{
    public function validate($scenario, $params)
    {
        if (! method_exists($this, $scenario)) {
            return true;
        }


        return call_user_func_array([$this, $scenario], [$params]);
    }
}
