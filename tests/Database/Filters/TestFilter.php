<?php

namespace Netsells\EloquentFilters\Tests\Database\Filters;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;

final class TestFilter implements FilterInterface
{
    public function applyFilter(Builder $query, $value): void
    {
    }
}
