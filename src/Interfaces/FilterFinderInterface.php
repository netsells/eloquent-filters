<?php

namespace Netsells\EloquentFilters\Interfaces;

interface FilterFinderInterface
{
    public function getFilterList(): array;
}