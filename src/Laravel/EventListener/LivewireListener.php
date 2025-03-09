<?php

declare(strict_types=1);

namespace Flasher\Laravel\EventListener;

use Flasher\Laravel\Http\Request;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Http\Csp\ContentSecurityPolicyHandlerInterface;
use Flasher\Prime\Notification\Envelope;
use Illuminate\Http\Request as LaravelRequest;
use Livewire\Component;
use Livewire\LivewireManager;
use Livewire\Mechanisms\HandleComponents\ComponentContext;

/**
 * LivewireListener - Integrates PHPFlasher with Livewire component lifecycle.
 *
 * This listener ensures that PHPFlasher notifications can be displayed during
 * Livewire component updates without requiring a full page load. It dispatches
 * notifications as Livewire events that are handled by the front-end JavaScript.
 *
 * Design patterns:
 * - Observer: Listens to Livewire component lifecycle events
 * - Adapter: Adapts PHPFlasher notifications to Livewire's event system
 * - Security-aware: Ensures CSP compliance with proper nonce handling
 */
final readonly class LivewireListener
{
    /**
     * Creates a new LivewireListener instance.
     *
     * @param LivewireManager                       $livewire   The Livewire manager
     * @param FlasherInterface                      $flasher    The PHPFlasher service
     * @param ContentSecurityPolicyHandlerInterface $cspHandler The CSP handler for security
     * @param \Closure                              $request    Closure to get the current request
     */
    public function __construct(
        private LivewireManager $livewire,
        private FlasherInterface $flasher,
        private ContentSecurityPolicyHandlerInterface $cspHandler,
        private \Closure $request,
    ) {
    }

    /**
     * Handle a Livewire component dehydration event.
     *
     * This method is invoked during Livewire's component rendering process
     * and dispatches any pending notifications as Livewire events.
     *
     * @param Component        $component The Livewire component being rendered
     * @param ComponentContext $context   The Livewire component context
     */
    public function __invoke(Component $component, ComponentContext $context): void
    {
        if ($this->shouldSkip($context)) {
            return;
        }

        /** @var array{envelopes: Envelope[]} $data */
        $data = $this->flasher->render('array', [], $this->createContext());

        if (\count($data['envelopes']) > 0) {
            $this->dispatchNotifications($component, $context, $data);
        }
    }

    /**
     * Dispatches notifications as Livewire events.
     *
     * This method adds the notifications data to the Livewire component's
     * dispatched events, which will be processed by the front-end.
     *
     * @param Component                    $component The Livewire component
     * @param ComponentContext             $context   The Livewire component context
     * @param array{envelopes: Envelope[]} $data      The notification data
     */
    private function dispatchNotifications(Component $component, ComponentContext $context, array $data): void
    {
        $data['context']['livewire'] = [
            'id' => $component->getId(),
            'name' => $component->getName(),
        ];

        $dispatches = $context->effects['dispatches'] ?? [];
        $dispatches[] = ['name' => 'flasher:render', 'params' => $data];

        $context->addEffect('dispatches', $dispatches);
    }

    /**
     * Determines if notification processing should be skipped.
     *
     * Skips processing in the following cases:
     * - Not a Livewire request
     * - During component mounting (initial render)
     * - When a redirect is in progress
     *
     * @param ComponentContext $context The Livewire component context
     *
     * @return bool True if notification processing should be skipped
     */
    private function shouldSkip(ComponentContext $context): bool
    {
        return !$this->livewire->isLivewireRequest() || $context->mounting || isset($context->effects['redirect']);
    }

    /**
     * Creates the security context for rendering notifications.
     *
     * This method generates CSP nonces to ensure scripts loaded by PHPFlasher
     * comply with Content Security Policy.
     *
     * @return array<string, mixed> The context with CSP nonces
     */
    private function createContext(): array
    {
        /** @var LaravelRequest $request */
        $request = ($this->request)();
        $nonces = $this->cspHandler->getNonces(new Request($request));

        return [
            'csp_script_nonce' => $nonces['csp_script_nonce'] ?? null,
            'csp_style_nonce' => $nonces['csp_style_nonce'] ?? null,
        ];
    }
}
