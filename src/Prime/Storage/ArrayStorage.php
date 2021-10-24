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

    public function all()
    {
        return $this->envelopes;
    }

    public function add($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $this->envelopes = array_merge($this->envelopes, $envelopes);
    }

    public function update($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        foreach ($this->envelopes as $index => $envelope) {
            $uuidStamp = $envelope->get('Flasher\Prime\Stamp\UuidStamp');
            if (!$uuidStamp instanceof UuidStamp) {
                continue;
            }

            $uuid = $uuidStamp->getUuid();
            if (!isset($map[$uuid])) {
                continue;
            }

            $this->envelopes[$index] = $map[$uuid];
        }
    }

    public function remove($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();
        $map = UuidStamp::indexByUuid($envelopes);

        $this->envelopes = array_filter($this->envelopes, function (Envelope $envelope) use ($map) {
            $uuidStamp = $envelope->get('Flasher\Prime\Stamp\UuidStamp');
            if (!$uuidStamp instanceof UuidStamp) {
                return false;
            }

            $uuid = $uuidStamp->getUuid();

            return !isset($map[$uuid]);
        });
    }

    public function clear()
    {
        $this->envelopes = array();
    }
}
