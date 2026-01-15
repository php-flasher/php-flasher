<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

final readonly class HtmlStamp implements StampInterface, PresentableStampInterface
{
    public function __construct(private string $html)
    {
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return array{html: string}
     */
    public function toArray(): array
    {
        return ['html' => $this->html];
    }
}
