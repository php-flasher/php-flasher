<?php

declare(strict_types=1);

namespace Flasher\Symfony\Translation;

use Flasher\Prime\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatorBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface as SymfonyTranslatorInterface;

final class Translator implements TranslatorInterface
{
    public function __construct(private readonly SymfonyTranslatorInterface $translator)
    {
    }

    public function translate(string $id, array $parameters = [], string $locale = null): string
    {
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

    public function getLocale(): string
    {
        return $this->translator->getLocale();
    }
}
