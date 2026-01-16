<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Exception\PresetNotFoundException;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PresetStamp;

/**
 * @phpstan-type PresetType array{
 *     type: string,
 *     title: string,
 *     message: string,
 *     options: array<string, mixed>,
 * }
 */
final readonly class ApplyPresetListener implements EventListenerInterface
{
    /**
     * @param array<string, PresetType> $presets
     */
    public function __construct(private array $presets)
    {
    }

    /**
     * @throws PresetNotFoundException
     */
    public function __invoke(PersistEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->applyPreset($envelope);
        }
    }

    public function getSubscribedEvents(): string
    {
        return PersistEvent::class;
    }

    /**
     * @throws PresetNotFoundException
     */
    private function applyPreset(Envelope $envelope): void
    {
        $presetStamp = $envelope->get(PresetStamp::class);
        if (!$presetStamp instanceof PresetStamp) {
            return;
        }

        $alias = $presetStamp->getPreset();
        if (!isset($this->presets[$alias])) {
            throw PresetNotFoundException::create($alias, array_keys($this->presets));
        }

        $preset = $this->getPreset($alias);
        $this->updateEnvelope($envelope, $preset);
    }

    /**
     * @return PresetType
     */
    private function getPreset(string $alias): array
    {
        return [
            'type' => '',
            'title' => '',
            'message' => '',
            'options' => [],
            ...$this->presets[$alias],
        ];
    }

    /**
     * @param PresetType $preset
     */
    private function updateEnvelope(Envelope $envelope, array $preset): void
    {
        if ('' === $envelope->getType()) {
            $envelope->setType($preset['type']);
        }

        if ('' === $envelope->getTitle()) {
            $envelope->setTitle($preset['title']);
        }

        if ('' === $envelope->getMessage()) {
            $envelope->setMessage($preset['message']);
        }

        $envelope->setOptions([...$preset['options'], ...$envelope->getOptions()]);
    }
}
