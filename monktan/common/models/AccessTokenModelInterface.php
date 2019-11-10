<?php
namespace monktan\common\models;

interface AccessTokenModelInterface extends \monktan\framework\db\ModelInterface,
    \monktan\libraries\oauth2\storages\AccessTokenModelInterface
{

}
