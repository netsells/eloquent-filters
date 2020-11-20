<?php

namespace Netsells\EloquentFilters\Factories;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;
use Netsells\EloquentFilters\Interfaces\FilterFactoryInterface;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;
use Netsells\EloquentFilters\Utilities\FilterFinder;

final class AttributeFilterFactory implements FilterFactoryInterface
{
    private array $filters;

    public function __construct(FilterFinder $finder)
    {
        $this->filters = $finder->getFilterList();
    }

    /**
     * @throws ModelFiltersNotFoundException
     */
    public function getFilter(Builder $query, string $field): FilterInterface
    {
        $modelClass = get_class($query->getModel());

        $this->validateConfigItem($modelClass, $field);

        return app($this->config[$modelClass][$field]);
    }

    private function validateConfigItem(string $modelClass, string $field): void
    {
        if (!isset($this->config[$modelClass][$field])) {
            throw new ModelFiltersNotFoundException(
                "No filter map is present for a {$field} field on the {$modelClass} model in eloquent-filters.php config"
            );
        }

        $filter = $this->config[$modelClass][$field];

        $interface = FilterInterface::class;

        if (!isset(class_implements($filter)[$interface])) {
            throw new ModelFiltersNotFoundException(
                "The filter registered for the {$field} field on the {$modelClass} model must implement {$interface}"
            );
        }
    }
}
