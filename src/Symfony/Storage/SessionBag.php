<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Storage\Bag\BagInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session as LegacySession;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionBag implements BagInterface
{
    /**
     * @var string
     */
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    private readonly \Flasher\Symfony\Storage\FallbackSession $fallbackSession;

    /**
     * @param RequestStack|SessionInterface $session
     */
    public function __construct(private $session)
    {
        $this->fallbackSession = new FallbackSession();
    }

    public function get(): array
    {
        return $this->session()->get(self::ENVELOPES_NAMESPACE, []); // @phpstan-ignore-line
    }

    public function set(array $envelopes): void
    {
        $this->session()->set(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    /**
     * @return SessionInterface
     */
    private function session(): SessionInterface|LegacySession|FallbackSession
    {
        if ($this->session instanceof SessionInterface || $this->session instanceof LegacySession) { // @phpstan-ignore-line
            return $this->session; // @phpstan-ignore-line
        }

        try {
            if (method_exists($this->session, 'getSession')) {
                $session = $this->session->getSession();
            } else {
                $session = $this->session->getCurrentRequest()->getSession();
            }

            if ($session instanceof \Symfony\Component\HttpFoundation\Session\SessionInterface && $session->isStarted()) {
                return $this->session = $session;
            }

            return $this->fallbackSession;
        } catch (SessionNotFoundException) {
            return $this->fallbackSession;
        }
    }
}
