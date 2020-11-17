<?php

namespace Netsells\EloquentFilters\Tests\Unit\FilterFactories;

use Netsells\EloquentFilters\Tests\TestCase;

abstract class BaseFilterFactoryTest extends TestCase
{
    protected $builder;

    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setup();

        $this->builder = $this->getBuilderMock();
    }

    private function getBuilderMock()
    {
        return;
    }
}
