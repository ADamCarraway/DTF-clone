<?php

namespace App\Models;

use App\Concerns\Ignorable;
use App\Concerns\Notifiable;
use App\Contracts\Ignorable as IgnorableInterface;
use App\Contracts\Notifiable as NotifiableInterface;
use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model implements CanBeFollowedContract, IgnorableInterface, NotifiableInterface
{
    use CanBeFollowed, Ignorable, Notifiable;

    //a - postsLikes, b
    const ODDS = ['a' => 0.02, 'c' => 1];

    protected $appends = ['is_notify', 'type', 'url', 'is_ignore', 'is_favorite', 'is_follow'];

    public function getTypeAttribute()
    {
        return 'category';
    }

    public function subscribers()
    {
        return $this->morphToMany(User::class, 'subscription');
    }

    public function getUrlAttribute()
    {
        return $this->slug;
    }

    public function getIsIgnoreAttribute()
    {
        if (!auth()->check() || $this->id === auth()->user()->id) return false;

        return auth()->user()->ignored()->where('ignorable_type', self::class)->where('ignorable_id', $this->id)->exists();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check() || $this->id === auth()->user()->id) return false;

        return auth()->user()->notifications()->where('notifiable_type', Category::class)->where('notifiable_id', $this->id)->exists();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getIsFavoriteAttribute()
    {
        if (!auth()->check() || $this->id === auth()->user()->id) return false;

        $follower = $this->findFollower(auth()->user());

        return $follower && !$follower->trashed() ? $follower->favorite : false;
    }

    public function getIsFollowAttribute()
    {
        if (!auth()->check() || $this->id === auth()->user()->id) return false;

        return $this->hasFollower(auth()->user());
    }
}
