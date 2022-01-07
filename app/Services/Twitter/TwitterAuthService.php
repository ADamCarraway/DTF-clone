<?php

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use stdClass;

class TwitterAuthService
{
    private TwitterOAuth $connection;
    private array $requestToken;
    public stdClass $user;
    public string $name;
    /**
     * @var mixed
     */
    public $token;
    /**
     * @var null
     */
    public $refreshToken;
    public string $avatar;
    /**
     * @var mixed
     */
    private $secretToken;

    public function __construct()
    {
        $this->connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'));
        $this->requestToken = $this->connection->oauth('oauth/request_token', array('oauth_callback' => config('services.twitter.redirect')));
        $this->secretToken = $this->requestToken['oauth_token_secret'];
    }

    public function getTargetUrl(): string
    {
        return $this->connection->url('oauth/authorize', array('oauth_token' => $this->requestToken['oauth_token']));
    }

    public function setUser(Request $request): TwitterAuthService
    {
        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $request->oauth_token, $this->secretToken);
        $access_token = $connection->oauth('oauth/access_token', ['oauth_verifier' => $request->oauth_verifier]);

        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
        $this->user = $connection->get('account/verify_credentials', ['include_email' => 'true']);

        $this->token = $access_token['oauth_token'];
        $this->name = $this->user->name;
        $this->avatar = $this->user->profile_image_url_https;

        return $this;
    }

    public function getUser(): stdClass
    {
        return $this->user;
    }

    public function getId()
    {
        return $this->user->id;
    }

    public function getEmail()
    {
        return $this->user->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }
}