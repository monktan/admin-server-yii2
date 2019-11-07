<?php

namespace monktan\libraries\oauth2\storages;

interface ClientModelInterface
{
    public function getClient($clientIdentifier);
}
