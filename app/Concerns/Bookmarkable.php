<?php

namespace App\Concerns;

use App\Bookmark;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Bookmarkable
{
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
