<?php

namespace Flasher\Prime\Translation;

final class EchoTranslator implements TranslatorInterface
{
    /**
     * @inheritDoc
     */
    public function translate($id, $locale = null)
    {
        return $id;
    }

    /**
     * @inheritDoc
     */
    public function getLocale()
    {
        return 'en';
    }
}
