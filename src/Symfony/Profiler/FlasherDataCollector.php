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
     * @phpstan-param ConfigShare $config
     */
    public function __construct(
        private readonly NotificationLoggerListener $logger,
        private readonly array $config,
    ) {
    }

    public function collect(Request $request, Response $response, ?\Throwable $exception = null): void
    {
        // No action needed here since we're collecting data in lateCollect
    }

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
     * @return DataShape|Data<DataShape>
     */
    public function getData(): array|Data
    {
        return $this->data;
    }

    public function getName(): string
    {
        return 'flasher';
    }

    public function reset(): void
    {
        $this->logger->reset();
        parent::reset();
    }

    /**
     * @return NotificationShape[]|Data<NotificationShape>
     */
    public function getDisplayedEnvelopes(): array|Data
    {
        return $this->data['displayed_envelopes'] ?? [];
    }

    /**
     * @return NotificationShape[]|Data<NotificationShape>
     */
    public function getDispatchedEnvelopes(): array|Data
    {
        return $this->data['dispatched_envelopes'] ?? [];
    }

    /**
     * @phpstan-return ConfigShare|Data
     */
    public function getConfig(): array|Data
    {
        return $this->data['config'] ?? [];
    }

    /**
     * @return array{php_flasher: string, php: string, symfony: string}|Data
     */
    public function getVersions(): array|Data
    {
        return $this->data['versions'] ?? [];
    }

    public static function getTemplate(): string
    {
        return '@FlasherSymfony/profiler/flasher.html.twig';
    }
}
