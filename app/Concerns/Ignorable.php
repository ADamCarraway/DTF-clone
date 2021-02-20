<?php

namespace App\Concerns;

use App\Models\Ignore;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Ignorable
{
    public function ignorable(): MorphMany
    {
        return $this->morphMany(Ignore::class, 'ignorable');
    }
}
