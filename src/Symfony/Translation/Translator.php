<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Translation;

use Flasher\Prime\Stamp\TranslationStamp;
use Flasher\Prime\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

final class Translator implements TranslatorInterface
{
    /**
     * @var SymfonyTranslatorInterface
     */
    private $translator;

    /**
     * @param SymfonyTranslatorInterface $translator
     */
    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function translate($id, $parameters = array(), $locale = null)
    {
        $order = TranslationStamp::parametersOrder($parameters, $locale);
        $parameters = $this->addPrefixedParams($order['parameters']);
        $locale = $order['locale'];

        if (!$this->translator instanceof TranslatorBagInterface) {
            return $this->translator->trans($id, $parameters, 'flasher', $locale);
        }

        $catalogue = $this->translator->getCatalogue($locale);

        foreach (array('flasher', 'messages') as $domain) {
            if ($catalogue->has($id, $domain)) {
                return $this->translator->trans($id, $parameters, $domain, $locale);
            }
        }

        return $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getLocale()
    {
        return $this->translator->getLocale();
    }

    /**
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    private function addPrefixedParams(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (0 !== strpos($key, ':')) {
                $parameters[':'.$key] = $value;
            }
        }

        return $parameters;
    }
}
