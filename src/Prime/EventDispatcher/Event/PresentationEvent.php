<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * PresentationEvent - Event dispatched when notifications are being prepared for presentation.
 *
 * This event is dispatched during the rendering process, before notifications are
 * converted to their final format. It allows listeners to modify notifications
 * right before they are presented to the user (e.g., for translation or formatting).
 */
final readonly class PresentationEvent
{
    /**
     * Creates a new PresentationEvent instance.
     *
     * @param Envelope[]           $envelopes The notification envelopes being presented
     * @param array<string, mixed> $context   Additional context for presentation
     */
    public function __construct(
        private array $envelopes,
        private array $context,
    ) {
    }

    /**
     * Gets the notification envelopes being presented.
     *
     * @return Envelope[] The notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * Gets the presentation context.
     *
     * This context provides additional information that may be useful
     * for listeners during the presentation process.
     *
     * @return array<string, mixed> The presentation context
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
