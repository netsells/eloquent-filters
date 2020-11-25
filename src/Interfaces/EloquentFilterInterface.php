<?php

namespace Netsells\EloquentFilters\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface EloquentFilterInterface
{
    public function applyFilters(Builder $query, iterable $searchParams): void;
}
