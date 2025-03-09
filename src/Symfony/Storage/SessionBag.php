<?php

declare(strict_types=1);

namespace Flasher\Symfony\Storage;

use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Storage\Bag\BagInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * SessionBag - Symfony session storage for PHPFlasher notifications.
 *
 * This class implements PHPFlasher's storage interface using Symfony's session
 * system, providing persistence for notifications across requests. It includes
 * fallback behavior for stateless contexts.
 *
 * Design patterns:
 * - Adapter Pattern: Adapts Symfony's session to PHPFlasher's storage interface
 * - Strategy Pattern: Uses different storage strategies based on context
 * - Fallback Strategy: Falls back to in-memory storage when session unavailable
 * - Repository Pattern: Provides CRUD operations for notification storage
 */
final readonly class SessionBag implements BagInterface
{
    /**
     * Session key for storing notification envelopes.
     */
    public const ENVELOPES_NAMESPACE = 'flasher::envelopes';

    /**
     * Fallback storage for contexts where session is unavailable.
     */
    private FallbackSessionInterface $fallbackSession;

    /**
     * Creates a new SessionBag instance.
     *
     * @param RequestStack                  $requestStack    Symfony's request stack for accessing session
     * @param FallbackSessionInterface|null $fallbackSession Optional custom fallback storage
     */
    public function __construct(private RequestStack $requestStack, ?FallbackSessionInterface $fallbackSession = null)
    {
        $this->fallbackSession = $fallbackSession ?: new FallbackSession();
    }

    /**
     * {@inheritdoc}
     *
     * Gets all notification envelopes from storage.
     *
     * @return Envelope[] The stored notification envelopes
     */
    public function get(): array
    {
        $session = $this->getSession();

        /** @var Envelope[] $envelopes */
        $envelopes = $session->get(self::ENVELOPES_NAMESPACE, []);

        return $envelopes;
    }

    /**
     * {@inheritdoc}
     *
     * Stores notification envelopes in storage.
     *
     * @param array<Envelope> $envelopes The notification envelopes to store
     */
    public function set(array $envelopes): void
    {
        $session = $this->getSession();

        $session->set(self::ENVELOPES_NAMESPACE, $envelopes);
    }

    /**
     * Gets the appropriate session storage implementation.
     *
     * Uses Symfony session if available and request is not stateless,
     * otherwise falls back to the fallback session implementation.
     *
     * @return SessionInterface|FallbackSessionInterface The storage implementation
     */
    private function getSession(): SessionInterface|FallbackSessionInterface
    {
        try {
            $request = $this->requestStack->getCurrentRequest();

            if ($request && !$request->attributes->get('_stateless', false)) {
                return $this->requestStack->getSession();
            }
        } catch (SessionNotFoundException) {
        }

        return $this->fallbackSession;
    }
}
