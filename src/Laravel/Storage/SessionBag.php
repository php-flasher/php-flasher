<?php

declare(strict_types=1);

namespace Flasher\Laravel\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Bag\BagInterface;
use Illuminate\Session\SessionManager;

/**
 * SessionBag - Laravel session storage for PHPFlasher notifications.
 *
 * This class implements PHPFlasher's storage interface using Laravel's session
 * system, providing persistence for notifications across requests.
 *
 * Design patterns:
 * - Adapter: Adapts Laravel's session system to PHPFlasher's storage interface
 * - Repository: Provides CRUD operations for notification storage
 */
final readonly class SessionBag implements BagInterface
{
    /**
     * Session key for storing notification envelopes.
     */
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * Creates a new SessionBag instance.
     *
     * @param SessionManager $session Laravel's session manager
     */
    public function __construct(private SessionManager $session)
    {
    }

    /**
     * {@inheritdoc}
     *
     * Retrieves all stored notification envelopes from the session.
     *
     * @return Envelope[] The stored notification envelopes
     */
    public function get(): array
    {
        /** @var Envelope[] $envelopes */
        $envelopes = $this->session->get(self::ENVELOPES_NAMESPACE, []);

        return $envelopes;
    }

    /**
     * {@inheritdoc}
     *
     * Stores notification envelopes in the session.
     *
     * @param Envelope[] $envelopes The notification envelopes to store
     */
    public function set(array $envelopes): void
    {
        $this->session->put(self::ENVELOPES_NAMESPACE, $envelopes);
    }
}
