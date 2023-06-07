<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\Notification\Envelope;

final class Response
{
    private string $rootScript = '';

    /**
     * @var string[]
     */
    private array $scripts = [];

    /**
     * @var string[]
     */
    private array $styles = [];

    /**
     * @var array<string, array<string, mixed>>
     */
    private array $options = [];

    /**
     * @param  Envelope[]  $envelopes
     * @param  array<string, mixed>  $context
     */
    public function __construct(
        private readonly array $envelopes,
        private readonly array $context,
    ) {
    }

    /**
     * @param  string[]  $scripts
     */
    public function addScripts(array $scripts): void
    {
        $scripts = array_merge($this->scripts, $scripts);
        $scripts = array_filter(array_unique($scripts));
        $this->scripts = array_values($scripts);
    }

    /**
     * @param  string[]  $styles
     */
    public function addStyles(array $styles): void
    {
        $styles = array_merge($this->styles, $styles);
        $styles = array_filter(array_unique($styles));
        $this->styles = array_values($styles);
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function addOptions(string $alias, array $options): void
    {
        $options = array_merge($this->options[$alias] ?? [], $options);
        $this->options[$alias] = $options;
    }

    /**
     * @return Envelope[]
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    public function getRootScript(): string
    {
        return $this->rootScript;
    }

    public function setRootScript(string $rootScript): void
    {
        $this->rootScript = $rootScript;
    }

    /**
     * @return string[]
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @return string[]
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return array<string, mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return array{
     *     envelopes: array<array{
     *         title: string,
     *         message: string,
     *         type: string,
     *         options: array<string, mixed>,
     *         stamps: array<string, mixed>,
     *     }>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, array<string, mixed>>,
     *     context: array<string, mixed>,
     * }
     */
    public function toArray(): array
    {
        $envelopes = array_map(static fn (Envelope $envelope): array => $envelope->toArray(), $this->getEnvelopes());

        return [
            'envelopes' => $envelopes,
            'scripts' => $this->getScripts(),
            'styles' => $this->getStyles(),
            'options' => $this->getOptions(),
            'context' => $this->getContext(),
        ];
    }
}
