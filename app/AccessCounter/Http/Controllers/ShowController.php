<?php

namespace App\AccessCounter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\AccessCounter\ImageWriters\TextSVGImageWriter;
use App\AccessCounter\Counters\Factory as CounterFactory;
use Storage;


class ShowController extends BaseController
{
    public function getCounter(Request $request)
    {
        $factory = new CounterFactory();
        $counterKey = $request->input('key', 'default');
        $counter = $factory->createCounter($counterKey, $request);
        $score = $counter->increase();
        $imageWidth = $request->input('w', null);
        $imageHeight = $request->input('h', null);
        $writer = new TextSVGImageWriter($imageWidth, $imageHeight);
        $writer->setText($score);
        $response = new Response($writer->getContent());
        $response->header('Content-Type', 'image/svg+xml');
        return $response;
    }
}
