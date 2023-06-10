<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Exception\PresetNotFoundException;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PresetStamp;

/**
 * @phpstan-type PresetType array<string, array{
 *     type: string,
 *     title: string,
 *     message: string,
 *     options: array<string, mixed>,
 * }>
 */
final class PresetListener implements EventListenerInterface
{
    /**
     * @phpstan-param PresetType $presets
     */
    public function __construct(private readonly array $presets)
    {
    }

    /**
     * @throws PresetNotFoundException
     */
    public function __invoke(PersistEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->attachPresets($envelope);
        }
    }

    public static function getSubscribedEvents(): string
    {
        return PersistEvent::class;
    }

    /**
     * @throws PresetNotFoundException
     */
    private function attachPresets(Envelope $envelope): void
    {
        $presetStamp = $envelope->get(PresetStamp::class);
        if (! $presetStamp instanceof PresetStamp) {
            return;
        }

        if (! isset($this->presets[$presetStamp->getPreset()])) {
            throw new PresetNotFoundException($presetStamp->getPreset(), array_keys($this->presets));
        }

        $preset = $this->presets[$presetStamp->getPreset()];
        $preset = [
            'type' => 'info',
            'title' => null,
            'message' => null,
            'options' => [],
            ...$preset,
        ];

        if ('' === $envelope->getType()) {
            $envelope->setType($preset['type']);
        }

        if ('' === $envelope->getTitle()) {
            $envelope->setTitle($preset['title']);
        }

        if ('' === $envelope->getMessage()) {
            $envelope->setMessage($preset['message']);
        }

        $envelope->setOptions([
            ...$preset['options'],
            ...$envelope->getOptions(),
        ]);
    }
}
