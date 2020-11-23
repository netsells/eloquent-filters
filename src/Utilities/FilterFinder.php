<?php

namespace Netsells\EloquentFilters\Utilities;

use Netsells\AttributeFinder\AttributeFinder;
use ReflectionClass;
use Netsells\EloquentFilters\Attributes\FiltersModel;
use Netsells\EloquentFilters\Interfaces\FilterFinderInterface;

final class FilterFinder implements FilterFinderInterface
{
    private array $mappedFilters;
    private AttributeFinder $finder;

    public function __construct()
    {
        $this->finder = new AttributeFinder(config('eloquent-filters.directory', base_path('app')));
        $this->mappedFilters = config('eloquent-filters.filters', []);
    }

    public function getFilterList(): array
    {
        $this->mapFilters();

        return $this->mappedFilters;
    }

    private function mapFilters(): void
    {
        $filters = $this->finder->getClassesWithAttribute(FiltersModel::class);

        foreach ($filters as $filter) {
            $attribute  = $filter->getAttributes(FiltersModel::class)[0]->newInstance();

            if (!array_key_exists($attribute->model, $this->mappedFilters)) {
                $this->mappedFilters[$attribute->model] = [];
            }

            $this->mappedFilters[$attribute->model][$attribute->queryParameter] = $filter;
        }
    }
}
