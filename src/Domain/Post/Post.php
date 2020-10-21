<?php

namespace App\Domain\Post;

use App\Infrastructure\Entity\Entity;
use App\Infrastructure\Entity\EntityId;

use App\Infrastructure\Support\Collection\Collection;

class Post extends Entity
{
    protected PostTitle $title;

    /**
     * @var Collection<int, Comment>
     */
    protected Collection $comments;
    
    /**
     * @var Collection<int, Category>
     */
    protected Collection $categories;

    /**
     * @var string[]
     */
    protected array $fields = [
        'title',
        'comments',
        'categories'
    ];

    /**
     * @param Collection<int, Comment> $comments
     * @param Collection<int, Category> $categories
     */
    public function __construct(
        EntityId $id,
        PostTitle $title,
        Collection $comments,
        Collection $categories
    ) {
        parent::__construct($id);

        $this->title        = $title;
        $this->comments     = $comments;
        $this->categories   = $categories;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function comments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection<int, Category>
     */
    public function categories(): Collection
    {
        return $this->categories;
    }

    public function addComment(Comment $comment): self
    {
        $this->comments = $this->comments->add($comment);

        return $this;
    }

    public function addCategory(Category $category): self
    {
        $this->categories = $this->categories->add($category);

        return $this;
    }
}
