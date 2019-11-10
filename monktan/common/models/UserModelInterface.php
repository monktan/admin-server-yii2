<?php
namespace monktan\common\models;

interface UserModelInterface extends \monktan\framework\db\ModelInterface,
    \monktan\libraries\oauth2\storages\UserModelInterface
{

}