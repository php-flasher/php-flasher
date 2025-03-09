<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

use Flasher\Prime\FlasherInterface;

/**
 * RequestExtension - Converts framework flash messages to PHPFlasher notifications.
 *
 * This class is responsible for extracting flash messages from request objects
 * (typically stored in the session) and converting them to PHPFlasher notifications.
 * It provides a bridge between framework-specific flash messaging systems and
 * PHPFlasher's notification system.
 *
 * Design patterns:
 * - Adapter: Adapts framework flash message systems to PHPFlasher
 * - Mediator: Coordinates the interaction between framework and PHPFlasher
 */
final readonly class RequestExtension implements RequestExtensionInterface
{
    /**
     * Flattened mapping from flash message keys to notification types.
     *
     * @var array<string, string>
     */
    private array $mapping;

    /**
     * Creates a new RequestExtension instance.
     *
     * @param FlasherInterface        $flasher The flasher service for creating notifications
     * @param array<string, string[]> $mapping Mapping from framework flash types to PHPFlasher types
     */
    public function __construct(private FlasherInterface $flasher, array $mapping = [])
    {
        $this->mapping = $this->flatMapping($mapping);
    }

    /**
     * {@inheritdoc}
     *
     * This method processes the request to extract flash messages and convert them
     * to PHPFlasher notifications. It only processes requests with active sessions.
     */
    public function flash(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!$request->hasSession()) {
            return $response;
        }

        $this->processRequest($request);

        return $response;
    }

    /**
     * Flattens a nested mapping array to a simple key-value mapping.
     *
     * Converts a mapping like ['success' => ['success', 'ok']] to
     * ['success' => 'success', 'ok' => 'success'].
     *
     * @param array<string, string[]> $mapping The nested mapping array
     *
     * @return array<string, string> The flattened mapping
     */
    private function flatMapping(array $mapping): array
    {
        $flatMapping = [];

        foreach ($mapping as $type => $aliases) {
            foreach ($aliases as $alias) {
                $flatMapping[$alias] = $type;
            }
        }

        return $flatMapping;
    }

    /**
     * Processes the request and converts flash messages to notifications.
     *
     * This method checks for each flash message type in the request and creates
     * corresponding PHPFlasher notifications for any that are found.
     *
     * @param RequestInterface $request The request to process
     */
    private function processRequest(RequestInterface $request): void
    {
        foreach ($this->mapping as $alias => $type) {
            if (!$request->hasType($alias)) {
                continue;
            }

            $messages = (array) $request->getType($alias);

            foreach ($messages as $message) {
                $this->flasher->flash($type, $message);
            }

            $request->forgetType($alias);
        }
    }
}
