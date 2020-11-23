<?php

namespace Netsells\EloquentFilters\Tests\Unit\FilterFactories;

use Netsells\EloquentFilters\Tests\TestCase;
use Netsells\EloquentFilters\Factories\FilterFactory;
use Netsells\EloquentFilters\Tests\Database\Models\TestModel;
use Netsells\EloquentFilters\Tests\Database\Filters\TestFilter;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;

class FilterFactoryTest extends TestCase
{
    private $factory;

    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $this->factory = app(FilterFactory::class);
    }

    public function testGetFilterReturnsCorrectFilterObject(): void
    {
        $filter = $this->factory->getFilter(TestModel::query(), 'title');

        $this->assertEquals(TestFilter::class, get_class($filter));
    }

    public function testGetFilterThrowsExceptionForUnregisteredFilter(): void
    {
        $this->expectException(ModelFiltersNotFoundException::class);

        $this->factory->getFilter(TestModel::query(), 'unregistered_query_param');
    }

    public function testGetFilterThrowsExceptionForIncorrectFilterType(): void
    {
        $this->expectException(ModelFiltersNotFoundException::class);

        $this->app->config->set(
            "eloquent-filters.filters",
            [
                TestModel::class => [
                    'title' => '',
                ]
            ]
        );

        $this->factory->getFilter(TestModel::query(), 'unregistered_query_param');
    }
}
