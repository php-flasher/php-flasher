<?php

declare(strict_types=1);

namespace Flasher\Symfony\EventListener;

use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandlerInterface;
use Flasher\Symfony\Storage\FallbackSession;
use Symfony\Contracts\Service\ResetInterface;

/**
 * Resets static state between requests in long-running processes
 * like FrankenPHP, Swoole, or RoadRunner.
 *
 * Tagged with kernel.reset in services.php to be automatically called
 * by Symfony's kernel between requests.
 */
final readonly class WorkerListener implements ResetInterface
{
    public function __construct(
        private ContentSecurityPolicyHandlerInterface $cspHandler,
    ) {
    }

    public function reset(): void
    {
        FallbackSession::reset();
        $this->cspHandler->reset();
    }
}
