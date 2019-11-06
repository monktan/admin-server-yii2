<?php

namespace star\oauth2\storages;

interface ClientModelInterface
{
    public function getClient($clientIdentifier);
}
