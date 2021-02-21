<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingHistory extends Model
{
    protected $guarded = [''];

    public function hasRatingHistory()
    {
        return $this->morphTo();
    }

    private function user()
    {
        return $this->belongsTo(User::class);
    }
}
