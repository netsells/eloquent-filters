<?php

namespace Netsells\EloquentFilters;

use Illuminate\Support\ServiceProvider;

class EloquentFiltersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/eloquent-filters.php' => config_path('eloquent-filters.php.php'),
        ], 'eloquent-filters');
    }

    public function register()
    {
        //
    }
}