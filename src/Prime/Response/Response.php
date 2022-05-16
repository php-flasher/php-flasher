<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Prime\Response;

use Flasher\Prime\Notification\Envelope;

final class Response
{
    /**
     * @var Envelope[]
     */
    private $envelopes;

    /**
     * @var string|null
     */
    private $rootScript;

    /**
     * @var string[]
     */
    private $scripts = array();

    /**
     * @var string[]
     */
    private $styles = array();

    /**
     * @var array<string, array<string, mixed>>
     */
    private $options = array();

    /**
     * @var array<string, mixed>
     */
    private $context;

    /**
     * @param Envelope[]           $envelopes
     * @param array<string, mixed> $context
     */
    public function __construct(array $envelopes, array $context)
    {
        $this->envelopes = $envelopes;
        $this->context = $context;
    }

    /**
     * @param string[] $scripts
     *
     * @return void
     */
    public function addScripts(array $scripts)
    {
        $this->scripts = array_merge($this->scripts, $scripts);
    }

    /**
     * @param string[] $styles
     *
     * @return void
     */
    public function addStyles(array $styles)
    {
        $this->styles = array_merge($this->styles, $styles);
    }

    /**
     * @param string               $alias
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function addOptions($alias, array $options)
    {
        $this->options[$alias] = $options;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes()
    {
        return $this->envelopes;
    }

    /**
     * @return string|null
     */
    public function getRootScript()
    {
        return $this->rootScript;
    }

    /**
     * @param string|null $rootScript
     *
     * @return void
     */
    public function setRootScript($rootScript)
    {
        $this->rootScript = $rootScript;
    }

    /**
     * @return string[]
     */
    public function getStyles()
    {
        return array_values(array_filter(array_unique($this->styles)));
    }

    /**
     * @return string[]
     */
    public function getScripts()
    {
        return array_values(array_filter(array_unique($this->scripts)));
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array<string, mixed>
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param mixed $filter
     *
     * @return array<string, mixed>
     */
    public function toArray($filter = false)
    {
        $envelopes = array_map(function (Envelope $envelope) {
            return $envelope->toArray();
        }, $this->getEnvelopes());

        $response = array(
            'envelopes' => $envelopes,
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
        );

        if (false === $filter) {
            return $response;
        }

        return array_filter($response);
    }
}
