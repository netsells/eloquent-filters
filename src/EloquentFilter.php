<?php

namespace Netsells\EloquentFilters;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterFactoryInterface;
use Netsells\EloquentFilters\Interfaces\EloquentFilterInterface;

final class EloquentFilter implements EloquentFilterInterface
{
    private FilterFactoryInterface $factory;

    public function __construct(FilterFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @throws ModelFiltersNotFoundException
     */
    public function applyFilters(Builder $query, iterable $searchFields): void
    {
        foreach ($searchFields as $field => $value) {
            $this->factory
                ->getFilter($query, $field)
                ->applyFilter($query, $value);
        }
    }
}
