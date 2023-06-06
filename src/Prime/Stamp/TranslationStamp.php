<?php

namespace Flasher\Prime\Stamp;

final class TranslationStamp implements StampInterface
{
    /**
     * @var array<string, mixed>
     */
    private $parameters;

    /**
     * @var string|null
     */
    private $locale;

    /**
     * @param array<string, mixed> $parameters
     * @param string|null          $locale
     */
    public function __construct($parameters = [], $locale = null)
    {
        $order = self::parametersOrder($parameters, $locale);
        $parameters = $order['parameters'];
        $locale = $order['locale'];

        $this->parameters = $parameters;
        $this->locale = $locale;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
