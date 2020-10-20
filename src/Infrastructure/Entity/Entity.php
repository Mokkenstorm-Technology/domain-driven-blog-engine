<?php

namespace App\Infrastructure\Entity;

use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    protected EntityId $id;

    /**
     * @var string[]
     */
    protected array $fields = [];

    public function __construct(EntityId $id)
    {
        $this->id = $id;
    }

    public function getId(): EntityId
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return array_reduce(
            array_merge($this->fields, ['id']),
            fn (array $accumulator, string $field): array =>
                $accumulator + [ $field => $this->{$field} ],
            []
        );
    }

    public function equals(Entity $entity): bool
    {
        return get_class($entity) === static::class && $entity->getId() == $this->getId();
    }
}
