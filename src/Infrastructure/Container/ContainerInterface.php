<?php

declare(strict_types=1);

namespace App\Infrastructure\Container;

interface ContainerInterface
{
    /**
     * @template T
     * @param class-string<T> $target
     * @return T
     */
    public function make(string $target);

    /**
     * @param class-string $interface
     * @param class-string $class
     */
    public function bind(string $interface, string $class): void;
}
