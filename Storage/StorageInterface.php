<?php

namespace Flasher\Prime\TestsStorage;

interface StorageInterface
{
    /**
     * @return \Notify\Envelope[]
     */
    public function all();

    /**
     * @param \Notify\Envelope|\Notify\Envelope[] $envelopes
     */
    public function add($envelopes);

    /**
     * @param \Notify\Envelope|\Notify\Envelope[] $envelopes
     */
    public function remove($envelopes);

    /**
     * Remove all notifications from the storage
     */
    public function clear();
}
