<?php

declare(strict_types=1);

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Prime\Translation\Language;
use Flasher\Prime\Translation\TranslatorInterface;

final class TranslationListener implements EventListenerInterface
{
    private readonly TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator = null,
        private readonly bool $autoTranslate = true,
    ) {
        $this->translator = $translator ?: new EchoTranslator();
    }

    public function __invoke(PresentationEvent $event): void
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $stamp = $envelope->get(TranslationStamp::class);
            if (! $stamp instanceof TranslationStamp && ! $this->autoTranslate) {
                continue;
            }

            $locale = $stamp instanceof TranslationStamp && $stamp->getLocale()
                ? $stamp->getLocale()
                : $this->translator->getLocale();

            $parameters = $stamp instanceof TranslationStamp && $stamp->getParameters()
                ? $stamp->getParameters()
                : [];

            $preset = $envelope->get(PresetStamp::class);
            if ($preset instanceof PresetStamp) {
                foreach ($preset->getParameters() as $key => $value) {
                    $parameters[$key] = $this->translator->translate($value, $parameters, $locale);
                }
            }

            $title = $envelope->getTitle() ?: $envelope->getType();
            if ('' !== $title) {
                $title = $this->translator->translate($title, $parameters, $locale);
                $envelope->setTitle($title);
            }

            $message = $envelope->getMessage();
            if ('' !== $message) {
                $message = $this->translator->translate($message, $parameters, $locale);
                $envelope->setMessage($message);
            }

            if (Language::isRTL($locale)) {
                $envelope->setOption('rtl', true);
            }
        }
    }

    public static function getSubscribedEvents(): string
    {
        return PresentationEvent::class;
    }
}
