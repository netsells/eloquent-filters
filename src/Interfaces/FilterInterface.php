<?php

namespace Netsells\EloquentFilters\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function applyFilter(Builder $query, $value): void;
}