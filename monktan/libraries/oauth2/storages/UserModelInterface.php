<?php

namespace star\oauth2\storages;

interface UserModelInterface
{
    public function getUserByAccount($loginId, $password);
}
