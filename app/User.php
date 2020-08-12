<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facade;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject//, MustVerifyEmail
{
    use Notifiable;

    const AVATAR_PATH = 'user/avatars/full/';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'qr'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'oauthProviders'
    ];

    protected $appends = [
        'have_password'
    ];

    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getHavePasswordAttribute()
    {
        return $this->password === null;
    }
}
