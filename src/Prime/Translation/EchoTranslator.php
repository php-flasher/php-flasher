<?php

namespace Flasher\Prime\Translation;

final class EchoTranslator implements TranslatorInterface
{
    public function translate($id, $parameters = [], $locale = null)
    {
        return $id;
    }

    public function getLocale()
    {
        return 'en';
    }
}
