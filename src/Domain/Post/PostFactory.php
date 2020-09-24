<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\EntityFactory;

/**
 * @extends EntityFactory<Post>
 */
class PostFactory extends EntityFactory
{
    /**
     * @var class-string<Post>
     */
    protected string $entityClass = Post::class;
}
