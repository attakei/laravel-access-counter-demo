<?php

namespace App\AccessCounter\Counters;

use Illuminate\Support\Facades\Config;


class Factory {
    public function createCounter($key, $request) {
        $storage = Config::get('access_counter.storage', 'filesystem');
        switch ($storage) {
            case 'database':
                $counter = new DatabaseCounter();
                break;
            case 'filesystem':
                $counter = new FilesystemCounter($key);
        }
        if(Config::get('access_counter.use_session', false)) {
            return new SessionCounter($counter, $request);
        }
        return $counter;
    }
}
