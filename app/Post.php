<?php

namespace App;

use App\Contracts\Bookmarkable;
use App\Contracts\Likeable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model implements Likeable, Bookmarkable
{
    use Concerns\Likeable, Concerns\Bookmarkable;

    //a - like, b = views , d = comments
    const ODDS = ['a' => 40, 'b' => 60, 'c' => 10, 'd' => 40];

    protected $guarded = ['id'];
    protected $appends = ['type', 'is_like', 'is_bookmarked', 'date', 'unique_views_count', 'comments_count'];
    protected $withCount = ['likes', 'bookmarks'];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if ($model->slug == null) {
                $model->update(['slug' => $model->id]);
            }else{
                $model->update(['slug' => $model->id.'-'.$model->slug]);
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

    public function getWeightAttribute()
    {
        return round(self::ODDS['c']+self::ODDS['a']*Log(1+$this->likes->count())+self::ODDS['b']*Log(1+$this->views->count())+self::ODDS['d']*Log(1+$this->comments->count()), 2);
    }
}
