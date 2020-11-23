<?php

namespace Netsells\EloquentFilters\Factories;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;
use Netsells\EloquentFilters\Interfaces\FilterFactoryInterface;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;
use Netsells\EloquentFilters\Interfaces\FilterFinderInterface;

final class FilterFactory implements FilterFactoryInterface
{
    private array $filters;

    public function __construct(FilterFinderInterface $finder)
    {
        $this->filters = $finder->getFilterList();
    }

    /**
     * @throws ModelFiltersNotFoundException
     */
    public function getFilter(Builder $query, string $field): FilterInterface
    {
        $modelClass = get_class($query->getModel());

        $this->validateFilter($modelClass, $field);

        return app($this->filters[$modelClass][$field]);
    }

    private function validateFilter(string $modelClass, string $field): void
    {
        if (!isset($this->filters[$modelClass][$field])) {
            throw new ModelFiltersNotFoundException(
                "No filter map is present for a {$field} field on the {$modelClass} model in eloquent-filters.php config"
            );
        }

        $filter = $this->filters[$modelClass][$field];

        $interface = FilterInterface::class;

        if (!isset(class_implements($filter)[$interface])) {
            throw new ModelFiltersNotFoundException(
                "The filter registered for the {$field} field on the {$modelClass} model must implement {$interface}"
            );
        }
    }
}
