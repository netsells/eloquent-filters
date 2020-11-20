<?php

namespace Netsells\EloquentFilters\Attributes;

#[Attribute]
class FiltersModel
{
    public string $model;
    public string $queryParameter;

    public function __construct(string $model, string $queryParameter)
    {
        $this->model = $model;
        $this->queryParameter = $queryParameter;
    }
}
