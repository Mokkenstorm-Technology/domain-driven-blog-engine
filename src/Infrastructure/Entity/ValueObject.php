<?php

namespace App\Infrastructure\Entity;

use JsonSerializable;

abstract class ValueObject implements JsonSerializable
{
    protected string $value;

    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
