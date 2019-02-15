<?php

namespace Tests;

use App\AccessCounter\Counters\FilesystemCounter;
use Illuminate\Support\Facades\Storage;


class FilesystemCounterTest extends TestCase
{
    public function testCountDefault()
    {
        Storage::fake('local');
        $counter = new FilesystemCounter();
        $this->assertTrue(Storage::disk('local')->exists('counter/default.dat'));
    }

    public function testCountIncrease()
    {
        Storage::fake('local');
        $counter = new FilesystemCounter();
        $counter->increase();
        $this->assertEquals($counter->format(), "1");
    }
}
