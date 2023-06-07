<?php

declare(strict_types=1);

namespace Flasher\Cli\Prime;

use Flasher\Cli\Prime\Notifier\BaseNotifier;
use Flasher\Cli\Prime\System\Path;
use Flasher\Prime\Notification\NotificationInterface;

final class Notify extends BaseNotifier
{
    private ?\Flasher\Cli\Prime\NotifyInterface $notifier = null;

    /**
     * @var NotifyInterface[]
     */
    private array $notifiers = [];

    /**
     * @var NotifyInterface[]
     */
    private array $sorted = [];

    private ?bool $isSupported = null;

    /**
     * @var array{success?: string, error?: string, info?: string, warning?: string}
     */
    private array $icons = [];

    /**
     * @param  array{success?: string, error?: string, info?: string, warning?: string}|string  $icons
     */
    public function __construct(private readonly ?string $title = 'PHPFlasher', $icons = [])
    {
        $this->icons = $this->configureIcons($icons);

        $this->addNotifier(new Notifier\NotifySendBaseNotifier());
        $this->addNotifier(new Notifier\AppleScriptBaseNotifier());
        $this->addNotifier(new Notifier\GrowlNotifyBaseNotifier());
        $this->addNotifier(new Notifier\KDialogBaseNotifier());
        $this->addNotifier(new Notifier\NotifuBaseNotifier());
        $this->addNotifier(new Notifier\SnoreToastBaseNotifier());
        $this->addNotifier(new Notifier\TerminalNotifierBaseNotifier());
        $this->addNotifier(new Notifier\ToasterBaseNotifier());
        $this->addNotifier(new Notifier\ZenityBaseNotifier());
    }

    /**
     * @param  string|null  $title
     * @param  array{success?: string, error?: string, info?: string, warning?: string}|string  $icons
     * @return static
     */
    public static function create($title = null, $icons = []): self
    {
        return new self($title, $icons);
    }

    public function send($notification): void
    {
        $notification = $this->configureNotification($notification);

        $notifier = $this->createNotifier();
        $notifier->send($notification);
    }

    public function addNotifier(NotifyInterface $notifier): void
    {
        $this->notifiers[] = $notifier;
        $this->reset();
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function isSupported(): bool
    {
        if (null !== $this->isSupported) {
            return $this->isSupported;
        }

        if ($this->notifier instanceof NotifyInterface) {
            return true;
        }

        foreach ($this->getNotifiers() as $notifier) {
            if ($notifier->isSupported()) {
                return $this->isSupported = true;
            }
        }

        return false;
    }

    private function reset(): void
    {
        $this->notifier = null;
        $this->sorted = [];
        $this->isSupported = null;
    }

    /**
     * @return NotifyInterface[]
     */
    private function getNotifiers(): array
    {
        if ([] !== $this->sorted) {
            return $this->sorted;
        }

        $this->sorted = $this->notifiers;

        usort($this->sorted, static function (NotifyInterface $a, NotifyInterface $b): int {
            $priorityA = $a->getPriority();
            $priorityB = $b->getPriority();

            return $priorityB <=> $priorityA;
        });

        return $this->sorted;
    }

    /**
     * @return NotifyInterface
     */
    private function createNotifier()
    {
        if ($this->notifier instanceof NotifyInterface) {
            return $this->notifier;
        }

        foreach ($this->getNotifiers() as $notifier) {
            if ($notifier->isSupported()) {
                return $this->notifier = $notifier;
            }
        }

        return new Notifier\NullBaseNotifier();
    }

    /**
     * @param  array{success?: string, error?: string, info?: string, warning?: string}|string  $icons
     * @return array<'default'|'error'|'info'|'success'|'warning', string>
     */
    private function configureIcons($icons = []): array
    {
        $icons = $icons ?: [];

        if (! \is_array($icons)) {
            $icons = [
                NotificationInterface::SUCCESS => $icons,
                NotificationInterface::ERROR => $icons,
                NotificationInterface::INFO => $icons,
                NotificationInterface::WARNING => $icons,
                'default' => $icons,
            ];
        }

        return array_merge([
            NotificationInterface::SUCCESS => Path::realpath(__DIR__.'/Resources/icons/success.png'),
            NotificationInterface::ERROR => Path::realpath(__DIR__.'/Resources/icons/error.png'),
            NotificationInterface::INFO => Path::realpath(__DIR__.'/Resources/icons/info.png'),
            NotificationInterface::WARNING => Path::realpath(__DIR__.'/Resources/icons/warning.png'),
            'default' => Path::realpath(__DIR__.'/Resources/icons/info.png'),
        ], $icons);
    }

    /**
     * @param  Notification|string  $notification
     * @return Notification
     */
    private function configureNotification($notification)
    {
        $notification = Notification::wrap($notification);

        if (null === $notification->getTitle()) {
            $notification->setTitle($this->title);
        }

        if (null === $notification->getIcon() && isset($this->icons[$notification->getType()])) {
            $notification->setIcon($this->icons[$notification->getType()]);
        }

        if (null === $notification->getIcon()) {
            $notification->setIcon($this->icons['default']); // @phpstan-ignore-line
        }

        return $notification;
    }
}
