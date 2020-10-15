<?php

namespace Tests\Factories;

use App\Domain\Post\PostFactory;
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
     * @var class-string<T>
     */
    protected string $entityClass;

    /**
     * @var Factory<T>
     */
    private Factory $factory;

    public function __construct(PostFactory $factory)
    {
        $this->factory = $factory;
    }
   
    /**
     * @param array<mixed> $data
     * @return T
     */
    public function create(array $data = []): Entity
    {
        return $this->factory->create($this->fakeData($data));
    }

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
