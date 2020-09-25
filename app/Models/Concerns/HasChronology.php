<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasChronology
{
    private ?self $chronological_next;
    private ?self $chronological_previous;

    public function getNextAttribute(): ?self
    {
        return ($this->chronological_next ??= $this->moreRecent()->first());
    }

    public function getPreviousAttribute(): ?self
    {
        return ($this->chronological_previous ??= $this->earlier()->first());
    }

    public function moreRecent(): Builder
    {
        return self::where('created_at', '>', $this->created_at)->orderBy('created_at', 'ASC');
    }

    public function earlier(): Builder
    {
        return self::where('created_at', '<', $this->created_at)->orderBy('created_at', 'DESC');
    }
}
