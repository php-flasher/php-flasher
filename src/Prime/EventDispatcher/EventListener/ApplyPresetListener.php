<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PersistEvent;
use Flasher\Prime\Exception\PresetNotFoundException;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PresetStamp;

/**
 * ApplyPresetListener - Applies preset configurations to notifications.
 *
 * This listener is responsible for applying predefined notification templates (presets)
 * to envelopes that contain a PresetStamp. Presets allow defining common notification
 * patterns that can be reused across an application.
 *
 * Design patterns:
 * - Template Method: Applies predefined templates to notifications
 * - Strategy: Uses different preset configurations based on the preset name
 *
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
     * Creates a new ApplyPresetListener with the specified presets.
     *
     * @param array<string, PresetType> $presets Map of preset names to their configurations
     */
    public function __construct(private array $presets)
    {
    }

    /**
     * Handles persist events by applying presets to envelopes with PresetStamps.
     *
     * @param PersistEvent $event The persist event
     *
     * @throws PresetNotFoundException If a requested preset doesn't exist
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
     * Applies preset settings to an envelope if applicable.
     *
     * This method checks if the envelope has a PresetStamp and if so, applies
     * the corresponding preset configuration.
     *
     * @param Envelope $envelope The envelope to process
     *
     * @throws PresetNotFoundException If the requested preset doesn't exist
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
     * Retrieves preset data with default values for missing fields.
     *
     * @param string $alias The preset key
     *
     * @return PresetType The preset data with defaults for missing fields
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
     * Updates the envelope with the provided preset data.
     *
     * This method applies the preset data to the envelope, but only for fields
     * that aren't already set. Envelope-specific settings take precedence over
     * preset defaults.
     *
     * @param Envelope   $envelope The envelope to update
     * @param PresetType $preset   The preset data to apply
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
