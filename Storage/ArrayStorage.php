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
        $this->envelopes[] = is_array($envelopes) ? $envelopes : func_get_args();
    }

    /**
     * @inheritDoc
     */
    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        foreach ($this->envelopes as $index => $envelope) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            if (!isset($map[$uuid])) {
                continue;
            }

            $this->envelopes[$index] = $map[$uuid];
        }
    }

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        $this->envelopes = array_filter($this->envelopes, function (Envelope $envelope) use ($map) {
            $uuid = $envelope->get('Flasher\Prime\Stamp\UuidStamp')->getUuid();

            return !isset($map[$uuid]);
        });
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->envelopes = array();
    }
}
