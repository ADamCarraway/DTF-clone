<?php

namespace App\Concerns;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Bookmarkable
{
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
