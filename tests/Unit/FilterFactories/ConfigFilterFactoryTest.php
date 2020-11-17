<?php

namespace Netsells\EloquentFilters\Tests\Unit\FilterFactories;

use Netsells\EloquentFilters\Tests\TestCase;
use Netsells\EloquentFilters\ConfigFilterFactory;
use Netsells\EloquentFilters\Exceptions\ModelFiltersNotFoundException;
use Netsells\EloquentFilters\Tests\Database\Filters\TestFilter;
use Netsells\EloquentFilters\Tests\Database\Models\TestModel;

class ConfigFilterFactoryTest extends TestCase
{
    private $factory;

    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $this->factory = app(ConfigFilterFactory::class);
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
}
