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

final readonly class LivewireListener
{
    public function __construct(
        private LivewireManager $livewire,
        private FlasherInterface $flasher,
        private ContentSecurityPolicyHandlerInterface $cspHandler,
        private \Closure $request,
    ) {
    }

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
     * @param array{envelopes: Envelope[]} $data
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

    private function shouldSkip(ComponentContext $context): bool
    {
        return !$this->livewire->isLivewireRequest() || $context->mounting || isset($context->effects['redirect']);
    }

    /**
     * @return array<string, mixed>
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
