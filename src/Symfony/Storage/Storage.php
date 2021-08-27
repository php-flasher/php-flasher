<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class Storage implements StorageInterface
{
    const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function all()
    {
        $session = $this->getSession();

        return $session->get(self::ENVELOPES_NAMESPACE, array());
    }

    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $session = $this->getSession();
        $session->set(self::ENVELOPES_NAMESPACE, array_merge($this->all(), $envelopes));
    }

    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        $store = $this->all();
        foreach ($store as $index => $envelope) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            if (!isset($map[$uuid])) {
                continue;
            }

            $store[$index] = $map[$uuid];
        }

        $session = $this->getSession();
        $session->set(self::ENVELOPES_NAMESPACE, $store);
    }

    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        $store = array_filter($this->all(), function (Envelope $envelope) use ($map) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            return !isset($map[$uuid]);
        });

        $session = $this->getSession();
        $session->set(self::ENVELOPES_NAMESPACE, $store);
    }

    public function clear()
    {
        $session = $this->getSession();
        $session->set(self::ENVELOPES_NAMESPACE, array());
    }

    /**
     * @return SessionInterface
     */
    private function getSession()
    {
        if (method_exists($this->requestStack, 'getSession')) {
            return $this->requestStack->getSession();
        }

        $request = $this->requestStack->getCurrentRequest();

        return $request->getSession();
    }
}
