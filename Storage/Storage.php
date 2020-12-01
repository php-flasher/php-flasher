<?php

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\LifeStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageInterface;

final class Storage implements StorageInterface
{
    const ENVELOPES_NAMESPACE = 'notify::envelopes';

    /**
     * @var \Illuminate\Session\SessionManager|\Illuminate\Session\Store
     */
    private $session;

    public function __construct($session)
    {
        $this->session = $session;
    }

    public function get()
    {
        return $this->session->get(self::ENVELOPES_NAMESPACE, array());
    }

    public function add(Envelope $envelope)
    {
        if (null === $envelope->get('Flasher\Prime\Stamp\UuidStamp')) {
            $envelope->withStamp(new UuidStamp());
        }

        if (null === $envelope->get('Flasher\Prime\Stamp\LifeStamp')) {
            $envelope->withStamp(new LifeStamp(1));
        }

        if (null === $envelope->get('Flasher\Prime\Stamp\CreatedAtStamp')) {
            $envelope->withStamp(new CreatedAtStamp());
        }


        $envelopes = $this->get();
        $envelopes[] = $envelope;

        $this->session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    /**
     * @param \Flasher\Prime\Envelope[] $envelopes
     */
    public function flush($envelopes)
    {
        $envelopesMap = array();

        foreach ($envelopes as $envelope) {
            $life = $envelope->get('Flasher\Prime\Stamp\LifeStamp')->getLife();
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            $envelopesMap[$uuid] = $life;
        }

        $store = array();

        foreach ($this->session->get(self::ENVELOPES_NAMESPACE, array()) as $envelope) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            if(isset($envelopesMap[$uuid])) {
                $life = $envelopesMap[$uuid] - 1;

                if ($life <= 0) {
                    continue;
                }

                $envelope->with(new LifeStamp($life));
            }

            $store[] = $envelope;
        }

        $this->session->put(self::ENVELOPES_NAMESPACE, $store);
    }
}
