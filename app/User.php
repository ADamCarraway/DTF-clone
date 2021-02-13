<?php

namespace App;

use App\Events\CancelSubscriptionEvent;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
use Hypefactors\Laravel\Follow\Traits\CanFollow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, CanFollowContract, CanBeFollowedContract//, MustVerifyEmail
{
    use Notifiable, Concerns\Likes, Concerns\Bookmarks, CanFollow, CanBeFollowed;

    const AVATAR_PATH = 'user/avatars/full/';
    const COMMENT_FILE_PATH = 'comment/files/full/';
    const POST_FILE_PATH = 'post/files/full/';

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
        'oauthProviders',
    ];

    protected $appends = [
        'have_password',
        'icon',
        'title',
        'url',
        'is_ignore',
        'is_notify',
        'is_favorite',
        'type',
        'slug'
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

    protected function getSlugAttribute()
    {
        return $this->id . '-' . Str::slug($this->name);
    }


    public function userNotify()
    {
        return $this->morphedByMany(User::class, 'subs_notify');
    }

    public function categoryNotify()
    {
        return $this->morphedByMany(Category::class, 'subs_notify');
    }

    public function userIgnore()
    {
        return $this->morphedByMany(User::class, 'ignoreable');
    }

    public function categoryIgnore()
    {
        return $this->morphedByMany(Category::class, 'ignoreable');
    }


    public function getTypeAttribute()
    {
        return 'user';
    }

    public function getIconAttribute()
    {
        return $this->avatar;
    }

    public function getTitleAttribute()
    {
        return $this->name;
    }

    public function getUrlAttribute()
    {
        return 'u/' . $this->slug;
    }

    public function getIsIgnoreAttribute()
    {
        if (!auth()->check() || auth()->id() === $this->id) return false;

        return auth()->user()->userIgnore()->where('ignoreable_id', $this->id)->exists();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->userNotify()->where('subs_notify_id', $this->id)->exists();
    }

    public function scopeWhereSlug(Builder $query, $slug)
    {
        return $query->where('id', (int)stristr($slug, '-', true));
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getIsFavoriteAttribute()
    {
        if (!auth()->check() ||$this->id === auth()->user()->id) return false;

        $record = $this->findFollower(auth()->user());

        return $record ? (bool)$record->favorite : false;
    }
}
