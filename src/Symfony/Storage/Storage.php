<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session;

final class Storage implements StorageInterface
{
    const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var SessionInterface|Session
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    public function all()
    {
        return $this->session->get(self::ENVELOPES_NAMESPACE, array());
    }

    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $this->session->set(self::ENVELOPES_NAMESPACE, array_merge($this->all(), $envelopes));
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

        $this->session->set(self::ENVELOPES_NAMESPACE, $store);
    }

    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        $store = array_filter($this->all(), function (Envelope $envelope) use ($map) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            return !isset($map[$uuid]);
        });

        $this->session->set(self::ENVELOPES_NAMESPACE, $store);
    }

    public function clear()
    {
        $this->session->set(self::ENVELOPES_NAMESPACE, array());
    }
}
