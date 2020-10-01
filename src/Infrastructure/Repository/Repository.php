<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

use Traversable;

/**
 * @template T of Entity
 */
interface Repository
{
    /**
     * @return Traversable<T>
     */
    public function all(): Traversable;

    /**
     * @return T
     */
    public function find(EntityId $id);

    /**
     * @return T
     */
    public function save(Entity $post);
}
