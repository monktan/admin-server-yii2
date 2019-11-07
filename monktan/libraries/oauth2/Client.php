<?php
namespace monktan\libraries\oauth2;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use monktan\libraries\oauth2\storages\ClientModelInterface;
use monktan\libraries\oauth2\entities\ClientEntity;

class Client implements ClientRepositoryInterface
{
    private $clientModel;

    public function __construct(ClientModelInterface $clientModel)
    {
        $this->clientModel = $clientModel;
    }

    public function getClientEntity($clientIdentifier)
    {
        $client = $this->getClient($clientIdentifier);

        $clientEntity = new ClientEntity();
        $clientEntity->setIdentifier($clientIdentifier);
        $clientEntity->setName($client['client_name']);
        $clientEntity->setRedirectUri('');
        $clientEntity->setIsConfidential(true);

        return $clientEntity;
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $client = $this->getClient($clientIdentifier);
        if (! password_verify($clientSecret, $client['client_secret'])) {
            return false;
        }

        $grantTypes = explode(',', $client['grant_types']);
        if (! in_array($grantType, $grantTypes) && $grantType != 'refresh_token') {
            return false;
        }

        return true;
    }

    private function getClient($clientIdentifier)
    {
        return $this->clientModel->getClient($clientIdentifier);
    }
}