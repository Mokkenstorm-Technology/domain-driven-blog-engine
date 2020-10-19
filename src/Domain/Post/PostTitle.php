<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\ValueObject;

class PostTitle extends ValueObject
{
    protected string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return new self($value);
    }
}
