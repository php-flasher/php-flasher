<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

use Flasher\Prime\Stamp\PresetStamp;
use Flasher\Prime\Storage\StorageManagerInterface;
use Flasher\Prime\Translation\ResourceInterface;

trait NotificationStorageMethods
{
    private readonly StorageManagerInterface $storageManager;

    public function success(string $message, array $options = [], string $title = null): Envelope
    {
        return $this->flash(Type::SUCCESS, $message, $options, $title);
    }

    public function error(string $message, array $options = [], string $title = null): Envelope
    {
        return $this->flash(Type::ERROR, $message, $options, $title);
    }

    public function info(string $message, array $options = [], string $title = null): Envelope
    {
        return $this->flash(Type::INFO, $message, $options, $title);
    }

    public function warning(string $message, array $options = [], string $title = null): Envelope
    {
        return $this->flash(Type::WARNING, $message, $options, $title);
    }

    public function flash(string $type = null, string $message = null, array $options = [], string $title = null): Envelope
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

    public function created(string|object $resource = null): Envelope
    {
        return $this->operation('created', $resource);
    }

    public function updated(string|object $resource = null): Envelope
    {
        return $this->operation('updated', $resource);
    }

    public function saved(string|object $resource = null): Envelope
    {
        return $this->operation('saved', $resource);
    }

    public function deleted(string|object $resource = null): Envelope
    {
        return $this->operation('deleted', $resource);
    }

    public function operation(string $operation, string|object $resource = null): Envelope
    {
        if ($resource instanceof ResourceInterface) {
            $type = $resource->getResourceType();
            $name = $resource->getResourceName();

            $resource = sprintf(
                '%s %s',
                $type,
                '' === $name ? '' : sprintf('"%s"', $name)
            );
        }

        $parameters = [
            'resource' => $resource ?: 'resource',
        ];

        return $this->preset($operation, $parameters);
    }

    public function push(): Envelope
    {
        $envelope = $this->getEnvelope();

        $this->storageManager->add($envelope);

        return $envelope;
    }
}
