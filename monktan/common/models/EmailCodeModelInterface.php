<?php
namespace monktan\common\models;

interface EmailCodeModelInterface
{
    const STATUS_NOT_VALIDATE = 1;
    const STATUS_VALIDATED = 2;

    public function getStatusText($result);
}
