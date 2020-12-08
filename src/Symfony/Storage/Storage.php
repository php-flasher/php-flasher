<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;

final class Storage implements StorageInterface
{
    const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var Session
     */
    private $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function all()
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

        $this->session->set(self::ENVELOPES_NAMESPACE, $store);
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $map = UuidStamp::indexByUuid($envelopes);

        $store = array_filter(
            $this->all(),
            function (Envelope $envelope) use ($map) {
                $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

                return !isset($map[$uuid]);
            }
        );

        $this->session->set(self::ENVELOPES_NAMESPACE, $store);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->session->set(self::ENVELOPES_NAMESPACE, array());
    }
}
