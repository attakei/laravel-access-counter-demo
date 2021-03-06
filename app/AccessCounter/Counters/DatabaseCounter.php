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
        AccessCounter::firstOrCreate(
            [ 'code' => $key ], [ 'score' => 0 ]);
        $this->data = AccessCounter::where('code', $key)->lockForUpdate()->first();
    }

    public function increase()
    {
        $this->data->score++;
        $this->data->save();
        return $this->data->score;
    }

    public function format()
    {
        return $this->data->score;
    }
}
