<?php

namespace App\Models;

use App\Concerns\Bookmarkable;
use App\Concerns\Likeable;
use App\Concerns\Notifiable;
use App\Contracts\Bookmarkable as BookmarkableInterface;
use App\Contracts\Likeable as LikeableInterface;
use App\Contracts\Notifiable as NotifiableInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model implements BookmarkableInterface, LikeableInterface, NotifiableInterface
{
    use Likeable, Bookmarkable, Notifiable;

    //a - like, b = views , d = comments
    const ODDS = ['a' => 40, 'b' => 60, 'c' => 1, 'd' => 40];

    protected $guarded = ['id'];
    protected $appends = [
        'type',
        'is_like',
        'is_bookmarked',
        'date',
        'unique_views_count',
        'comments_count',
        'is_notify',
        'url',
        'vk_url',
        'is_reposted',
        'repost_count',
        'short_title'
    ];
    protected $withCount = ['likes', 'bookmarks'];

    public static function boot()
    {
        parent::boot();

        self::created(function (Post $model) {
            if ($model->slug == null) {
                $model->update(['slug' => $model->id]);
            } else {
                $model->update(['slug' => $model->id . '-' . $model->slug]);
            }
        });

        self::updating(function ($model) {
            if ($model->slug == null) {
                $model->slug = $model->id;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeAttribute()
    {
        return 'post';
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->locale('ru')->calendar();
    }

    public function getIsLikeAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->hasLiked($this);
    }

    public function getIsBookmarkedAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->hasBookmark($this);
    }

    public function views(): MorphMany
    {
        return $this->morphMany(Views::class, 'viewable');
    }

    public function getUniqueViewsCountAttribute()
    {
        return $this->views()->groupBy('ip')->count();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function getCommentsCountAttribute()
    {
        return $this->morphMany(Comment::class, 'commentable')->count();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->follower_notifications()->where('notifiable_type', self::class)->where('notifiable_id', $this->id)->exists();
    }

    public function getVkUrlAttribute()
    {
        return  url(($this->category ? $this->category->slug : 'u/' . $this->user->slug) . '/' . $this->slug . '&title=' . ($this->title ? $this->title : 'Запись пользователя ' . $this->user->name));
    }

    public function getUrlAttribute()
    {
        return  url(($this->category ? $this->category->slug : 'u/' . $this->user->slug) . '/' . $this->slug);
    }

    public function parent()
    {
        return $this->hasOne(self::class,'id', 'parent_id');
    }

    public function getIsRepostedAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->posts()->where('parent_id', $this->id)->exists();
    }

    public function getRepostCountAttribute()
    {
        return self::query()->where('parent_id', $this->id)->count();
    }

    public function getShortTitleAttribute()
    {
        if (iconv_strlen($this->title) <= 26) return $this->title;

        return substr($this->title, 0, strrpos(substr($this->title, 0, 52), ' ')) . '...';
    }

    public function scopePublic($q)
    {
        return $q->where('is_publish', true);
    }

    public function scopeDraft($q)
    {
        return $q->where('is_publish', false);
    }

    public function scopeWhereSlug(Builder $query, $slug)
    {
        return $query->where('id', (int)stristr($slug, '-', true));
    }
}
