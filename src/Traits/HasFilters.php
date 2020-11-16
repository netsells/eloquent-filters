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
        $modelClass = self::class;

        if (array_key_exists($modelClass, config('eloquent-filters'))) {
            app(EloquentFilterInterface::class)
                ->applyFilters($query, $searchValues);

            return $query;
        }

        throw new ModelFiltersNotFoundException(
            "No model filters are registered for {$modelClass} in the eloquent-filters config file"
        );
    }
}
