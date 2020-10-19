<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\EntityFactory;
use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

/**
 * @extends EntityFactory<Comment>
 */
class CommentFactory extends EntityFactory
{
    /**
     * @param   array<mixed> $data
     * @return  Comment
     */
    public function make(array $data = []): Entity
    {
        return new Comment(
            isset($data['id']) ? EntityId::make($data['id']) : EntityId::create(),
            $data['content']
        );
    }
}
