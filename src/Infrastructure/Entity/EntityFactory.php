<?php

namespace App\Infrastructure\Entity;

use App\Infrastructure\Support\Collection\Collection;

/**
 * @template T of Entity
 * @implements Factory<T>
 */
abstract class EntityFactory implements Factory
{
    /**
     * @param array<mixed> $data
     * @return T
     */
    abstract public function make(array $data = []): Entity;

    /**
     * @template S of Entity
     *
     * @param Factory<S>    $factory
     * @param array<mixed>  $data
     *
     * @return Collection<int, S>
     */
    protected function children(Factory $factory, array $data): Collection
    {
        return Collection::from(array_values(array_map([$factory, 'make'], $data)));
    }
}
