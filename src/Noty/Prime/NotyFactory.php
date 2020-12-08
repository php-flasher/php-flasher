<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Factory\AbstractFactory;
use Flasher\Prime\Notification\NotificationBuilderInterface;
use Flasher\Prime\Stamp\StampInterface;

/**
 * @method NotyBuilder type(string $type, string $message = null, array $options = array())
 * @method NotyBuilder message(string $message)
 * @method NotyBuilder options(array $options, bool $merge = true)
 * @method NotyBuilder setOption(string $name, $value)
 * @method NotyBuilder unsetOption(string $name)
 * @method NotyBuilder priority(int $priority)
 * @method NotyBuilder handler(string $handler)
 * @method NotyBuilder with(StampInterface[] $stamps)
 * @method NotyBuilder withStamp(StampInterface $stamp)
 * @method NotyBuilder hops(int $amount)
 * @method NotyBuilder keep()
 * @method NotyBuilder success(string $message = null, array $options = array())
 * @method NotyBuilder error(string $message = null, array $options = array())
 * @method NotyBuilder info(string $message = null, array $options = array())
 * @method NotyBuilder warning(string $message = null, array $options = array())
 */
final class NotyFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function createNotification()
    {
        return new Noty();
    }

    /**
     * @inheritDoc
     */
    public function createNotificationBuilder()
    {
        return new NotyBuilder($this->getStorageManager(), $this->createNotification(), 'noty');
    }

    /**
     * @inheritDoc
     */
    public function supports($name = null, array $context = array())
    {
        return in_array($name, array(__CLASS__, 'noty'));
    }
}
