<?php

namespace Flasher\Prime\TestsStorage;

use Notify\Envelope;
use Flasher\Prime\TestsStamp\ReplayStamp;

final class StorageManager implements StorageManagerInterface
{
    /**
     * @var \Flasher\Prime\TestsStorage\StorageInterface
     */
    private $storage;

    /**
     * @param \Flasher\Prime\TestsStorage\StorageInterface $storage
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
            $replayStamp = $envelope->get('Flasher\Prime\TestsStamp\ReplayStamp');
            $replayCount = null === $replayStamp ? 0 : $replayStamp->getCount() - 1;

            if (1 > $replayCount) {
                continue;
            }

            $envelope->with(new ReplayStamp($replayCount));
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
