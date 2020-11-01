<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Bookmarkable
{
    public function bookmarks(): MorphMany;
}
