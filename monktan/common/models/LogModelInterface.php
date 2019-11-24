<?php
namespace monktan\common\models;

interface LogModelInterface
{
    const RESULT_FAILED = 2;
    const RESULT_SUCCESS = 1;

    public function getResultText($result);
}
