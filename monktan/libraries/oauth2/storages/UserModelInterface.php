<?php

namespace monktan\libraries\oauth2\storages;

interface UserModelInterface
{
    public function getUserByAccount($loginId, $password);
}
