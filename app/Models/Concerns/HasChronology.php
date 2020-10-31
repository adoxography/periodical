<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasChronology
{
    /** @var ?Model */
    private $chronological_next;

    /** @var ?Model */
    private $chronological_previous;

    /** @return ?Model */
    public function getNextAttribute()
    {
        return ($this->chronological_next ??= $this->moreRecent()->first());
    }

    /** @return ?Model */
    public function getPreviousAttribute()
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
