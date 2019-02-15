<?php

namespace App\AccessCounter\Http;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\AccessCounter\ImageWriters\TextSVGImageWriter;
use App\AccessCounter\Counters\FilesystemCounter;
use Storage;


class Controller extends BaseController
{
    public function getCounter(Request $request)
    {
        $counter = new FilesystemCounter();
        $counter->increase();
        $writer = new TextSVGImageWriter();
        $writer->setText($counter->format());
        $response = new Response($writer->getContent());
        $response->header('Content-Type', 'image/svg+xml');
        return $response;
    }
}
