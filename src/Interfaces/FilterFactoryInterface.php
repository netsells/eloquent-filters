<?php

namespace Netsells\EloquentFilters\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface FilterFactoryInterface
{
    public function getFilter(Builder $query, $field): FilterInterface;
}