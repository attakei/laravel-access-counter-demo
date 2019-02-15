<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\AccessCounter\ImageWriters\TextSVGImageWriter;

class TextSVGImageWriterTest extends TestCase
{
    public function testViewBox_Default()
    {
        $image = new TextSVGImageWriter();
        $this->assertEquals($image->getViewBox(), '0 0 200 20');
    }

    public function testViewBox_SetWidth()
    {
        $image = new TextSVGImageWriter(100);
        $this->assertEquals($image->getViewBox(), '0 0 100 20');
    }

    public function testViewBox_SetHeight()
    {
        $image = new TextSVGImageWriter(null, 30);
        $this->assertEquals($image->getViewBox(), '0 0 200 30');
    }

    public function testDOM_Struct()
    {
        $image = new TextSVGImageWriter();
        $dom = $image->getDOM();
        $this->assertInstanceOf('DOMDocument', $dom);
        $svgTagList = $dom->getElementsByTagName('svg');
        $this->assertEquals(count($svgTagList), 1);
        $textTagList = $svgTagList[0]->getElementsByTagName('text');
        $this->assertEquals(count($textTagList), 1);
    }

    public function testDOM_TextValue()
    {
        $image = new TextSVGImageWriter();
        $image->setText('Hello');
        $dom = $image->getDOM();
        $textTag = $dom->getElementsByTagName('text')[0];
        $this->assertEquals($textTag->textContent, 'Hello');
    }

    public function testContent()
    {
        $image = new TextSVGImageWriter();
        $image->setText('Hello');
        $content = $image->getContent();
        $this->assertContains('Hello</text>', $content);
    }
}
