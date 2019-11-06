<?php


namespace star\oauth2\storages;

interface AccessTokenModelInterface
{
    public function saveToken($data);

    public function revokeToken($tokenId);

    public function isTokenRevoked($tokenId);
}
