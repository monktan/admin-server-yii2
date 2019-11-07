<?php


namespace monktan\libraries\oauth2\storages;

interface RefreshTokenModelInterface
{
    public function saveToken($data);

    public function revokeToken($tokenId);

    public function isTokenRevoked($tokenId);

    public function getRefreshTokenInfoByAccessTokenId($accessTokenId);
}
