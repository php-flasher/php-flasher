<?php

namespace App\Entity;

readonly class Book
{
    public function __construct(private string $title)
    {

    }
    public function getFlashIdentifier(): string
    {
        return sprintf('"%s" book', $this->title);
    }
}
