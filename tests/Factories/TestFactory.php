<?php

namespace Tests\Factories;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\Factory;
use App\Infrastructure\Entity\EntityFactory;

/**
 * @template T
 *
 * @implements Factory<T>
 */
abstract class TestFactory implements Factory
{
    /**
     * @var Factory<T>
     */
    protected Factory $factory;
   
    /**
     * @param array<mixed> $data
     * @return T
     */
    public function make(array $data = []): Entity
    {
        return $this->factory->make($this->fakeData($data));
    }

    abstract protected function fakeData(array $data): array;
}
