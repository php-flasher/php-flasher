<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * HtmlStamp - Contains prerendered HTML content for a notification.
 *
 * This stamp stores HTML content that should be rendered directly in the page
 * instead of being processed by the JavaScript notification library. It's useful
 * for complex notifications that require custom markup or server-rendered content.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Memento: Captures and externalizes an object's internal state
 */
final readonly class HtmlStamp implements StampInterface, PresentableStampInterface
{
    /**
     * Creates a new HtmlStamp instance.
     *
     * @param string $html The prerendered HTML content
     */
    public function __construct(private string $html)
    {
    }

    /**
     * Gets the HTML content.
     *
     * @return string The prerendered HTML content
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * Converts the stamp to an array representation.
     *
     * This method implements the serialization logic required by PresentableStampInterface.
     *
     * @return array{html: string} The array representation
     */
    public function toArray(): array
    {
        return ['html' => $this->html];
    }
}
