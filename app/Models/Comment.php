<?php

namespace App\Models;

use App\Contracts\Bookmarkable;
use App\Contracts\Likeable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements Likeable, Bookmarkable
{
    use Concerns\Likeable, Concerns\Bookmarkable;

    //a - like, b = bookmarks, d = replies
    const ODDS = ['a' => 80, 'b' => 50, 'c' => 10, 'd' => 30];

    protected $guarded = [];
    protected $appends = ['type', 'date', 'is_like', 'is_bookmarked'];
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
