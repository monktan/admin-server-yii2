<?php


namespace monktan\modules\auth;

use League\OAuth2\Server\AuthorizationValidators\BearerTokenValidator;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\ResourceServer;
use monktan\common\models\UserModelInterface;
use monktan\common\services\BaseService;
use monktan\libraries\oauth2\AccessToken;
use monktan\libraries\oauth2\Oauth2;
use monktan\libraries\oauth2\Request as Psr7Request;
use monktan\libraries\oauth2\Response as Psr7Response;

class AuthService extends BaseService
{
    public function __construct(UserModelInterface $userModel)
    {
        $this->model = $userModel;
    }

    public function login($params)
    {
        return $this->createNewAccessToken($params);
    }

    public function logout()
    {
        $this->revokeAccessToken();
    }

    private function createNewAccessToken($params)
    {
        $_POST = array_merge($params, $_POST);
        $_POST['client_id'] = mt_config('oauth2.self_client_id');
        $_POST['client_secret'] = mt_config('oauth2.self_client_secret');
        $psr7Request = Psr7Request::fromGlobals();
        $psr7Response = new Psr7Response();
        $instance = Oauth2::getInstance('Password')->getInstance();
        $response = $instance->respondToAccessTokenRequest($psr7Request, $psr7Response);
        $result = (string)$response->getBody();
        $result = json_decode($result, true);

        return $result;
    }

    public function refreshAccessToken()
    {
        $_POST['client_id'] = mt_config('oauth2.self_client_id');
        $_POST['client_secret'] =mt_config('oauth2.self_client_secret');
        $psr7Request = Psr7Request::fromGlobals();
        $psr7Response = new Psr7Response();
        $instance = Oauth2::getInstance('RefreshToken')->getInstance();
        $response = $instance->respondToAccessTokenRequest($psr7Request, $psr7Response);
        $result = (string)$response->getBody();
        $result = json_decode($result, true);

        return $result;
    }

    private function revokeAccessToken()
    {
        $accessTokenId = get_session_info('oauth_access_token_id');
        $instance = Oauth2::getInstance('Password');
        $instance->getAccessToken()->revokeAccessToken($accessTokenId);
        $refreshToken = $instance->getRefreshToken();
        $refreshTokenInfo = $refreshToken->getRefreshTokenInfoByAccessTokenId($accessTokenId);
        $refreshToken->revokeRefreshToken($refreshTokenInfo['token_id']);
    }

    public function auth()
    {
        $api = get_request_api();
        if (in_array($api, mt_config('ignore_route_rules'))) {
            return true;
        }
        $accessToken = new AccessToken();
        $validator = new BearerTokenValidator($accessToken);
        $publicKey = new CryptKey(
            mt_config('oauth2.public_key'),
            mt_config('oauth2.passphrase'),
            false
        );
        $resource = new ResourceServer(
            $accessToken,
            $publicKey,
            $validator
        );
        $psr7Request = Psr7Request::fromGlobals();
        $request = $resource->validateAuthenticatedRequest($psr7Request);

        $sessionInfo = $request->getAttributes();
        $userInfo = $this->model->newQuery()->where(['user_id'=>$sessionInfo['oauth_user_id']])->one();
        $sessionInfo = array_merge($userInfo, $sessionInfo);
        $_SERVER['session_info'] = $sessionInfo;
    }
}
