<?php


namespace monktan\modules\auth;

use League\OAuth2\Server\AuthorizationValidators\BearerTokenValidator;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\ResourceServer;
use monktan\common\models\AccessTokenModelInterface;
use monktan\common\models\RefreshTokenModelInterface;
use monktan\common\models\UserModelInterface;
use monktan\common\services\BaseService;
use monktan\common\services\TokenAuthServiceInterface;
use monktan\libraries\oauth2\repositories\AccessToken;
use monktan\libraries\oauth2\Oauth2;
use monktan\libraries\oauth2\Request as Psr7Request;
use monktan\libraries\oauth2\Response as Psr7Response;

class AuthService extends BaseService implements TokenAuthServiceInterface
{
    private $accessTokenModel;

    private $refreshTokenModel;

    private $accessTokenRepository;

    public function __construct(
        UserModelInterface $userModel,
        AccessTokenModelInterface $accessTokenModel,
        RefreshTokenModelInterface $refreshTokenModel,
        AccessToken $accessToken
    ) {
        $this->model = $userModel;
        $this->accessTokenModel = $accessTokenModel;
        $this->refreshTokenModel = $refreshTokenModel;
        $this->accessTokenRepository = $accessToken;
    }

    public function login($username, $password)
    {
        $params['username'] = $username;
        $params['password'] = $password;

        $result = $this->createNewAccessToken($params);
        $this->clearExpiredTokens();

        return $result;
    }

    public function createNewAccessToken($params)
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

    private function clearExpiredTokens()
    {
        $time = date('Y-m-d H:i:s', time() - 60);
        $where = ['<', 'expire_time', $time];

        $accessTokenIds = mt_model($this->refreshTokenModel)
            ->newQuery()
            ->where($where)
            ->limit(100)
            ->column('access_token_id');
        if (! empty($accessTokenIds)) {
            mt_model($this->accessTokenModel)->delete(['in', 'token_id', $accessTokenIds]);
            mt_model($this->refreshTokenModel)->delete(['in', 'access_token_id', $accessTokenIds]);
        }
    }

    public function logout()
    {
        $this->revokeAccessToken();
    }

    public function refreshToken()
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

    public function revokeAccessToken()
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
        $route = mt_route();
        if (in_array($route, mt_config('ignore_route_rules'))) {
            return true;
        }
        $validator = new BearerTokenValidator($this->accessTokenRepository);
        $publicKey = new CryptKey(
            mt_config('oauth2.public_key'),
            mt_config('oauth2.passphrase'),
            false
        );
        $resource = new ResourceServer(
            $this->accessTokenRepository,
            $publicKey,
            $validator
        );
        $psr7Request = Psr7Request::fromGlobals();
        try {
            $request = $resource->validateAuthenticatedRequest($psr7Request);
        } catch (\Exception $e) {
            mt_throw_info('请重新登录', RESPONSE_CODE_UNAUTHORIZED);
        }

        $sessionData = $request->getAttributes();
        $userInfo = mt_model($this->model)->newQuery()->where(['user_id'=>$sessionData['oauth_user_id']])->one();
        $sessionData = array_merge($userInfo, $sessionData);
        $_SERVER['session_data'] = $sessionData;
    }
}
