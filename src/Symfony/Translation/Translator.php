<?php

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

    public function translate($id, $parameters = [], $locale = null)
    {
        $order = TranslationStamp::parametersOrder($parameters, $locale);
        $parameters = $this->addPrefixedParams($order['parameters']);
        $locale = $order['locale'];

        if (!$this->translator instanceof TranslatorBagInterface) {
            return $this->translator->trans($id, $parameters, 'flasher', $locale);
        }

        $catalogue = $this->translator->getCatalogue($locale);

        foreach (['flasher', 'messages'] as $domain) {
            if ($catalogue->has($id, $domain)) {
                return $this->translator->trans($id, $parameters, $domain, $locale);
            }
        }

        return $id;
    }

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
            if (!str_starts_with($key, ':')) {
                $parameters[':'.$key] = $value;
            }
        }

        return $parameters;
    }
}
