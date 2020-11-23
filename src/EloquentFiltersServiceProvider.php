<?php

namespace Netsells\EloquentFilters;

use Illuminate\Support\ServiceProvider;
use Netsells\EloquentFilters\Factories\FilterFactory;
use Netsells\EloquentFilters\Interfaces\FilterFactoryInterface;
use Netsells\EloquentFilters\Interfaces\EloquentFilterInterface;
use Netsells\EloquentFilters\Interfaces\FilterFinderInterface;
use Netsells\EloquentFilters\Utilities\FilterFinder;

class EloquentFiltersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/eloquent-filters.php' => config_path('eloquent-filters.php'),
        ], 'eloquent-filters');
    }

    public function register()
    {
        $this->app->bind(EloquentFilterInterface::class, EloquentFilter::class);
        $this->app->bind(FilterFactoryInterface::class, FilterFactory::class);
        $this->app->bind(FilterFinderInterface::class, FilterFinder::class);
    }
}
