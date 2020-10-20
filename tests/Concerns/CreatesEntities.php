<?php

namespace Tests\Concerns;

use App\Infrastructure\Repository\Repository;
use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;
use App\Infrastructure\Entity\Factory;

trait CreatesEntities
{
    /**
     * @var array<class-string<Entity>, class-string<Factory>>
     */
    private array $factories = [];

    /**
     * @var array<class-string<Entity>, class-string<Repository>>
     */
    private array $repositories = [];

    protected function setupCreatesEntities(): void
    {
        foreach (require(__DIR__ . '/../Factories/.bindings.php') as $entity => $binding) {
            if (isset($binding['factory'])) {
                $this->registerFactory($entity, $binding['factory']);
            }

            if (isset($binding['repository'])) {
                $this->registerRepository($entity, $binding['repository']);
            }
        }
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T> $class
     * @param array<string, mixed> $data
     * @return T
     */
    protected function create(string $class, array $data = []): Entity
    {
        return $this->repository($class)->save($this->make($class, $data));
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T> $class
     * @param array<string, mixed> $data
     * @return T
     */
    protected function make(string $class, array $data = []): Entity
    {
        return $this->factory($class)->make($data);
    }

    protected function save(Entity $entity): void
    {
        $this->repository(get_class($entity))->save($entity);
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T>
     * @return T
     */
    protected function find(string $class, EntityId $id): Entity
    {
        return $this->repository($class)->find($id);
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T> $class
     * @return Repository<T>
     */
    protected function repository(string $class): Repository
    {
        return $this->app->make($this->repositories[$class]);
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T> $class
     * @return Factory<T>
     */
    protected function factory(string $class): Factory
    {
        return $this->app->make($this->factories[$class]);
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T> $class
     * @param class-string<Factory<T>> $factory
     */
    protected function registerFactory(string $class, string $factory): void
    {
        $this->factories[$class] = $factory;
    }

    /**
     * @template T of Entity
     *
     * @param class-string<T> $class
     * @param class-string<Repository<T>> $repository
     */
    protected function registerRepository(string $class, $repository): void
    {
        $this->repositories[$class] = $repository;
    }
}
