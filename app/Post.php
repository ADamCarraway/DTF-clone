<?php

namespace App;

use App\Contracts\Bookmarkable;
use App\Contracts\Likeable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Likeable, Bookmarkable
{
    use Concerns\Likeable, Concerns\Bookmarkable;

    protected $guarded = ['id'];
    protected $appends = ['type', 'is_like', 'is_bookmarked', 'date'];
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
}
