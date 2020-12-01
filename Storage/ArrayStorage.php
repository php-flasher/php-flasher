<?php

namespace Flasher\Prime\TestsStorage;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\UuidStamp;

final class ArrayStorage implements StorageInterface
{
    /**
     * @var Envelope[]
     */
    private $envelopes = array();

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->envelopes;
    }

    /**
     * @inheritDoc
     */
    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        foreach ($envelopes as $envelope) {
            if (null === $envelope->get('Flasher\Prime\TestsStamp\UuidStamp')) {
                $envelope->withStamp(new UuidStamp());
            }

            $this->envelopes[] = $envelope;
        }
    }

    /**
     * @param \Notify\Envelope[] $envelopes
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $map = UuidStamp::indexWithUuid($envelopes);

        $this->envelopes = array_filter(
            $this->envelopes,
            function (Envelope $envelope) use ($map) {
                $uuid = $envelope->get('Flasher\Prime\TestsStamp\UuidStamp')->getUuid();

                return !isset($map[$uuid]);
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->envelopes = array();
    }
}
