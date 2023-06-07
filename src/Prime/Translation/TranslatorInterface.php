<?php

namespace Flasher\Prime\Translation;

interface TranslatorInterface
{
    /**
     * @param string               $id
     * @param array<string, mixed> $parameters
     * @param string|null          $locale
     *
     * @return string
     */
    public function translate($id, $parameters = [], $locale = null);

    /**
     * @return string
     */
    public function getLocale();
}
