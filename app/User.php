<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'have_password',
        'category_notify',
        'user_notify',
        'categories_ignore',
        'users_ignore',
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

    public function users()
    {
        return $this->morphedByMany(User::class, 'subscription');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'subscription');
    }

    public function usersNotify()
    {
        return $this->morphedByMany(User::class, 'subs_notify');
    }

    public function categoriesNotify()
    {
        return $this->morphedByMany(Category::class, 'subs_notify');
    }

    public function usersIgnore()
    {
        return $this->morphedByMany(User::class, 'ignoreable');
    }

    public function categoriesIgnore()
    {
        return $this->morphedByMany(Category::class, 'ignoreable');
    }

    public function getCategoryNotifyAttribute()
    {
        return $this->categoriesNotify()->pluck('subs_notify_id');
    }

    public function getUserNotifyAttribute()
    {
        return $this->usersNotify()->pluck('subs_notify_id');
    }

    public function getCategoriesIgnoreAttribute()
    {
        return $this->categoriesIgnore()->pluck('ignoreable_id');
    }

    public function getUsersIgnoreAttribute()
    {
        return $this->usersIgnore()->pluck('ignoreable_id');
    }
}
