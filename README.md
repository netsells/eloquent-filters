# Eloquent Filters

Eloquent Filters provides you with the scaffolding to easily organise and add filters to your eloquent models. The primary purpose of this package is to help keep both models and controllers clean by helping you to extract search / filter logic into well defined, dedicated classes.

It is created and maintained by the [Netsells team](https://netsells.co.uk/)

## Key Features
* Setup is extremely easy. Publish a config file then apply a trait to your models and you're done.
* Gives you an alternative to filling your models full scopes or controllers full of query logic.
* Provides the foundation for greater reuse of filter logic across different models.

## Installation

using composer:

```
composer require netsells/eloquent-filters
```

Then publish the config file using the following artisan command:
```
php artisan vendor:publish --tag=eloquent-filters
```

## Usage

### Basic Usage
Once you have published the config add the `Netsells\EloquentFilters\Traits\HasFilters` trait to any models that you wish to add filters to.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFilters;
}
```

Next create a filter class that implements `Netsells\EloquentFilters\Interfaces\FilterInterface;`.

```php
<?php

namespace App\Features\Filters;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;

class TitleFilter implements FilterInterface
{
    public function applyFilter(Builder $query, $value): void
    {
        $query->where('title', 'like', "%{$value}%");
    }
}
```

### Registering Filters

There are two ways to register a filter. Firstly via the `filters` array in the `eloquent-filters.php` config file as below:

```php
    /*
    |--------------------------------------------------------------------------
    | Model Filter Registration
    |--------------------------------------------------------------------------
    | This config file is used to register eloquent filters against
    | a query parameter.
    |
    | Model::class => [
    |      'query_parameter' => Filter::class,
    | ],
    |
    */

    'filters' => [
        Post::class => [
            'title' => TitleFilter::class,
        ],
    ],
```

or by applying the `Netsells\EloquentFilters\Attributes\FiltersModel` attribute to the filter class. 
The attribute takes two arguments, these are the model class and the query parameters that the filter is to be bound to.

```php
<?php

namespace App\Features\Filters;

use Illuminate\Database\Eloquent\Builder;
use Netsells\EloquentFilters\Interfaces\FilterInterface;
use Netsells\EloquentFilters\Attributes\FiltersModel;

#[FiltersModel(Post::class, 'title')]
class TitleFilter implements FilterInterface
{
    public function applyFilter(Builder $query, $value): void
    {
        $query->where('title', 'like', "%{$value}%");
    }
}
```

You may specify the directory in which to look for filters by setting the `filter_directory` value in the `eloquent-filters.php` config file. By defualt the entire `app/` directory will be scanned.

*Note - the query parameter is independent of the database column being queried.*

Finally, apply the filter as follows.

```php
Route::get('/', function () {
    return Post::applyFilters([
            'title' => 'Laravel'
        ])->get();
});
```

You may pass any `iterable` to the `applyFilters()` method. So all of the below are also valid:

```php
Route::get('/', function (Request $request) {
    return Post::applyFilters($request->all())->get();
});
```

```php
Route::get('/', function (Request $request) {
    return Post::applyFilters($request->validated())->get();
});
```

```php
Route::get('/', function (Request $request) {
    return Post::applyFilters($request->only('title'))->get();
});
```

```php
Route::get('/', function (Request $request) {
    $collection = collect(['title' => 'laravel']);
    return Post::applyFilters($collection)->get();
});
```
