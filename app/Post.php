<?php

namespace App;

use App\Contracts\Bookmarkable;
use App\Contracts\Likeable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Likeable, Bookmarkable
{
    use Concerns\Likeable, Concerns\Bookmarkable;

    protected $guarded = ['id'];
    protected $appends = ['type', 'is_like', 'is_bookmarked'];
    protected $withCount = ['likes', 'bookmarks'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if ($model->slug == null) {
                $model->update(['slug' => $model->id]);
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
        return 'Post';
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
}
