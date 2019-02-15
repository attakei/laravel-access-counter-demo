<?php

namespace App\AccessCounter\Counters;

use Storage;

class FilesystemCounter
{
    const BASE_PATH = 'counter/';
    const DEFAULT_NAME = 'default';
    const EXT = 'dat';

    private $data = 0;
    private $savePath = '';

    public function __construct(string $name = null)
    {
        if (is_null($name)) {
            $name = static::DEFAULT_NAME;
        }
        $this->savePath = static::BASE_PATH . '/' . $name . '.' . static::EXT;
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
