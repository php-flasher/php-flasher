<?php

namespace Flasher\Prime\Storage;

use Flasher\Prime\Envelope;
use Flasher\Prime\Stamp\HopsStamp;

final class StorageManager implements StorageManagerInterface
{
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @inheritDoc
     */
    public function flush($envelopes)
    {
        $envelopes = is_array($envelopes) ? $envelopes : func_get_args();

        $this->storage->remove($envelopes);

        foreach ($envelopes as $envelope) {
            $replayStamp = $envelope->get('Flasher\Prime\Stamp\HopsStamp');
            $replayCount = null === $replayStamp ? 0 : $replayStamp->getAmount() - 1;

            if (1 > $replayCount) {
                continue;
            }

            $envelope->with(new HopsStamp($replayCount));
            $this->storage->add($envelope);
        }
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->storage->all();
    }

    /**
     * @inheritDoc
     */
    public function add(Envelope $envelope)
    {
        $this->storage->add($envelope);
    }

    /**
     * @inheritDoc
     */
    public function remove($envelopes)
    {
        $this->storage->remove($envelopes);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->storage->clear();
    }
}
