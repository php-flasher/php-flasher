<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

trait NotificationMethodAliases
{
    public function addSuccess(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->success($message, $options, $title);
    }

    public function addError(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->error($message, $options, $title);
    }

    public function addInfo(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->info($message, $options, $title);
    }

    public function addWarning(string $message, array $options = [], ?string $title = null): Envelope
    {
        return $this->warning($message, $options, $title);
    }

    public function addFlash(?string $type = null, ?string $message = null, array $options = [], ?string $title = null): Envelope
    {
        return $this->flash($type, $message, $options, $title);
    }

    public function addPreset(string $preset, array $parameters = []): Envelope
    {
        return $this->preset($preset, $parameters);
    }

    public function addCreated(string|object|null $resource = null): Envelope
    {
        return $this->created($resource);
    }

    public function addUpdated(string|object|null $resource = null): Envelope
    {
        return $this->updated($resource);
    }

    public function addSaved(string|object|null $resource = null): Envelope
    {
        return $this->saved($resource);
    }

    public function addDeleted(string|object|null $resource = null): Envelope
    {
        return $this->deleted($resource);
    }

    public function addOperation(string $operation, string|object|null $resource = null): Envelope
    {
        return $this->operation($operation, $resource);
    }
}
