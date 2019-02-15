<?php
namespace App\AccessCounter\ImageWriters;

/**
 * SVG text image writer
 *
 * This class handle only SVG format controll, does not control render value.
 *
 * @author Kazuya Takei<attakei@gmail.com>
 */
class TextSVGImageWriter
{
    const DEFAULT_WIDTH = 200;
    const DEFAULT_HEIGHT = 20;

    private $width = null;
    private $height = null;
    private $text = '';

    public function __construct($width = null, $height = null) {
        $this->width = $width !== null ? $width : static::DEFAULT_WIDTH;
        $this->height = $height !== null ? $height : static::DEFAULT_HEIGHT;
    }

    /**
     * Set text to render in image
     *
     * @param string $text render text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get viewBox format text for SVG
     *
     * @return string viewBox value for SVG attribute
     */
    public function getViewBox()
    {
        return "0 0 {$this->width} {$this->height}";
    }

    /**
     * Generate XML DOM of SVG formatted
     *
     * @return \DOMDocument DOM document object included render text
     */
    public function getDOM()
    {
        $this->width = $this->height * strlen($this->text);
        $dom = new \DOMDocument();
        $text = $dom->createElement('text', $this->text);
        $text->setAttribute('font-size', "{$this->height}px");
        $text->setAttribute('font-family', 'monospace');
        $text->setAttribute('font-weight', 'bolder');
        $text->setAttribute('x', "100%");
        $text->setAttribute('y', "90%");
        $text->setAttribute('text-anchor', 'end');
        $svg = $dom->createElement('svg');
        $svg->setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        $svg->setAttribute('width', $this->width);
        $svg->setAttribute('height', $this->height);
        $svg->setAttribute('viewBox', $this->getViewBox());
        $svg->appendChild($text);
        $dom->appendChild($svg);
        return $dom;
    }

    public function getContent()
    {
        return $this->getDOM()->saveXML();
    }
}
