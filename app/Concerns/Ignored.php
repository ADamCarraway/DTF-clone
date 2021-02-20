<?php

namespace App\Concerns;

use App\Contracts\Ignorable;
use App\Models\Ignore;

trait Ignored
{
    public function ignored()
    {
        return $this->hasMany(Ignore::class);
    }

    public function startIgnore(Ignorable $ignorable): self
    {
        if ($this->ignores($ignorable)) {
            return $this;
        }

        (new Ignore())
            ->user()->associate($this)
            ->ignorable()->associate($ignorable)
            ->save();

        return $this;
    }

    public function stopIgnore(Ignorable $ignorable): self
    {
        if (! $this->ignores($ignorable)) {
            return $this;
        }

        $ignorable->ignorable()->whereHas('user', fn($q) => $q->whereId($this->id))->delete();

        return $this;
    }

    public function ignores(Ignorable $ignorable): bool
    {
        if (! $ignorable->exists) {
            return false;
        }

        return $ignorable->ignorable()->whereHas('user', fn($q) =>  $q->whereId($this->id))->exists();
    }
}
