<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Bag\BagInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionBag implements BagInterface
{
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    private readonly FallbackSession $fallbackSession;

    public function __construct(private readonly RequestStack $requestStack)
    {
        $this->fallbackSession = new FallbackSession();
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

        $session->set(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    private function getSession(): SessionInterface|FallbackSession
    {
        try {
            $request = $this->requestStack->getCurrentRequest();

            if ($request && !$request->attributes->get('_stateless', false)) {
                return $this->requestStack->getSession();
            }
        } catch (SessionNotFoundException) {
        }

        return $this->fallbackSession;
    }
}
