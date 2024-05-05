<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Storage\StorageManagerInterface;

trait NotificationStorageMethods
{
    protected readonly StorageManagerInterface $storageManager;

    public function success(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::SUCCESS, $message, $options, $title);
    }

    public function error(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::ERROR, $message, $options, $title);
    }

    public function info(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::INFO, $message, $options, $title);
    }

    public function warning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash(Type::WARNING, $message, $options, $title);
    }

    public function flash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        if (null !== $type) {
            $this->type($type);
        }

        if (null !== $message) {
            $this->message($message);
        }

        if ([] !== $options) {
            $this->options($options);
        }

        if (null !== $title) {
            $this->title($title);
        }

        return $this->push();
    }

    public function preset(string $preset, array $parameters = []): Envelope
    {
        $this->envelope->withStamp(new PresetStamp($preset, $parameters));

        return $this->push();
    }

    public function created(string|object|null $resource = null): Envelope
    {
        return $this->operation('created', $resource);
    }

    public function updated(string|object|null $resource = null): Envelope
    {
        return $this->operation('updated', $resource);
    }

    public function saved(string|object|null $resource = null): Envelope
    {
        return $this->operation('saved', $resource);
    }

    public function deleted(string|object|null $resource = null): Envelope
    {
        return $this->operation('deleted', $resource);
    }

    public function operation(string $operation, string|object|null $resource = null): Envelope
    {
        $resource = match (true) {
            \is_string($resource) => $resource,
            \is_object($resource) => $this->resolveResourceName($resource),
            default => null,
        };

        return $this->preset($operation, [':resource' => $resource ?: 'resource']);
    }

    public function push(): Envelope
    {
        $envelope = $this->getEnvelope();

        $this->storageManager->add($envelope);

        return $envelope;
    }

    private function resolveResourceName(object $object): ?string
    {
        $displayName = \is_callable([$object, 'getFlashIdentifier']) ? $object->getFlashIdentifier() : null;

        return $displayName ?: basename(str_replace('\\', '/', $object::class));
    }
}
