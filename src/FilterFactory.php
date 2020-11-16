<?php

namespace Netsells\EloquentFilters;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;
use Netsells\EloquentFilters\Interfaces\FilterFactoryInterface;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;

final class FilterFactory implements FilterFactoryInterface
{
    private array $config;

    public function __construct()
    {
        $this->config = config('eloquent-filters');
    }

    /**
     * @throws ModelFiltersNotFoundException
     */
    public function getFilter(Builder $query, $field): FilterInterface
    {
        $modelName = get_class($query->getModel());
        $modelFilters = $this->config[$modelName];

        if (array_key_exists($field, $modelFilters)) {
            return app($modelFilters[$field]);
        }

        throw new ModelFiltersNotFoundException(
            "No filter map is present for a {$field} field on the {$modelName} model in eloquent-filters.php config"
        );
    }
}
