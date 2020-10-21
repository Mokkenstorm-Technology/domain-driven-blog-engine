<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\EntityFactory;
use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

/**
 * @extends EntityFactory<Post>
 */
class PostFactory extends EntityFactory
{
    private CommentFactory $comments;
    
    private CategoryFactory $categories;

    public function __construct(CommentFactory $comments, CategoryFactory $categories)
    {
        $this->comments     = $comments;
        $this->categories   = $categories;
    }

    /**
     * @param array<mixed> $data
     * @return Post
     */
    public function make(array $data = []): Entity
    {
        return new Post(
            isset($data['id']) ? EntityId::make($data['id']) : EntityId::create(),
            PostTitle::from($data['title']),
            $this->children($this->comments, $data['comments'] ?? []),
            $this->children($this->categories, $data['categories'] ?? [])
        );
    }
}
