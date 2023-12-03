<?php

declare(strict_types=1);

namespace Flasher\Prime\Notification;

final class Type implements \Stringable
{
    private function __construct(private readonly string $type)
    {
    }

    public static function from(string|self $type): self
    {
        return $type instanceof self ? $type : new self($type);
    }

    public static function success(): self
    {
        return self::from('success');
    }

    public static function error(): self
    {
        return self::from('error');
    }

    public static function info(): self
    {
        return self::from('info');
    }

    public static function warning(): self
    {
        return self::from('warning');
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function equals(Type $otherType): bool
    {
        return $this->type === $otherType->type;
    }
}
