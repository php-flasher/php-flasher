<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\Notification\Envelope;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Prime\Translation\Language;
use Flasher\Prime\Translation\TranslatorInterface;

/**
 * TranslationListener - Applies translations to notifications during presentation.
 *
 * This listener is responsible for translating notification titles and messages
 * before they are displayed to users. It also sets RTL mode for right-to-left
 * languages and translates preset parameters.
 *
 * Design patterns:
 * - Decorator: Adds translation functionality to notifications
 * - Strategy: Uses pluggable translation strategies via TranslatorInterface
 */
final readonly class TranslationListener implements EventListenerInterface
{
    /**
     * The translator to use for translating notification content.
     */
    private TranslatorInterface $translator;

    /**
     * Creates a new TranslationListener instance.
     *
     * If no translator is provided, falls back to the EchoTranslator which simply
     * returns the input strings unchanged.
     *
     * @param TranslatorInterface|null $translator The translator to use
     */
    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator ?: new EchoTranslator();
    }

    /**
     * Handles presentation events by translating all notifications.
     *
     * @param PresentationEvent $event The presentation event
     */
    public function __invoke(PresentationEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->translateEnvelope($envelope);
        }
    }

    public function getSubscribedEvents(): string
    {
        return PresentationEvent::class;
    }

    /**
     * Translates a notification envelope.
     *
     * This method:
     * 1. Determines the appropriate locale
     * 2. Gathers translation parameters
     * 3. Applies translations to title and message
     * 4. Sets RTL mode if needed
     *
     * @param Envelope $envelope The notification envelope to translate
     */
    private function translateEnvelope(Envelope $envelope): void
    {
        $translationStamp = $envelope->get(TranslationStamp::class);

        $locale = $translationStamp?->getLocale() ?: $this->translator->getLocale();

        $parameters = $translationStamp?->getParameters() ?: [];
        $parameters = array_merge($parameters, $this->getParameters($envelope, $locale));

        $this->applyTranslations($envelope, $locale, $parameters);

        if (Language::isRTL($locale)) {
            $envelope->setOption('rtl', true);
        }
    }

    /**
     * Extracts and translates parameters from preset stamps.
     *
     * @param Envelope $envelope The notification envelope
     * @param string   $locale   The locale to use
     *
     * @return array<string, mixed> The translated parameters
     *
     * @throws \InvalidArgumentException If a parameter value is not a string
     */
    private function getParameters(Envelope $envelope, string $locale): array
    {
        $preset = $envelope->get(PresetStamp::class);
        if (!$preset instanceof PresetStamp) {
            return [];
        }

        $parameters = [];

        foreach ($preset->getParameters() as $key => $value) {
            if (!\is_string($value)) {
                throw new \InvalidArgumentException(\sprintf('Value must be "string", got "%s".', get_debug_type($value)));
            }

            $parameters[$key] = $this->translator->translate($value, $parameters, $locale);
        }

        return $parameters;
    }

    /**
     * Applies translations to the notification title and message.
     *
     * If the title is empty, the notification type is used as a fallback.
     *
     * @param Envelope             $envelope   The notification envelope
     * @param string               $locale     The locale to use
     * @param array<string, mixed> $parameters The translation parameters
     */
    private function applyTranslations(Envelope $envelope, string $locale, array $parameters): void
    {
        $title = $envelope->getTitle() ?: $envelope->getType();
        if ('' !== $title) {
            $envelope->setTitle($this->translator->translate($title, $parameters, $locale));
        }

        $message = $envelope->getMessage();
        if ('' !== $message) {
            $envelope->setMessage($this->translator->translate($message, $parameters, $locale));
        }
    }
}
