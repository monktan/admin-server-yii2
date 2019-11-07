<?php
/**
 * Description
 *
 *
 * Datetime: 2019-08-04 13:37
 */

namespace monktan\libraries\oauth2;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use monktan\libraries\oauth2\entities\ScopeEntity;

class Scope implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier)
    {
        $scopeEntity = new ScopeEntity();
        $scopeEntity->setIdentifier($identifier);

        return $scopeEntity;
    }

    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        return [];
    }
}