<?php

namespace App;

use App\Contracts\Bookmarkable;
use App\Contracts\Likeable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements Likeable, Bookmarkable
{
    use Concerns\Likeable, Concerns\Bookmarkable;

    //a - like, b = bookmarks
    const ODDS = ['a' => 40, 'b' => 20, 'c' => 10];

    protected $guarded = [];
    protected $appends = ['type', 'date', 'is_like', 'is_bookmarked', 'weight'];
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

    public function getWeightAttribute()
    {
        return self::ODDS['c']+self::ODDS['a']*Log(1+$this->likes->count())+self::ODDS['b']*Log(1+$this->bookmarks->count());
    }
}
