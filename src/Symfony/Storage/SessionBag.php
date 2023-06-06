<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Storage\Bag\BagInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session as LegacySession;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionBag implements BagInterface
{
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var RequestStack|SessionInterface
     */
    private $session;

    /**
     * @var FallbackSession
     */
    private $fallbackSession;

    /**
     * @param RequestStack|SessionInterface $session
     */
    public function __construct($session)
    {
        $this->session = $session;
        $this->fallbackSession = new FallbackSession();
    }

    public function get()
    {
        return $this->session()->get(self::ENVELOPES_NAMESPACE, []); // @phpstan-ignore-line
    }

    public function set(array $envelopes)
    {
        $this->session()->set(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    /**
     * @return SessionInterface
     */
    private function session()
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

            if (null !== $session && $session->isStarted()) {
                return $this->session = $session;
            }

            return $this->fallbackSession;
        } catch (SessionNotFoundException $e) {
            return $this->fallbackSession;
        }
    }
}
