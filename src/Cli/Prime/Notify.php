<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Cli\Prime;

use Flasher\Cli\Prime\Notifier\BaseNotifier;
use Flasher\Cli\Prime\System\Path;
use Flasher\Prime\Notification\NotificationInterface;

final class Notify extends BaseNotifier
{
    /**
     * @var NotifyInterface|null
     */
    private $notifier;

    /**
     * @var NotifyInterface[]
     */
    private $notifiers = array();

    /**
     * @var NotifyInterface[]
     */
    private $sorted = array();

    /**
     * @var bool|null
     */
    private $isSupported;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var array{success?: string, error?: string, info?: string, warning?: string}
     */
    private $icons = array();

    /**
     * @param string|null                                                                     $title
     * @param array{success?: string, error?: string, info?: string, warning?: string}|string $icons
     */
    public function __construct($title = 'PHP Flasher', $icons = array())
    {
        $this->title = $title;
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
     * @param string|null                                                                     $title
     * @param array{success?: string, error?: string, info?: string, warning?: string}|string $icons
     *
     * @return static
     */
    public static function create($title = null, $icons = array())
    {
        return new self($title, $icons);
    }

    /**
     * {@inheritdoc}
     */
    public function send($notification)
    {
        $notification = $this->configureNotification($notification);

        $notifier = $this->createNotifier();
        $notifier->send($notification);
    }

    /**
     * @return void
     */
    public function addNotifier(NotifyInterface $notifier)
    {
        $this->notifiers[] = $notifier;
        $this->reset();
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
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

    /**
     * @return void
     */
    private function reset()
    {
        $this->notifier = null;
        $this->sorted = array();
        $this->isSupported = null;
    }

    /**
     * @return NotifyInterface[]
     */
    private function getNotifiers()
    {
        if (array() !== $this->sorted) {
            return $this->sorted;
        }

        $this->sorted = $this->notifiers;

        usort($this->sorted, static function (NotifyInterface $a, NotifyInterface $b) {
            $priorityA = $a->getPriority();
            $priorityB = $b->getPriority();

            if ($priorityA === $priorityB) {
                return 0;
            }

            return $priorityA < $priorityB ? 1 : -1;
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
     * @param array{success?: string, error?: string, info?: string, warning?: string}|string $icons
     *
     * @return array<'default'|'error'|'info'|'success'|'warning', string>
     */
    private function configureIcons($icons = array())
    {
        $icons = $icons ?: array();

        if (!\is_array($icons)) {
            $icons = array(
                NotificationInterface::SUCCESS => $icons,
                NotificationInterface::ERROR => $icons,
                NotificationInterface::INFO => $icons,
                NotificationInterface::WARNING => $icons,
                'default' => $icons,
            );
        }

        return array_merge(array(
            NotificationInterface::SUCCESS => Path::realpath(__DIR__.'/Resources/icons/success.png'),
            NotificationInterface::ERROR => Path::realpath(__DIR__.'/Resources/icons/error.png'),
            NotificationInterface::INFO => Path::realpath(__DIR__.'/Resources/icons/info.png'),
            NotificationInterface::WARNING => Path::realpath(__DIR__.'/Resources/icons/warning.png'),
            'default' => Path::realpath(__DIR__.'/Resources/icons/info.png'),
        ), $icons);
    }

    /**
     * @param Notification|string $notification
     *
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
