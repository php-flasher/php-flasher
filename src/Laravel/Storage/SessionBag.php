<?php

declare(strict_types=1);

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Storage\Bag\BagInterface;
use Illuminate\Session\Store;

final class SessionBag implements BagInterface
{
    /**
     * @var string
     */
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * @param  Store  $session
     */
    public function __construct(private $session)
    {
    }

    public function get()
    {
        return $this->session->get(self::ENVELOPES_NAMESPACE, []); // @phpstan-ignore-line
    }

    public function set(array $envelopes): void
    {
        $this->session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }
}
