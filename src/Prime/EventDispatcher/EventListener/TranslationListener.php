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
 * Listener responsible for applying translations to envelopes during presentation events based on TranslationStamps and locale settings.
 */
final class TranslationListener implements EventListenerInterface
{
    private readonly TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator = null)
    {
        $this->translator = $translator ?: new EchoTranslator();
    }

    public function __invoke(PresentationEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $this->translateEnvelope($envelope);
        }
    }

    public static function getSubscribedEvents(): string
    {
        return PresentationEvent::class;
    }

    private function translateEnvelope(Envelope $envelope): void
    {
        $stamp = $envelope->get(TranslationStamp::class);
        if (!$stamp instanceof TranslationStamp) {
            return;
        }

        $locale = $stamp->getLocale() ?: $this->translator->getLocale();
        $parameters = $stamp->getParameters() ?: $this->getParameters($envelope, $locale);

        $this->applyTranslations($envelope, $locale, $parameters);

        if (Language::isRTL($locale)) {
            $envelope->setOption('rtl', true);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function getParameters(Envelope $envelope, string $locale): array
    {
        $preset = $envelope->get(PresetStamp::class);
        if (!$preset instanceof PresetStamp) {
            return [];
        }

        $parameters = [];

        foreach ($preset->getParameters() as $key => $value) {
            $parameters[$key] = $this->translator->translate($value, $parameters, $locale);
        }

        return $parameters;
    }

    /**
     * @param array<string, mixed> $parameters
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
