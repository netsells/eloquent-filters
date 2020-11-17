<?php

namespace Netsells\EloquentFilters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\EloquentFilterInterface;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;

trait HasFilters
{
    /**
     * @throws ModelFiltersNotFoundException
     */
    public function scopeApplyFilters(Builder $query, iterable $searchValues): Builder
    {
        app(EloquentFilterInterface::class)->applyFilters($query, $searchValues);

        return $query;
    }
}
