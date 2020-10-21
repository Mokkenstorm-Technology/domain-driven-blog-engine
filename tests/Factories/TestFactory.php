<?php

namespace Tests\Factories;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\Factory;
use App\Infrastructure\Entity\EntityFactory;

use App\Infrastructure\Container\Container;

/**
 * @template T
 *
 * @implements Factory<T>
 */
abstract class TestFactory implements Factory
{
    /**
     * @var class-string<Factory<T>>
     */
    protected string $factoryClass;

    /**
     * @var Factory<T>
     */
    private Factory $factory;

    public function __construct(Container $container)
    {
        $this->factory = $container->make($this->factoryClass);
    }

    /**
     * @param array<string, mixed> $data
     * @return T
     */
    public function make(array $data = []): Entity
    {
        return $this->factory->make(array_merge($this->fakeData(), $data));
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function fakeData(): array;
}
