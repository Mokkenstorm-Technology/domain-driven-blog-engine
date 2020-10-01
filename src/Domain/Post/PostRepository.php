<?php

namespace App\Domain\Post;

use App\Infrastructure\Repository\FileRepository;

/**
 * @extends FileRepository<Post>
 */
class PostRepository extends FileRepository
{
    protected string $location = 'posts';

    /**
     * @var class-string<Post>
     */
    protected string $entityClass = Post::class;
}
