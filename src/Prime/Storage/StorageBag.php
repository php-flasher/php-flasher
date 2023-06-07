<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Stamp\UuidStamp;
use Flasher\Prime\Storage\Bag\ArrayBag;
use Flasher\Prime\Storage\Bag\BagInterface;

final class StorageBag implements StorageInterface
{
    /**
     * @var BagInterface
     */
    private $bag;

    public function __construct(BagInterface $bag = null)
    {
        $this->bag = null !== $bag && 'cli' !== \PHP_SAPI ? $bag : new ArrayBag();
    }

    public function all()
    {
        return array_values($this->bag->get());
    }

    public function add($envelopes)
    {
        $envelopes = \is_array($envelopes) ? $envelopes : \func_get_args();
        $envelopes = UuidStamp::indexByUuid($envelopes);

        $stored = UuidStamp::indexByUuid($this->all());
        $envelopes = array_merge($stored, $envelopes);

        $this->bag->set(array_values($envelopes));
    }

    public function update($envelopes)
    {
        $envelopes = \is_array($envelopes) ? $envelopes : \func_get_args();
        $envelopes = UuidStamp::indexByUuid($envelopes);

        $stored = UuidStamp::indexByUuid($this->all());
        $envelopes = array_merge($stored, $envelopes);

        $this->bag->set(array_values($envelopes));
    }

    public function remove($envelopes)
    {
        $envelopes = \is_array($envelopes) ? $envelopes : \func_get_args();
        $envelopes = UuidStamp::indexByUuid($envelopes);

        $stored = UuidStamp::indexByUuid($this->all());
        $envelopes = array_diff_key($stored, $envelopes);

        $this->bag->set(array_values($envelopes));
    }

    public function clear()
    {
        $this->bag->set([]);
    }
}
