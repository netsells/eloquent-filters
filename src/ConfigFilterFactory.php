<?php

namespace Netsells\EloquentFilters;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;
use Netsells\EloquentFilters\Interfaces\FilterFactoryInterface;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;

final class ConfigFilterFactory implements FilterFactoryInterface
{
    private array $config;

    public function __construct()
    {
        $this->config = config('eloquent-filters.filters');
    }

    /**
     * @throws ModelFiltersNotFoundException
     */
    public function getFilter(Builder $query, string $field): FilterInterface
    {
        $modelClass = get_class($query->getModel());

        if (isset($this->config[$modelClass][$field])) {
            return app($this->config[$modelClass][$field]);
        }

        throw new ModelFiltersNotFoundException(
            "No filter map is present for a {$field} field on the {$modelClass} model in eloquent-filters.php config"
        );
    }
}
