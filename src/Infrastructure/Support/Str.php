<?php

namespace App\Infrastructure\Support;

class Str
{
    public static function prefix(string $target, string $prefix): string
    {
        return (substr($target, 0, strlen($prefix)) === $prefix) ? $target: ($prefix . $target);
    }
}
