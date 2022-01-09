<?php

namespace App\Models;

use App\Concerns\Bookmarkable;
use App\Concerns\Likeable;
use App\Contracts\Bookmarkable as BookmarkableInterface;
use App\Contracts\Likeable as LikeableInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements LikeableInterface, BookmarkableInterface
{
    use Likeable, Bookmarkable;

    protected $guarded = [];
    protected $appends = ['type', 'date', 'date_minute', 'is_like', 'is_bookmarked'];
    protected $with = ['user', 'replies'];
    protected $withCount = ['likes', 'bookmarks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'commentable_id');
    }

    public function getTypeAttribute()
    {
        return 'comment';
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->created_at)->locale('ru')->calendar();
    }

    public function getDateMinuteAttribute(): string
    {
        return Carbon::parse($this->created_at)->locale('ru')->diffForHumans(['short' => true]);
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
