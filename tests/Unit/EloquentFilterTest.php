<?php

namespace Netsells\EloquentFilters\Tests\Unit;

use Netsells\EloquentFilters\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquentFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
    }

   /**
    * @test
    */
    public function testFaketest(): void
    {
        $this->assertTrue(1);
    }
}
