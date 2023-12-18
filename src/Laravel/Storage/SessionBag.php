<?php

declare(strict_types=1);

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Bag\BagInterface;
use Illuminate\Contracts\Session\Session;

final class SessionBag implements BagInterface
{
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    public function __construct(private readonly Session $session)
    {
    }

    public function get(): array
    {
        /** @var Envelope[] $envelopes */
        $envelopes = $this->session->get(self::ENVELOPES_NAMESPACE, []);

        return $envelopes;
    }

    public function set(array $envelopes): void
    {
        $this->session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }
}
