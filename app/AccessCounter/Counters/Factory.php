<?php

namespace App\AccessCounter\Counters;

use Illuminate\Support\Facades\Config;


class Factory {
    public function createCounter($key, $request) {
        $counter = new FilesystemCounter($key);
        if(Config::get('access_counter.use_session', false)) {
            return new SessionCounter($counter, $request);
        }
        return $counter;
    }
}
