<?php

declare(strict_types=1);

namespace Flasher\Prime\Response;

use Flasher\Prime\Notification\Envelope;

/**
 * Response - Container for notification data ready for presentation.
 *
 * This class encapsulates all the data needed to render notifications in a response,
 * including the notification envelopes themselves, scripts, styles, options, and context.
 * It serves as a data transfer object between the notification storage and presenters.
 *
 * Design patterns:
 * - Data Transfer Object (DTO): Aggregates all data needed for notification rendering
 * - Immutable Collection: Core envelopes and context are immutable while allowing
 *   controlled mutation of presentation resources
 */
final class Response
{
    /**
     * The main script to be included in the response.
     */
    private string $mainScript = '';

    /**
     * Additional JavaScript files to be included in the response.
     *
     * @var string[]
     */
    private array $scripts = [];

    /**
     * CSS stylesheets to be included in the response.
     *
     * @var string[]
     */
    private array $styles = [];

    /**
     * Plugin-specific options organized by plugin alias.
     *
     * @var array<string, array<string, mixed>>
     */
    private array $options = [];

    /**
     * Creates a new Response instance.
     *
     * @param Envelope[]           $envelopes The notification envelopes to present
     * @param array<string, mixed> $context   Additional context for the presentation (e.g., CSP nonces)
     */
    public function __construct(private readonly array $envelopes, private readonly array $context)
    {
    }

    /**
     * Adds JavaScript scripts to the response.
     *
     * This method appends new scripts to the existing list, ensuring uniqueness.
     *
     * @param string[] $scripts The scripts to add
     */
    public function addScripts(array $scripts): void
    {
        $this->scripts = $this->addItems($this->scripts, $scripts);
    }

    /**
     * Adds CSS stylesheets to the response.
     *
     * This method appends new styles to the existing list, ensuring uniqueness.
     *
     * @param string[] $styles The styles to add
     */
    public function addStyles(array $styles): void
    {
        $this->styles = $this->addItems($this->styles, $styles);
    }

    /**
     * Adds or merges options for a specific plugin.
     *
     * This method merges new options with existing ones for the specified alias,
     * creating the entry if it doesn't exist.
     *
     * @param string               $alias   The plugin alias
     * @param array<string, mixed> $options The options to add or merge
     */
    public function addOptions(string $alias, array $options): void
    {
        $options = array_merge($this->options[$alias] ?? [], $options);
        $this->options[$alias] = $options;
    }

    /**
     * Gets the notification envelopes to be presented.
     *
     * @return Envelope[] The notification envelopes
     */
    public function getEnvelopes(): array
    {
        return $this->envelopes;
    }

    /**
     * Gets the main script path.
     *
     * @return string The path to the main JavaScript file
     */
    public function getMainScript(): string
    {
        return $this->mainScript;
    }

    /**
     * Sets the main script path.
     *
     * @param string $mainScript The path to the main JavaScript file
     */
    public function setMainScript(string $mainScript): void
    {
        $this->mainScript = $mainScript;
    }

    /**
     * Gets the CSS stylesheets.
     *
     * @return string[] The stylesheet paths
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * Gets the JavaScript scripts.
     *
     * @return string[] The script paths
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * Gets the plugin-specific options.
     *
     * @return array<string, array<string, mixed>> The options organized by plugin alias
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Gets the presentation context.
     *
     * @return array<string, mixed> The context data
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Converts the response to an array representation.
     *
     * This method transforms all data in the response, including converting notification
     * envelopes to arrays, into a format suitable for serialization or rendering.
     *
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
