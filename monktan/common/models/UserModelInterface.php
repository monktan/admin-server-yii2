<?php
namespace monktan\common\models;

interface UserModelInterface extends \monktan\libraries\oauth2\storages\UserModelInterface
{
    const STATUS_DISABLE = 2;
    const STATUS_ENABLE = 1;
    const DELETED = 1;
    const NORMAL = 0;

    public function getStatusText($status);
}