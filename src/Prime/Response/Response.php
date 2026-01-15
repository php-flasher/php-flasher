<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\Notification\Envelope;

final class Response
{
    private string $mainScript = '';

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
     * @param Envelope[]           $envelopes
     * @param array<string, mixed> $context
     */
    public function __construct(private readonly array $envelopes, private readonly array $context)
    {
    }

    /**
     * @param string[] $scripts
     */
    public function addScripts(array $scripts): void
    {
        $this->scripts = $this->addItems($this->scripts, $scripts);
    }

    /**
     * @param string[] $styles
     */
    public function addStyles(array $styles): void
    {
        $this->styles = $this->addItems($this->styles, $styles);
    }

    /**
     * @param array<string, mixed> $options
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

    public function getMainScript(): string
    {
        return $this->mainScript;
    }

    public function setMainScript(string $mainScript): void
    {
        $this->mainScript = $mainScript;
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
     *         metadata: array<string, mixed>,
     *     }>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, array<string, mixed>>,
     *     context: array<string, mixed>,
     * }
     */
    public function toArray(): array
    {
        $envelopes = array_map(static fn (Envelope $envelope): array => $envelope->toArray(), $this->envelopes);

        return [
            'envelopes' => $envelopes,
            'scripts' => $this->scripts,
            'styles' => $this->styles,
            'options' => $this->options,
            'context' => $this->context,
        ];
    }

    /**
     * Adds items to a list, ensuring uniqueness and removing empty values.
     *
     * @param string[] $existingItems The existing list of items
     * @param string[] $newItems      The new items to add
     *
     * @return string[] The combined list with duplicates and empty values removed
     */
    private function addItems(array $existingItems, array $newItems): array
    {
        $items = array_merge($existingItems, $newItems);
        $items = array_filter(array_unique($items));

        return array_values($items);
    }
}
