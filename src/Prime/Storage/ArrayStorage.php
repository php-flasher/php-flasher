<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\UuidStamp;

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
            if (null === $envelope->get('Flasher\Prime\Stamp\UuidStamp')) {
                $envelope->withStamp(new UuidStamp());
            }

            $this->envelopes[] = $envelope;
        }
    }

    /**
     * @inheritDoc
     */
    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexWithUuid($envelopes);

        foreach ($this->envelopes as $index => $envelope) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            if (!isset($map[$uuid])) {
                continue;
            }

            $this->envelopes[$index] = $map[$uuid];
        }
    }

    /**
     * @param Envelope[] $envelopes
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $map = UuidStamp::indexWithUuid($envelopes);

        $this->envelopes = array_filter(
            $this->envelopes,
            function (Envelope $envelope) use ($map) {
                $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

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
