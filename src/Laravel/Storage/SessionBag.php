<?php

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Storage\Bag\BagInterface;
use Illuminate\Session\Store;

final class SessionBag implements BagInterface
{
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

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

    public function get()
    {
        return $this->session->get(self::ENVELOPES_NAMESPACE, []); // @phpstan-ignore-line
    }

    public function set(array $envelopes)
    {
        $this->session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }
}
