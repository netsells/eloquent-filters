<?php

namespace Netsells\EloquentFilters\Tests;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Netsells\EloquentFilters\EloquentFiltersServiceProvider;
use Netsells\EloquentFilters\Tests\Database\Filters\TestFilter;
use Netsells\EloquentFilters\Tests\Database\Models\TestModel;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            EloquentFiltersServiceProvider::class,
        ];

        $this->app->config->set(
            "eloquent-filters.filters",
            [
                TestModel::class => [
                    'title' => TestFilter::class,
                ]
            ]
        );
    }

    protected function getEnvironmentSetUp($app)
    {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__ . '/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);
    }
}
