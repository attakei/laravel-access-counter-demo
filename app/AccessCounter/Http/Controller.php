<?php

namespace App\AccessCounter\Http;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use App\AccessCounter\ImageWriters\TextSVGImageWriter;


class Controller extends BaseController
{
    public function getCounter(Request $request)
    {
        $writer = new TextSVGImageWriter();
        $writer->setText(100101);
        $response = new Response($writer->getContent());
        $response->header('Content-Type', 'image/svg+xml');
        return $response;
    }
}
