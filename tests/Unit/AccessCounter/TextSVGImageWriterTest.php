<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Attakei\AccessCounter\TextSVGImage;

class TextSVGImageWriterTest extends TestCase
{
    public function testViewBox_Default()
    {
        $image = new TextSVGImage();
        $this->assertEquals($image->getViewBox(), '0 0 200 20');
    }

    public function testViewBox_SetWidth()
    {
        $image = new TextSVGImage(100);
        $this->assertEquals($image->getViewBox(), '0 0 100 20');
    }

    public function testViewBox_SetHeight()
    {
        $image = new TextSVGImage(null, 30);
        $this->assertEquals($image->getViewBox(), '0 0 200 30');
    }

    public function testDOM_Struct()
    {
        $image = new TextSVGImage();
        $dom = $image->getDOM();
        $this->assertInstanceOf('DOMDocument', $dom);
        $svgTagList = $dom->getElementsByTagName('svg');
        $this->assertEquals(count($svgTagList), 1);
        $textTagList = $svgTagList[0]->getElementsByTagName('text');
        $this->assertEquals(count($textTagList), 1);
    }

    public function testDOM_TextValue()
    {
        $image = new TextSVGImage();
        $image->setText('Hello');
        $dom = $image->getDOM();
        $textTag = $dom->getElementsByTagName('text')[0];
        $this->assertEquals($textTag->textContent, 'Hello');
    }

    public function testContent()
    {
        $image = new TextSVGImage();
        $image->setText('Hello');
        $content = $image->getContent();
        $this->assertContains('Hello</text>', $content);
    }
}
