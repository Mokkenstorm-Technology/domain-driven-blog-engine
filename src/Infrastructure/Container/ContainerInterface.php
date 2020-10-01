<?php

declare(strict_types=1);

namespace App\Infrastructure\Container;

interface ContainerInterface
{
    /**
     * @template T
     *
     * @param class-string<T> $target
     * @return T
     */
    public function make(string $target);

    /**
     * @template T
     *
     * @param class-string<T> $interface
     * @param class-string<T> | callable(): T $class
     */
    public function bind(string $interface, $class): void;
}
