<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Stamp;

use Flasher\Prime\Stamp\HtmlStamp;
use PHPUnit\Framework\TestCase;

final class HtmlStampTest extends TestCase
{
    private string $htmlString;
    private HtmlStamp $htmlStamp;

    protected function setUp(): void
    {
        $this->htmlString = '<div>Hello World</div>';
        $this->htmlStamp = new HtmlStamp($this->htmlString);
    }

    /**
     * Testing the getHtml method of the HtmlStamp class.
     */
    public function testGetHtml(): void
    {
        $this->assertSame($this->htmlString, $this->htmlStamp->getHtml());
    }

    /**
     * Testing the toArray method of the HtmlStamp class.
     */
    public function testToArray(): void
    {
        $expected = ['html' => $this->htmlString];
        $this->assertSame($expected, $this->htmlStamp->toArray());
    }
}
