<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\Event;

use Flasher\Prime\Notification\Envelope;

/**
 * @internal
 */
final class NotificationEvents
{
    /** @var Envelope[] */
    private array $envelopes = [];

    public function add(Envelope ...$notifications): void
    {
        foreach ($notifications as $notification) {
            $this->addEnvelope($notification);
        }
    }

    public function addEnvelope(Envelope $notification): void
    {
        $this->envelopes[] = $notification;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }
}
