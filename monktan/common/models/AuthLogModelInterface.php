<?php
namespace monktan\common\models;

interface AuthLogModelInterface
{
    const LOG_TYPE_LOGIN = 1;
    const LOG_TYPE_LOGOUT = 2;

    public function getTypeText($type);
}
