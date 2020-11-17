<?php

namespace Netsells\EloquentFilters\Tests\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Netsells\EloquentFilters\Traits\HasFilters;

class TestModel extends Model
{
    use HasFilters;
    use HasFactory;

    protected $table = 'test_data';
}
