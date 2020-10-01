<?php

namespace App\Infrastructure\Entity;

use JsonSerializable;

class EntityId implements JsonSerializable
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function create(): self
    {
        return new self((string)md5((string)rand(1, 10000)));
    }

    public static function make(string $value): self
    {
        return new self($value);
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
