# Eloquent Filters

Eloquent Filters provides you with the scaffolding to easily organise and add filters to your eloquent models. The primary purpose of this package is to help keep both models and controllers clean by helping you to extract search / filter logic into well defined, dedicated classes.

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

class TileFilter implements FilterInterface
{
    public function applyFilter(Builder $query, $value): void
    {
        $query->where('title', 'like', "%{$value}%");
    }
}
```

Then register the filter against the model in the `eloquent-filters.php` config file.

```php
<?php

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

use App\Features\Filters\TitleFilter;
use App\Models\Post;

return [
    Post::class => [
        'title' => TitleFilter::class,
    ],
];
```

*Note - the query parameter is independent of the database column being queried. They are coupled together only by the config file*

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