<?php

namespace App\Infrastructure\Exception;

use Exception;

class ShouldNotHappen extends Exception
{
    public static function throw(string $message, string ...$args): void
    {
        throw new self(sprintf($message, ...$args));
    }
}
