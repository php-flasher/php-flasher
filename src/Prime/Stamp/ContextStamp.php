<?php

declare(strict_types=1);

namespace Flasher\Prime\Stamp;

/**
 * ContextStamp - Stores additional context data for a notification.
 *
 * This stamp provides a way to attach arbitrary context data to a notification.
 * This context data can be used by presenters, templates, or frontend code to
 * customize how the notification is rendered or processed.
 *
 * Design patterns:
 * - Value Object: Immutable object representing a specific concept
 * - Memento: Captures and externalizes an object's internal state
 */
final readonly class ContextStamp implements PresentableStampInterface, StampInterface
{
    /**
     * Creates a new ContextStamp instance.
     *
     * @param array<string, mixed> $context The context data to attach
     */
    public function __construct(private array $context)
    {
    }

    /**
     * Gets the context data.
     *
     * @return array<string, mixed> The context data
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Converts the stamp to an array representation.
     *
     * This method implements the serialization logic required by PresentableStampInterface.
     *
     * @return array{context: array<string, mixed>} The array representation
     */
    public function toArray(): array
    {
        return ['context' => $this->context];
    }
}
