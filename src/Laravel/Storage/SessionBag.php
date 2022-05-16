<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Storage\Bag\BagInterface;
use Illuminate\Session\Store;

final class SessionBag implements BagInterface
{
    const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @var Store
     */
    private $session;

    /**
     * @param Store $session
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->session->get(self::ENVELOPES_NAMESPACE, array()); // @phpstan-ignore-line
    }

    /**
     * {@inheritdoc}
     */
    public function set(array $envelopes)
    {
        $this->session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }
}
