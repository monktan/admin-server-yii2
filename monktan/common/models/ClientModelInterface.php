<?php
namespace monktan\common\models;

interface ClientModelInterface extends \monktan\libraries\oauth2\storages\ClientModelInterface
{
    const STATUS_DISABLE = 2;

    const STATUS_ENABLE = 1;
}
