<?php

namespace App\Infrastructure\Entity;

/**
 * @template T of Entity
 */
abstract class EntityFactory
{
    /**
     * @var class-string<T>
     */
    protected string $entityClass;
    
    /**
     * @param array<mixed> $data
     * @return T
     */
    public function create(array $data = []): Entity
    {
        return $this->make(array_merge($data, ['id' => EntityId::create()]));
    }

    /**
     * @param array<mixed> $data
     * @return T
     */
    public function make(array $data = []): Entity
    {
        $class = $this->entityClass;

        return new $class($data['id'], $data['title']);
    }
}
