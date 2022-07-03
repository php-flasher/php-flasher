<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\EventDispatcher\EventListener;

use Flasher\Prime\EventDispatcher\Event\PresentationEvent;
use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\EchoTranslator;
use Flasher\Prime\Translation\Language;
use Flasher\Prime\Translation\TranslatorInterface;

final class TranslationListener implements EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var bool
     */
    private $autoTranslate;

    /**
     * @param bool $autoTranslate
     */
    public function __construct(TranslatorInterface $translator = null, $autoTranslate = true)
    {
        $this->translator = $translator ?: new EchoTranslator();
        $this->autoTranslate = $autoTranslate;
    }

    /**
     * @return void
     */
    public function __invoke(PresentationEvent $event)
    {
        foreach ($event->getEnvelopes() as $envelope) {
            $stamp = $envelope->get('Flasher\Prime\Stamp\TranslationStamp');
            if (!$stamp instanceof TranslationStamp && !$this->autoTranslate) {
                continue;
            }

            $locale = $stamp instanceof TranslationStamp && $stamp->getLocale()
                ? $stamp->getLocale()
                : $this->translator->getLocale();

            $parameters = $stamp instanceof TranslationStamp && $stamp->getParameters()
                ? $stamp->getParameters()
                : array();

            $preset = $envelope->get('Flasher\Prime\Stamp\PresetStamp');
            if ($preset instanceof PresetStamp) {
                foreach ($preset->getParameters() as $key => $value) {
                    $parameters[$key] = $this->translator->translate($value, $parameters, $locale); // @phpstan-ignore-line
                }
            }

            $title = $envelope->getTitle() ?: $envelope->getType();
            if (null !== $title) {
                $title = $this->translator->translate($title, $parameters, $locale);
                $envelope->setTitle($title);
            }

            $message = $envelope->getMessage();
            if (null !== $message) {
                $message = $this->translator->translate($message, $parameters, $locale);
                $envelope->setMessage($message);
            }

            if (Language::isRTL($locale)) {
                $envelope->setOption('rtl', true);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return 'Flasher\Prime\EventDispatcher\Event\PresentationEvent';
    }
}
