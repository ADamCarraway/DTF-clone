<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Likeable
{
    public function likes(): MorphMany;
}
