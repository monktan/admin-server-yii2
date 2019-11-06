<?php
/**
 * Description
 *
 *
 * Datetime: 2019-08-04 13:44
 */

namespace star\oauth2\storages\mysql;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class ClientEntity implements ClientEntityInterface
{
    use EntityTrait, ClientTrait;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function setIsConfidential($isConfidential)
    {
        $this->isConfidential = $isConfidential;
    }
}
