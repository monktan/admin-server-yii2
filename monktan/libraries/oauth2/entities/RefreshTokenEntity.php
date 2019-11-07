<?php


namespace monktan\libraries\oauth2\entities;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

class RefreshTokenEntity implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;

    /**
     * @var CryptKey
     */
    private $privateKey;

    /**
     * Set the private key used to encrypt this access token.
     * @param CryptKey $privateKey
     */
    public function setPrivateKey(CryptKey $privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * Generate a JWT from the access token
     *
     * @param CryptKey $privateKey
     *
     * @return Token
     */
    private function convertToJWT(CryptKey $privateKey)
    {
        $accessToken = $this->getAccessToken();
        return (new Builder())
            ->setAudience($accessToken->getClient()->getIdentifier())
            ->setId($this->getIdentifier())
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration($this->getExpiryDateTime()->getTimestamp())
            ->set('access_token_id', $accessToken->getIdentifier())
            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
            ->getToken();
    }

    /**
     * Generate a string representation from the access token
     */
    public function __toString()
    {
        return (string) $this->convertToJWT($this->privateKey);
    }
}
