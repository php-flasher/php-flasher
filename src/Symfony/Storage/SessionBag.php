<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Storage\Bag\BagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session as LegacySession;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionBag implements BagInterface
{
    const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var RequestStack|SessionInterface
     */
    private $session;

    /**
     * @param RequestStack|SessionInterface $session
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->session()->get(self::ENVELOPES_NAMESPACE, array()); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
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

        if (method_exists($this->session, 'getSession')) {
            return $this->session = $this->session->getSession();
        }

        return $this->session = $this->session->getCurrentRequest()->getSession(); // @phpstan-ignore-line
    }
}
