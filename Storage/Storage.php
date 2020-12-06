<?php

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageInterface;

final class Storage implements StorageInterface
{
    const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var \Illuminate\Session\SessionManager|\Illuminate\Session\Store
     */
    private $session;

    /**
     * @param \Illuminate\Session\SessionManager|\Illuminate\Session\Store $session
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->session->get(self::ENVELOPES_NAMESPACE, array());
    }

    /**
     * @inheritDoc
     */
    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $store = $this->all();

        foreach ($envelopes as $envelope) {
            if (null === $envelope->get('Flasher\Prime\Stamp\UuidStamp')) {
                $envelope->withStamp(new UuidStamp());
            }

            $store[] = $envelope;
        }

        $this->session->put(self::ENVELOPES_NAMESPACE, $store);
    }

    /**
     * @inheritDoc
     */
    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexWithUuid($envelopes);

        $store = $this->all();
        foreach ($store as $index => $envelope) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            if (!isset($map[$uuid])) {
                continue;
            }

            $store[$index] = $map[$uuid];
        }

        $this->session->put(self::ENVELOPES_NAMESPACE, $store);
    }

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $map = UuidStamp::indexWithUuid($envelopes);

        $store = array_filter(
            $this->all(),
            function (Envelope $envelope) use ($map) {
                $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

                return !isset($map[$uuid]);
            }
        );

        $this->session->put(self::ENVELOPES_NAMESPACE, $store);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->session->set(self::ENVELOPES_NAMESPACE, array());
    }
}
