<?php

namespace App\Http\Controllers\Auth;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use App\Models\User;
use App\Services\Twitter\TwitterAuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        config([
            'services.github.redirect'   => route('oauth.callback', 'github'),
            'services.twitch.redirect'   => route('oauth.callback', 'twitch'),
            'services.facebook.redirect' => route('oauth.callback', 'facebook'),
            'services.google.redirect'   => route('oauth.callback', 'google'),
            'services.twitter.redirect'  => route('oauth.callback', 'twitter'),
        ]);
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return array
     */
    public function redirectToProvider($provider)
    {
        if ($provider == 'twitter') {
            $url = (new TwitterAuthService())->getTargetUrl();
        } else {
            $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        }

        return [
            'url' => $url,
        ];
    }

    /**
     * Obtain the user information from the provider.
     *
     * @param $provider
     * @return Factory|View
     */
    public function handleProviderCallback($provider)
    {
        if (auth()->check()) {
            return $this->attach($provider);
        }

        if ($provider === 'twitter') {
            $user = (new TwitterAuthService())->setUser(request());
        } else {
            $user = Socialite::driver($provider)->stateless()->user();
        }

        $user->name = $user->name == null ? $user->nickname : $user->name;

        $user = $this->findOrCreateUser($provider, $user);

        $this->guard()->setToken(
            $token = $this->guard()->login($user, true)
        );

        return view('oauth/callback', [
            'token'      => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ]);
    }

    /**
     * @param string $provider
     * @param $user
     * @return User|false
     */
    protected function findOrCreateUser($provider, $user)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token'  => $user->token,
                'refresh_token' => $user->refreshToken,
            ]);

            return $oauthProvider->user;
        }

        if ($ex_user = User::where('email', $user->getEmail())->first()) {
            $ex_user->oauthProviders()->create([
                'provider'         => $provider,
                'provider_user_id' => $user->getId(),
                'access_token'     => $user->token,
                'refresh_token'    => $user->refreshToken,
            ]);

            return $ex_user;
        }

        return $this->createUser($provider, $user);
    }

    /**
     * @param string $provider
     * @param \Laravel\Socialite\Contracts\User $sUser
     * @return User
     */
    protected function createUser($provider, $sUser)
    {
        $user = User::create([
            'name'              => $sUser->getName(),
            'email'             => $sUser->getEmail(),
            'email_verified_at' => now(),
            'avatar'            => $sUser->getAvatar()
        ]);

        $user->oauthProviders()->create([
            'provider'         => $provider,
            'provider_user_id' => $sUser->getId(),
            'access_token'     => $sUser->token,
            'refresh_token'    => $sUser->refreshToken,
        ]);

        event(new Registered($user));

        return $user;
    }

    public function detach($driver)
    {
        abort_if(auth()->user()->oauthProviders()->count() === 1, 400, 'Нельзя отсоединить последний подключенный аккаунт');

        return auth()->user()->oauthProviders()->where('provider', $driver)->firstOrFail()->delete();
    }

    public function attach($driver)
    {
        if ($driver === 'twitter') {
            $user = (new TwitterAuthService())->setUser(request());
        } else {
            $user = Socialite::driver($driver)->stateless()->user();
        }

        $user->name = $user->name == null ? $user->nickname : $user->name;

        $ex_u = OAuthProvider::query()->where('provider', $driver)->where('provider_user_id', $user->getId())->first();

        if ($ex_u && $ex_u->user_id != auth()->id()) {
            return view('oauth.socialAttach', [
                'status'   => 'false',
                'message'  => 'Этот аккаунт нельзя прикрепить, потому что он уже прикреплён к другому пользователю',
                'provider' => $driver,
            ]);
        }

        if ($ex_u && $ex_u->user_id == auth()->id()) {
            return view('oauth.socialAttach', [
                'status'   => 'false',
                'message'  => 'Этот аакаунт уже привязан',
                'provider' => $driver,
            ]);
        }

        auth()->user()->oauthProviders()->create([
            'provider'         => $driver,
            'provider_user_id' => $user->getId(),
            'access_token'     => $user->token,
            'refresh_token'    => $user->refreshToken ?? null,
        ]);

        return view('oauth.socialAttach', [
            'status'   => true,
            'message'  => '',
            'provider' => $driver,
        ]);
    }
}
