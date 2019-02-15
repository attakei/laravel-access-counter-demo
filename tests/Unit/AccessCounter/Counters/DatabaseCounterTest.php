<?php

namespace Tests;

use App\AccessCounter\Counters\DatabaseCounter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class DatabaseCounterTest extends TestCase
{
    use RefreshDatabase;

    public function testCountDefault()
    {
        $counter = new DatabaseCounter();
        $this->assertEquals($counter->format(), 0);
        $counter->increase();
        $this->assertEquals($counter->format(), 1);

        $counterRow = DB::table('access_counters')->first();
        $this->assertEquals($counterRow->score, 1);
        $this->assertEquals($counterRow->code, 'default');
    }

    public function testCountCustom()
    {
        $counter = new DatabaseCounter('custom');
        $this->assertEquals($counter->format(), 0);
        $counter->increase();
        $this->assertEquals($counter->format(), 1);

        $counterRow = DB::table('access_counters')->first();
        $this->assertEquals($counterRow->score, 1);
        $this->assertEquals($counterRow->code, 'custom');
    }

    public function testCountGuardDuplicated()
    {
        $counter = new DatabaseCounter();
        $this->assertEquals($counter->format(), 0);
        $counter->increase();
        $this->assertEquals($counter->format(), 1);

        $counter = new DatabaseCounter();
        $this->assertEquals($counter->format(), 1);
    }
}
