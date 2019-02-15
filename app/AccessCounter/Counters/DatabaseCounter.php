<?php

namespace App\AccessCounter\Counters;

use Illuminate\Database\Eloquent\Model;


class AccessCounter extends Model
{
    protected $fillable =['code', 'score'];
}


class DatabaseCounter
{
    const DEFAULT_CODE_NAME = 'default';

    private $data;

    public function __construct(string $key = null)
    {
        $key = !is_null($key) ? $key : static::DEFAULT_CODE_NAME;
        $this->data = AccessCounter::firstOrCreate(
            [ 'code' => $key ], [ 'score' => 0 ]);
    }

    public function increase()
    {
        $this->data->score++;
        $this->data->save();
        return $this->data;
    }

    public function format()
    {
        return $this->data->score;
    }
}
