<?php

namespace App\AccessCounter\Counters;

use Storage;

class FilesystemCounter
{
    const DEFAULT_PATH = 'count.dat';
    private $data = 0;
    private $savePath = '';

    public function __construct(string $path = null)
    {
        if (is_null($path)) {
            $path = static::DEFAULT_PATH;
        }
        $this->savePath = $path;
        if (!Storage::disk('local')->exists($this->savePath)) {
            Storage::put($this->savePath, 0);
        }
        $this->data = (int)Storage::get($this->savePath);
    }

    public function increase()
    {
        $this->data++;
        $this->save();
        return $this->data;
    }

    public function save()
    {
        Storage::put($this->savePath, $this->data);
    }

    public function format()
    {
        return $this->data;
    }
}
