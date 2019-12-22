<?php


namespace monktan\common\services;

interface TokenAuthServiceInterface
{
    public function createNewAccessToken($params);

    public function revokeAccessToken();

    public function auth();

    public function refreshToken($params);
}
