<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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
    public function __construct($parameters = array(), $locale = null)
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

    /**
     * @param mixed      $parameters
     * @param mixed|null $locale
     *
     * @return array{parameters: array<string, mixed>, locale: string|null}
     */
    public static function parametersOrder($parameters = array(), $locale = null)
    {
        if (\is_string($parameters)) {
            $locale = $parameters;
            $parameters = array();

            @trigger_error('Since php-flasher/flasher v1.4, passing the locale as first parameter is deprecated and will be removed in v2.0. Use the second parameter instead.', \E_USER_DEPRECATED);
        }

        return array('parameters' => $parameters, 'locale' => $locale); // @phpstan-ignore-line
    }
}
