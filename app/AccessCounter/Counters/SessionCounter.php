<?php

namespace App\AccessCounter\Counters;

use Illuminate\Support\Facades\Session;

class LatestCount {
    public $score;
    public $timestamp;

    public static function fromJson(string $json)
    {
        $inst = new static();
        $data = json_decode($json, true);
        $inst->score = $data['score'];
        $inst->timestamp = $data['timestamp'];
        return $inst;
    }

    public function toJson()
    {
        return json_encode($this);
    }
}


class SessionCounter
{
    private $counter;
    private $request;

    public function __construct($counter, $request)
    {
        $this->counter = $counter;
        $this->request = $request;
    }

    public function increase()
    {
        //
        $session = $this->request->session();
        $log = LatestCount::fromJson(
            $session->get('access_counter', '{"timestamp":0,"score":0}'));
        //
        if ($log->timestamp + 24 * 60 * 60 > time()) {
            return $log->score;
        }
        $score = $this->counter->increase();
        //
        $log->score = $score;
        $log->timestamp = time();
        $session->put('access_counter', $log->toJson());
        return $score;
    }

    public function format()
    {
        return $this->counter->format();
    }
}
