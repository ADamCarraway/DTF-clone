<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Ignorable
{
    public function ignorable(): MorphMany;
}
