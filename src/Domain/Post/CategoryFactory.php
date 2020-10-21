<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\EntityFactory;
use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

/**
 * @extends EntityFactory<Category>
 */
class CategoryFactory extends EntityFactory
{
    /**
     * @param   array<mixed> $data
     * @return  Category
     */
    public function make(array $data = []): Entity
    {
        return new Category(
            isset($data['id']) ? EntityId::make($data['id']) : EntityId::create(),
            $data['name']
        );
    }
}
