<?php

declare(strict_types=1);

namespace Flasher\Symfony\Profiler;

use Flasher\Prime\EventDispatcher\EventListener\NotificationLoggerListener;
use Flasher\Prime\Flasher;
use Flasher\Prime\Notification\Envelope;
use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * FlasherDataCollector - Collects PHPFlasher data for the Symfony profiler.
 *
 * This data collector captures information about PHPFlasher notifications,
 * both dispatched and displayed, for the Symfony web profiler. It also collects
 * configuration and version information.
 *
 * Design patterns:
 * - Data Collector: Implements Symfony's data collector pattern for profiling
 * - Late Collection: Collects data after a request is completed
 * - Type Safety: Uses PHPDoc annotations for complex type declarations
 *
 * @phpstan-type NotificationShape array{
 *     title: string,
 *     message: string,
 *     type: string,
 *     options: array<string, mixed>,
 *     metadata: array<string, mixed>,
 * }
 * @phpstan-type ConfigShare array{
 *     default: string,
 *     main_script: string,
 *     inject_assets: bool,
 *     excluded_paths: list<non-empty-string>,
 *     presets: array<string, mixed>,
 *     flash_bag: array<string, mixed>,
 *     filter: array{limit?: int|null},
 *     plugins: array<array<string, mixed>>,
 * }
 * @phpstan-type DataShape array{
 *     displayed_envelopes: NotificationShape[],
 *     dispatched_envelopes: NotificationShape[],
 *     config: array<string, mixed>,
 *     versions: array{
 *         php_flasher: string,
 *         php: string,
 *         symfony: string
 *     }
 * }
 *
 * @property DataShape|Data<DataShape> $data
 *
 * @internal
 */
#[\AllowDynamicProperties]
final class FlasherDataCollector extends AbstractDataCollector implements LateDataCollectorInterface
{
    /**
     * Creates a new FlasherDataCollector instance.
     *
     * @param NotificationLoggerListener $logger The notification logger for accessing dispatched notifications
     * @param array<string, mixed>       $config The PHPFlasher configuration
     *
     * @phpstan-param ConfigShare $config
     */
    public function __construct(
        private readonly NotificationLoggerListener $logger,
        private readonly array $config,
    ) {
    }

    /**
     * Initial data collection - called during request processing.
     *
     * This implementation doesn't collect data here, deferring to lateCollect.
     *
     * @param Request         $request   The request object
     * @param Response        $response  The response object
     * @param \Throwable|null $exception Any exception that occurred
     */
    public function collect(Request $request, Response $response, ?\Throwable $exception = null): void
    {
        // No action needed here since we're collecting data in lateCollect
    }

    /**
     * Late data collection - called after response is sent.
     *
     * Collects information about notifications, configuration, and versions.
     */
    public function lateCollect(): void
    {
        $this->data = [
            'displayed_envelopes' => array_map(fn (Envelope $envelope) => $envelope->toArray(), $this->logger->getDisplayedEnvelopes()->getEnvelopes()),
            'dispatched_envelopes' => array_map(fn (Envelope $envelope) => $envelope->toArray(), $this->logger->getDispatchedEnvelopes()->getEnvelopes()),
            'config' => $this->config,
            'versions' => [
                'php_flasher' => Flasher::VERSION,
                'php' => \PHP_VERSION,
                'symfony' => Kernel::VERSION,
            ],
        ];

        $this->data = $this->cloneVar($this->data);
    }

    /**
     * Gets the collector data.
     *
     * @return DataShape|Data<DataShape>
     */
    public function getData(): array|Data
    {
        return $this->data;
    }

    /**
     * Gets the collector name for the profiler panel.
     *
     * @return string The collector name
     */
    public function getName(): string
    {
        return 'flasher';
    }

    /**
     * Resets the collector between requests when using kernel.reset.
     */
    public function reset(): void
    {
        $this->logger->reset();
        parent::reset();
    }

    /**
     * Gets the displayed notification envelopes.
     *
     * @return NotificationShape[]|Data<NotificationShape>
     */
    public function getDisplayedEnvelopes(): array|Data
    {
        return $this->data['displayed_envelopes'] ?? [];
    }

    /**
     * Gets the dispatched notification envelopes.
     *
     * @return NotificationShape[]|Data<NotificationShape>
     */
    public function getDispatchedEnvelopes(): array|Data
    {
        return $this->data['dispatched_envelopes'] ?? [];
    }

    /**
     * Gets the PHPFlasher configuration.
     *
     * @phpstan-return ConfigShare|Data
     */
    public function getConfig(): array|Data
    {
        return $this->data['config'] ?? [];
    }

    /**
     * Gets version information.
     *
     * @return array{php_flasher: string, php: string, symfony: string}|Data
     */
    public function getVersions(): array|Data
    {
        return $this->data['versions'] ?? [];
    }

    /**
     * Gets the template path for the profiler panel.
     *
     * @return string The template path
     */
    public static function getTemplate(): string
    {
        return '@FlasherSymfony/profiler/flasher.html.twig';
    }
}
