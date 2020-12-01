<?php

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\CreatedAtStamp;
use Flasher\Prime\Stamp\LifeStamp;
use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;

final class Storage implements StorageInterface
{
    const ENVELOPES_NAMESPACE = 'notify::envelopes';

    private $session;

    public function __construct(Session $session)
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

        $this->session->set(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    /**
     * @param Envelope[] $envelopes
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

        $this->session->set(self::ENVELOPES_NAMESPACE, $store);
    }
}
