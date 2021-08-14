<?php

namespace App\Concerns;

use App\Models\Bookmark;
use App\Contracts\Bookmarkable;

trait Bookmarks
{
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function addBookmark(Bookmarkable $likeable): self
    {
        if ($this->hasBookmark($likeable)) {
            return $this;
        }

        (new Bookmark)
            ->user()->associate($this)
            ->bookmarkable()->associate($likeable)
            ->save();

        return $this;
    }

    public function removeBookmark(Bookmarkable $likeable): self
    {
        if (! $this->hasBookmark($likeable)) {
            return $this;
        }

        $likeable->bookmarks()->whereHas('user', fn($q) => $q->whereId($this->id))->delete();

        return $this;
    }

    public function hasBookmark(Bookmarkable $bookmarkable): bool
    {
        if (! $bookmarkable->exists) {
            return false;
        }

        return $bookmarkable->bookmarks()->whereHas('user', fn($q) =>  $q->whereId($this->id))->exists();
    }
}
