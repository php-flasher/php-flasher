<?php

declare(strict_types=1);

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Bag\BagInterface;
use Illuminate\Contracts\Session\Session;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;

final readonly class SessionBag implements BagInterface
{
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    private FallbackSessionInterface $fallbackSession;

    public function __construct(private SessionManager $sessionManager, ?FallbackSessionInterface $fallbackSession = null)
    {
        $this->fallbackSession = $fallbackSession ?? new FallbackSession();
    }

    public function get(): array
    {
        $session = $this->getSession();

        /** @var Envelope[] $envelopes */
        $envelopes = $session->get(self::ENVELOPES_NAMESPACE, []);

        return $envelopes;
    }

    public function set(array $envelopes): void
    {
        $session = $this->getSession();

        if ($session instanceof FallbackSessionInterface) {
            $session->set(self::ENVELOPES_NAMESPACE, $envelopes);

            return;
        }

        $session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    private function getSession(): Session|FallbackSessionInterface
    {
        $session = $this->sessionManager->driver();

        if ($session instanceof Store && $session->isStarted()) {
            return $session;
        }

        return $this->fallbackSession;
    }
}
